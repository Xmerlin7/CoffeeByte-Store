function addToCart(productId) {
    fetch("../../features/cart/add.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "product_id=" + productId
    })
    .then(() => {
        renderControls(productId, 1)
    })
}

function increase(productId){
    let qtyElement = document.getElementById("qty-"+productId)
    let qty = parseInt(qtyElement.innerText) + 1
    update(productId,qty)
}

function decrease(productId) {
    let qty = parseInt(document.getElementById("qty-" + productId).innerText) - 1
    if (qty <= 0) {
        removeItem(productId)
        return
    }
    update(productId, qty)
}

function update(productId, qty) {
    fetch("../../features/cart/update.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "product_id=" + productId + "&quantity=" + qty
    })
    .then(() => {
        if(location.pathname.includes("cart"))
            loadCart();
        else
            document.getElementById("qty-" + productId).innerText = qty
    })
}

function removeItem(productId) {
    fetch("../../features/cart/remove.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "product_id=" + productId
    })
    .then(() => {
        if(location.pathname.includes("cart"))
            loadCart();
        else
            renderControls(productId,0)
    })
}

function renderControls(productId, quantity){
    let container = document.getElementById("cart-" + productId)
    if(quantity > 0){
    container.innerHTML = `
        <button onclick="decrease(${productId})">-</button>
        <span id="qty-${productId}">
        ${quantity}
        </span>
        <button onclick="increase(${productId})">+</button>
        <button onclick="removeItem(${productId})">Remove</button>
    `
    } else {
    container.innerHTML = `
        <button onclick="addToCart(${productId})">
        Add to Cart
        </button>
    `
    }
}

function loadCartState(){
    fetch("../../features/cart/get.php??action=state")
    .then(res => res.json())
    .then(items => {
        items.forEach(item => {
            renderControls(item.product_id,item.quantity)
        })
    })
}

if(location.href.includes("products")){
    document.addEventListener("DOMContentLoaded",function(){
        loadCartState()
    })
}