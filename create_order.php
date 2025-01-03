<?php
require 'DBconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $buyer_id = $_POST['buyer_id'];
    $order_date = date('Y-m-d H:i:s');
    $products = $_POST['products']; // Array of products with Name and Quantity

    // Insert into `order` table
    $order_sql = "INSERT INTO `order` (Buyer_ID, Order_Date) VALUES (?, ?)";
    $stmt = $conn->prepare($order_sql);
    $stmt->bind_param("is", $buyer_id, $order_date);
    $stmt->execute();
    $order_id = $conn->insert_id; // Get the last inserted Order_ID

    // Insert into `order_details` table
    $order_details_sql = "INSERT INTO `order_details` (Order_ID, Product_ID, Quantity, Total_Price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($order_details_sql);

    foreach ($products as $product) {
        $product_name = $product['product_name'];
        $quantity = $product['quantity'];

        // Fetch product ID and price
        $product_sql = "SELECT Product_ID, Price FROM product WHERE Name = ?";
        $product_stmt = $conn->prepare($product_sql);
        $product_stmt->bind_param("s", $product_name);
        $product_stmt->execute();
        $product_result = $product_stmt->get_result();
        
        if ($product_row = $product_result->fetch_assoc()) {
            $product_id = $product_row['Product_ID'];
            $product_price = $product_row['Price'];

            // Calculate total price
            $total_price = $product_price * $quantity;

            // Insert into order_details
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $total_price);
            $stmt->execute();
        } else {
            echo "Error: Product '$product_name' not found.";
            exit();
        }
    }

    echo "Order created successfully!";
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="buy_styles.css">
</head>
<body>
    <h1>Create Order</h1>
    <form action="create_order.php" method="post">
        <label for="buyer_id">Buyer ID:</label>
        <input type="number" name="buyer_id" id="buyer_id" required>

        <h3>Products</h3>
        <div id="product-section">
            <div>
                <label for="product_name_1">Product Name:</label>
                <input type="text" name="products[0][product_name]" id="product_name_1" required>
                <label for="quantity_1">Quantity:</label>
                <input type="number" name="products[0][quantity]" id="quantity_1" required>
            </div>
        </div>

        <button type="button" onclick="addProduct()">Add More Products</button>
        <button type="submit">Submit Order</button>
    </form>

    <script>
        let productCount = 1;

        function addProduct() {
            const section = document.getElementById('product-section');
            const div = document.createElement('div');
            div.innerHTML = `
                <label for="product_name_${productCount}">Product Name:</label>
                <input type="text" name="products[${productCount}][product_name]" id="product_name_${productCount}" required>
                <label for="quantity_${productCount}">Quantity:</label>
                <input type="number" name="products[${productCount}][quantity]" id="quantity_${productCount}" required>
            `;
            section.appendChild(div);
            productCount++;
        }
    </script>
</body>
</html>
