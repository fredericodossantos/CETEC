<!-- Edit Equipment Form -->
<?php if (isset($_GET['edit'])) {
    // Retrieve the equipment record to edit from the database
    $editId = $_GET['edit'];
    $editQuery = "SELECT * FROM equipment WHERE id = ?";
    $editStmt = $conn->prepare($editQuery);
    $editStmt->bind_param("i", $editId);
    $editStmt->execute();
    $editResult = $editStmt->get_result();

    // Check if the record exists
    if ($editResult->num_rows > 0) {
        $editRow = $editResult->fetch_assoc();
        ?>
        <h2>Edit Equipment</h2>
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
        <?php
    }

    $editStmt->close(); // Close the statement after retrieving the record
}
?>
