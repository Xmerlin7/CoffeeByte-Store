<?php
$title = "CoffeeByte - Reset Password";
ob_start();
?>

<div class="container">
    <div class="auth-card">
        <div class="text-center mb-4">
            <span class="auth-icon mb-3">
                <i class="bi bi-key-fill"></i>
            </span>
            <h4 class="fw-bold mb-1">Reset Password</h4>
            <p class="text-muted small">
                Enter your email to reset your password
            </p>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-danger text-center mb-3">
                <?= htmlspecialchars($_GET['message']) ?>
            </div>
        <?php endif; ?>

        <form action="../includes/render_resetPassword.php" method="POST">
            <div class="mb-3">
                <input
                    type="email"
                    name="email"
                    class="form-control input-cafe"
                    placeholder="Email Address"
                    autocomplete="email"
                    required
                />
            </div>

            <div class="mb-3">
                <input
                    type="password"
                    name="old_password"
                    class="form-control input-cafe"
                    placeholder="Old Password"
                    autocomplete="current-password"
                    required
                />
            </div>

            <button
                type="submit"
                name="reset-btn"
                class="btn-auth w-100"
            >
                Verify Email
            </button>

            <p class="text-center small mt-4 mb-0">
                Remember your password?
                <a href="login.php" class="auth-link">
                    Sign In
                </a>
            </p>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include "../layouts/auth.php";
?>