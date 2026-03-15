<?php
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Product.php';
require_once __DIR__ . '/../../classes/Category.php';
require_once __DIR__ . '/../../includes/layout.php';

$errors  = [];
$message = '';
$name = $price = $category_id = $imagePath = '';
$status = 'available';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = trim($_POST['name'] ?? '');
    $price       = $_POST['price'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $status      = $_POST['status'] ?? 'available';

    // ── Validate ──────────────────────────────────────────
    if ($name === '')        $errors[] = 'Product name is required.';
    if (!is_numeric($price)) $errors[] = 'Price must be a number.';
    if ($category_id === '') $errors[] = 'Please select a category.';

    // ── Handle image upload ───────────────────────────────
    $imagePath = '';
    if (!empty($_FILES['image']['name'])) {
        $allowed  = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $mimeType = mime_content_type($_FILES['image']['tmp_name']);

        if (!in_array($mimeType, $allowed)) {
            $errors[] = 'Image must be JPG, PNG, WEBP or GIF.';
        } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Image must be under 2 MB.';
        } else {
            $uploadDir = __DIR__ . '/../../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $ext       = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename  = uniqid('prod_') . '.' . $ext;
            $imagePath = 'uploads/' . $filename;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename);
        }
    }

    // ── Save ─────────────────────────────────────────────
    if (empty($errors)) {
        $product = new Product();
        $ok      = $product->create($name, (float)$price, (int)$category_id, $imagePath, $status);
        $message = $ok ? 'success' : 'error';
        if ($ok) { $name = $price = $category_id = $imagePath = ''; $status = 'available'; }
    }
}

$categoryObj = new Category();
$categories  = $categoryObj->getAll();


$title = "CoffeeByte - create-product";
ob_start();

//layout_head('Add Product', ['label' => '← Back', 'href' => 'manage-products.php']);
?>
    <h1 class="page-title">Add Product</h1>
    <p class="page-sub">Fill in the details below to create a new product.</p>

<?php if ($message === 'success'): ?>
    <div class="notif success">
        ✓ Product created successfully.
        <a href="manage-products.php" class="notif-link">View all →</a>
    </div>
<?php elseif ($message === 'error'): ?>
    <div class="notif error">
        ✕ Something went wrong. Please try again.
    </div>
<?php endif; ?>

<?php foreach ($errors as $e): ?>
    <div class="notif error">
        ✕ <?= htmlspecialchars($e) ?>
    </div>
<?php endforeach; ?>


    <div class="form-card">

        <form method="POST" enctype="multipart/form-data" class="admin-form">

            <div class="form-grid">

                <!-- Name -->
                <div class="field full">
                    <label for="name">Product Name</label>
                    <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?= htmlspecialchars($name) ?>"
                            placeholder="e.g. Cappuccino"
                            required
                    >
                </div>

                <!-- Price -->
                <div class="field">
                    <label for="price">Price ($)</label>
                    <input
                            type="number"
                            id="price"
                            name="price"
                            step="0.01"
                            min="0"
                            value="<?= htmlspecialchars($price) ?>"
                            placeholder="0.00"
                            required
                    >
                </div>

                <!-- Status -->
                <div class="field">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="available" <?= $status === 'available' ? 'selected' : '' ?>>Available</option>
                        <option value="unavailable" <?= $status === 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
                    </select>
                </div>

                <!-- Category -->
                <div class="field full">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">— Select a category —</option>

                        <?php foreach ($categories as $cat): ?>
                            <option
                                    value="<?= $cat['id'] ?>"
                                    <?= $category_id == $cat['id'] ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- Image Upload -->
                <div class="field full">

                    <label>Product Image</label>

                    <div class="upload-zone" id="uploadZone">

                        <input
                                type="file"
                                name="image"
                                id="imageInput"
                                accept="image/*"
                        >

                        <div class="upload-icon">📷</div>

                        <div class="upload-label">
                            <strong>Click to upload</strong> or drag & drop
                            <br>
                            PNG, JPG, WEBP — max 2 MB
                        </div>

                    </div>

                    <div class="preview-wrap" id="previewWrap">
                        <img id="previewImg" src="" alt="Preview">
                    </div>

                </div>

            </div>

            <div class="form-actions">

                <button type="submit" class="btn-save">
                    ✓ Create Product
                </button>

                <a href="manage-products.php" class="btn-cancel">
                    Cancel
                </a>

            </div>

        </form>

    </div>
    <script>
        const input   = document.getElementById('imageInput');
        const preview = document.getElementById('previewImg');
        const wrap    = document.getElementById('previewWrap');
        const zone    = document.getElementById('uploadZone');

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;
            preview.src = URL.createObjectURL(file);
            wrap.style.display = 'block';
        });

        zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('dragover'); });
        zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('dragover');
            input.files = e.dataTransfer.files;
            input.dispatchEvent(new Event('change'));
        });
    </script>

<?php
$content = ob_get_clean();
include "../../layouts/dash.php";
?>
<?php //layout_foot(); ?>