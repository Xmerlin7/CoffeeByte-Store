function loadCart() {
  fetch("../../features/cart/get.php")
    .then((res) => {
      if (res.status === 401) {
        window.location.href = "/public/login.php?message=Please login first";
        throw new Error("Unauthorized");
      }

      if (!res.ok) {
        throw new Error("Failed to load cart");
      }

      return res;
    })
    .then((res) => res.json())
    .then((items) => {
      if (items.length == 0) {
        document.getElementById("cart-info").innerHTML =
          `<div class="cart-empty">
                        <p>No items found ☕</p>
                    </div>`;
        return;
      }

      let total = 0;
      let count = 0;
      let html = `
            <div class="cart-wrapper">
                <div class="table-responsive">
                <table class="table cafe-cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th class="text-center">Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
            `;

      items.forEach((item) => {
        total += parseFloat(item.total);
        count += parseInt(item.quantity);

        html += `
                <tr>
                    <td class="product-name">
                        ${item.name}
                    </td>
                    <td class="price">
                        $${item.price}
                    </td>
                    <td>
                        <div class="cart-controls">
                            <button onclick="decrease(${item.id})">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <span id="qty-${item.id}">
                                ${item.quantity}
                            </span>
                            <button onclick="increase(${item.id})">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td class="item-total">
                        $${item.total}
                    </td>
                    <td>
                        <button class="remove-btn"
                        onclick="removeItem(${item.id})">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                `;
      });
      html += `
                    </tbody>
                </table>
                </div>
                <div class="cart-summary">
                    <div class="summary-item">
                        <span>Total Items</span>
                        <strong>${count}</strong>
                    </div>
                    <div class="summary-item">
                        <span>Total Price</span>
                        <strong>$${total.toFixed(2)}</strong>
                    </div>
                    <a class="btn-checkout" href="/public/order.php">
                        Checkout
                    </a>
                </div>
            </div>
            `;
      document.getElementById("cart-info").innerHTML = html;
    })
    .catch((error) => {
      console.error(error);
      const cartInfo = document.getElementById("cart-info");
      if (cartInfo) {
        cartInfo.innerHTML = `<div class="cart-empty"><p>Could not load cart.</p></div>`;
      }
    });
}

loadCart();
