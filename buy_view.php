<?php
require 'DBconnect.php';

// Fetch products
$sql = "SELECT name, price, quantity FROM product ORDER BY name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer View</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Available Products</h1>
    </header>
    <main>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($row['price'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>
        <div class="action-buttons">
            <button onclick="window.location.href='create_order.php'">Create Order</button>
        </div>
    </main>
</body>
</html>

<?php
$conn->close();
?>
