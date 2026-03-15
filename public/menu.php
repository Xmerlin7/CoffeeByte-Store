<?php
session_start();
require "../classes/Product.php";

$title = "CoffeeByte - Our Menu";
ob_start();

$p = new Product();
$products = $p->getAll();
?>
<!-- src="<?= $product['image']?>" -->

<div class="container my-5">
    <h1>Our Menu</h1>
    <p>Fresh coffee every day ☕</p>
</div>
<div class="container">
    <div class="row row-cols-2">
        <?php foreach($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="cafe-card">
                <img src="../assets/imgs/backup-img.png" class="cafe-img" />
                <div class="cafe-body">
                    <h4 class="coffee-title"><?= $product['name'] ?></h4>
                    <span class="coffee-price">$<?= $product['price'] ?></span>
                    <div id="cart-<?= $product['id'] ?>" class="d-flex justify-content-between align-items-center mt-3">
                        <button class="btn-coffee" onclick="addToCart(<?= $product['id'] ?>)">
                            <i class="fa-solid fa-cart-arrow-down"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="../assets/js/cart.js"></script>

<?php
$content = ob_get_clean();
include "../layouts/main.php";
?>