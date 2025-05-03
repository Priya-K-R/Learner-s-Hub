<?php
session_start();
include 'partials/_dbconnect.php'; // Make sure this file connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_SESSION);  // Debug session data
    print_r($_POST);     // Debug POST data
    echo "</pre>";

    if (!isset($_SESSION['email'])) {
        // die("Error: User not logged in.");
        header("Location: homeInstructor.php");
            exit;
    }

    if (empty($_POST['course_id'])) {
        die("Error: No course selected.");
    }

    $student_email = $_SESSION['email'];
    $course_id = intval($_POST['course_id']); // Ensure it's an integer

    // Check if course_id exists in courses table
    $check_query = "SELECT id FROM courses WHERE id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Error: Selected course does not exist.");
    }

    // Proceed with enrollment
    $sql = "INSERT INTO enrolled_courses (student_email, course_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $student_email, $course_id);

    if ($stmt->execute()) {
        header("Location: enrolled.php");
        
    } else {
    echo "Error: " . $stmt->error;
    }
}

?>
