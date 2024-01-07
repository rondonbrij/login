<?php
// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  echo '<div class="login-container">
  <h2 class="title">Welcome Back!</h2>
  <p>You are currently logged in.</p>
  <form action="success.php" method="POST">
    <button type="submit" class="button">Continue</button>
  </form>
  <form action="logout.php" method="POST">
    <button type="submit" class="button">Logout</button>
  </form>
</div>';
  exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans&family=Ubuntu+Mono&display=swap');

    body {
      font-family: 'Open Sans', sans-serif;
      font-size: 16px;
      background-color: #f5f5f5;
      color: #333;
    }

    .login-container {
      width: 300px;
      margin: 100px auto;
      padding: 20px;
      background-color: #fff;
      text-align: center;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    input[type="text"],
    input[type="password"],
    button {
      width: 92%;
      margin-bottom: 10px;
      padding: 10px;
      background-color: #f0f0f0;
      color: #333;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      background-color: #ff2054;
      color: #fff;
      border: none;
      cursor: pointer;
    }

    .error {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>

<body class="dark-mode">
  <div class="login-container">
    <h2 class="title">Admin Page</h2>
    <form action="login.php" method="POST">
      <input type="text" class="input" name="username" placeholder="Username" required><br>
      <input type="password" class="input" name="password" placeholder="Password" required><br>
      <button type="submit" class="button">Login</button>
    </form>
    <?php if (isset($_GET['error'])): ?>
      <p class="error">Access Denied</p>
    <?php endif; ?>
  </div>
</body>

</html>