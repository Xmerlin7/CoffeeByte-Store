<?php
session_start();
require "../classes/Product.php";

$p = new Product();
$products = $p->getAll();
?>

<h2>Products</h2>

<?php foreach($products as $product): ?>
    <div>
        <h3><?= $product['name'] ?></h3>
        <p>$<?= $product['price'] ?></p>
        <div id="cart-<?= $product['id'] ?>">
            <button onclick="addToCart(<?= $product['id'] ?>)">
            Add to Cart
            </button>
        </div>
    </div>
<hr>
<?php endforeach; ?>

<a href="./cart.php">View Cart</a>

<script src="../assets/js/cart.js"></script>