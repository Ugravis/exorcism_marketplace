const addressInput = document.querySelector('.address-input-element')
const addressSuggestions = document.getElementById('address-suggestions')
let controller
console.log(addressSuggestions)

addressInput.addEventListener('input', async () => {
  const query = addressInput.value.trim()

  if (query.length < 3) {
    addressSuggestions.innerHTML = ''
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
    addressSuggestions.innerHTML = ''

    data.features.forEach(feature => {
      const li = document.createElement('li')
      li.textContent = feature.properties.label

      li.addEventListener('click', () => {
        addressInput.value = feature.properties.label
        addressSuggestions.innerHTML = ''
      })

      addressSuggestions.appendChild(li)
    })

  } catch (err) { }
})    