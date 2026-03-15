<?php
$title = "CoffeeByte - Register";
ob_start();
?>

<div class="container">
    <div class="auth-card">

        <div class="text-center mb-4">

            <span class="auth-icon mb-3">
                <i class="bi bi-person-plus-fill"></i>
            </span>

            <h4 class="fw-bold mb-1">Create Account</h4>

            <p class="text-muted small">
                Join 50k+ teams using Nexus
            </p>

        </div>

        <?php
        if (isset($_GET['name_message'])) {
            echo '<div class="alert alert-danger text-center">' . $_GET['name_message'] . '</div>';
        }
        if (isset($_GET['email_message'])) {
            echo '<div class="alert alert-danger text-center">' . $_GET['email_message'] . '</div>';
        }
        if (isset($_GET['password_message'])) {
            echo '<div class="alert alert-danger text-center">' . $_GET['password_message'] . '</div>';
        }
        if (isset($_GET['email_is_exist'])) {
            echo '<div class="alert alert-danger text-center">' . $_GET['email_is_exist'] . '</div>';
        }
        if (isset($_GET['success_message'])) {
            echo '<div class="alert alert-success text-center">' . $_GET['success_message'] . '</div>';
        }
        ?>


        <form action="../includes/render_register.php" method="POST">

            <div class="mb-3">
                <input
                    type="text"
                    name="name"
                    class="form-control input-cafe"
                    placeholder="Full Name"
                    required
                >
            </div>

            <div class="mb-3">
                <input
                    type="email"
                    name="email"
                    class="form-control input-cafe"
                    placeholder="Email Address"
                    required
                >
            </div>

            <div class="mb-4">
                <input
                    type="password"
                    name="password"
                    class="form-control input-cafe"
                    placeholder="Password"
                    required
                >
            </div>

            <button
                type="submit"
                name="register-btn"
                class="btn-auth w-100"
            >
                Create Account
            </button>

        </form>

        <p class="text-center small mt-4 mb-0">

            Already have an account?

            <a href="login.php" class="auth-link">
                Login
            </a>

        </p>

    </div>

</div>

<?php
$content = ob_get_clean();
include "../layouts/auth.php";
?>