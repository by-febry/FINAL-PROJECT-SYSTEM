<?php
// Start the session to access session variables
session_start();

// Check if user is logged in and get user ID and role from session
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Redirect to login or handle unauthorized access
    
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/f9f109a3d9.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="wastedesign.css">
        <title>Waste Management</title>
</head>
<body>
<script>
        function setTrashBin() {
            var office = document.getElementById("office").value;
            var trashBin = document.getElementById("trash");

            switch(office) {
                case "CICS":
                case "HRMO":
                case "OVCAF":
                case "OVCDEA":
                    trashBin.value = 2; 
                    break;
                case "OVCRDES":
                case "CAS":
                    trashBin.value = 3;
                    break;
                case "OC":
                case "OVCAA":
                case "HSD/CLNIC":
                case "LIBRARY":
                case "CABE":
                    trashBin.value = 4;
                    break;
                case "ACCOUNTING":
                case "BUDGET":
                case "CTE":
                case "GSO":
                case "PRCORUEMENT/BAC":
                    trashBin.value = 1;
                    break;
                case "REGISTRAR":
                case "CASHIER":
                case "TAO":
                case "CE":
                case "FACULTY ROOM":
                case "OGC":
                case "UNIVERSITY SHOP":
                case "PSO":
                    trashBin.value = 2;
                    break;
                default:
                    trashBin.value = 0;
            }
        }
        function validateForm() {
    var office = document.getElementById("office").value;
    var trash = document.getElementById("trash").value;
    var collected = document.getElementById("collected").value;
    var confirmed = document.getElementById("confirmed").value;
    var remarks = document.getElementById("remarks").value;
    var date = document.getElementById("date").value;

    if (office === "" || trash === "" || collected === "" || confirmed === "" || remarks === "" || date === "") {
        alert("Error: Please fill in all fields.");
        return false;
    }

    return confirm("Are you sure you want to submit this form?");
}
</script>

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
    <div class="right-side">
        <form method="POST" action="insert_waste.php" onsubmit="return validateForm()">
            <label for="office">Office:</label><br>
            <select id="office" name="office" onchange="setTrashBin()">
                <option value="CICS">CICS</option>
                <option value="HRMO">HRMO</option>
                <option value="OVCRDES">OVCRDES</option>
                <option value="OVCAF">OVCAF</option>
                <option value="OVCDEA">OVCDEA</option>
                <option value="OC">OC</option>
                <option value="REGISTRAR">REGISTRAR</option>
                <option value="ACCOUNTING">ACCOUNTING</option>
                <option value="CASHIER">CASHIER</option>
                <option value="BUDGET">BUDGET</option>
                <option value="TAO">TAO</option>
                <option value="CE">CE</option>
                <option value="CAS">CAS</option>
                <option value="OVCAA">OVCAA</option>
                <option value="HSD/CLINIC">HSD/CLINIC</option>
                <option value="CTE">CTE</option>
                <option value="FACULTY ROOM">FACULTY ROOM</option>
                <option value="OGC">OGC</option>
                <option value="CTE">CTE</option>
                <option value="UNIVERSITY SHOP">UNIVERSITY SHOP</option>
                <option value="LIBRARY">LIBRARY</option>
                <option value="CABE">CABE</option>
                <option value="GSO">GSO</option>
                <option value="PROCUREMENT/BAC">PROCUREMENT/BAC</option>
                <option value="PSO">PSO</option>
                <!-- Add more options as needed -->
            </select><br>
            <label for="trash">No. of Trash Bin Garbage Collected:</label><br>
            <input type="text" id="trash" name="trash" readonly><br>
            <label for="collected">Garbage Collected:</label><br>
            <select id="collected" name="collected">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select><br>
            <label for="confirmed">Confirmed by:</label><br>
            <input type="text" id="confirmed" name="confirmed"><br>
            <label for="remarks">Remarks:</label><br>
            <textarea id="remarks" name="remarks"></textarea><br>
            <label for="date">Date:</label><br>
            <input type="date" id="date" name="date"><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</div>
<form id="logoutForm" action="index.php" method="post">
        <input type="hidden" name="logout" value="true">
        <button type="submit" onclick="return confirm('Are you sure you want to logout?')">lOGOUT</button>
    </form>
</body>
</html>

