<?php
session_start(); // Start the session to access session variables

// Check if user is logged in and get user_id from session
if (!isset($_SESSION['user_id'])) {
    // Redirect to login or handle unauthorized access
    header("Location: index.php");
    exit(); // Stop script execution
}

$user_id = $_SESSION['user_id']; // Get user_id from session

// Establish database connection (adjust the connection details as per your setup)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection
    $office = $conn->real_escape_string($_POST['office']);
    $trash_bin = $conn->real_escape_string($_POST['trash']);
    $garbage_collected = $conn->real_escape_string($_POST['collected']);
    $confirmed_by = $conn->real_escape_string($_POST['confirmed']);
    $remarks = $conn->real_escape_string($_POST['remarks']);
    $date_collected = $conn->real_escape_string($_POST['date']);

    // SQL query to insert data into waste_management table using $user_id
    $sql = "INSERT INTO waste_management (user_id, office, trash_bin, garbage_collected, confirmed_by, remarks, date_collected)
            VALUES ('$user_id', '$office', '$trash_bin', '$garbage_collected', '$confirmed_by', '$remarks', '$date_collected')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to a confirmation page after successful insertion
        header("Location: wasteinfo2.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<script>
function confirmSubmission() {
    // Ask for confirmation using JavaScript confirm dialog
    if (confirm("Are you sure you want to submit this form?")) {
        return true; // Proceed with form submission
    } else {
        return false; // Cancel form submission
    }
}
</script>
