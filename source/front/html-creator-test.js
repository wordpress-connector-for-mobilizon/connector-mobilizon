import test from 'ava'
import { JSDOM } from 'jsdom'

import { createAnchorElement } from './html-creator'

let document

test.beforeEach(() => {
  document = new JSDOM().window.document
})

test('#createAnchorElement usual parameters', (t) => {
  const a = createAnchorElement({ document, text: 'a', url: 'b' })
  t.is(a.tagName, 'A')
  t.is(a.innerHTML, 'a')
  t.is(a.getAttribute('href'), 'b')
})
