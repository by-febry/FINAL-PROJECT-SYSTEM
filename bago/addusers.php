<?php
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

// Function to get users from the database
function getUsers($conn) {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Create a new user
    if ($_POST['action'] === 'create') {
        createNewUser($conn);
    }
    // Update an existing user
    elseif ($_POST['action'] === 'update') {
        updateExistingUser($conn);
    }
    // Delete a user by srcode
    elseif ($_POST['action'] === 'delete' && isset($_POST['deleteSrcode'])) {
        $srcode = $_POST['deleteSrcode'];
        deleteBySrcode($conn, $srcode);
    }
}

// Function to create a new user
function createNewUser($conn) {
    $srcode = $_POST['srcode'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $role = $_POST['role']; // Include the role parameter

    $sql = "INSERT INTO users (srcode, first_name, last_name, role) VALUES ('$srcode', '$firstName', '$lastName', '$role')";
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php'); // Redirect after insertion
        exit();
    } else {
        echo 'Error: ' . $conn->error;
    }
}

// Function to update an existing user
function updateExistingUser($conn) {
    $userId = $_POST['user_id'];
    $srcode = $_POST['srcode'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $role = $_POST['role']; // Include the role parameter

    $sql = "UPDATE users SET srcode='$srcode', first_name='$firstName', last_name='$lastName', role='$role' WHERE user_id=$userId";
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php'); // Redirect after update
        exit();
    } else {
        echo 'Error: ' . $conn->error;
    }
}

// Function to delete a user by srcode
function deleteBySrcode($conn, $srcode) {
    // First, get the user_id for the given srcode
    $user_id_query = "SELECT user_id FROM users WHERE srcode = ?";
    $stmt_user_id = mysqli_prepare($conn, $user_id_query);
    mysqli_stmt_bind_param($stmt_user_id, "s", $srcode);
    mysqli_stmt_execute($stmt_user_id);
    mysqli_stmt_bind_result($stmt_user_id, $user_id);
    mysqli_stmt_fetch($stmt_user_id);
    mysqli_stmt_close($stmt_user_id);

    // Check if user_id was found
    if ($user_id) {
        // Delete related records in the bio_waste table
        $sql_delete_bio_waste = "DELETE FROM bio_waste WHERE user_id = ?";
        $stmt_delete_bio_waste = mysqli_prepare($conn, $sql_delete_bio_waste);
        mysqli_stmt_bind_param($stmt_delete_bio_waste, "i", $user_id);
        mysqli_stmt_execute($stmt_delete_bio_waste);
        mysqli_stmt_close($stmt_delete_bio_waste);

        // Delete related records in the nonbio_waste table
        $sql_delete_nonbio_waste = "DELETE FROM nonbio_waste WHERE user_id = ?";
        $stmt_delete_nonbio_waste = mysqli_prepare($conn, $sql_delete_nonbio_waste);
        mysqli_stmt_bind_param($stmt_delete_nonbio_waste, "i", $user_id);
        mysqli_stmt_execute($stmt_delete_nonbio_waste);
        mysqli_stmt_close($stmt_delete_nonbio_waste);

        // Delete related records in the other_waste table
        $sql_delete_other_waste = "DELETE FROM other_waste WHERE user_id = ?";
        $stmt_delete_other_waste = mysqli_prepare($conn, $sql_delete_other_waste);
        mysqli_stmt_bind_param($stmt_delete_other_waste, "i", $user_id);
        mysqli_stmt_execute($stmt_delete_other_waste);
        mysqli_stmt_close($stmt_delete_other_waste);

        // Delete related records in the waste_management table
        $sql_delete_waste_management = "DELETE FROM waste_management WHERE user_id = ?";
        $stmt_delete_waste_management = mysqli_prepare($conn, $sql_delete_waste_management);
        mysqli_stmt_bind_param($stmt_delete_waste_management, "i", $user_id);
        mysqli_stmt_execute($stmt_delete_waste_management);
        mysqli_stmt_close($stmt_delete_waste_management);

        // Now, delete the user from the users table
        $sql_delete_user = "DELETE FROM users WHERE srcode = ?";
        $stmt_delete_user = mysqli_prepare($conn, $sql_delete_user);
        mysqli_stmt_bind_param($stmt_delete_user, "s", $srcode);
        mysqli_stmt_execute($stmt_delete_user);
        mysqli_stmt_close($stmt_delete_user);

        // Redirect to the dashboard after deletion
        header('Location: dashboard.php');
        exit();
    } else {
        echo 'Error: User not found.';
    }
}
?>
