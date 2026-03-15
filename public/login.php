<?php
$title = "CoffeeByte - Welcome back";
ob_start();
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* Background */

body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#2f2a26,#6f4e37);
    font-family:system-ui;
}

/* Card */

.login-card{
    width:100%;
    max-width:420px;
    border-radius:20px;
    padding:40px;
    background:white;
    box-shadow:0 25px 45px rgba(0,0,0,.25);
}

/* Logo */

.logo-box{
    width:60px;
    height:60px;
    background:#6f4e37;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:14px;
    margin:auto;
    margin-bottom:15px;
    color:white;
    font-size:22px;
}

/* Title */

.login-title{
    text-align:center;
    font-weight:700;
}

.login-sub{
    text-align:center;
    color:#777;
    font-size:.9rem;
    margin-bottom:25px;
}

/* Inputs */

.form-control{
    border-radius:10px;
    padding:10px;
}

.form-control:focus{
    border-color:#6f4e37;
    box-shadow:0 0 0 3px rgba(111,78,55,.15);
}

/* Button */

.btn-coffee{
    background:#6f4e37;
    color:white;
    border:none;
    border-radius:10px;
    padding:10px;
    font-weight:600;
}

.btn-coffee:hover{
    background:#5b3f2d;
}

/* Reset link */

.reset-link{
    font-size:.8rem;
    text-decoration:none;
    color:#6f4e37;
}

.reset-link:hover{
    text-decoration:underline;
}

</style>

</head>

<body>

<div class="login-card">

<div class="logo-box">
☕
</div>

<h4 class="login-title">Welcome back</h4>
<p class="login-sub">Sign in to your account</p>

<?php if (isset($_GET['message'])): ?>
<div class="alert alert-danger text-center">
<?= htmlspecialchars($_GET['message']) ?>
</div>
<?php endif; ?>

<form action="../includes/render_login.php" method="POST">

<div class="mb-3">
<label class="form-label small fw-semibold">Email address</label>
<input type="email"
name="email"
class="form-control"
placeholder="you@example.com"
required>
</div>

<div class="mb-3">

<div class="d-flex justify-content-between">
<label class="form-label small fw-semibold">Password</label>
<a href="resetPassword.php" class="reset-link">reset password?</a>
</div>

<input type="password"
name="password"
class="form-control"
placeholder="••••••••"
required>

</div>

<div class="d-grid">
<button type="submit" name="login-btn" class="btn btn-coffee">
Sign In
</button>
</div>

</form>

</div>

</body>
</html>
<?php
$title = "CoffeeByte - login";
ob_start();
?>
