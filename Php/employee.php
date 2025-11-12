<?php
// --- DATABASE CONNECTION ---
$servername = "localhost";
$username = "root"; // Change if needed
$password = "";     // Change if needed
$dbname = "Employee_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS employees (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    salary DECIMAL(10,2) NOT NULL
)");

// --- HANDLE FORM SUBMISSION ---
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $department = trim($_POST['department']);
    $salary = trim($_POST['salary']);

    if ($name && $email && $department && $salary) {
        $stmt = $conn->prepare("INSERT INTO employees (name, email, department, salary) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $name, $email, $department, $salary);
        if ($stmt->execute()) {
            $message = "<p style='color:green;'>Employee added successfully!</p>";
        } else {
            $message = "<p style='color:red;'>Error saving employee.</p>";
        }
        $stmt->close();
    } else {
        $message = "<p style='color:red;'>Please fill all fields.</p>";
    }
}

// --- FETCH ALL EMPLOYEES ---
$result = $conn->query("SELECT * FROM employees ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Management</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f9; }
        h2 { color: #333; }
        form { background: white; padding: 20px; width: 400px; border-radius: 8px; box-shadow: 0 0 5px #aaa; }
        input, select { width: 100%; padding: 8px; margin: 6px 0; }
        input[type="submit"] { background: #007BFF; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background: #0056b3; }
        table { border-collapse: collapse; width: 100%; margin-top: 30px; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #007BFF; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .msg { margin: 10px 0; }
    </style>
</head>
<body>
    <h2>Employee Management System</h2>

    <div class="msg"><?php echo $message; ?></div>

    <form method="POST" action="">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Department:</label>
        <input type="text" name="department" required>

        <label>Salary:</label>
        <input type="number" name="salary" step="0.01" required>

        <input type="submit" value="Add Employee">
    </form>

    <h3>Employee List</h3>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Department</th><th>Salary</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['salary']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No employees found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>

