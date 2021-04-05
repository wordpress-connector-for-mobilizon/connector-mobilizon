import hash from './object-hash-wrapper'

const MAX_AGE_IN_MS = 120000

export class SessionCache {

  static add(storage, parameters, data) {
    const key = hash(parameters)
    const timestamp = Date.now()
    const value = {
      data,
      timestamp,
    }
    storage.setItem(key, JSON.stringify(value))
  }

  static get(storage, parameters) {
    const key = hash(parameters)
    const value = JSON.parse(storage.getItem(key))
    if (value && value.timestamp && value.timestamp > Date.now() - MAX_AGE_IN_MS)
      return value.data
    return null
  }
}
