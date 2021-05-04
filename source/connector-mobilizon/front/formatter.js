import DateTimeWrapper from './date-time-wrapper'

export default class Formatter {
  
  static formatDate({ locale, start, end }) {
    const startDateTime = new DateTimeWrapper({ locale, text: start })
    const endDateTime = new DateTimeWrapper({ locale, text: end })
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
