<?php
// ---------- DATABASE CONNECTION ----------
$servername = "localhost";
$username = "root";     // default for XAMPP
$password = "";         // default empty
$dbname = "Login_form";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ---------- LOGIN LOGIC ----------
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUser = $_POST['username'];
    $inputPass = $_POST['password'];

    // Check if username exists
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inputUser);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username exists → check password
        $row = $result->fetch_assoc();
        if ($row['password'] == $inputPass) {
            // Successful login
            header("Location: welcome.php?user=" . urlencode($row['username']));
            exit();
        } else {
            $message = "❌ Incorrect Password!";
        }
    } else {
        // Username not found → check if password matches any user
        $sql2 = "SELECT * FROM users WHERE password = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s", $inputPass);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows > 0) {
            $message = "❌ Incorrect Username!";
        } else {
            $message = "❌ Invalid Username and Password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f0f4f8;
        }
        .login-box {
            width: 350px;
            margin: 100px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #0056b3;
        }
        .message {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2 align="center">User Login</h2>
    <?php if ($message != "") echo "<p class='message'>$message</p>"; ?>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>

