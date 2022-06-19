# Connector for Mobilizon

Connector for Mobilizon allows you to display the upcoming events of [Mobilizon](https://joinmobilizon.org/), which is a federated event listing platform, on your WordPress website.

More details can be found in the [WordPress Plugin Directory](https://wordpress.org/plugins/connector-mobilizon/).

The current changelog can be found under [source/changelog.txt](source/changelog.txt).

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
2. Use a new version number and copy over the new section into `readme.txt`.
3. Update `package.json` with the same version number.
4. Update the `package-lock.json`: `npm i --package-lock-only`
5. Build: `npm run build-prod`
6. Make sure screenshots are up-to-date.
7. Copy the built plugin into `/trunk` of SVN.
8. Create a new tag of the new version: `svn cp trunk tags/<version>`
9. Check the version number occurrences in both folders.
10. Commit everything together to the release SVN: `svn ci -m "release version <version>"` Make sure to add new files beforehand.
11. Commit the new version in git with the same message.
12. Tag the new version: `git tag v<version>`
13. Push the new tag to the repository: `git push --tags`

### Other commands

- Run ESLint: `npm run eslint`
- Run JavaScript code coverage with tests: `npm run coverage`
- Run tests: `npm test`
- Delete build folder: `npm run clean`
- Update PHP dependencies: `composer update`
- Check for direct PHP dependency updates: `composer outdated --direct`
- Format code with prettier: `npm run format`
