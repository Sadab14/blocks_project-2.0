<?php
require 'DBconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_quantity'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $new_quantity = $_POST['product_quantity'];

        // Update product quantity based on Product ID and Name
        $stmt = $conn->prepare("UPDATE product SET quantity = ? WHERE product_id = ? AND name = ?");
        $stmt->bind_param("iis", $new_quantity, $product_id, $product_name);
        $stmt->execute();
        
    }

    if (isset($_POST['delete_order'])) {
        $order_id = $_POST['order_id'];

        // Delete related order details first
        $stmt = $conn->prepare("DELETE FROM `order_details` WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        // Delete the order
        $stmt = $conn->prepare("DELETE FROM `order` WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link rel="stylesheet" href="employee_styles.css">
</head>
<body>
    <header>
        <h1>Employee Management</h1>
    </header>
    <main>
        <!-- Update Product Quantity -->
        <section>
            <h2>Update Product Quantity</h2>
            <form method="POST" action="employee.php">
                <label for="product_id">Product ID:</label>
                <input type="number" name="product_id" id="product_id" required>
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" id="product_name" required>
                <label for="product_quantity">New Quantity:</label>
                <input type="number" name="product_quantity" id="product_quantity" required>
                <button type="submit" name="update_quantity">Update Quantity</button>
            </form>
        </section>

        <!-- View Product Stock -->
        <section>
            <h2>View Product Stock</h2>
            <?php
            $stock_result = $conn->query("SELECT product_id, name, price, category, quantity FROM product");

            if ($stock_result && $stock_result->num_rows > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = $stock_result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['product_id']) . "</td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['price']) . "</td>
                            <td>" . htmlspecialchars($row['category']) . "</td>
                            <td>" . htmlspecialchars($row['quantity']) . "</td>
                          </tr>";
                }
                echo "</tbody>
                    </table>";
            } else {
                echo "<p>No products in stock.</p>";
            }
            ?>
        </section>

        <!-- Manage Orders -->
        <section>
            <h2>Manage Orders</h2>
            <?php
            $result = $conn->query("SELECT o.order_id, o.buyer_id, o.order_date, b.username AS buyer_name FROM `order` o JOIN buyer b ON o.buyer_id = b.buyer_id");

            if ($result && $result->num_rows > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Buyer Name</th>
                                <th>Order Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['order_id']) . "</td>
                            <td>" . htmlspecialchars($row['buyer_name']) . "</td>
                            <td>" . htmlspecialchars($row['order_date']) . "</td>
                            <td>
                                <form method='POST' action='employee.php' style='display: inline-block;'>
                                    <input type='hidden' name='order_id' value='" . htmlspecialchars($row['order_id']) . "'>
                                    <button type='submit' name='delete_order'>Delete Order</button>
                                </form>
                            </td>
                        </tr>";
                }
                echo "</tbody>
                    </table>";
            } else {
                echo "<p>No orders found.</p>";
            }
            ?>
        </section>
    </main>
</body>
</html>
<?php $conn->close(); ?>
