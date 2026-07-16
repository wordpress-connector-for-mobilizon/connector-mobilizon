import { defineConfig } from 'eslint/config'
import ava from 'eslint-plugin-ava'
import wordpress from '@wordpress/eslint-plugin'
import babelParser from '@babel/eslint-parser'

export default defineConfig([
  ...wordpress.configs['recommended-with-formatting'],
  ...ava.configs.recommended,
  {
    languageOptions: {
      parser: babelParser,
    },
    rules: {
      'array-bracket-spacing': ['error', 'never'],
      'computed-property-spacing': ['error', 'never'],
      'import/no-extraneous-dependencies': ['warn'],
      'import/no-unresolved': ['warn'],
      indent: ['error', 2],
      'react/jsx-curly-spacing': ['error', 'never'],
      'react/jsx-key': ['off'],
      'react/jsx-indent': ['error', 2],
      'react/jsx-indent-props': ['error', 2],
      'no-console': [
        'error',
        {
          allow: ['error'],
        },
      ],
      semi: ['error', 'never'],
      'space-in-parens': ['error', 'never'],
      'space-unary-ops': ['error', { nonwords: false }],
      'template-curly-spacing': ['error', 'never'],
    },
  },
])
