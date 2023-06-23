<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sipam_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add equipment form submission
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // Insert new equipment record
    $sql = "INSERT INTO equipment (name, description, category) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $description, $category);
    $stmt->execute();
    $stmt->close(); // Close the statement after executing the insert query

    // Redirect to the equipment management page
    header("Location: manage_equipment.php");
    exit();
}

// Handle delete equipment request
if (isset($_GET['delete'])) {
    $equipmentId = $_GET['delete'];

    // Delete the equipment record
    $sql = "DELETE FROM equipment WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $equipmentId);
    $stmt->execute();
    $stmt->close(); // Close the statement after executing the delete query

    // Redirect to the equipment management page
    header("Location: manage_equipment.php");
    exit();
}

// Handle edit equipment form submission
if (isset($_POST['update'])) {
    $equipmentId = $_POST['equipment_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // Update the equipment record
    $sql = "UPDATE equipment SET name = ?, description = ?, category = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $description, $category, $equipmentId);
    $stmt->execute();
    $stmt->close(); // Close the statement after executing the update query

    // Redirect to the equipment management page
    header("Location: manage_equipment.php");
    exit();
}

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

    <!-- Add Equipment Form -->
    <h2>Add Equipment</h2>
    <form action="manage_equipment.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="description">Description:</label>
        <input type="text" name="description">
        <label for="category">Category:</label>
        <input type="text" name="category">
        <button type="submit" name="add">Add</button>
    </form>

    <!-- Equipment List -->
    <h2>Equipment List</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td>
                    <a href="manage_equipment.php?edit=<?php echo $row['id']; ?>">Edit</a>
                    <a href="manage_equipment.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this equipment?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Edit Equipment Form -->
    <?php if (isset($_GET['edit']) && $editResult->num_rows > 0) { ?>
    <h2>Edit Equipment</h2>
    <?php $editRow = $editResult->fetch_assoc(); ?>
    <form action="manage_equipment.php" method="post">
        <input type="hidden" name="equipment_id" value="<?php echo $editRow['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $editRow['name']; ?>" required>
        <label for="description">Description:</label>
        <input type="text" name="description" value="<?php echo $editRow['description']; ?>">
        <label for="category">Category:</label>
        <input type="text" name="category" value="<?php echo $editRow['category']; ?>">
        <button type="submit" name="update">Update</button>
    </form>
    <?php } ?>
</body>
</html>
