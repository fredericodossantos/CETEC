<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Main Dashboard</h1>
        <table>
            <tbody>
                <tr>
                    <td><a href="dashboard.php">Dashboard</a></td>
                    <td>View statistics and recent activities</td>
                </tr>
                <tr>
                    <td><a href="manage_equipment.php">Equipment Management</a></td>
                    <td>Manage equipment records</td>
                </tr>
                <tr>
                    <td><a href="borrowers.php">Borrower Management</a></td>
                    <td>Manage borrower records</td>
                </tr>
                <tr>
                    <td><a href="transactionlog.php">Borrow Transaction Log</a></td>
                    <td>View borrow transaction history</td>
                </tr>
                <tr>
                    <td><a href="reports.php">Reports and Analytics</a></td>
                    <td>Generate reports and analyze data</td>
                </tr>
                <tr>
                    <td><a href="search.php">Search Functionality</a></td>
                    <td>Search for specific records</td>
                </tr>
                <tr>
                    <td><a href="profile.php">User Profile</a></td>
                    <td>Manage user profile and settings</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
