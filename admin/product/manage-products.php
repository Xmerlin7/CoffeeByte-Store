<?php

require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Product.php';
require_once __DIR__ . '/../../classes/Category.php';

/* ── Handle delete ───────────────────────── */

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $p = new Product();
    $message = $p->delete((int) $_POST['delete_id']) ? 'success' : 'error';
}

/* ── Load data ───────────────────────── */

$product = new Product();
$products = $product->getAll();

$categoryObj = new Category();
$categories = $categoryObj->getAll();


/* ── Render ───────────────────────── */

$title = "CoffeeByte - Products";

ob_start();
?>

    <h2>Products</h1>

    <p class="page-sub">
        <strong><?= count($products) ?></strong> items in catalogue
    </p>


<?php if ($message === 'success'): ?>
    <div class="notif success">
        ✓ Product deleted successfully.
    </div>
<?php elseif ($message === 'error'): ?>
    <div class="notif error">
        ✕ Something went wrong. Please try again.
    </div>
<?php endif; ?>


    <!-- Category Filter -->

    <div class="filter-bar" id="filterBar">

        <button class="filter-btn active" data-cat="all">
            All
        </button>

        <?php foreach ($categories as $cat): ?>

            <button
                    class="filter-btn"
                    data-cat="<?= $cat['id'] ?>"
            >
                <?= htmlspecialchars($cat['name']) ?>
            </button>

        <?php endforeach; ?>

    </div>


    <div class="table-wrapper card">

        <?php if (empty($products)): ?>

            <div class="empty">

                <div class="empty-icon">📦</div>

                <h3>No products yet</h3>

                <p>Add your first product to get started.</p>

            </div>

        <?php else: ?>


            <table class="admin-table">

                <thead>

                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

                </thead>

                <tbody>

                <?php foreach ($products as $p): ?>

                    <tr data-cat="<?= $p['category_id'] ?>">

                        <td>

                            <div class="product-info">

                                <?php if (!empty($p['image'])): ?>

                                    <img
                                            src="../../<?= htmlspecialchars($p['image']) ?>"
                                            class="prod-img"
                                            alt="product-image"
                                            onerror="handleImageError(this)"
                                    >

                                <?php else: ?>

                                    <div class="no-img">🛒</div>

                                <?php endif; ?>


                                <div>

                                    <div class="prod-name">
                                        <?= htmlspecialchars($p['name']) ?>
                                    </div>

                                    <div class="prod-id">
                                        #<?= $p['id'] ?>
                                    </div>

                                </div>

                            </div>

                        </td>


                        <td>

<span class="price">
$<?= number_format((float)$p['price'], 2) ?>
</span>

                        </td>


                        <td class="cat-name">

                            <?php

                            $catName = '—';

                            foreach ($categories as $cat) {
                                if ($cat['id'] == $p['category_id']) {
                                    $catName = $cat['name'];
                                    break;
                                }
                            }

                            echo htmlspecialchars($catName);

                            ?>

                        </td>


                        <td>

                            <?php

                            $cls = match (strtolower($p['status'] ?? '')) {
                                'available' => 'available',
                                'unavailable' => 'unavailable',
                                default => 'other'
                            };

                            ?>

                            <span class="badge <?= $cls ?>">
<?= htmlspecialchars($p['status']) ?>
</span>

                        </td>


                        <td>

                            <div class="actions">

                                <a
                                        href="edit-product.php?id=<?= $p['id'] ?>"
                                        class="btn-edit"
                                >
                                    ✎ Edit
                                </a>

                                <button
                                        class="btn-delete"
                                        onclick="openModal(
                                        <?= $p['id'] ?>,
                                                '<?= htmlspecialchars(addslashes($p['name'])) ?>'
                                                )"
                                >
                                    🗑 Delete
                                </button>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        <?php endif; ?>

    </div>



    <!-- Delete Modal -->

    <div class="modal-overlay" id="deleteModal">

        <div class="modal">

            <h3>Delete Product?</h3>

            <p>
                You're about to permanently delete
                <span id="modalProductName"></span>.
            </p>

            <div class="modal-actions">

                <button
                        class="modal-cancel"
                        onclick="closeModal()"
                >
                    Cancel
                </button>

                <form method="POST">

                    <input
                            type="hidden"
                            name="delete_id"
                            id="modalDeleteId"
                    >

                    <button
                            type="submit"
                            class="modal-confirm"
                    >
                        Yes, Delete
                    </button>

                </form>

            </div>

        </div>

    </div>



    <script>

        function openModal(id, name) {

            document.getElementById('modalDeleteId').value = id;
            document.getElementById('modalProductName').textContent = '"' + name + '"';

            document
                .getElementById('deleteModal')
                .classList
                .add('open');

        }

        function closeModal() {

            document
                .getElementById('deleteModal')
                .classList
                .remove('open');

        }

        document
            .getElementById('deleteModal')
            .addEventListener('click', function(e) {

                if (e.target === this) closeModal();

            });


        /* Category Filter */

        document
            .getElementById('filterBar')
            .addEventListener('click', e => {

                const btn = e.target.closest('.filter-btn');

                if (!btn) return;

                document
                    .querySelectorAll('.filter-btn')
                    .forEach(b => b.classList.remove('active'));

                btn.classList.add('active');

                const cat = btn.dataset.cat;

                document
                    .querySelectorAll('tbody tr')
                    .forEach(row => {

                        row.style.display =
                            (cat === 'all' || row.dataset.cat === cat)
                                ? ''
                                : 'none';

                    });

            });

    </script>
    <script src="/assets/js/script.js"></script>


<?php

$content = ob_get_clean();

include "../../layouts/dash.php";