<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Blocks inventory</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="background">
    <div class="login-container">
      <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
      <p>Role: <?php echo $_SESSION['role']; ?></p>
      
      <a href="logout.php">Logout</a>
    </div>
  </div>
</body>
</html>
