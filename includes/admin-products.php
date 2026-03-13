<?php
require_once '../classes/Product.php';

$product = new Product();
// Handle delete action
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $product = new Product();
    $deleted  = $product->delete((int) $_POST['delete_id']);
    $message  = $deleted ? 'success' : 'error';
}

$products = $product->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0d0d0f;
            --surface:   #16161a;
            --border:    #2a2a32;
            --accent:    #e8ff47;
            --accent2:   #ff6b35;
            --text:      #f0f0f5;
            --muted:     #6b6b7a;
            --danger:    #ff3b55;
            --safe:      #3bffb0;
            --radius:    12px;
        }

        body {
            font-family: 'Syne', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            padding: 0;
        }

        /* ── Header ── */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 28px 48px;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            background: rgba(13,13,15,.9);
            backdrop-filter: blur(14px);
            z-index: 100;
        }

        .logo {
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -.02em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo span {
            background: var(--accent);
            color: #000;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .06em;
        }

        .add-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: #000;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .85rem;
            padding: 10px 22px;
            border-radius: 50px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s;
        }
        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(232,255,71,.25);
        }

        /* ── Main ── */
        main { padding: 48px; max-width: 1320px; margin: 0 auto; }

        .page-title {
            font-size: 2.6rem;
            font-weight: 800;
            letter-spacing: -.04em;
            margin-bottom: 6px;
        }
        .page-sub {
            color: var(--muted);
            font-family: 'DM Mono', monospace;
            font-size: .8rem;
            margin-bottom: 36px;
        }
        .page-sub strong { color: var(--accent); }

        /* ── Notification ── */
        .notif {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            border-radius: var(--radius);
            font-size: .88rem;
            font-weight: 600;
            margin-bottom: 28px;
            animation: slideIn .3s ease;
        }
        .notif.success { background: rgba(59,255,176,.1); border: 1px solid rgba(59,255,176,.3); color: var(--safe); }
        .notif.error   { background: rgba(255,59,85,.1);  border: 1px solid rgba(255,59,85,.3);  color: var(--danger); }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Table ── */
        .table-wrap {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }

        thead tr {
            background: rgba(232,255,71,.05);
            border-bottom: 1px solid var(--border);
        }

        th {
            font-family: 'DM Mono', monospace;
            font-size: .7rem;
            font-weight: 500;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            padding: 16px 24px;
            text-align: left;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.03); }

        td {
            padding: 18px 24px;
            font-size: .9rem;
            vertical-align: middle;
        }

        /* ── Product image ── */
        .prod-img {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid var(--border);
            background: var(--border);
        }
        .no-img {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            background: var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .prod-name { font-weight: 700; font-size: .95rem; }
        .prod-id   { font-family: 'DM Mono', monospace; font-size: .72rem; color: var(--muted); margin-top: 2px; }

        .price {
            font-family: 'DM Mono', monospace;
            font-weight: 500;
            font-size: .95rem;
            color: var(--accent);
        }

        /* ── Status badge ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
        }
        .badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }
        .badge.available  { background: rgba(59,255,176,.12); color: var(--safe); }
        .badge.unavailable { background: rgba(255,59,85,.12);  color: var(--danger); }
        .badge.other       { background: rgba(255,107,53,.12); color: var(--accent2); }

        /* ── Action buttons ── */
        .actions { display: flex; align-items: center; gap: 10px; }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Syne', sans-serif;
            font-size: .78rem;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid var(--border);
            color: var(--text);
            background: transparent;
            cursor: pointer;
            transition: all .15s;
        }
        .btn-edit:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: rgba(232,255,71,.07);
        }

        .btn-del {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Syne', sans-serif;
            font-size: .78rem;
            font-weight: 700;
            border: 1px solid transparent;
            color: var(--danger);
            background: rgba(255,59,85,.08);
            cursor: pointer;
            transition: all .15s;
        }
        .btn-del:hover {
            background: var(--danger);
            color: #fff;
            box-shadow: 0 4px 16px rgba(255,59,85,.3);
        }

        /* ── Empty state ── */
        .empty {
            text-align: center;
            padding: 80px 24px;
            color: var(--muted);
        }
        .empty-icon { font-size: 3rem; margin-bottom: 16px; }
        .empty h3 { font-size: 1.1rem; font-weight: 700; color: var(--text); margin-bottom: 6px; }
        .empty p  { font-size: .85rem; }

        /* ── Modal ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.7);
            backdrop-filter: blur(6px);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.open { display: flex; }

        .modal {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 36px;
            max-width: 420px;
            width: 90%;
            animation: popIn .2s ease;
        }
        @keyframes popIn {
            from { opacity: 0; transform: scale(.94); }
            to   { opacity: 1; transform: scale(1); }
        }

        .modal h3 { font-size: 1.2rem; font-weight: 800; margin-bottom: 8px; }
        .modal p  { color: var(--muted); font-size: .88rem; line-height: 1.6; margin-bottom: 28px; }
        .modal-product { color: var(--text); font-weight: 700; }

        .modal-actions { display: flex; gap: 12px; justify-content: flex-end; }

        .modal-cancel {
            padding: 10px 22px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text);
            font-family: 'Syne', sans-serif;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            transition: border-color .15s;
        }
        .modal-cancel:hover { border-color: var(--muted); }

        .modal-confirm {
            padding: 10px 22px;
            border-radius: 8px;
            border: none;
            background: var(--danger);
            color: #fff;
            font-family: 'Syne', sans-serif;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            transition: box-shadow .15s, transform .15s;
        }
        .modal-confirm:hover {
            box-shadow: 0 6px 20px rgba(255,59,85,.4);
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            header { padding: 20px 24px; }
            main   { padding: 28px 24px; }
            .page-title { font-size: 1.8rem; }
            th, td { padding: 14px 16px; }
            th:nth-child(3), td:nth-child(3) { display: none; } /* hide category on mobile */
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        ⚡ Admin <span>PANEL</span>
    </div>
    <a href="add_product.php" class="add-btn">
        ＋ Add Product
    </a>
</header>

<main>
    <h1 class="page-title">Products</h1>
    <p class="page-sub">
        <strong><?= count($products) ?></strong> items in catalogue
    </p>

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
                        <!-- Product name + image -->
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

                        <!-- Price -->
                        <td>
                            <span class="price">$<?= number_format((float)$p['price'], 2) ?></span>
                        </td>

                        <!-- Category -->
                        <td style="color:var(--muted);font-size:.85rem;">
                            <?= htmlspecialchars($p['category_id']) ?>
                        </td>

                        <!-- Status -->
                        <td>
                            <?php
                            $s = strtolower($p['status'] ?? '');
                            $cls = match($s) {
                                'available'   => 'available',
                                'unavailable' => 'unavailable',
                                default       => 'other'
                            };
                            ?>
                            <span class="badge <?= $cls ?>"><?= htmlspecialchars($p['status']) ?></span>
                        </td>

                        <!-- Actions -->
                        <td>
                            <div class="actions">
                                <a href="edit_product.php?id=<?= $p['id'] ?>" class="btn-edit">
                                    ✎ Edit
                                </a>
                                <button
                                    class="btn-del"
                                    onclick="openModal(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['name'])) ?>')"
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
</main>

<!-- Delete confirmation modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <h3>Delete Product?</h3>
        <p>
            You're about to permanently delete
            <span class="modal-product" id="modalProductName"></span>.
            This action cannot be undone.
        </p>
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
    // Close on overlay click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>

</body>
</html>