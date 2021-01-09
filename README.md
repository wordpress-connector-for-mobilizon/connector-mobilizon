# Connector for Mobilizon

## Development

### Setup
1. Make sure `npm` and `composer` are installed.
2. Run: `npm install`
3. Run: `php composer.phar install`

### Development build
1. Build: `npm run build-dev`

### Release procedure
1. Build: `npm run build-prod`
2. Determine minimum PHP version for code and update package.json if needed: `./vendor/bin/phpcompatinfo analyser:run ./source`
3. Make sure screenshots are up-to-date.

### Other commands
- Run tests: `npm test`
- Delete build folder: `gulp clean`
