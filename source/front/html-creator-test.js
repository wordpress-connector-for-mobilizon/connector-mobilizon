import test from 'ava'
import browserEnv from 'browser-env'

import { createAnchorElement } from './html-creator.js'

test.beforeEach(() => {
  browserEnv()
})

test('#createAnchorElement usual parameters', (t) => {
  const a = createAnchorElement({ document, text: 'a', url: 'b' })
  t.is(a.tagName, 'A')
  t.is(a.innerHTML, 'a')
  t.is(a.getAttribute('href'), 'b')
})
