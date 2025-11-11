<?php
// ---------------- DATABASE CONNECTION -----------------
$servername = "localhost";
$username = "root";     // default for XAMPP/WAMP
$password = "";         // default empty
$dbname = "Book_info"; // you can use any database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ---------------- CREATE TABLE (if not exists) -----------------
$table_sql = "CREATE TABLE IF NOT EXISTS bookdetails (
    book_no INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    edition VARCHAR(100),
    publisher VARCHAR(255)
)";
$conn->query($table_sql);

// ---------------- INSERT FORM DATA -----------------
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_no = $_POST['book_no'];
    $title = $_POST['title'];
    $edition = $_POST['edition'];
    $publisher = $_POST['publisher'];

    // Prepare SQL insert statement
    $stmt = $conn->prepare("INSERT INTO bookdetails (book_no, title, edition, publisher) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $book_no, $title, $edition, $publisher);

    if ($stmt->execute()) {
        $message = "✅ Book record added successfully!";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

// ---------------- FETCH ALL BOOKS -----------------
$result = $conn->query("SELECT * FROM bookdetails ORDER BY book_no ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Details Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 40px;
        }
        .container {
            width: 500px;
            background: white;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        input[type=submit]:hover {
            background-color: #0056b3;
        }
        h2 {
            text-align: center;
        }
        .message {
            color: green;
            text-align: center;
            font-weight: bold;
        }
        table {
            border-collapse: collapse;
            margin: 30px auto;
            width: 80%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Book Information Entry</h2>
    <?php if ($message != "") echo "<p class='message'>$message</p>"; ?>
    
    <form method="POST" action="">
        <label>Book Number:</label>
        <input type="number" name="book_no" required>

        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Edition:</label>
        <input type="text" name="edition">

        <label>Publisher:</label>
        <input type="text" name="publisher">

        <input type="submit" value="Add Book">
    </form>
</div>

<?php
// ---------------- DISPLAY ALL BOOKS -----------------
if ($result->num_rows > 0) {
    echo "<h2 align='center'>Book Details List</h2>";
    echo "<table>";
    echo "<tr><th>Book No</th><th>Title</th><th>Edition</th><th>Publisher</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['book_no']}</td>
                <td>{$row['title']}</td>
                <td>{$row['edition']}</td>
                <td>{$row['publisher']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p align='center'>No books found in the database.</p>";
}

$conn->close();
?>

</body>
</html>
