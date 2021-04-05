import test from 'ava'
import { JSDOM } from 'jsdom'

import * as HtmlCreator from './html-creator'

test.beforeEach(() => {
  global.document = new JSDOM().window.document
})

test('createAnchorElement() usual parameters', t => {
  const a = HtmlCreator.createAnchorElement({ text: 'a', url: 'b' })
  t.is(a.tagName, 'A')
  t.is(a.innerHTML, 'a')
  t.is(a.getAttribute('href'), 'b')
})
