# <wordpress-nice-name>
Contributors: dwaxweiler
Donate link: <wordpress-donation-link>
Tags: mobilizon, events
Stable tag: <wordpress-version>
Requires at least: <wordpress-minimum-version>
Tested up to: <wordpress-tested-up-to-version>
Requires PHP: <wordpress-php-minimum-version>
License: <wordpress-license>

<wordpress-description>

## Description

<wordpress-nice-name> allows you to display the upcoming events of [Mobilizon](https://joinmobilizon.org/), which is a federated event listing platform, on your WordPress website.

Features
- Display events as widget and as shortcut
- Display events' title, date, and location if available
- Cache requests' responses for 2 minutes in the browser's `sessionStorage`
- Configure number of events to show per widget and per shortcut
- Optionally filter events by a specific group per widget and per shortcut
- Set the URL of the Mobilizon instance in the settings
- Toggle adding named offset in brackets after the time in the settings

Shortcut format with limiting the number of events to show to 3 for example: `[<wordpress-name>-events-list events-count=3]`
Optionally, you can only show the events of a specific group by indicatings its name: `[<wordpress-name>-events-list events-count=3 group-name="mygroup"]`

The source code is available on [Github](https://github.com/dwaxweiler/connector-mobilizon).

## Screenshots
1. Events list
2. General settings
3. Widget creation
4. Shortcut creation

## Changelog

### [0.6.0] - 2021-06-02
#### Added
- Optionally display the current offset as short name after the time via the general plugin settings
#### Changed
- Update dependencies
#### Fixed
- Capitalise Mobilizon name in description

### [0.5.0] - 2021-05-06
#### Added
- Localise dates based on the WordPress locale and time zone
#### Changed
- Clearly list features in `readme.txt` description
- Update dev dependencies c8, eslint, gulp-replace, webpack
#### Fixed
- Improve translatability

### [0.4.0] - 2021-04-20
#### Added
- Show events' location if set: `description` and `locality` fields
- Plugin icon
#### Changed
- Update dev dependencies eslint, jsdom, webpack

### [0.3.0] - 2021-04-05
#### Added
- Donation link to WordPress Plugin Directory sidebar and to `package.json`
- Cache requests for 2 minutes
- Set up ESLint static code analysis
#### Changed
- Update luxon dependency
- Update dev dependencies jsdom, webpack, webpack-cli

### [0.2.2] - 2021-03-10
#### Changed
- Confirm compatibility with WordPress 5.7
- Update graphql dependency
- Update dev dependencies jsdom, webpack, webpack-cli, webpack-stream

### [0.2.1] - 2021-01-15
#### Fixed
- Add missing backtick to `readme.txt`

### [0.2.0] - 2021-01-15
#### Added
- `changelog.txt`
- Changelog maintenance steps to `README.md`
- Link to Github repository in `readme.txt`
- Option to show events of a specific group by indicating its name
#### Changed
- Use same Markdown style in `README.md` as in other documents

### [0.1.0] - 2021-01-09
initial release
