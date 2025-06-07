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
    startDateFormatted: '15/04/2021',
    startTimeFormatted: '10:30',
    endDateFormatted: '15/04/2021',
    endTimeFormatted: '15:30',
  })
  t.is(date, '15/04/2021 10:30 - 15:30')
})

test('#formatDate two dates', (t) => {
  const date = Formatter.formatDate({
    startDateFormatted: '15/04/2021',
    startTimeFormatted: '10:30',
    endDateFormatted: '16/04/2021',
    endTimeFormatted: '15:30',
  })
  t.is(date, '15/04/2021 10:30 - 16/04/2021 15:30')
})

test('#formatDate second date is null', (t) => {
  const date = Formatter.formatDate({
    startDateFormatted: '15/04/2021',
    startTimeFormatted: '10:30',
    endDateFormatted: undefined,
    endTimeFormatted: undefined,
  })
  t.is(date, '15/04/2021 10:30')
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
