// Importing input fields
const budgetInput = document.querySelector('#budget');

const productNameInput = document.querySelector('#name');
const productPriceInput = document.querySelector('#price');
const productQuantityInput = document.querySelector('#qty');

// Importing tags set to display data
const setBudget = document.querySelector('#setBudget');
const remainingBudget = document.querySelector('#remBudget');
const itemsSection = document.querySelector('.itemsSection');

// Importing buttons
const insertBudget = document.querySelector('#insert');
const insertProductDetails = document.querySelector('#insertData');

///////////////////////////////////////////////////////////////////////
let productDetailsTracker = [];

const budgetInsertHandler = () => {
    setBudget.innerHTML = budgetInput.value;
};

const productDetailsHandler = () => {
    if (setBudget.innerHTML == '') {
        alert('Please enter your budget!');
        return;
    }
    let productDetails = {
        name: productNameInput.value,
        price: productPriceInput.value,
        qty: productQuantityInput.value,
    };

    if (productDetails.name == '' ||
        productDetails.price == '' ||
        productDetails.qty == '') {
            alert('Please enter the details of the product correctly!')
            return;
        }

    productDetailsTracker.push(productDetails);
    console.log(productDetailsTracker);
    productNameInput.value = '';
    productQuantityInput.value = '';
    productPriceInput.value = '';

    displayProductDetails(productDetails.name, productDetails.price, productDetails.qty)
}

const displayProductDetails = (name, price, qty) => {
    itemsSection.innerHTML += `
    <div class="item">
        <p class="productName">Name - ${name}</p>
        <p class="productQty">Qty - ${qty}</p>
        <p class="productPrice">Price - ${price}</p>
    </div>`;
    budgetDeductor(price, qty);
};

let isFirstTime = true;

const budgetDeductor = (price, qty) => {
    if (isFirstTime) {
        remainingBudget.innerHTML = setBudget.innerHTML;
        isFirstTime = false;
    }
    remainingBudget.innerHTML = remainingBudget.innerHTML - price * qty;
};

insertBudget.addEventListener('click', budgetInsertHandler);
insertProductDetails.addEventListener('click', productDetailsHandler);