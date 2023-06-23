<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit();
}

// Connect to the database
require_once '../db/database.php';

// Include add equipment file
require_once 'add_equipment.php';

// Include edit equipment file
require_once 'edit_equipment.php';

// Include delete equipment file
require_once 'delete_equipment.php';

// Retrieve all equipment records
$sql = "SELECT * FROM equipment";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Equipment</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Manage Equipment</h1>

    <!-- Add Equipment Section -->
    <?php require_once 'add_equipment_form.php'; ?>

    <!-- Equipment List Section -->
    <?php require_once 'equipment_list.php'; ?>

    <!-- Edit Equipment Section -->
    <?php require_once 'edit_equipment_form.php'; ?>
</body>
</html>
