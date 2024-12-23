<?php
require'DBconnect.php';

$sql = "
    SELECT 
        o.Order_ID, 
        o.Order_Date, 
        b.Username AS Buyer_Name, 
        od.Product_ID, 
        p.Name AS Product_Name, 
        od.Quantity, 
        od.Total_Price 
    FROM 
        `order` o
    JOIN 
        buyer b ON o.Buyer_ID = b.Buyer_ID
    JOIN 
        order_details od ON o.Order_ID = od.Order_ID
    JOIN 
        product p ON od.Product_ID = p.Product_ID
    ORDER BY 
        o.Order_Date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Order Details</h1>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Buyer Name</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['Order_ID']; ?></td>
                        <td><?php echo $row['Order_Date']; ?></td>
                        <td><?php echo $row['Buyer_Name']; ?></td>
                        <td><?php echo $row['Product_Name']; ?></td>
                        <td><?php echo $row['Quantity']; ?></td>
                        <td><?php echo number_format($row['Total_Price'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
