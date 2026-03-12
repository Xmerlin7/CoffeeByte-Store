<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
</head>

<body class="bg-body-tertiary min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card border-0 shadow-lg rounded-4" style="width:100%;max-width:420px">
        <div class="card-body p-5">

            <div class="text-center mb-4">
                <span class="bg-warning bg-gradient p-3 rounded-3 d-inline-flex mb-3">
                    <i class="bi bi-key-fill text-white fs-4"></i>
                </span>
                <h4 class="fw-bold mb-0">Reset Password</h4>
                <p class="text-body-secondary small mt-1">Enter your email to reset your password</p>
            </div>

            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-danger text-center mb-3" role="alert">
                    <?= htmlspecialchars($_GET['message']) ?>
                </div>
            <?php endif; ?>

            <form action="../includes/render_resetPassword.php" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-secondary border-end-0">
                            <i class="bi bi-envelope text-body-secondary"></i>
                        </span>
                        <input type="email" name="email" class="form-control border-start-0 bg-body-secondary ps-0"
                            placeholder="you@example.com" autocomplete="email" required />
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" name="reset-btn" class="btn btn-warning rounded-3 fw-semibold py-2">
                        Send Reset Link <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>

                <p class="text-center text-body-secondary small mt-4 mb-0">
                    Remember your password? <a href="login.php" class="text-primary fw-semibold text-decoration-none">Sign In</a>
                </p>

            </form>

        </div>
    </div>
</body>

</html>