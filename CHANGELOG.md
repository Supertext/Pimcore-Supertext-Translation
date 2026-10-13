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

### Fixed
- Pimcore languages without a region (e.g. `de`, `fr`) are now sent to Supertext as `de-DE`, `fr-FR` (`en` → `en-US`, …); Supertext rejected them as target languages ("invalid language pair"). A configured `code` without region gets the usual one too, codes are normalized (`de_ch` → `de-CH`), and the source language is sent without region, as before.
