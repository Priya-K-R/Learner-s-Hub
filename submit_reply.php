<?php
require 'partials/_dbconnect.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $reply_text = isset($_POST['reply_text']) ? trim($_POST['reply_text']) : '';

    if ($id > 0 && !empty($reply_text)) {
        $query = "UPDATE doubts SET reply_text = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("si", $reply_text, $id); // FIXED: Changed $doubt_id to $id
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "error: " . $stmt->error; // Debugging message
            }
            $stmt->close();
        } else {
            echo "error: " . $conn->error;
        }
    } else {
        echo "error: Invalid input";
    }
}

$conn->close();
?>
