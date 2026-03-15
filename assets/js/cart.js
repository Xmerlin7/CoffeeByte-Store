function handleCartResponse(res) {
  if (res.status === 401) {
    window.location.href = "/public/login.php?message=Please login first";
    throw new Error("Unauthorized");
  }

  if (!res.ok) {
    throw new Error("Cart request failed");
  }

  return res;
}

function addToCart(productId) {
  fetch("/features/cart/add.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "product_id=" + productId,
  })
    .then(handleCartResponse)
    .then(() => {
      renderControls(productId, 1);
    })
    .catch((error) => {
      console.error(error);
    });
}

function increase(productId) {
  let qtyElement = document.getElementById("qty-" + productId);
  let qty = parseInt(qtyElement.innerText) + 1;
  update(productId, qty);
}

function decrease(productId) {
  let qty = parseInt(document.getElementById("qty-" + productId).innerText) - 1;
  if (qty <= 0) {
    removeItem(productId);
    return;
  }
  update(productId, qty);
}

function update(productId, qty) {
  fetch("/features/cart/update.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "product_id=" + productId + "&quantity=" + qty,
  })
    .then(handleCartResponse)
    .then(() => {
      if (location.pathname.includes("cart")) loadCart();
      else document.getElementById("qty-" + productId).innerText = qty;
    })
    .catch((error) => {
      console.error(error);
    });
}

function removeItem(productId) {
  fetch("/features/cart/remove.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "product_id=" + productId,
  })
    .then(handleCartResponse)
    .then(() => {
      if (location.pathname.includes("cart")) loadCart();
      else renderControls(productId, 0);
    })
    .catch((error) => {
      console.error(error);
    });
}

function renderControls(productId, quantity) {
  let container = document.getElementById("cart-" + productId);
  if (quantity > 0) {
    container.innerHTML = `
            <div class="cart-controls">
                <button onclick="decrease(${productId})">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <span id="qty-${productId}">
                ${quantity}
                </span>
                <button onclick="increase(${productId})">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <button class="remove-btn" onclick="removeItem(${productId})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;
  } else {
    container.innerHTML = `
            <button class="btn-coffee" onclick="addToCart(${productId})">
                <i class="fa-solid fa-cart-arrow-down"></i>
                Add to Cart
            </button>
        `;
  }
}

function loadCartState() {
  fetch("/features/cart/get.php?action=state")
    .then(handleCartResponse)
    .then((res) => res.json())
    .then((items) => {
      items.forEach((item) => {
        renderControls(item.product_id, item.quantity);
      });
    })
    .catch((error) => {
      console.error(error);
    });
}

if (location.href.includes("menu")) {
  document.addEventListener("DOMContentLoaded", function () {
    loadCartState();
  });
}
