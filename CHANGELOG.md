# Changelog

All notable changes to this project are documented here. The format follows [Keep a Changelog](https://keepachangelog.com/).

## Unreleased

### Added

- French and Italian interface (and German where it was missing): the Studio button, dialog, permission label and the messages from the server (Supertext errors, permissions, missing parent page) follow the user's Studio language.
- First version for Pimcore 2026 with Pimcore Studio. All Supertext API calls go through the official Supertext PHP SDK, shipped inside the bundle (nothing extra to install).
- Its own message for an unsupported language pair, naming the codes ("Supertext does not support this language pair (en → xx-YY)"), in English, German, French and Italian.
- **Translate with Supertext** button in the toolbar of documents (pages, snippets, e-mails) and data objects, with a dialog: languages to translate into, "Already translated" / "Translated with Supertext on …" per language and an explicit *Overwrite existing translations* option.
- Documents: title, description, navigation name and title, and the texts of input, textarea, WYSIWYG and link editables are translated. Missing translations are created unpublished under the parent page's translation and linked to the original, with keys made from the translated navigation name; existing ones get a new version.
- Data objects: localized input, textarea and WYSIWYG fields, from any language that has text, saved as a new version.
- Permission *Translate with Supertext*; Pimcore's workspaces and language restrictions apply.
- Every translation is recorded as a note (type `supertext`) on the original.
- Settings: `SUPERTEXT_API_KEY` (with or without the `Supertext-Auth-Key` prefix), `SUPERTEXT_API_URL`, and in `supertext_translation` YAML the environment, timeout, Supertext language code and form of address per language, and the translated field and editable types.
- Links to create a Supertext account and to generate the API key in the dialog when no key is set, in messages for a rejected key, in `supertext:check` and in the installation guide.
- Console commands `supertext:translate` and `supertext:check` (which also shows the installed version).
- Retries when the Supertext API answers HTTP 429 (rate limit).
- English and German Studio strings.
- Demo for Railway (`demo/`) with demo accounts, an Editors role, four languages, sample pages and an article created on every start.

### Changed

- **Languages are no longer guessed.** A Pimcore language whose code is a Supertext code (`de_CH` → `de-CH`, `fr_CH`, `es`, `zh_Hans`, apart from case and `_`/`-`) is used as it is; every other language needs a Supertext code in the language mapping (`supertext_translation.languages.<language>.code`, e.g. `en: { code: en-GB }`). There are no default regions any more: they were wrong for most languages (Supertext wants `es`, `sl`, `nl` without region, `zh-Hans` instead of `zh-CN`, and rejects bare `de`). The same mapping gives the source language (bare: `en-GB` → `en`). An unmapped language shows *No Supertext language* in the dialog and can't be selected; translating into it reports *has no Supertext language yet* and sends nothing. `supertext:check` lists the mapping and marks unmapped languages.
- A formal/informal tone configured for a language Supertext offers none for (English, Swiss German, Romansh, Albanian, Serbian) is no longer sent: the dialog marks the language *No formal/informal tone*, and translating into it reports *Supertext offers no formal or informal tone for this language*.
- `POST /supertext/settings/test` returns the API key check (`{ok, check, message}`, always HTTP 200 for administrators).
- Bundled Supertext SDK 0.2.1 (commit `eeba8fa`, `V1` namespace): the API's language list, the key check and the version reports.

### Added

- Automatic API key check (Supertext's cost-free `features` call): when the bundle runs with a key it hasn't checked yet, when Supertext rejects the key during a translation, and on `supertext:check`. Administrators see the latest result with its time at the bottom of the translate dialog (*Supertext status*), together with unmapped languages and the version information setting, in English, German, French and Italian.
- *Send version information to Supertext* (`version_reports`, on by default; `SUPERTEXT_VERSION_REPORTS=0` turns it off): after an update and when the key check result changes, the bundle sends the site URL, the bundle, Pimcore, PHP and SDK versions, whether a key is set, the key check result and the ping address to the Supertext Commando Center, after the response. No content, no API key and no personal data. `supertext:check` sends a `check` report.
- Public ping endpoint `GET /supertext/ping` that only echoes Supertext's challenge, so Supertext can check the site is reachable (404 with version information off).
- The bundle keeps this state in Pimcore's settings store (scope `supertext_translation`).
- New messages *The language … has no Supertext language yet* and *Supertext offers no formal or informal tone for this language* in all four interface languages.
