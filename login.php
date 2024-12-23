<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Blocks inventory</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="background">
    <div class="login-container">
      <h2>Login</h2>
      <form action="auth.php" method="POST">
        <div class="input-group">
          <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-group">
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="signup.php">Register</a></p>
      </form>
    </div>
  </div>
</body>
</html>