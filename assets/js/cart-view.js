function loadCart() {
    fetch("../../features/cart/get.php")
        .then(res => res.json())
        .then(items => {
            if (items.length == 0) {
                document.getElementById("cart-info").innerHTML = "<p>No Items Founded</p>";
                return;
            }

            let total = 0
            let count = 0
            let html = `
                <table border="1">
                    <thead>
                        <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
            `
            items.forEach(item => {
                total += parseFloat(item.total)
                count += parseInt(item.quantity)
                html += `
                <tr>
                    <td>${item.name}</td>
                    <td>$${item.price}</td>
                    <td>
                        <button onclick="decrease(${item.id})">-</button>
                        <span id="qty-${item.id}">${item.quantity}</span>
                        <button onclick="increase(${item.id})">+</button>
                    </td>
                    <td>$${item.total}</td>
                    <td>
                        <button onclick="removeItem(${item.id})">Remove</button>
                    </td>
                </tr>
            `})
            html += `
                    </tbody>
                </table>

                <h3>Total Items: ${count}</h3>
                <h3>Total Price: $${total.toFixed(2)}</h3>
            `
            document.getElementById("cart-info").innerHTML = html;
        })
}

loadCart()