import flatpickr from "flatpickr"
import { French } from "flatpickr/dist/l10n/fr.js"

const tomorrow = new Date()
tomorrow.setDate(tomorrow.getDate() + 1)

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.js-datepicker').forEach(input => {
    const disabledDates = JSON.parse(input.dataset.disabledDates || '[]')

    flatpickr(input, {
      locale: French,
      dateFormat: 'Y-m-d',
      minDate: tomorrow,
      disable: [
        date => date.getDay() === 0,
        ...disabledDates
      ]
    })
  })
})