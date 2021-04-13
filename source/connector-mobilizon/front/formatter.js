import DateTimeWrapper from './date-time-wrapper'

export default class Formatter {
  
  static formatDate({ start, end }) {
    const startDateTime = new DateTimeWrapper(start)
    const endDateTime = new DateTimeWrapper(end)
    let dateText = startDateTime.getShortDate()
    dateText += ' ' + startDateTime.get24Time()
    dateText += ' - '
    if (!startDateTime.equalsDate(endDateTime)) {
      dateText += endDateTime.getShortDate() + ' '
    }
    dateText += endDateTime.get24Time()
    return dateText
  }

  static formatLocation({ description, locality }) {
    let location = ''
    if (description) {
      location += description
    }
    if (location && locality) {
      location += ', '
    }
    if (locality) {
      location += locality
    }
    return location
  }
}
