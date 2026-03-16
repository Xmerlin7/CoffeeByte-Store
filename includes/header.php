<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
?>

<nav class="navbar navbar-expand-lg navbar-cafe">
  <div class="container">
    <a class="navbar-brand" href="/public/home.php">☕ CoffeeByte</a>
    
    <button class="navbar-toggler border-white" data-bs-toggle="collapse" data-bs-target="#nav">
      <i class="fa-solid fa-bars text-white"></i>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto me-4">
        <li class="nav-item">
          <a class="nav-link" href="/public/home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/public/menu.php">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/public/cart.php">Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/public/order.php">Orders</a>
        </li>
        </ul>
        <a class="btn btn-danger d-flex align-items-center gap-2" style="margin-top: 2px; width:fit-content;" href="/includes/logout.php">
          <i class="fa-solid fa-right-from-bracket"></i>
          Logout
        </a>
    </div>
  </div>
</nav>