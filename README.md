# Connector for Mobilizon

## Development

### Setup
1. Make sure `npm` and `composer` are installed.
2. Run: `npm install`
3. Run: `php composer.phar install`

### Development build
1. Build: `npm run build-dev`
2. Make sure to keep `changelog.txt` up-to-date.

### Release procedure
1. Make sure `changelog.txt` is up-to-date. Use a new version number and copy over the new section into `readme.txt`.
2. Update `package.json` with the same version number.
3. Build: `npm run build-prod`
4. Determine minimum PHP version for code and update package.json if needed: `./vendor/bin/phpcompatinfo analyser:run ./source`
5. Make sure screenshots are up-to-date.
6. Copy the built plugin into `/trunk` of SVN. Also creatte a new tag of the new version. Check the version number occurences in both folders. Commit everything together.

### Other commands
- Run tests: `npm test`
- Delete build folder: `gulp clean`
