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
  t.is(a.getAttribute('rel'), null)
  t.is(a.className, '')
})

test('#createAnchorElement with className and rel', (t) => {
  const a = createAnchorElement({
    document,
    text: 'c',
    url: 'd',
    className: 'button',
    rel: 'noopener',
  })
  t.is(a.tagName, 'A')
  t.is(a.innerHTML, 'c')
  t.is(a.getAttribute('href'), 'd')
  t.is(a.getAttribute('rel'), 'noopener')
  t.is(a.className, 'button')
})

test('#createContainerElement creates element', (t) => {
  const c = createContainerElement({ document, className: 'a' })
  t.is(c.tagName, 'DIV')
  t.is(c.className, 'a')
})
