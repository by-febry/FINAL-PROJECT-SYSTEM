<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste</title>
    <link rel="stylesheet" href="admindesign.css">
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
            <li><a href="admin.php">Admin</a></li>
        </ul>
    </div>
    <div class="right-nav">
        <img src="logo.png" alt="Logo">
    </div>
</nav>
    <h2>User Information</h2>
    


    <form action="addusers.php" method="post">
    <input type="hidden" name="action" value="create">
    <label for="srcode">srcode:</label>
    <input type="text" id="srcode" name="srcode" required><br>
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required><br>
    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required><br>
    <label for="role">Role:</label>
    <select id="role" name="role" required>
        <option value="employee">Employee</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Add User</button>
</form>


         <form action="addusers.php" method="post">
                <input type="hidden" name="action" value="delete">
                <label for="deleteSrcode">Enter srcode to delete user:</label>
                <input type="text" id="deleteSrcode" name="deleteSrcode" required>
                <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')">Delete User</button>
         </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>srcode</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role </th>
                <th>Action</th>
            </tr>
        </thead>
        
        <tbody>

        
        <?php
        // Fetch users from the database
        require_once "addusers.php"; // Include PHP script for handling CRUD operations

        $users = getUsers($conn); // Function to get users from the database

        if (!empty($users)) {
            foreach ($users as $user) {
                echo "<tr>" ;
                echo "<td>" . $user['user_id'] . "</td>" ;
                echo "<td>" . $user['srcode'] . "</td>" ;
                echo "<td>" . $user['first_name'] . "</td>" ;
                echo "<td>" . $user['last_name'] . "</td>" ;
                echo "<td>" . $user['role'] . "</td>" ;
                echo "<td>
                        <a href='updateusers.php?id=" . $user['user_id'] . "'>update</a> 
                     
                    
                      </td>" ;
                echo "</tr>" ;
            }
        } else {
            echo "<tr><td colspan='5'>No users found</td></tr>" ;
        }
        

        
        ?>
        </tbody>
    </table>

    <form id="logoutForm" action="index.php" method="post">
        <input type="hidden" name="logout" value="true">
        <button type="submit" onclick="return confirm('Are you sure you want to logout?')">lOGOUT</button>
    </form>
</body>
</html>

