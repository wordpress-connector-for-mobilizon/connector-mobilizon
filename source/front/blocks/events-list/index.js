import edit from './edit.js'

import { registerBlockType } from '@wordpress/blocks'

const NAME = '<wordpress-name>'

registerBlockType(NAME + '/events-list', { edit })
