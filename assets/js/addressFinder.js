const addressInput = document.getElementById('booking_step2_address')
const cityInput = document.getElementById('booking_step2_city')
const postalCodeInput = document.getElementById('booking_step2_postal_code')
const addressSuggestionsDiv = document.getElementById('address-suggestions')
let controller

addressInput.addEventListener('input', async () => {
  const query = addressInput.value.trim()

  if (query.length < 3) {
    addressSuggestionsDiv.innerHTML = ''
    console.log('< 3')
    return
  }

  if (controller) controller.abort()
  controller = new AbortController()

  try {
    console.log('2')
    const res = await fetch(
      `https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(query)}&limit=6`, {
        
        signal: controller.signal
      }
    )

    const data = await res.json()
    console.log(data)
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

  } catch (err) { }
})