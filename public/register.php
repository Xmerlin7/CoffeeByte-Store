<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="min-vh-100 d-flex align-items-center justify-content-center">

    <div class="w-100 p-4" style="max-width:400px">

        <div class="text-center mb-4">
            <span class="bg-success bg-gradient p-3 rounded-3 d-inline-flex mb-3">
                <i class="bi bi-person-plus-fill text-white fs-4"></i>
            </span>
            <h4 class="fw-bold mb-0">Create Account</h4>
            <p class="text-body-secondary small mt-1">Join 50k+ teams using Nexus</p>
        </div>

        <?php
        if (isset($_GET['name_message'])) {
            echo '<div class="alert alert-danger text-center mb-3" role="alert">' . $_GET['name_message'] . '</div>';
        }
        if (isset($_GET['email_message'])) {
            echo '<div class="alert alert-danger text-center mb-3" role="alert">' . $_GET['email_message'] . '</div>';
        }
        if (isset($_GET['password_message'])) {
            echo '<div class="alert alert-danger text-center mb-3" role="alert">' . $_GET['password_message'] . '</div>';
        }
        if (isset($_GET['email_is_exist'])) {
            echo '<div class="alert alert-danger text-center mb-3" role="alert">' . $_GET['email_is_exist'] . '</div>';
        }
        if (isset($_GET['success_message'])) {
            echo '<div class="alert alert-success text-center mb-3" role="alert">' . $_GET['success_message'] . '</div>';
        }
        ?>

        <form action="../includes/render_register.php" method="POST">

            <div class="mb-3">
                <label class="form-label small fw-semibold">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text bg-body-secondary border-end-0">
                        <i class="bi bi-person text-body-secondary"></i>
                    </span>
                    <input type="text" name="name" class="form-control border-start-0 bg-body-secondary ps-0" placeholder="John Doe" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-body-secondary border-end-0">
                        <i class="bi bi-envelope text-body-secondary"></i>
                    </span>
                    <input type="email" name="email" class="form-control border-start-0 bg-body-secondary ps-0" placeholder="you@example.com" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-body-secondary border-end-0">
                        <i class="bi bi-lock text-body-secondary"></i>
                    </span>
                    <input type="password" name="password" class="form-control border-start-0 bg-body-secondary ps-0" placeholder="••••••••" required>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" name="register-btn" class="btn btn-success rounded-3 fw-semibold py-2">
                    Create Account <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </div>

            <p class="text-center text-body-secondary small mt-4 mb-0">
                Already have an account? <a href="login.php" class="text-success fw-semibold text-decoration-none">Login</a>
            </p>

        </form>
    </div>

</body>

</html>