# Changelog

All notable changes to this project are documented here. The format follows [Keep a Changelog](https://keepachangelog.com/).

## Unreleased

### Added

- First version for Pimcore 2026 with Pimcore Studio.
- **Translate with Supertext** button in the toolbar of documents (pages, snippets, e-mails) and data objects, with a dialog: languages to translate into, "Already translated" / "Translated with Supertext on …" per language and an explicit *Overwrite existing translations* option.
- Documents: title, description, navigation name and title, and the texts of input, textarea, WYSIWYG and link editables are translated. Missing translations are created unpublished under the parent page's translation and linked to the original, with keys made from the translated navigation name; existing ones get a new version.
- Data objects: localized input, textarea and WYSIWYG fields, from any language that has text, saved as a new version.
- Permission *Translate with Supertext*; Pimcore's workspaces and language restrictions apply.
- Every translation is recorded as a note (type `supertext`) on the original.
- Settings: `SUPERTEXT_API_KEY` (with or without the `Supertext-Auth-Key` prefix), `SUPERTEXT_API_URL`, and in `supertext_translation` YAML the environment, timeout, Supertext language code and form of address per language, and the translated field and editable types.
- Links to create a Supertext account and to generate the API key in the dialog when no key is set, in messages for a rejected key, in `supertext:check` and in the installation guide.
- Console commands `supertext:translate` and `supertext:check`.
- Retries when the Supertext API answers HTTP 429 (rate limit).
- English and German Studio strings.
- Demo for Railway (`demo/`) with demo accounts, an Editors role, four languages, sample pages and an article created on every start.
