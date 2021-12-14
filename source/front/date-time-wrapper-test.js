import test from 'ava'
import DateTimeWrapper from './date-time-wrapper'

test('#getShortDate usual date', (t) => {
  const d = new DateTimeWrapper({ text: '2020-12-24T16:45:00Z' })
  t.is(d.getShortDate(), '24/12/2020')
})

test('#getShortDate usual date with timezone string', (t) => {
  const d = new DateTimeWrapper({
    text: '2020-12-24T16:45:00Z',
    timeZone: 'Europe/Rome',
  })
  t.is(d.getShortDate(), '24/12/2020')
})

test('#getShortDate usual date with fixed offset', (t) => {
  const d = new DateTimeWrapper({
    text: '2020-12-24T16:45:00Z',
    timeZone: 'UTC+02:00',
  })
  t.is(d.getShortDate(), '24/12/2020')
})

test('#getShortDate usual date with fixed offset without UTC prefix', (t) => {
  const d = new DateTimeWrapper({
    text: '2020-12-24T16:45:00Z',
    timeZone: '+02:00',
  })
  t.is(d.getShortDate(), '24/12/2020')
})

test('#getShortDate usual date with empty time zone', (t) => {
  const d = new DateTimeWrapper({ text: '2020-12-24T16:45:00Z', timeZone: '' })
  t.is(d.getShortDate(), '24/12/2020')
})

test('#get24Time usual time', (t) => {
  const d = new DateTimeWrapper({ text: '2020-12-24T16:45:00Z' })
  t.is(d.get24Time(), '16:45')
})

test('#equalsDate same date, different time', (t) => {
  const d = new DateTimeWrapper({ text: '2020-12-24T16:45:00Z' })
  const e = new DateTimeWrapper({ text: '2020-12-24T17:46:01Z' })
  t.true(d.equalsDate(e))
})

test('#equalsDate different date, different time', (t) => {
  const d = new DateTimeWrapper({ text: '2020-12-24T16:45:00Z' })
  const e = new DateTimeWrapper({ text: '2021-11-25T17:46:01Z' })
  t.false(d.equalsDate(e))
})

test('#equalsDate different day, different time', (t) => {
  const d = new DateTimeWrapper({ text: '2020-12-24T16:45:00Z' })
  const e = new DateTimeWrapper({ text: '2020-12-25T17:46:01Z' })
  t.false(d.equalsDate(e))
})

test('#equalsDate different month, different time', (t) => {
  const d = new DateTimeWrapper({ text: '2020-12-24T16:45:00Z' })
  const e = new DateTimeWrapper({ text: '2020-11-24T17:46:01Z' })
  t.false(d.equalsDate(e))
})

test('#equalsDate different year, different time', (t) => {
  const d = new DateTimeWrapper({ text: '2020-12-24T16:45:00Z' })
  const e = new DateTimeWrapper({ text: '2021-12-24T17:46:01Z' })
  t.false(d.equalsDate(e))
})

test('#getCurrentDatetimeAsString correct format', (t) => {
  const d = DateTimeWrapper.getCurrentDatetimeAsString()
  t.is(d[4], '-')
  t.is(d[7], '-')
  t.is(d[10], 'T')
  t.is(d[13], ':')
  t.is(d[16], ':')
  t.is(d[19], '.')
  t.is(d[d.length - 3], ':')
})

test('#getShortOffsetName usual time', (t) => {
  const d = new DateTimeWrapper({ text: '2020-12-24T16:45:00Z' })
  t.is(d.getShortOffsetName(), 'UTC')
})
