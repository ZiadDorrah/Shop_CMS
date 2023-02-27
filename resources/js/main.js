


let type = document.getElementById('validationTooltip04');
let details = document.getElementById('itemDetails');


if(details)
details.style.display = 'none';


if(type)
type.addEventListener('change', function(){

    if(type.value == 'Laptop')
        detailsDisplay = 'block';
    else 
        detailsDisplay = 'none'

    details.style.display = detailsDisplay;
    
})


let extra = document.querySelectorAll('.chkbox_item');



if(extra.length){
    
    let price = document.getElementById('price');
    let minPrice = document.getElementById('min_price');

    extra.forEach(element => {
    
        element.addEventListener('change', function(e){
            
            let priceoldVal = parseInt(price.innerText);
            let minOldVal = parseInt(minPrice.innerText);

            let extraPrice = parseInt(element.value);

            if(element.checked){
                price.innerText = priceoldVal + extraPrice;
                minPrice.innerText = minOldVal + extraPrice;
            }else{
                price.innerText = priceoldVal - extraPrice;
                minPrice.innerText = minOldVal - extraPrice;
            }

        })
    })
}