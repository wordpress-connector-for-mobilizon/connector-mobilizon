# Connector for Mobilizon

Connector for Mobilizon allows you to display the upcoming events of [Mobilizon](https://joinmobilizon.org/), which is a federated event listing platform, on your WordPress website.

More details can be found in the [WordPress Plugin Directory](https://wordpress.org/plugins/connector-mobilizon/).

The current changelog can be found under [source/changelog.txt](source/changelog.txt).

This plugin uses [Mobilizon's GraphQL API](https://docs.joinmobilizon.org/contribute/graphql_api/).

## Development

### Setup

1. Make sure `npm` and `composer` are installed.
2. Run: `npm install`
3. Run: `composer install`

### Development build

1. Build: `npm run build-dev`
2. Make sure to keep `changelog.txt` up-to-date.

### Release procedure

1. Make sure `changelog.txt` is up-to-date.
2. Create a new section with a new version number.
3. Copy over the new section into `readme.txt`.
4. Update `package.json` with the same version number.
5. Update the `package-lock.json`: `npm i --package-lock-only`
6. Build: `npm run build-prod`
7. Make sure screenshots are up-to-date.
8. Copy the built plugin into `/trunk` of SVN.
9. Create a new tag of the new version: `svn cp trunk tags/<version>`
10. Check the version number occurrences in both folders.
11. Make sure to handle exclamation and question marks in `svn status`.
12. Commit everything together to the release SVN: `svn ci -m "release version <version>"`
13. Commit the new version in git with the same message.
14. Tag the new version: `git tag v<version>`
15. Push the new tag to the repository: `git push --tags`
16. Append `-next` to the version number in `package.json`.
17. Update the `package-lock.json`: `npm i --package-lock-only`
18. Commit: `git commit -am "prepare next release"`

### Other commands

- Run ESLint: `npm run eslint`
- Run JavaScript code coverage with tests: `npm run coverage`
- Run tests: `npm test`
- Delete build folder: `npm run clean`
- Update PHP dependencies: `composer update`
- Check for direct PHP dependency updates: `composer outdated --direct`
- Format code with prettier: `npm run format`
- Generate `vendor/autoload.php` file after creating new class: `composer dump-autoload`
