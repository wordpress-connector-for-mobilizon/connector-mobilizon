import test from 'ava'
import { JSDOM } from 'jsdom'

import Formatter from './formatter.js'

test.beforeEach(() => {
  const dom = new JSDOM()
  global.document = dom.window.document
})

test('#escapeHTML', (t) => {
  const escaped = Formatter.escapeHTML('<b>a</b>')
  t.is(escaped, '&lt;b&gt;a&lt;/b&gt;')
})

test('#formatDate one date', (t) => {
  const date = Formatter.formatDate({
    start: '2021-04-15T10:30:00Z',
    end: '2021-04-15T15:30:00Z',
  })
  t.is(date, '15/04/2021 10:30 - 15:30')
})

test('#formatDate one date with short offset name', (t) => {
  const date = Formatter.formatDate({
    start: '2021-04-15T10:30:00Z',
    end: '2021-04-15T15:30:00Z',
    isShortOffsetNameShown: true,
  })
  t.is(date, '15/04/2021 10:30 - 15:30 (UTC)')
})

test('#formatDate two dates', (t) => {
  const date = Formatter.formatDate({
    start: '2021-04-15T10:30:00Z',
    end: '2021-04-16T15:30:00Z',
  })
  t.is(date, '15/04/2021 10:30 - 16/04/2021 15:30')
})

test('#formatDate two dates with short offset name', (t) => {
  const date = Formatter.formatDate({
    start: '2021-04-15T10:30:00Z',
    end: '2021-04-16T15:30:00Z',
    isShortOffsetNameShown: true,
  })
  t.is(date, '15/04/2021 10:30 - 16/04/2021 15:30 (UTC)')
})

test('#formatDate second date is null', (t) => {
  const date = Formatter.formatDate({
    start: '2021-04-15T10:30:00Z',
    end: null,
  })
  t.is(date, '15/04/2021 10:30')
})

test('#formatDate second date is null with short offset name', (t) => {
  const date = Formatter.formatDate({
    start: '2021-04-15T10:30:00Z',
    end: null,
    isShortOffsetNameShown: true,
  })
  t.is(date, '15/04/2021 10:30 (UTC)')
})

test('#formatLocation both parameters', (t) => {
  const location = Formatter.formatLocation({ description: 'a', locality: 'b' })
  t.is(location, 'a, b')
})

test('#formatLocation description only', (t) => {
  const location = Formatter.formatLocation({ description: 'a' })
  t.is(location, 'a')
})

test('#formatLocation description with space only', (t) => {
  const location = Formatter.formatLocation({ description: ' ' })
  t.is(location, '')
})

test('#formatLocation locality only', (t) => {
  const location = Formatter.formatLocation({ locality: 'a' })
  t.is(location, 'a')
})
