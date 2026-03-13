<?php
session_start();
require "classes/Database.php";

$db = (new Database())->getConnection();

$stmt = $db->prepare("SELECT id, name, price FROM products");
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<a href="./public/cart.php">View Cart</a>

<script src="./assets/js/cart.js"></script>