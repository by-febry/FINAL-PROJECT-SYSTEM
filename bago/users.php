    <?php
    // Start the session to access session variables
    session_start();

    // Check if user is logged in and get user ID and role from session
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
        // Redirect to login or handle unauthorized access
        
    }
    $user_role = $_SESSION['user_role'];
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "waste";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];

    // Fetch user's current information from the database
    $sql = "SELECT srcode, first_name, last_name FROM users WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $srcode = $row['srcode'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
    } else {
        echo "User not found in the database.";
        exit(); // Stop script execution
    }

    // Check if the form is submitted for updating user information
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        // Sanitize input data
        $new_srcode = mysqli_real_escape_string($conn, $_POST['srcode']);
        $new_first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $new_last_name = mysqli_real_escape_string($conn, $_POST['last_name']);

        // Update user information in the database
        $update_sql = "UPDATE users SET srcode = '$new_srcode', first_name = '$new_first_name', last_name = '$new_last_name' WHERE user_id = '$user_id'";

        if ($conn->query($update_sql) === TRUE) {
            echo "User information updated successfully";
            // Refresh user information after update
            $srcode = $new_srcode;
            $first_name = $new_first_name;
            $last_name = $new_last_name;
        } else {
            echo "Error updating user information: " . $conn->error;
        }
    }

    $conn->close();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Information</title>
        <link rel="stylesheet" href="usersdesign.css">
    </head>
    <body>
    <nav>
        <div class="div left-nav"> 
            <h2>WasteCompany</h2>
        </div>
        <div class="left-side">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="wasteinfo.php">Waste Info</a></li>
                <li><a href="users.php">My Account</a></li>
            <?php
                    // Show the "Admin Panel" link only for users with the "admin" role
                    if ($user_role == 'admin') {
                        echo '<li><a href="admin.php">Admin Panel</a></li>';
                    }
                    ?>
            </ul>
        </div>
        <div class="right-nav">
            <img src="logo.png" alt="Logo">
        </div>
    </nav>
        <div class="container">
        <div class="user-form">
            <h2>User Information</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="srcode">Srcode:</label><br>
                <input type="text" id="srcode" name="srcode" value="<?php echo $srcode; ?>"><br>
            
                <label for="first_name">First Name:</label><br>
                <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>"><br>
            
                <label for="last_name">Last Name:</label><br>
                <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>"><br>
            
                <input type="submit" name="update" value="Update Information">
            </form>
        </div>
        <form id="logoutForm" action="index.php" method="post">
        <input type="hidden" name="logout" value="true">
        <button type="submit" onclick="return confirm('Are you sure you want to logout?')">lOGOUT</button>
    </form>
    </body>
    </html>
