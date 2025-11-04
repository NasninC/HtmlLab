<!DOCTYPE html>
<html>
<head>
    <title>Odd or Even Checker</title>
</head>
<body>

    <h2>Check Whether a Number is Odd or Even</h2>

    <form method="get" action="">
        Enter a number: 
        <input type="number" name="num" required>
        <input type="submit" value="Check">
    </form>

    <?php
    if (isset($_GET['num'])) {
        $num = $_GET['num'];

        if ($num % 2 == 0) {
            echo "<h3>The number $num is <span style='color:green;'>Even</span>.</h3>";
        } else {
            echo "<h3>The number $num is <span style='color:blue;'>Odd</span>.</h3>";
        }
    }
    ?>

</body>
</html>

