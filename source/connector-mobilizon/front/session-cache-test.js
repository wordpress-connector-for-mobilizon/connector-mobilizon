import test from 'ava'
import SessionCache from './session-cache'

const fakeStorage = {

  elements: {},

  clear() {
    this.elements = {}
  },

  getItem(key) {
    const value = this.elements[key]
    if (value === undefined) return null
    return value
  },

  setItem(key, value) {
    this.elements[key] = value
  }
}

test.afterEach(() => {
  fakeStorage.clear()
})

test('#add & #get', t => {
  SessionCache.add(fakeStorage, { a: 'b' }, { c: 'd' })
  t.deepEqual(SessionCache.get(fakeStorage, { a: 'b' }), { c: 'd' })
})

test('#get no entry', t => {
  t.is(SessionCache.get(fakeStorage, { a: 'bb' }), null)
})
