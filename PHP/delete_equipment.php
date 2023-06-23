<?php
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
?>
