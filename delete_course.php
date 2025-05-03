<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'instructor') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "No course specified.";
    exit;
}
$course_id = $_GET['id'];

$server   = "localhost";
$username = "root";
$password = "";
$database = "hubdb";

$conn = new mysqli($server, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM courses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
if ($stmt->execute()) {
    // Redirect back to the courses page (adjust the target page as needed)
    header("Location: courses_dashboard.php");
    exit;
} else {
    echo "Error deleting course: " . $conn->error;
}
$stmt->close();
$conn->close();
?>
