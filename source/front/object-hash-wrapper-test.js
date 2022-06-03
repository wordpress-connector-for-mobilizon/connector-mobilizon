import test from 'ava'
import hash from './object-hash-wrapper.js'

test('#hash object', (t) => {
  t.is(hash({ foo: 'bar' }), 'a75c05bdca7d704bdfcd761913e5a4e4636e956b')
})
