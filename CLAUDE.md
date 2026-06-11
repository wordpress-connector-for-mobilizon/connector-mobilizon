# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Install dependencies
npm install
composer install

# Build
npm run build-dev   # development build (incremental, no minification)
npm run build-prod  # production build (runs tests first, then minifies)
npm run clean       # remove build artifacts

# Test
npm test            # run all tests (JavaScript AVA + PHP PHPUnit)
npm run coverage    # JavaScript test coverage (HTML + text)

# Lint & format
npm run eslint      # lint JavaScript
npm run format      # format with Prettier
```

To run a single AVA test file:

```bash
npx ava source/front/formatter-test.js
```

To run a single PHPUnit test:

```bash
./vendor/bin/phpunit --filter TestMethodName tests/SomeTest.php
```

## Architecture

This is a WordPress plugin that fetches upcoming events from a [Mobilizon](https://mobilizon.org) instance (a federated event platform) and displays them on a WordPress site.

### Three display methods, one data pipeline

Events can be displayed via a **Gutenberg block**, a **shortcode** (`[connector-mobilizon-events-list]`), or a **sidebar widget**. All three share the same PHP data pipeline:

```
WordPress admin settings (Mobilizon URL)
    → GraphQlClient.php  (queries Mobilizon GraphQL API)
    → EventsCache.php    (WordPress transients, 120s TTL, key = MD5 of params)
    → formatter classes  (timezone-aware date/location formatting)
    → PHP templates (view/) or vanilla JS renderer (front/events-displayer.js)
```

### Two rendering contexts

**Server-side** (shortcode and widget): PHP queries the GraphQL API and renders `view/events-list.php` directly.

**Block editor** (Gutenberg): The React `edit.js` component calls the plugin's own REST endpoint (`/wp-json/connector-mobilizon/v1/events`), which hits the same PHP pipeline, then hands the JSON to `events-displayer.js` for DOM construction.

### Build pipeline

Source lives in `source/`. The webpack build (entry: `source/front/block-events-loader.js`) bundles JS and copies all PHP/TXT files to `build/`. A gulp step then replaces `<placeholder>` strings (e.g., `<wordpress-version>`) with values from `package.json` in the built files — metadata is never hand-edited in the PHP/JS source.

### PHP namespace

All PHP classes live under `MobilizonConnector\` (PSR-4 autoloaded from `source/includes/`).

### Tests

- **JavaScript**: AVA with JSDOM — test files are `source/front/**/*-test.js`, covering `formatter.js`, `html-creator.js`, and `events-displayer.js`
- **PHP**: PHPUnit 9 — test files are `tests/**Test.php`, covering `GroupNameHelper`, `LineFormatter`, and `LocalDateTime`

### Key files

| File                                      | Role                                                      |
| ----------------------------------------- | --------------------------------------------------------- |
| `source/connector-mobilizon.php`          | Plugin entry point; singleton init, hook registration     |
| `source/includes/GraphQlClient.php`       | Queries Mobilizon GraphQL, base64-encodes pictures        |
| `source/includes/Api.php`                 | REST endpoint consumed by the block editor                |
| `source/includes/EventsCache.php`         | Transient-based caching layer                             |
| `source/front/blocks/events-list/edit.js` | Gutenberg block React component                           |
| `source/front/events-displayer.js`        | Vanilla JS DOM renderer (block frontend + editor preview) |
| `webpack.config.cjs`                      | Bundles JS, copies PHP/TXT to `build/`                    |
| `gulpfile.cjs`                            | Injects metadata placeholders after webpack               |

## Release workflow

1. Update `changelog.txt` and copy the section to `readme.txt`
2. Update version in `package.json`, then `npm i --package-lock-only`
3. `npm run build-prod` (tests run automatically)
4. Commit to SVN `/trunk`, create SVN tag
5. Add `-next` suffix to version in `package.json`, commit, and git tag
