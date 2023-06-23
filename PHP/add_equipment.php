<?php
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
?>
