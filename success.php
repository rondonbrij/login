<?php
// Start the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Successful</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body class="dark-mode">
    <div class="login-container">
        <h1>Login Successful</h1>
        <p>Welcome! You have successfully logged in.</p>
        <a href="logout.php">Logout</a>
    </div>
</body>

</html>