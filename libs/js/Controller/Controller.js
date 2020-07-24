class AddProduct{

    constructor(cadd){
        this.add =  document.getElementsByClassName(cadd)
        this.body = document.getElementById('product_cart')
        this.product = document.querySelector('#product')

        this.addProduct();
    }


    
 addProduct(){

  

        [...this.add].forEach(cart =>{

          
            cart.addEventListener('click', e =>{

               [...this.product.children].forEach(tr =>{
                    console.log(tr.innerHTML)
                });
               
            })
    
        })
}

}