<!DOCTYPE html>
<html>
<head>
    <title>Student Details Form</title>
</head>
<body>
    <h2>Enter Student Details</h2>

    <!-- Student Details Form -->
    <form method="post" action="">
        <label>Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Address:</label>
        <textarea name="address" rows="3" cols="30" required></textarea><br><br>

        <label>Gender:</label>
        <input type="radio" name="gender" value="Male" required> Male
        <input type="radio" name="gender" value="Female" required> Female
        <input type="radio" name="gender" value="Other" required> Other<br><br>

        <label>Date of Birth:</label>
        <input type="date" name="dob" required><br><br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <hr>

    <?php
    // Check if form is submitted
    if (isset($_REQUEST['submit'])) {
        // Retrieve form data using $_REQUEST
        $name = $_REQUEST['name'];
        $email = $_REQUEST['email'];
        $address = $_REQUEST['address'];
        $gender = $_REQUEST['gender'];
        $dob = $_REQUEST['dob'];

        // Display student details
        echo "<h2>Student Details</h2>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Address:</strong> $address</p>";
        echo "<p><strong>Gender:</strong> $gender</p>";
        echo "<p><strong>Date of Birth:</strong> $dob</p>";
    }
    ?>
</body>
</html>

