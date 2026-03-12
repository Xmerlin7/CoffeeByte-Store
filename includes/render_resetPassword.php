<?php
include "../classes/Database.php";
$database = new Database();
$connection = $database->getConnection();

if (isset($_POST['reset-btn'])) {
    $email = $_POST['email'];
    $old_password = $_POST['old_password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../public/resetPassword.php?message=Please enter a valid email address.");
        exit();
    }

    // Check if email exists in database
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $connection->prepare($query);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: ../public/resetPassword.php?message=Email not found in our system.");
        exit();
    }

    // Verify old password
    if (!password_verify($old_password, $user['password'])) {
        header("Location: ../public/resetPassword.php?message=Old password is incorrect.");
        exit();
    }

    // Email and password verified, show new password form
?>
    <!DOCTYPE html>
    <html lang="en" data-bs-theme="dark">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Create New Password</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    </head>

    <body class="bg-body-tertiary min-vh-100 d-flex align-items-center justify-content-center">
        <div class="card border-0 shadow-lg rounded-4" style="width:100%;max-width:420px">
            <div class="card-body p-5">

                <div class="text-center mb-4">
                    <span class="bg-success bg-gradient p-3 rounded-3 d-inline-flex mb-3">
                        <i class="bi bi-check-circle-fill text-white fs-4"></i>
                    </span>
                    <h4 class="fw-bold mb-0">Password Verified</h4>
                    <p class="text-body-secondary small mt-1">Create a new password for your account</p>
                </div>

                <form action="update_resetPassword.php" method="POST">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                    <input type="hidden" name="old_password_hash" value="<?= htmlspecialchars($user['password']) ?>">

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body-secondary border-end-0">
                                <i class="bi bi-lock text-body-secondary"></i>
                            </span>
                            <input type="password" name="password" class="form-control border-start-0 bg-body-secondary ps-0"
                                placeholder="••••••••" required />
                        </div>
                        <small class="text-body-secondary">At least 8 characters with one letter</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Confirm New Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body-secondary border-end-0">
                                <i class="bi bi-lock text-body-secondary"></i>
                            </span>
                            <input type="password" name="confirm_password" class="form-control border-start-0 bg-body-secondary ps-0"
                                placeholder="••••••••" required />
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="update-btn" class="btn btn-success rounded-3 fw-semibold py-2">
                            Update Password <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>

                    <p class="text-center text-body-secondary small mt-4 mb-0">
                        <a href="../public/login.php" class="text-primary fw-semibold text-decoration-none">Back to Login</a>
                    </p>
                </form>

            </div>
        </div>
    </body>

    </html>
<?php
}
?>