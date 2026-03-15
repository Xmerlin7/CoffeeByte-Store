<?php
$title = "CoffeeByte - Login";
ob_start();
?>

<div class="container">

    <div class="auth-card">

        <div class="text-center mb-4">

            <span class="auth-icon mb-3">
                <i class="bi bi-lightning-charge-fill"></i>
            </span>

            <h4 class="fw-bold mb-1">Welcome back</h4>

            <p class="text-muted small">
                Sign in to your account
            </p>

        </div>


        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-danger text-center mb-3">
                <?= htmlspecialchars($_GET['message']) ?>
            </div>
        <?php endif; ?>

        <form action="../includes/render_login.php" method="POST">

            <div class="mb-3">

                <input
                    type="email"
                    name="email"
                    class="form-control input-cafe"
                    placeholder="Email address"
                    autocomplete="email"
                    required
                />

            </div>


            <div class="mb-3">

                <input
                    type="password"
                    name="password"
                    class="form-control input-cafe"
                    placeholder="Password"
                    autocomplete="current-password"
                    required
                />

            </div>


            <div class="d-flex justify-content-end mb-3">

                <a href="resetPassword.php" class="auth-link small">
                    Reset password?
                </a>

            </div>


            <button
                type="submit"
                name="login-btn"
                class="btn-auth w-100"
            >
                Sign In
            </button>

        </form>

    </div>

</div>

<?php
$content = ob_get_clean();
include "../layouts/auth.php";
?>