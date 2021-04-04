import hash from './object-hash-wrapper'

const MAX_AGE_IN_MS = 120000

export class SessionCache {

  static add(parameters, data) {
    const key = hash(parameters)
    const timestamp = Date.now()
    const value = {
      data,
      timestamp,
    }
    sessionStorage.setItem(key, JSON.stringify(value))
  }

  static get(parameters) {
    const key = hash(parameters)
    const value = JSON.parse(sessionStorage.getItem(key))
    if (value.timestamp && value.timestamp > Date.now() - MAX_AGE_IN_MS)
      return value.data
    return null
  }
}
