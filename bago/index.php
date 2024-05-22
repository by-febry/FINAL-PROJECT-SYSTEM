<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['srcode'])) {
    // Establish database connection
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'waste';
    $conn = mysqli_connect($host, $user, $password, $dbname);

    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Sanitize input to prevent SQL injection
    $srcode = mysqli_real_escape_string($conn, $_POST['srcode']);

    // Query to check if srcode exists in the database and retrieve user role
    $sql = "SELECT user_id, role FROM users WHERE srcode = '$srcode'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // srcode is valid, set user ID and role in session
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_role'] = $row['role'];
        // Redirect the user to the dashboard or desired page
        header('Location: dashboard.php');
        exit(); // Make sure to exit after redirection
    } else {
        $error_message = "Invalid srcode. Please try again.";
    }

    mysqli_close($conn); // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Waste</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>
<!-- Your login form -->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <!-- Input field for srcode -->
    <div class="login">
        <h3>Login Here</h3>
        <input type="text" name="srcode" placeholder="Enter srcode" required><br>
        <button type="submit">Log In</button>
    </form>

    <?php
    // Display error message if srcode is invalid
    if (isset($error_message)) {
        echo "<p>$error_message</p>";
    }
    ?>
</div>
</body>
</html>
