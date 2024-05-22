<?php
// Establish a database connection (adjust the connection details as per your setup)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste";

// Create a new mysqli connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch summarized waste data grouped by month and year
$sql = "
    SELECT
        CONCAT(MONTH(wm.date_collected), '-', YEAR(wm.date_collected)) AS month_year,
        SUM(bw.prev_waste_generated + bw.curr_waste_generated) AS total_bio_waste,
        SUM(nw.prev_waste_generated + nw.curr_waste_generated) AS total_nonbio_waste,
        SUM(ow.prev_waste_generated + ow.curr_waste_generated) AS total_other_waste
    FROM
        waste_management wm
    LEFT JOIN bio_waste bw ON wm.user_id = bw.user_id
    LEFT JOIN nonbio_waste nw ON wm.user_id = nw.user_id
    LEFT JOIN other_waste ow ON wm.user_id = ow.user_id
    GROUP BY
        YEAR(wm.date_collected), MONTH(wm.date_collected)
    ORDER BY
        YEAR(wm.date_collected), MONTH(wm.date_collected)
";      

// Execute the SQL query
$result = $conn->query($sql);

// Initialize variables to track the cumulative waste for each month
$cumulative_bio_waste = 0;
$cumulative_nonbio_waste = 0;
$cumulative_other_waste = 0;

// Check if there are rows returned
if ($result->num_rows > 0) {
    $data = array(); // Initialize an empty array to store data

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Update cumulative waste variables
        $cumulative_bio_waste += $row['total_bio_waste'];
        $cumulative_nonbio_waste += $row['total_nonbio_waste'];
        $cumulative_other_waste += $row['total_other_waste'];

        // Add current month's cumulative data to the array
        $data[] = [
            'month_year' => $row['month_year'], // Store the month and year
            'total_bio_waste' => $cumulative_bio_waste, // Store cumulative bio waste
            'total_nonbio_waste' => $cumulative_nonbio_waste, // Store cumulative non-bio waste
            'total_other_waste' => $cumulative_other_waste // Store cumulative other waste
        ];
    }

    echo json_encode($data); // Output data in JSON format
} else {
    echo json_encode(array('error' => 'No data found')); // Output error message in JSON format
}

// Close the database connection
$conn->close();
?>
