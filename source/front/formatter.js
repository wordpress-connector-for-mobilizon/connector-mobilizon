export default class Formatter {
  static formatDate({
    startDateFormatted,
    startTimeFormatted,
    endDateFormatted,
    endTimeFormatted,
    showStartTime = true,
    showEndTime = true,
  }) {
    let dateText = startDateFormatted
    if (showStartTime) {
      dateText += ' ' + startTimeFormatted
    }
    if (endDateFormatted) {
      const endPieces = []
      if (startDateFormatted !== endDateFormatted) {
        endPieces.push(endDateFormatted)
      }
      if (showEndTime) {
        endPieces.push(endTimeFormatted)
      }
      if (endPieces.length) {
        dateText += ' - ' + endPieces.join(' ')
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
