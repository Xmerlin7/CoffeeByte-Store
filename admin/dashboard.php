<?php
$title = "CoffeeByte - Dashboard";
ob_start();
?>

<div class="container">
    <h1>Welcome to Dashboard Admin Page for CoffeeByte Store</h1>
</div>

<?php
$content = ob_get_clean();
include "../layouts/dash.php";
?>