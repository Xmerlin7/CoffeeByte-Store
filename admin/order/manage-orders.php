<?php  
require_once '../../classes/Database.php';
require_once '../../classes/Order.php';

// 1. INITIALIZE DATABASE & CLASSES
$db = new Database();
$pdo = $db->getConnection();
$orderObj = new Order($pdo);

$message = "";

// 2. HANDLE THE UPDATE ACTION (Must happen before fetching data)
if (isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];
    
    // Using the update method from your Order class
    // Ensure your Order class has: public function updateStatus($id, $status) { ... }
    if ($orderObj->updateStatus($orderId, $newStatus)) {
        $message = "Order #$orderId updated to " . str_replace('_', ' ', $newStatus) . "!";
    } else {
        $message = "Error: Could not update order.";
    }
}

// 3. FETCH FRESH DATA FROM DB
$allOrders = $orderObj->getAllOrders(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoffeeByte Admin - Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-coffee: #6F4E37;
            --bg-light: #f4f7f6;
            --text-dark: #2d3436;
            --border-color: #dfe6e9;
            --success-bg: #d4edda;
            --success-text: #155724;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .alert {
            padding: 15px;
            background-color: var(--success-bg);
            color: var(--success-text);
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        h2 {
            color: var(--primary-coffee);
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: 600;
            border-bottom: 2px solid var(--bg-light);
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            background-color: #fcfcfc;
            padding: 15px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #b2bec3;
            border-bottom: 2px solid var(--bg-light);
        }

        td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.95rem;
        }

        .status-badge {
            background: #f1f2f6;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .update-form {
            display: flex;
            gap: 8px;
        }

        select {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: white;
            outline: none;
        }

        button {
            padding: 8px 15px;
            background-color: var(--primary-coffee);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
        }

        button:hover {
            background-color: #5d402d;
        }

        tr:hover {
            background-color: #fdfdfd;
        }
    </style>
</head>
<body>

<div class="container">
    
    <?php if($message): ?>
        <div class="alert"><?= $message ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>Admin - All Orders</h2>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Current Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allOrders as $o): ?>
                <tr>
                    <td><strong>#<?= htmlspecialchars($o['id']) ?></strong></td>
                    <td><?= htmlspecialchars($o['user']) ?></td>
                    <td>
                        <span class="status-badge"><?= str_replace('_', ' ', $o['status']) ?></span>
                    </td>
                    <td>
                        <form method="POST" class="update-form">
                            <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                            
                            <select name="status">
                                <option value="processing" <?= $o['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                <option value="out_for_delivery" <?= $o['status'] == 'out_for_delivery' ? 'selected' : '' ?>>Out for Delivery</option>
                                <option value="delivered" <?= $o['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="cancelled" <?= $o['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>

                            <button name="update_status" type="submit">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>