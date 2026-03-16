<?php
$title = "CoffeeByte - Your Cart";
ob_start();
?>

<div class="container mt-5">
    <h1>Your Cart</h1>
    <div id="cart-info"></div>
</div>
<script src="../assets/js/cart.js"></script>
<script src="../assets/js/cart-view.js"></script>

<?php
$content = ob_get_clean();
include "../layouts/main.php";
?>