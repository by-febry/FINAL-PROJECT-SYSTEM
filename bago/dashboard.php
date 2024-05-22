
        <?php
        // Establish database connection
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $dbname = 'waste';
        $conn = mysqli_connect($host, $user, $password, $dbname);

        if (!$conn) {
            die('Connection failed: ' . mysqli_connect_error());
        }
        session_start();

        // Check if user is logged in and get user ID and role from session
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
            // Redirect to login or handle unauthorized access
            
        }

        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];

        // Query to fetch the 5 most recent records from the waste_management table ordered by date_collected in descending order
        $sql = "SELECT u.first_name, u.last_name, wm.office, wm.garbage_collected, wm.date_collected
                FROM waste_management wm
                INNER JOIN users u ON wm.user_id = u.user_id
                ORDER BY wm.date_collected DESC
                LIMIT 5"; // Order by date_collected in descending order and limit to 5 records

        $result = mysqli_query($conn, $sql);
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="dashboard.css">
            <title>Waste Management</title>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Fetch data from PHP script using AJAX
            // Fetch data from PHP script using AJAX
        $.ajax({
            url: 'fetch_data.php', // Assuming you have a PHP script to fetch data
            dataType: 'json',
            success: function(data) {
                var chartData = [];
                chartData.push(['Month-Year', 'Biodegradable', 'Non-Biodegradable', 'Other']);

                // Populate chart data
                data.forEach(function(row) {
                    chartData.push([
                        row.month_year,
                        parseFloat(row.total_bio_waste),
                        parseFloat(row.total_nonbio_waste),
                        parseFloat(row.total_other_waste)
                    ]);
                });

                var chartDataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    title: 'Waste Management',
                    curveType: 'function',
                    legend: { position: 'bottom' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                chart.draw(chartDataTable, options);
            }
        });

        }

            </script>

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

            <h1>Monitoring Report</h1>

        <div id="curve_chart" style="width: 900px; height: 500px"></div>

            <table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Office</th>
                        <th>Garbage Collected</th>
                        <th>Date Collected</th>
                    </tr>   
                </thead>
                <tbody>
                <h1>Recent Logged</h1>
                    <?php
                    // Check if there are any rows returned by the query
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["first_name"] . "</td>";
                            echo "<td>" . $row["last_name"] . "</td>";
                            echo "<td>" . $row["office"] . "</td>";
                            echo "<td>" . $row["garbage_collected"] . "</td>";
                            echo "<td>" . $row["date_collected"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </body>
        <form id="logoutForm" action="index.php" method="post">
                <input type="hidden" name="logout" value="true">
                <button type="submit" onclick="return confirm('Are you sure you want to logout?')">lOGOUT</button>
            </form>
        </html>

        <?php
        // Close the database connection
        mysqli_close($conn);
        ?>
