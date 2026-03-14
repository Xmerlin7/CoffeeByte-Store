<?php
$title = "CoffeeByte - Login";
ob_start();
?>

<div class="container">
    <div class="auth-card">
    <h4 class="mb-4 text-center">Login</h4>
    <form>
        <div class="mb-3">
            <input class="form-control input-cafe" placeholder="Email">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control input-cafe" placeholder="Password">
        </div>
        <button class="btn-auth w-100">Login</button>
    </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include "./layouts/auth.php";
?>