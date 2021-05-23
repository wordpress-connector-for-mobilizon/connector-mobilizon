import test from 'ava'
import Formatter from './formatter'

test('#formatDate one date', t => {
  const date = Formatter.formatDate({ start: '2021-04-15T10:30:00Z', end: '2021-04-15T15:30:00Z' })
  t.is(date, '15/04/2021 10:30 - 15:30')
})

test('#formatDate one date with short offset name', t => {
  const date = Formatter.formatDate({ start: '2021-04-15T10:30:00Z', end: '2021-04-15T15:30:00Z', isShortOffsetNameShown: true })
  t.is(date, '15/04/2021 10:30 - 15:30 (UTC)')
})

test('#formatDate two dates', t => {
  const date = Formatter.formatDate({ start: '2021-04-15T10:30:00Z', end: '2021-04-16T15:30:00Z' })
  t.is(date, '15/04/2021 10:30 - 16/04/2021 15:30')
})

test('#formatDate two dates with short offset name', t => {
  const date = Formatter.formatDate({ start: '2021-04-15T10:30:00Z', end: '2021-04-16T15:30:00Z', isShortOffsetNameShown: true })
  t.is(date, '15/04/2021 10:30 (UTC) - 16/04/2021 15:30 (UTC)')
})

test('#formatLocation both parameters', t => {
  const date = Formatter.formatLocation({ description: 'a', locality: 'b' })
  t.is(date, 'a, b')
})

test('#formatLocation description only', t => {
  const date = Formatter.formatLocation({ description: 'a' })
  t.is(date, 'a')
})

test('#formatLocation locality only', t => {
  const date = Formatter.formatLocation({ locality: 'a' })
  t.is(date, 'a')
})
