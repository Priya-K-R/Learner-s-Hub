<?php 
session_start();
include '../partials/_dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $uploaded_by = $_SESSION['user_id']; // Assuming you're storing user ID in session
    $uploaded_at = date('Y-m-d H:i:s');

    // File upload handling
    $targetDir = "uploads/study_materials/";
    $fileName = basename($_FILES["file"]["name"]);
    $fileTmp = $_FILES["file"]["tmp_name"];
    $newFileName = time() . "_" . preg_replace("/[^A-Za-z0-9.]/", "_", $fileName);
    $targetFilePath = $targetDir . $newFileName;

    if (move_uploaded_file($fileTmp, $targetFilePath)) {
        $sql = "INSERT INTO study_materials (title, description, file_path, subject, uploaded_by, uploaded_at)
                VALUES ('$title', '$description', '$targetFilePath', '$subject', '$uploaded_by', '$uploaded_at')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Study material uploaded successfully'); window.location.href='upload_material.php';</script>";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "File upload failed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload_Materials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 40px;
        }

        .upload-form-wrapper {
            background-color: #fff;
            max-width: 600px;
            margin: auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .upload-form-wrapper h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        .upload-form-wrapper label {
            display: block;
            margin-bottom: 6px;
            color: #555;
            font-weight: bold;
        }

        .upload-input-text,
        .upload-textarea,
        .upload-select,
        .upload-file {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .upload-btn-submit {
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .upload-btn-submit:hover {
            background-color: #0056b3;
        }

        .upload-back-link {
            margin-bottom: 20px;
            display: inline-block;
            color: #007bff;
            text-decoration: none;
        }

        .upload-back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="upload-form-wrapper">
        <div style="display: flex; justify-content: space-between; width: 70%; margin: auto;">
            <a class="upload-back-link" href="javascript:history.back()">← Back</a>
            <a href="../index.php" class="home-button">Home</a>
        </div>
        <h2>Upload Study Material</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" class="upload-input-text" required>

            <label>Description:</label>
            <textarea name="description" rows="4" class="upload-textarea" required></textarea>

            <label>Subject:</label>
            <select name="subject" class="upload-select" required>
                <option value="">Select Subject</option>
                <option value="Science">Science</option>
                <option value="Maths">Maths</option>
                <option value="Computer">Computer</option>
                <!-- Add more subjects as needed -->
            </select>

            <label>Choose PDF File:</label>
            <input type="file" name="file" class="upload-file" accept="application/pdf" required>

            <button type="submit" class="upload-btn-submit">Upload</button>
        </form>
    </div>

</body>

</html>