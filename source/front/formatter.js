import DateTimeWrapper from './date-time-wrapper.js'

export default class Formatter {
  static formatDate({ locale, timeZone, start, end, isShortOffsetNameShown }) {
    const startDateTime = new DateTimeWrapper({
      locale,
      text: start,
      timeZone,
    })
    let dateText = startDateTime.getShortDate()
    dateText += ' ' + startDateTime.get24Time()
    if (!end && isShortOffsetNameShown) {
      dateText += ' (' + startDateTime.getShortOffsetName() + ')'
    }

    if (end) {
      const endDateTime = new DateTimeWrapper({ locale, text: end, timeZone })
      if (!startDateTime.equalsDate(endDateTime)) {
        dateText += ' - '
        dateText += endDateTime.getShortDate() + ' '
      } else {
        dateText += ' - '
      }
      dateText += endDateTime.get24Time()
      if (isShortOffsetNameShown) {
        dateText += ' (' + endDateTime.getShortOffsetName() + ')'
      }
    }
    return dateText
  }

  static formatLocation({ description, locality }) {
    let location = ''
    if (description && description.trim()) {
      location += description.trim()
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
