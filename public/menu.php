<?php
session_start();
require "../classes/Product.php";

$title = "CoffeeByte - Our Menu";
ob_start();

$p = new Product();
$products = $p->getAll();
?>

<div class="container my-5">
    <h1>Our Menu</h1>
    <p>Fresh coffee every day ☕</p>
</div>
<div class="container">
    <div class="row row-cols-1 md:row-cols-2">
        <?php foreach($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="cafe-card">
                <img src="../<?= htmlspecialchars($product['image']) ?>" class="cafe-img" onerror="handleImageError(this)" />
                <div class="cafe-body">
                    <h4 class="coffee-title"><?= $product['name'] ?></h4>
                    <span class="coffee-price">$<?= $product['price'] ?></span>
                     <?php if ($product['status'] === 'available'): ?>
                        <div id="cart-<?= $product['id'] ?>" class="d-flex justify-content-between align-items-center mt-3">
                            <button class="btn-coffee" onclick="addToCart(<?= $product['id'] ?>)">
                                <i class="fa-solid fa-cart-arrow-down"></i>
                                Add to Cart
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="mt-3 text-center">
                            <span class="text-muted p-2">Out of Stock</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="../assets/js/script.js"></script>
<script src="../assets/js/cart.js"></script>

<?php
$content = ob_get_clean();
include "../layouts/main.php";
?>