<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="updateusers.css">
<title>Waste Management</title>
<nav>
    <div class="div left-nav"> 
        <h2>WasteCompany</h2>
    </div>
    <div class="right-nav">
        <img src="logo.png" alt="Logo">
    </div>

    
</nav>
</head>
<body>

<?php
// Include necessary files and establish database connection
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'waste';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    // Fetch user details based on ID from the database
    $sql = "SELECT * FROM users WHERE user_id = $userId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Display edit form with user details pre-filled
        echo "<h2>Edit User</h2>";
        echo "<form action='addusers.php' method='post'>";
        echo "<input type='hidden' name='action' value='update'><n>";
        echo "<input type='hidden' name='user_id' value='" . $user['user_id'] . "'>";
        echo "<label for='srcode'>srcode:</label>";
        echo "<input type='text' id='srcode' name='srcode' value='" . $user['srcode'] . "' required><br>";
        echo "<label for='firstName'>First Name:</label>";
        echo "<input type='text' id='firstName' name='firstName' value='" . $user['first_name'] . "' required><br>";
        echo "<label for='lastName'>Last Name:</label>";
        echo "<input type='text' id='lastName' name='lastName' value='" . $user['last_name'] . "' required><br>";
        // Include the role field
        echo "<label for='role'>Role:</label>";
        echo "<select id='role' name='role' required>";
        echo "<option value='employee' " . ($user['role'] == 'employee' ? 'selected' : '') . ">Employee</option>";
        echo "<option value='admin' " . ($user['role'] == 'admin' ? 'selected' : '') . ">Admin</option>";
        echo "</select><br>";
        echo "<button type='submit'>Update User</button>";
        echo "</form>";
    } else {
        echo "User not found.";
    }
} else {
    echo "User ID not provided.";
}
?>
</body>
</html> 
