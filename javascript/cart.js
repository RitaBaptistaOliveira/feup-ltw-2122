async function attachBuyEvents() {
  for (const button of document.querySelectorAll('#products button'))
    button.addEventListener('click', async function () {
      const article = this.parentElement

      const id = article.getAttribute('data-id')
      const row = document.querySelector(`#cart table tr[data-id="${id}"]`)

      const name = article.querySelector('h3').textContent
      const price = article.querySelector('.price').textContent
      const quantity = article.querySelector('.quantity').value

      var url_string = window.location.href
      var url = new URL(url_string)
      var idR = url.searchParams.get("id")

      if (row) {
        updateRow(row, price, quantity)
      }
      else {
        addRow(id, name, price, quantity)
      }

      let data = { id: id, quantity: quantity, price: price, idR: idR };
      console.log(data)
/*
      const rawResponse = await fetch('../api/api_updateCart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax(data)
      });
*/
      updateTotal()
    })

  for (const button of document.querySelectorAll('#menus button'))
    button.addEventListener('click', async function () {
      const article = this.parentElement

      const id = article.getAttribute('data-id')
      const row = document.querySelector(`#cart table tr[data-id="${id}"]`)

      const name = article.querySelector('h3').textContent
      const price = article.querySelector('.price').textContent
      const quantity = article.querySelector('.quantity').value

      var url_string = window.location.href
      var url = new URL(url_string)
      var idR = url.searchParams.get("id")

      let data = { id: id, quantity: quantity, price: price, idR: idR }

      if (row) {
        updateRow(row, price, quantity)
      }
      else {
        if(quantity){}
          addRow(id, name, price, quantity)
      }
      /*
        const rawResponse = await fetch('../api_updateCart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: encodeForAjax(data)
        });
        */
      updateTotal()
    })
}

attachBuyEvents();

function addRow(id, name, price, quantity) {
  const table = document.querySelector('#cart table')
  const row = document.createElement('tr')
  row.setAttribute('data-id', id)

  const idCell = document.createElement('td')
  idCell.setAttribute("style", "display:none");
  idCell.textContent = id

  idCell.setAttribute("type", "hidden");

  const nameCell = document.createElement('td')
  nameCell.textContent = name

  const quantityCell = document.createElement('td')
  quantityCell.textContent = quantity

  const priceCell = document.createElement('td')
  priceCell.textContent = price

  const totalCell = document.createElement('td')
  totalCell.textContent = price * quantity

  const deleteCell = document.createElement('td')
  deleteCell.classList.add('delete')
  deleteCell.innerHTML = '<a href="">X</a>'
  deleteCell.querySelector('a').addEventListener('click', function (e) {
    e.preventDefault()
    e.currentTarget.parentElement.parentElement.remove()
    updateTotal()
  })

  row.appendChild(idCell)
  row.appendChild(nameCell)
  row.appendChild(quantityCell)
  row.appendChild(priceCell)
  row.appendChild(totalCell)
  row.appendChild(deleteCell)

  table.appendChild(row)
}

function updateRow(row, price, quantity) {
  const quantityCell = row.querySelector('td:nth-child(3)')
  const totalCell = row.querySelector('td:nth-child(5)')

  quantityCell.textContent = parseInt(quantityCell.textContent, 10) + parseInt(quantity, 10)
  totalCell.textContent = parseInt(quantityCell.textContent, 10) * parseInt(price, 10)
}

function updateTotal() {
  const rows = document.querySelectorAll('#cart table > tr')
  const values = [...rows].map(r => parseInt(r.querySelector('td:nth-child(5)').textContent, 10))
  const total = values.reduce((t, v) => t + v, 0)
  document.querySelector('#cart table tfoot th:last-child').textContent = total
}


function encodeForAjax(data) {
  return Object.keys(data).map(function (k) {
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}