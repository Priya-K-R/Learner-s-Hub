<?php
session_start();
include 'partials/_dbconnect.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $course_name = $_POST['course_name'];
    $doubt_type = $_POST['doubt_type'];
    $doubt_text = $_POST['doubt_text'];

    // Validate required fields  empty($first_name) ||
    if (empty($email) || empty($course_name) || empty($doubt_type) || empty($doubt_text)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit;
    }

    // Handle file upload
    $doubt_img = NULL; // Default to NULL if no file is uploaded
    if (isset($_FILES["upimg"]) && $_FILES["upimg"]["error"] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["upimg"]["name"]);
        $target_file = $target_dir . $file_name;

        // Allow certain file formats
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png", "gif");

        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.'); window.history.back();</script>";
            exit;
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["upimg"]["tmp_name"], $target_file)) {
            $doubt_img = $target_file; // Store file path in the database
        } else {
            echo "<script>alert('Error uploading file.'); window.history.back();</script>";
            exit;
        }
    }

    // Insert into database                                    course_id,                  phone,                        ?, ?,
   // Change your prepare statement to match the table structure
    $stmt = $conn->prepare("INSERT INTO doubts (student_email, doubt_text, doubt_type, course_name, doubt_img, reply_text) 
    VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $email, $doubt_text, $doubt_type, $course_name, $doubt_img, $reply_text);
    if ($stmt->execute()) {
        header("location: index.php");
        alert("Your doubt has been submitted successfully!");
    } else {
        // Add error logging
        error_log("Database error: " . $stmt->error);
        echo "<script>alert('Error submitting doubt: " . addslashes($stmt->error) . "'); window.history.back();</script>";
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
