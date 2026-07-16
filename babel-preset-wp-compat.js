// Wraps @wordpress/babel-preset-default and strips Babel 8-incompatible options
module.exports = function (api, opts) {
  const wpPreset = require('@wordpress/babel-preset-default')
  const config = wpPreset(api, opts)

  // Recursively remove 'bugfixes' from any preset-env options in the preset chain
  config.presets = (config.presets || []).map((preset) => {
    if (!Array.isArray(preset)) return preset
    const [name, options] = preset
    if (
      typeof name === 'string' &&
      name.includes('preset-env') &&
      options?.bugfixes !== undefined
    ) {
      const { bugfixes, ...rest } = options
      return [name, rest]
    }
    return preset
  })

  return config
}
