<?php
session_start();

// (Optional) Check if the user is an instructor/admin before allowing access
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'instructor') {
    header("Location: login.php");
    exit;
}

// Connect to database
$server   = "localhost";
$username = "root";
$password = "";
$database = "hubdb"; // Update if your DB name is different

$conn = new mysqli($server, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message for success/error feedback
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title       = $_POST['title'];
    $course_category = $_POST['course_category'];
    $duration    = $_POST['duration'];
    $price       = $_POST['price'];
    $description = $_POST['description'];
    $video_link  = $_POST['video_link'];
    $faculty     = $_POST['faculty'];

    // Handle cover image upload if provided
    $cover_img = 'default.jpg'; // default
    if (!empty($_FILES['cover_img']['name'])) {
        // Create an uploads folder (if it doesn't exist) or adjust $targetDir
        $targetDir = "uploads/";
        // Generate a unique filename
        $fileExt   = pathinfo($_FILES['cover_img']['name'], PATHINFO_EXTENSION);
        $fileName  = "cover_" . uniqid() . "." . $fileExt;
        $targetFile = $targetDir . $fileName;

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['cover_img']['tmp_name'], $targetFile)) {
            $cover_img = $fileName;
        } else {
            $message = "Error uploading cover image.";
        }
    }

    // Prepare and execute INSERT
    $sql = "INSERT INTO courses (title, cover_img, course_category, duration, price, description, video_link, faculty)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $title, $cover_img, $course_category, $duration, $price, $description, $video_link, $faculty);

    if ($stmt->execute()) {
        $message = "Course added successfully!";
    } else {
        $message = "Error adding course: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Course</title>
  <style>
    /* body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0; padding: 0;
    } */
    .add-course-container {
      max-width: 600px;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 6px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    h1 {
      margin-bottom: 20px;
      font-size: 24px;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    label {
      margin-bottom: 10px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="number"],
    textarea{
      width: 100%;
      padding: 8px;
      margin: 5px 0 15px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    input[type="file"] {
      width: 90%;
      padding: 8px;
      margin: 5px 0 15px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .course-category select{
      width: 100%;
      padding: 8px;
      margin: 5px 0 15px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    textarea {
      resize: vertical;
    }
    .add-course-button {
      width: 120px;
      padding: 10px;
      background: blueviolet;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }
    .message {
      margin-top: 15px;
      font-weight: bold;
      color: green;
    }
    .error {
      color: red;
    }
  </style>
</head>
<body>
  <?php require 'partials/_nav.php' ?>
  <div class="add-course-container ">
    <h1>Add New Course</h1>
    <?php if(!empty($message)): ?>
      <p class="message" id="alertMessage"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="add_course.php" method="POST" enctype="multipart/form-data">
      <label for="title">Course Title</label>
      <input type="text" id="title" name="title" required>

      <div style="display: flex; justify-content: space-between;">
        <div>
          <label for="cover_img">Cover Image</label>
          <input type="file" id="cover_img" name="cover_img">
        </div>
        <div class="course-category">
          <label for="course_category">Course Category</label>
          <select id="course_category" name="course_category">
             <option value="gov">Government</option>
             <option value="neet">NEET</option>
              <option value="iit">IIT</option>
              <option value="tech">Technology</option>
               <option value="management">Management</option>
             <option value="accounts">Accounts</option>
          </select>
        </div>
      </div>
      <label for="duration">Duration</label>
      <input type="text" id="duration" name="duration" placeholder="e.g. 10 hours" required>

      <label for="price">Price</label>
      <input type="number" step="0.01" id="price" name="price" placeholder="e.g. 499.99" required>

      <label for="description">Description</label>
      <textarea id="description" name="description" rows="4" required></textarea>

      <label for="video_link">Video Link</label>
      <input type="text" id="video_link" name="video_link" placeholder="https://youtu.be/xxxxx or file path">

      <label for="faculty">Faculty</label>
      <input type="text" id="faculty" name="faculty" required>

      <button class="add-course-button" type="submit">Add Course</button>
    </form>
  </div>
  <script>
    // Hide the message after 3 seconds (3000ms)
    setTimeout(function() {
        var messageElement = document.getElementById("alertMessage");
        if (messageElement) {
            messageElement.style.display = "none";
        }
    }, 3000);
</script>
</body>
</html>
