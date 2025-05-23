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
- Display events as Gutenberg block, as widget and as shortcut
- Display events' title with link, date, and location, if available
- Cache requests' responses for 2 minutes in the database
- Configure number of events to show per block, per widget and per shortcut
- Optionally filter events by a specific public group per block, per widget and per shortcut
- Set the URL of the Mobilizon instance in the settings
- Toggle adding named offset in brackets after the time in the settings

This plugin requests the events via Mobilizon's GraphQL API.

The source code is available on [Github](https://github.com/dwaxweiler/connector-mobilizon).

## Installation

Install this plugin on the "Add Plugin" page in the administrator backend of your WordPress website by searching for it by its name or by uploading its archive by clicking on "Upload Plugin".
In both cases, you then need to click the corresponding "Install now" button.

After the installation, you can adapt the URL of the Mobilizon instance whose events you want to list on the plugin's settings' page.

### Shortcut usage

Shortcut format with limiting the number of events to show to 3 for example: `[<wordpress-name>-events-list events-count=3]`

Optionally, you can only show the events of a specific group by indicatings its name: `[<wordpress-name>-events-list events-count=3 group-name="mygroup"]`
You have to use their username, e.g. `@nosliensvivants`, and append the name of their instance if they use a different one, e.g. `@yaam_berlin@mobilize.berlin`.

## Screenshots
1. Events list
2. General settings
3. Widget creation
4. Shortcut creation
5. Gutenberg block in editor

## Changelog

### [1.4.0]
#### Changed
- Update dependencies
- Confirm compatibility with WordPress 6.8

### [1.3.0]
#### Added
- Comment for translators what placeholder will contain
#### Changed
- Confirm compatibility with WordPress 6.7
- Load block script only in footer to reduce waiting time
- Update dependencies
#### Fixed
- Mark event-related data as non-translatable within plugin
- Add version number to script registration to break browser caching
- Handle location being null

### [1.2.0]
#### Added
- Display event picture if available
#### Changed
- Update dependencies

### [1.1.0]
#### Added
- Add some spacing between event items
#### Changed
- Update dependencies
- Confirm compatibility with WordPress 6.6
#### Fixed
- Fix undefined variable $classNamePrefix for both error views

### [1.0.0]
#### Added
- Display name of group when it cannot be found
#### Changed
- Let backend do requests to API of Mobilizon instance for increased privacy
- Update dependencies
#### Fixed
- Fix displaying more than one block in the editor

### [0.11.5]
#### Changed
- Confirm compatibility with WordPress 6.5

### [0.11.4]
#### Changed
- Confirm compatibility with WordPress 6.4
- Update dependencies

### [0.11.3]
#### Fixed
- Clean up distributed files

### [0.11.2]
#### Changed
- Update dependencies
- Confirm compatibility with WordPress 6.3

### [0.11.1]
#### Fixed
- Revert minimum PHP version to 7.4 to allow some more time for upgrading PHP

### [0.11.0]
#### Changed
- Update dependencies
- Confirm compatibility with WordPress 6.2
#### Security
- Set minimum PHP version to oldest stable 8.0

### [0.10.1]
#### Changed
- Confirm compatibility with WordPress 6.1
- Update dependencies

### [0.10.0]
#### Added
- Add Gutenberg events list block
- Show loading indicator during request
#### Changed
- Set list style type to none and left padding to zero for all occurences
- Move shortcut usage description into installation section in `readme.txt`
- Update dependencies

### [0.9.1] - 2020-05-19
#### Fixed
- Fix WordPress compatibility version number

### [0.9.0] - 2020-05-19
#### Added
- Improve explanation of group name filter
#### Changed
- Update dependencies
- Confirm compatibility with WordPress 6.0
#### Fixed
- Fix displaying error message for the case the group is not found

### [0.8.0] - 2022-01-09
#### Added
- Add support for older browsers using babel
#### Changed
- Confirm compatibility with WordPress 5.9
- Update dependencies
#### Fixed
- Use ES modules correctly
- Trim events' location

### [0.7.0] - 2021-12-23
#### Added
- Add specific error message for the case the group is not found
- Add code formatter prettier
#### Changed
- Update dependencies
- Simplify build process
#### Fixed
- Fix Invalid DateTime on event end time being null
#### Security
- Set minimum PHP version to oldest stable 7.4

### [0.6.2] - 2021-08-24
#### Changed
- Update dependencies
#### Fixed
- Fix empty WordPress timezone_string option resulting in Invalid DateTime

### [0.6.1] - 2021-07-13
#### Changed
- Confirm compatibility with WordPress 5.8
- Update dependencies

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
