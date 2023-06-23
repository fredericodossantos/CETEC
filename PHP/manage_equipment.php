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

// Handle form submission - Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    // Get the form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // Insert the new equipment record
    $sql = "INSERT INTO equipment (name, description, category) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $description, $category);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "Equipment record added successfully.";
    } else {
        $error = "Failed to add equipment record.";
    }

    $stmt->close();
}

// Handle form submission - Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Get the form data
    $equipmentId = $_POST['equipment_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // Update the equipment record
    $sql = "UPDATE equipment SET name = ?, description = ?, category = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $description, $category, $equipmentId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "Equipment record updated successfully.";
    } else {
        $error = "Failed to update equipment record.";
    }

    $stmt->close();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $equipmentId = $_GET['delete'];

    // Delete the equipment record
    $sql = "DELETE FROM equipment WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $equipmentId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "Equipment record deleted successfully.";
    } else {
        $error = "Failed to delete equipment record.";
    }

    $stmt->close();
}

// Fetch all equipment records
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

    <?php
    if (isset($message)) {
        echo '<div class="success-message">' . $message . '</div>';
    } elseif (isset($error)) {
        echo '<div class="error-message">' . $error . '</div>';
    }
    ?>

    <h2>Add Equipment</h2>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        <label for="category">Category:</label>
        <input type="text" name="category" id="category" required>
        <button type="submit" name="add">Add</button>
    </form>

    <h2>Existing Equipment</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['description'] . '</td>';
                    echo '<td>' . $row['category'] . '</td>';
                    echo '<td>';
                    echo '<a href="manage_equipment.php?edit=' . $row['id'] . '">Edit</a>';
                    echo '<a href="manage_equipment.php?delete=' . $row['id'] . '">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">No equipment records found.</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <?php
    // Handle edit request
    if (isset($_GET['edit'])) {
        $equipmentId = $_GET['edit'];

        // Fetch the equipment record for editing
        $sql = "SELECT * FROM equipment WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $equipmentId);
        $stmt->execute();
        $editResult = $stmt->get_result();
        $stmt->close();

        if ($editResult->num_rows > 0) {
            $editRow = $editResult->fetch_assoc();
    ?>
            <h2>Edit Equipment</h2>
            <form action="" method="post">
                <input type="hidden" name="equipment_id" value="<?php echo $editRow['id']; ?>">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $editRow['name']; ?>" required>
                <label for="description">Description:</label>
                <textarea name="description" id="description" required><?php echo $editRow['description']; ?></textarea>
                <label for="category">Category:</label>
                <input type="text" name="category" id="category" value="<?php echo $editRow['category']; ?>" required>
                <button type="submit" name="update">Update</button>
            </form>
    <?php
        }
    }
    ?>
</body>
</html>
