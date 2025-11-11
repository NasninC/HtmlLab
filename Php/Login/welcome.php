<?php
$user = $_GET['user'] ?? 'Guest';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial;
            background-color: #e9f5e9;
            text-align: center;
            padding-top: 100px;
        }
        h1 {
            color: #2b7a0b;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user); ?> 🎉</h1>
    <p>You have successfully logged in!</p>
    <a href="Login_form.php">Logout</a>
</body>
</html>

