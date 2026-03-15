<?php
$title = "CoffeeByte - Home";
ob_start();
?>

<div>
    <h1 class="text-center py-5 my-5">Welcome to ☕ CoffeeByte</h1>
</div>

<?php
$content = ob_get_clean();
include "../layouts/main.php";
?>