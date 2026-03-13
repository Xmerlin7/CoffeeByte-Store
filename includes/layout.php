<?php
function layout_head(string $title, array $btn = []): void { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin — <?= htmlspecialchars($title) ?></title>

        <!-- ✅ Absolute path from web root — works from ANY subfolder depth -->
        <link rel="stylesheet" href="/CoffeeByte-Store/assets/css/admin-products.css">
    </head>
    <body>

    <header>
        <div class="logo">⚡ Admin <span>PANEL</span></div>
        <?php if (!empty($btn)): ?>
            <a href="<?= htmlspecialchars($btn['href']) ?>" class="add-btn">
                <?= htmlspecialchars($btn['label']) ?>
            </a>
        <?php endif; ?>
    </header>

    <main>
<?php }

function layout_foot(): void { ?>
    </main>
    </body>
    </html>
<?php }