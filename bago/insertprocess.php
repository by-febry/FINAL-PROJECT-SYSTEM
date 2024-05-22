<?php
session_start(); // Start the session if not already started

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("Error: User ID not set in session.");
    }

    $user_id = $_SESSION['user_id'];

    // Sanitize input data (for security)
    function sanitizeInput($conn, $input)
    {
        return mysqli_real_escape_string($conn, $input);
    }

    // Process bio_waste data
    $prevWasteBio = sanitizeInput($conn, $_POST['prevWasteBio']);
    $currWasteBio = sanitizeInput($conn, $_POST['currWasteBio']);
    $wasteDisposalBio = sanitizeInput($conn, $_POST['wasteDisposalBio']);
    $remarksBio = sanitizeInput($conn, $_POST['remarksBio']);
    $varianceBio = $prevWasteBio + $currWasteBio - $wasteDisposalBio;

    // Insert data into bio_waste table
    $sqlBio = "INSERT INTO bio_waste (user_id, prev_waste_generated, curr_waste_generated, total_waste_generated, waste_disposal, variance, remarks)
               VALUES ('$user_id', '$prevWasteBio', '$currWasteBio', '$prevWasteBio + $currWasteBio', '$wasteDisposalBio', '$varianceBio', '$remarksBio')";

    if ($conn->query($sqlBio) === TRUE) {
        echo "Bio Waste record created successfully<br>";
    } else {
        echo "Error inserting Bio Waste record: " . $conn->error . "<br>";
    }

    // Process nonbio_waste data
    $prevWasteNonBio = sanitizeInput($conn, $_POST['prevWasteNonBio']);
    $currWasteNonBio = sanitizeInput($conn, $_POST['currWasteNonBio']);
    $wasteDisposalNonBio = sanitizeInput($conn, $_POST['wasteDisposalNonBio']);
    $remarksNonBio = sanitizeInput($conn, $_POST['remarksNonBio']);
    $varianceNonBio = $prevWasteNonBio + $currWasteNonBio - $wasteDisposalNonBio;

    // Insert data into nonbio_waste table
    $sqlNonBio = "INSERT INTO nonbio_waste (user_id, prev_waste_generated, curr_waste_generated, total_waste_generated, waste_disposal, variance, remarks)
                 VALUES ('$user_id', '$prevWasteNonBio', '$currWasteNonBio', '$prevWasteNonBio + $currWasteNonBio', '$wasteDisposalNonBio', '$varianceNonBio', '$remarksNonBio')";

    if ($conn->query($sqlNonBio) === TRUE) {
        echo "Non-Bio Waste record created successfully<br>";
    } else {
        echo "Error inserting Non-Bio Waste record: " . $conn->error . "<br>";
    }

    // Process other_waste data
    $prevWasteOther = sanitizeInput($conn, $_POST['prevWasteOther']);
    $currWasteOther = sanitizeInput($conn, $_POST['currWasteOther']);
    $wasteDisposalOther = sanitizeInput($conn, $_POST['wasteDisposalOther']);
    $remarksOther = sanitizeInput($conn, $_POST['remarksOther']);
    $varianceOther = $prevWasteOther + $currWasteOther - $wasteDisposalOther;

    // Insert data into other_waste table
    $sqlOther = "INSERT INTO other_waste (user_id, prev_waste_generated, curr_waste_generated, total_waste_generated, waste_disposal, variance, remarks)
                 VALUES ('$user_id', '$prevWasteOther', '$currWasteOther', '$prevWasteOther + $currWasteOther', '$wasteDisposalOther', '$varianceOther', '$remarksOther')";

    if ($conn->query($sqlOther) === TRUE) {
        echo "Other Waste record created successfully<br>";
    } else {
        echo "Error inserting Other Waste record: " . $conn->error . "<br>";
    }
    header("Location: dashboard.php");
    exit(); // Ensure script execution stops after redirection
    // Close the connection
    $conn->close();
}
?>
