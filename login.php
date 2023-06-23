<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sipam_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}

// Check if the email and password are valid
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Valid login, redirect to dashboard.php
    header("Location: PHP/main.php");
    exit();
} else {
    // Invalid login, redirect to login.php with an error message
    header("Location: login.php?error=invalid");
    exit();
}

$stmt->close();
$conn->close();
?>
