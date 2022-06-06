import edit from './edit.js'

const { registerBlockType } = wp.blocks

const NAME = '<wordpress-name>'

registerBlockType(NAME + '/events-list', { edit })
