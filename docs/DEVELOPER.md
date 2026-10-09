# Developer guide — Supertext Translation for Pimcore

For developers who work on the bundle, its demo or its CI. Administrators find setup in the [installation guide](INSTALLATION.md), editors their part in the [user guide](USER_GUIDE.md).

## Architecture

A Symfony bundle (`Supertext\PimcoreTranslationBundle`) with a Pimcore Studio UI plugin. The bundle adds API endpoints to Studio's backend; the plugin adds the toolbar button and the dialog that call them.

| Path | Purpose |
| --- | --- |
| `src/SupertextTranslationBundle.php` | The bundle (`AbstractPimcoreBundle`, installer from the container) |
| `src/Installer/Installer.php` | Adds (and on uninstall removes) the permission `supertext_translate` in the category *Supertext* |
| `src/DependencyInjection/` | Configuration tree `supertext_translation` (see the settings table in the installation guide) |
| `src/Settings.php` | Reads the configuration and `SUPERTEXT_API_KEY` / `SUPERTEXT_API_URL`, maps Pimcore languages to Supertext codes, builds the API client (Symfony HttpClient transport), the account and API key links |
| `src/Api/` | API client, HTML document packing and parsing, exception. No Pimcore or Symfony classes: unit-tested on their own, shared with the other Supertext PHP plugins |
| `src/Service/SegmentTranslator.php` | Sends a set of texts for one language pair, in chunks below the API's size limit |
| `src/Service/DocumentTranslator.php` | Documents: texts of a page, creating or updating its linked translation |
| `src/Service/ObjectTranslator.php` | Data objects: the localized fields of one language into others |
| `src/Service/History.php` | One `Element\Note` (type `supertext`) per translation, on the source element; also the "Translated with Supertext on" dates |
| `src/Controller/SupertextController.php` | Studio API endpoints (below) |
| `src/Command/` | `supertext:translate`, `supertext:check` (also prints the installed version) |
| `src/Webpack/WebpackEntryPointProvider.php` | Registers the plugin's build (`public/build/*/entrypoints.json`) with Studio |
| `assets/js/src/` | The Studio plugin (React, TypeScript, Module Federation via rsbuild): `index.ts` registers the buttons in the document and data object editor toolbars, `components/translate-modal.tsx` is the dialog, `api.ts` the fetch calls |
| `public/build/<hash>/` | The built plugin, committed (installs need no Node.js) |
| `translations/studio.{en,de,fr,it}.yaml` | Studio strings (dialog, permission label, `supertext.error.*` for the messages from the API), in English, German, French and Italian |
| `config/` | Services, the route import |

**Studio API** (session authentication, under `/pimcore-studio/api`):

| Method and path | |
| --- | --- |
| `GET /supertext/elements/{document\|data-object}/{id}` | Languages and their state for the dialog: exists / has content, editable, parent ready (documents), last Supertext translation; whether a key is set; the account and key links |
| `POST /supertext/elements/{type}/{id}/translate` | `{source?, targets[], overwrite}` → `{results: [{language, status: translated\|skipped\|error, message, documentId?, path?, created?}]}` |
| `GET /supertext/settings` | API address, key status, languages with Supertext code and politeness |
| `POST /supertext/settings/test` | Cost-free key check (administrators) |

Each requires the permission `supertext_translate` and *view* on the element; the services check the rest (save/create on target documents, `lEdit` languages on objects).

**Documents.** A document's language is its `language` property (default: the first valid language). Its translations are Pimcore's linked translations (`Document\Service::getTranslations`). A missing translation is created with `Document\Service::copyAsChild($parentTranslation, $document, …, $language)` (which links it), unpublished, then its texts are replaced; an existing one is loaded at its latest version and saved with `saveVersion()` (not published), with missing editables copied from the source first. The source's latest version (drafts included) is translated.

**Data objects.** Values are read from the latest version of the object and written with `setLocalizedValue()`; all target languages go into one `saveVersion()` with a note in the version.

### Field rules

`DocumentTranslator::units()`:

| Unit | Rule |
| --- | --- |
| `meta:title`, `meta:description` | Page title and description (`Document\Page` only) |
| `property:navigation_name`, `property:navigation_title` | Text properties; written back as inheritable properties |
| `editable:<name>` | Editables whose type is in `document_editable_types` (default `input`, `textarea`, `wysiwyg`, `link`); WYSIWYG as HTML, link: the `text` only |

New keys: the target's code (`de-ch`) for pages directly under the root, otherwise `AsciiSlugger` of the translated navigation name or title, made unique. Existing translations keep their key.

`ObjectTranslator::fields()`: the children of the class's `localizedfields` whose field type is in `object_field_types` (default `input`, `textarea`, `wysiwyg`; WYSIWYG as HTML). Field collections, object bricks, blocks and classification stores are not included. A language "has content" if any of these fields has text in it (fallback values ignored).

Empty values (and HTML without text) are not sent.

## Supertext API protocol

Shared with the WordPress plugin and every other Supertext CMS plugin:

1. `POST {base}translate/ai/file`: multipart with `file` (part `Content-Type` exactly `text/html`, no charset, or the API answers 415), `target_lang` (BCP-47, e.g. `de-CH`), optional `source_lang` (primary subtag only, e.g. `en`, or the pair is rejected), optional `politeness` (`more`/`less`). Returns `{file_id}`.
2. `GET …/{file_id}/status` until `done` (`error`, `limit_exceeded`, `deleted` are terminal).
3. `GET …/{file_id}/translation` returns the translated HTML.
4. `DELETE …/{file_id}` (files also expire after 24 h).

Each text is one `<div data-st-id="n">` element in the document, so it is translated as a whole. Auth header: `Authorization: Supertext-Auth-Key <key>`. Supertext shows the key with the prefix, so the client strips a pasted `Supertext-Auth-Key ` and always sends exactly one. Base URLs: `https://api.supertext.com/v1/` (live), `https://api.staging.supertext.com/v1/`, `https://api.testing.supertext.com/v1/`. `GET features` is the cost-free key check.

**Rate limit:** the API limits requests per second per key (HTTP 429). The client retries a 429 up to 4 times, waiting for `Retry-After` if sent, otherwise 1, 2, 4 and 8 seconds plus jitter. Target languages are translated one after the other.

## Local development

Pimcore 2026 needs PHP 8.4, MySQL 8 or MariaDB 10.11, OpenSearch 2 (Studio's search index), and a product key (free Community Edition, see [below](#pimcore-product-key)). The demo project in `demo/project` installs the bundle from `demo/module` (a Composer path repository), which `demo/stage-module.sh` fills.

```bash
cd assets && npm ci && npm run build && cd ..      # only after changing the plugin
demo/stage-module.sh
cd demo/project
composer install
docker run -d --name opensearch -p 9200:9200 -e discovery.type=single-node \
  -e DISABLE_SECURITY_PLUGIN=true -e DISABLE_INSTALL_DEMO_CONFIG=true opensearchproject/opensearch:2
cat > .env.local <<'ENV'
APP_ENV=dev
DATABASE_URL=mysql://pimcore:…@127.0.0.1:3306/pimcore?serverVersion=mariadb-10.11.14
PIMCORE_OPENSEARCH_DSN=opensearch://127.0.0.1:9200?ssl=false
PIMCORE_ENCRYPTION_SECRET=…
PIMCORE_INSTANCE_IDENTIFIER=…
PIMCORE_PRODUCT_KEY=…
APPLICATION_SECRET=…
MERCURE_JWT_KEY=…
SUPERTEXT_API_KEY=…
ENV
PIMCORE_ADMIN_USER=admin PIMCORE_ADMIN_PASSWORD='…' vendor/bin/pimcore-install --install-profile='App\Installer\SkeletonProfile' --no-interaction
DEMO_EDITOR_EMAIL=… DEMO_EDITOR_PASSWORD='…' bin/console supertext:demo-setup
bin/console messenger:consume pimcore_core pimcore_generic_data_index_queue &   # keeps the search index up to date
php -S 127.0.0.1:8090 -t public ../router.php   # serves files, everything else through public/index.php
# Studio: http://127.0.0.1:8090/pimcore-studio/
```

PHP's built-in server needs a router script that returns `false` for existing files; otherwise Studio's JavaScript is served through Symfony with the wrong type and Studio stays on its loading screen. In `dev`, the Symfony debug toolbar covers the bottom of Studio; use `APP_ENV=prod` for UI tests. If OpenSearch refuses writes because the disk is nearly full, turn off its disk watermark (`cluster.routing.allocation.disk.threshold_enabled: false`).

After changing the bundle, run `demo/stage-module.sh` and `composer update supertext/pimcore-supertext-translation` (or work with a symlinked path repository), then `bin/console assets:install public` and `bin/console cache:clear`.

To work without a real key, run the stand-in API (`node tests/docs/stand-in.mjs`) and set `SUPERTEXT_API_KEY=anything SUPERTEXT_API_URL=http://127.0.0.1:8765/v1/`. It returns real German, French and Italian for the demo's pages and article and `[de-CH] …`-prefixed text for anything else.

### Pimcore product key

Pimcore 2026 refuses to start without a registered instance: `PIMCORE_ENCRYPTION_SECRET` (generated), `PIMCORE_INSTANCE_IDENTIFIER` (chosen) and `PIMCORE_PRODUCT_KEY` (from <https://license.pimcore.com/register>, which takes the identifier and a hash of the secret) belong together. The Community Edition key is free for organisations below Pimcore's revenue limit. The demo, CI and local installs use the same registered instance; the three values live only in Railway's variables, GitHub's repository secrets and private `.env.local` files.

## Tests

```bash
phpunit            # or vendor/bin/phpunit after composer install
cd assets && npm run check-types && npm run build
```

- `tests/unit/SupertextClientTest.php`: the API protocol, auth header and prefix, 429 retries, errors, clean-up.
- `tests/unit/StudioTranslationsTest.php`: the four `studio.*.yaml` files have the same keys, `{{placeholders}}` and links, and every error key the PHP code sends has an English text.
- `tests/unit/HtmlDocumentTest.php`, `tests/unit/ChunksTest.php`: document packing and parsing, whitespace, splitting below the size limit.
- `tests/demo-check.sh` (CI): the demo image on MySQL and OpenSearch with the stand-in, started twice: demo accounts created once and never duplicated, no passwords in the log, the Editors role and the permission, `supertext:check`, the parent-page rule, translation of the sample pages and article as the editor into three languages (titles, slug keys, HTML with markup, link texts, unpublished pages, linked translations, notes), and the skip on a second run.

CI (`.github/workflows/ci.yml`) on every push and pull request: **test** (PHP lint, PHPUnit), **studio** (type check and build of the plugin) and **demo** (builds `demo/Dockerfile`, runs `tests/demo-check.sh`). The demo job needs the repository secrets `PIMCORE_ENCRYPTION_SECRET`, `PIMCORE_INSTANCE_IDENTIFIER` and `PIMCORE_PRODUCT_KEY`, and skips itself without them (e.g. for pull requests from forks).

## Demo (Railway)

The public demo is a container built from `demo/Dockerfile`: PHP 8.4 with Apache, Pimcore 2026 with Pimcore Studio and this bundle, the languages English (`en`, default), German, French and Italian (Switzerland: `de_CH`, `fr_CH`, `it_CH`, formal), two sample pages and a sample article object. It runs on Railway in the `supertext-cms-demos` project, service `Pimcore`, region EU West (Amsterdam): <https://pimcore-production-56d2.up.railway.app/> (Studio: `/pimcore-studio/`). Data lives in a `pimcore` database on the project's MySQL service; the search index in the service `Pimcore-OpenSearch` (OpenSearch 2, security plugin off, private network only).

**Deploys:** Railway builds `main` of this repository (`railway.json` points it at `demo/Dockerfile`).

**What's in `demo/`:**

| Path | Purpose |
| --- | --- |
| `Dockerfile` | PHP 8.4 + Apache (document root `demo/project/public`, `/.well-known/mercure` proxied to the Mercure hub), PHP extensions, the Mercure hub binary, the bundle copied to `demo/module`, Composer install of `demo/project` |
| `docker/entrypoint.sh` | Every start, see below |
| `docker/apache.conf` | The virtual host |
| `router.php` | Router for PHP's built-in server (local development) |
| `stage-module.sh` | Copies the bundle's files to `demo/module` for local installs |
| `project/` | The Pimcore project (from Pimcore's skeleton): `composer.json`, `config/bundles.php`, `config/packages/supertext_demo.yaml` (languages, read from this file; Supertext politeness), `config/pimcore/classes/` (the class `Article`), `templates/default/default.html.twig` and `src/Controller/DefaultController.php` (page layout with a language switcher), `src/Installer/SkeletonProfile.php` (install profile, Doctrine Messenger instead of RabbitMQ), `src/Command/DemoSetupCommand.php` |
| `.env.example` | The variables below |

**Every start** (`docker/entrypoint.sh`): creates the database `PIMCORE_DB_NAME` on the MySQL server if missing; on the first start installs Pimcore (`pimcore-install` with the skeleton profile; the installer's administrator is `DEMO_ADMIN_*` if set, otherwise an account `pimcore-install` with a random password nobody knows); then `cache:warmup` (which also unpacks Studio's frontend), Pimcore migrations, `pimcore:bundle:install SupertextTranslationBundle`, `pimcore:deployment:classes-rebuild --create-classes`, `assets:install`, a rebuild of the search index (OpenSearch keeps no data between deploys) and `supertext:demo-setup`. It then starts the Mercure hub, a Messenger worker (search index updates, maintenance; restarted hourly), `pimcore:maintenance` every 15 minutes, and Apache on `$PORT`.

**Demo setup** (`bin/console supertext:demo-setup`, only adds what is missing): the role **Editors** (permissions *Documents*, *Objects*, *Classes*, *Notes & Events* and *Translate with Supertext*; document and data object workspaces on the whole tree with all rights except delete, no language restrictions, so every language), the demo accounts, the English pages `/en` and `/en/swiss-chocolate`, and the article `/Articles/swiss-chocolate`. An existing *Editors* role gets missing permissions added.

**No volume:** everything is in MySQL; OpenSearch is rebuilt at start. Uploaded assets would disappear with the next deploy.

**Service variables** (`Pimcore`):

| Variable | |
| --- | --- |
| `MYSQL_URL` | `${{MySQL.MYSQL_URL}}`; the demo uses the database `PIMCORE_DB_NAME` (default `pimcore`) on that server. `DATABASE_URL` works too. |
| `PIMCORE_DB_SERVER_VERSION` | `8.0.0` for MySQL, e.g. `mariadb-10.11.14` for MariaDB |
| `PIMCORE_OPENSEARCH_DSN` | `opensearch://pimcore-opensearch.railway.internal:9200?ssl=false` |
| `PIMCORE_ENCRYPTION_SECRET`, `PIMCORE_INSTANCE_IDENTIFIER`, `PIMCORE_PRODUCT_KEY` | The registered instance (see [Pimcore product key](#pimcore-product-key)) |
| `APPLICATION_SECRET`, `MERCURE_JWT_KEY` | Long random strings; keep them stable (sessions, live updates) |
| `DEMO_ADMIN_EMAIL`, `DEMO_ADMIN_PASSWORD` | Administrator |
| `DEMO_EDITOR_EMAIL`, `DEMO_EDITOR_PASSWORD` | Editor for automated tests and screenshots: role **Editors**, every language. Pimcore has no editor role out of the box, so the demo creates this one. |
| `SUPERTEXT_API_KEY` | Supertext key |
| `SUPERTEXT_API_URL` | Optional, e.g. a stand-in API |
| `PUBLIC_URL` | Optional; otherwise `https://$RAILWAY_PUBLIC_DOMAIN` (Mercure's public address) |
| `PORT` | Port Apache listens on (`8080`) |

**Demo accounts:** on every start the setup creates the `DEMO_ADMIN` and `DEMO_EDITOR` accounts (user name = e-mail address) if no user with that name exists. Existing accounts are never changed; change passwords in Studio. Pimcore's rule is at least 4 characters for user name and password; an account that doesn't meet it is skipped with a warning naming the variables, and the demo still starts. Passwords are never logged. Pimcore 2026 has no web installer and no first-run screen; with `DEMO_ADMIN_*` set before the first start, that account is the installer's administrator.

**Run it locally:**

```bash
docker build -f demo/Dockerfile -t supertext-pimcore-demo .
docker run --rm --network host -e PORT=8080 \
  -e MYSQL_URL=mysql://root:…@127.0.0.1:3306/mysql -e PIMCORE_OPENSEARCH_DSN='opensearch://127.0.0.1:9200?ssl=false' \
  --env-file my-instance.env \   # PIMCORE_ENCRYPTION_SECRET, PIMCORE_INSTANCE_IDENTIFIER, PIMCORE_PRODUCT_KEY, APPLICATION_SECRET, MERCURE_JWT_KEY, DEMO_*, SUPERTEXT_API_KEY
  supertext-pimcore-demo
# http://localhost:8080/pimcore-studio/
```

## Docs screenshots

The images in `docs/images/` are generated by `tests/docs/screenshots.mjs` (Playwright) from a freshly set-up demo (no translations yet) whose bundle talks to `tests/docs/stand-in.mjs`. The stand-in returns German, French and Italian for the demo's content (`samples.json`, real Supertext output). The screenshots show no addresses. Regenerate them whenever a screen they show changes:

```bash
cd tests/docs && npm install && npx playwright install chromium
npm run stand-in &
# a fresh demo (DEMO_* set), served on :8080 with SUPERTEXT_API_KEY=anything SUPERTEXT_API_URL=http://127.0.0.1:8765/v1/
BASE_URL=http://127.0.0.1:8080 DEMO_ADMIN_EMAIL=… DEMO_ADMIN_PASSWORD=… \
  DEMO_EDITOR_EMAIL=… DEMO_EDITOR_PASSWORD=… npm run screenshots
```

The script uses a 1400×900 window; some clicks (the data object tree, the object's language switcher, the main menu) are at fixed positions in Studio's layout.

## Releasing

Releases are published by `.github/workflows/release.yml` when the version is officially bumped; nobody tags or creates releases by hand.

1. If the Studio plugin changed, rebuild it (`cd assets && npm run build`) and commit `public/build/` (the old build folder is replaced). If strings changed, update all four `translations/studio.*.yaml` (en, de, fr, it).
2. Move the *Unreleased* entries in `CHANGELOG.md` under a new `## X.Y.Z — YYYY-MM-DD` section, and keep an empty *Unreleased* above it.
3. There is no version field to change: Composer takes the version from the Git tag the workflow creates, and `supertext:check` prints it (`Settings::version()`, via `Composer\InstalledVersions`).
4. Push to `main`. The workflow tags `vX.Y.Z` and creates the GitHub release with the CHANGELOG section as notes (0.x versions as pre-releases). A push that adds no new version does nothing, and a version that is already released is skipped. After fixing a failed run, start it again with *Run workflow* on the *Release* workflow.

Submitting the package to Packagist is planned.

## Conventions

- PSR-12, PHP 8.4, typed properties; keep `src/Api/` free of Pimcore and Symfony classes.
- Studio strings in `translations/studio.{en,de,fr,it}.yaml`: every new string in all four (formal address: Sie, vous, Lei; Pimcore's own terms; never translate "Supertext", `{{placeholders}}` or URLs). Console messages, logs, notes and version comments stay English.
- Messages from the API: the JSON carries the English `error`/`message` plus a `key` (`supertext.error.<key>`), `params` and Supertext's untranslated `detail`; `SupertextException` takes them as named arguments (`key: 'parent-missing'`), and the per-language results carry them too. `translate-modal.tsx` → `describe()` shows the translation (with the detail in brackets, and `supertext.error.key-help` after key errors) or the English text if the key is unknown. A new message needs its key in all four files.
- Keep the three docs in `docs/` current with every change (see `CLAUDE.md`).

## Known limitations / roadmap

- Pimcore Studio only; the classic admin interface is not supported.
- No settings screen in Studio: settings are environment variables and YAML; `supertext:check` and `POST /supertext/settings/test` check the key.
- Translation runs inside the editor's request (one language after the other, up to `timeout` each). Planned: a queued job (Generic Execution Engine) and a batch action for several elements.
- Data objects: localized fields at the top level only; field collections, object bricks, blocks and classification stores are not translated yet. Asset metadata and shared translations (*Translations*) are not covered.
- Documents: renderlet, snippet and relation editables are copied, not translated.
- Pimcore Studio 2026.3 only opens data objects for users with the *Classes* permission.
- Not on Packagist yet.
- Human (professional) translation orders are not supported yet (the WordPress plugin has them).
