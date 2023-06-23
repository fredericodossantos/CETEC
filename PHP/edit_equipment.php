<?php
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
?>
