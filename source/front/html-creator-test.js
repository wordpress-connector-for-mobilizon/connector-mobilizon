import test from 'ava'
import { JSDOM } from 'jsdom'

import { createAnchorElement, createContainerElement } from './html-creator.js'

test.beforeEach(() => {
  const dom = new JSDOM()
  global.document = dom.window.document
})

test('#createAnchorElement usual parameters', (t) => {
  const a = createAnchorElement({ document, text: 'a', url: 'b' })
  t.is(a.tagName, 'A')
  t.is(a.innerHTML, 'a')
  t.is(a.getAttribute('href'), 'b')
})

test('#createContainerElement creates element', (t) => {
  const c = createContainerElement({ document, className: 'a' })
  t.is(c.tagName, 'DIV')
  t.is(c.className, 'a')
})
