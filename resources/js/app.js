import './bootstrap';

const checkProducts = document.querySelectorAll('.check-product')
checkProducts.forEach(checkProduct =>{
  checkProduct.addEventListener('change', (e)=> {
    let idProduct = e.target.id
      axios.post(`/products/${idProduct}`, {
        _method: 'DELETE'
      })
      .then( response => {
         console.log(response)
      })
      .catch( error => {
         console.log(error)
      })
  })
})
