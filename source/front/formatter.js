import DateTimeWrapper from './date-time-wrapper'

export default class Formatter {
  static formatDate({ locale, timeZone, start, end, isShortOffsetNameShown }) {
    const startDateTime = new DateTimeWrapper({
      locale,
      text: start,
      timeZone,
    })
    const endDateTime = new DateTimeWrapper({ locale, text: end, timeZone })
    let dateText = startDateTime.getShortDate()
    dateText += ' ' + startDateTime.get24Time()
    if (!startDateTime.equalsDate(endDateTime)) {
      if (isShortOffsetNameShown) {
        dateText += ' (' + startDateTime.getShortOffsetName() + ')'
      }
      dateText += ' - '
      dateText += endDateTime.getShortDate() + ' '
    } else {
      dateText += ' - '
    }
    dateText += endDateTime.get24Time()
    if (isShortOffsetNameShown) {
      dateText += ' (' + endDateTime.getShortOffsetName() + ')'
    }
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
