<?php
require_once '../classes/Database.php';
require_once '../classes/Product.php';  // move your Product class there
require_once './layout.php';

// ── Handle delete ──────────────────────────────────────────
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $p       = new Product();
    $message = $p->delete((int) $_POST['delete_id']) ? 'success' : 'error';
}

$product  = new Product();
$products = $product->getAll();

// ── Render ────────────────────────────────────────────────
layout_head('Products', ['label' => '＋ Add Product', 'href' => 'add_product.php']);
?>

    <h1 class="page-title">Products</h1>
    <p class="page-sub"><strong><?= count($products) ?></strong> items in catalogue</p>

<?php if ($message === 'success'): ?>
    <div class="notif success">✓ &nbsp;Product deleted successfully.</div>
<?php elseif ($message === 'error'): ?>
    <div class="notif error">✕ &nbsp;Something went wrong. Please try again.</div>
<?php endif; ?>

    <div class="table-wrap">
        <?php if (empty($products)): ?>
            <div class="empty">
                <div class="empty-icon">📦</div>
                <h3>No products yet</h3>
                <p>Add your first product to get started.</p>
            </div>
        <?php else: ?>
            <table>
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
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:14px;">
                                <?php if (!empty($p['image'])): ?>
                                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="" class="prod-img">
                                <?php else: ?>
                                    <div class="no-img">🛒</div>
                                <?php endif; ?>
                                <div>
                                    <div class="prod-name"><?= htmlspecialchars($p['name']) ?></div>
                                    <div class="prod-id">#<?= $p['id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="price">$<?= number_format((float)$p['price'], 2) ?></span></td>
                        <td style="color:var(--muted);font-size:.85rem;"><?= htmlspecialchars($p['category_id']) ?></td>
                        <td>
                            <?php
                            $cls = match(strtolower($p['status'] ?? '')) {
                                'available'   => 'available',
                                'unavailable' => 'unavailable',
                                default       => 'other'
                            };
                            ?>
                            <span class="badge <?= $cls ?>"><?= htmlspecialchars($p['status']) ?></span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="edit_product.php?id=<?= $p['id'] ?>" class="btn-edit">✎ Edit</a>
                                <button
                                        class="btn-del"
                                        onclick="openModal(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['name'])) ?>')"
                                >🗑 Delete</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Delete confirmation modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <h3>Delete Product?</h3>
            <p>You're about to permanently delete <span class="modal-product" id="modalProductName"></span>. This action cannot be undone.</p>
            <div class="modal-actions">
                <button class="modal-cancel" onclick="closeModal()">Cancel</button>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_id" id="modalDeleteId">
                    <button type="submit" class="modal-confirm">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id, name) {
            document.getElementById('modalDeleteId').value = id;
            document.getElementById('modalProductName').textContent = '"' + name + '"';
            document.getElementById('deleteModal').classList.add('open');
        }
        function closeModal() {
            document.getElementById('deleteModal').classList.remove('open');
        }
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>

<?php layout_foot(); ?>