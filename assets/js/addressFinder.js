const addressInput = document.getElementById('booking_step2_address')
const cityInput = document.getElementById('booking_step2_city')
const postalCodeInput = document.getElementById('booking_step2_postal_code')
const addressSuggestionsDiv = document.getElementById('address-suggestions')

let controller
let debounceTimer

function fetchWithTimeout(url, timeout, externalSignal) {
  const timeoutController = new AbortController()
  const timer = setTimeout(() => timeoutController.abort(), timeout)

  externalSignal?.addEventListener('abort', () => timeoutController.abort())

  return fetch(url, { signal: timeoutController.signal }).finally(() => clearTimeout(timer))
}

addressInput.addEventListener('input', () => {
  clearTimeout(debounceTimer)

  debounceTimer = setTimeout(async () => {
    const query = addressInput.value.trim()

    if (query.length < 3) {
      addressSuggestionsDiv.innerHTML = ''
      return
    }

    if (controller) controller.abort()
    controller = new AbortController()

    try {
      const res = await fetchWithTimeout(
        `https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(query)}&limit=6`,
        1000, 
        controller.signal
      )
      if (!res.ok) return

      const data = await res.json()
      addressSuggestionsDiv.innerHTML = ''

      data.features.forEach(feature => {
        const li = document.createElement('li')
        li.textContent = feature.properties.label

        li.addEventListener('click', () => {
          addressInput.value = feature.properties.name
          cityInput.value = feature.properties.city
          postalCodeInput.value = feature.properties.postcode
          addressSuggestionsDiv.innerHTML = ''
        })

        addressSuggestionsDiv.appendChild(li)
      })

    } catch (err) {
      if (err.name !== 'AbortError') {
        console.error(err)
      }
    }
  }, 400)
})