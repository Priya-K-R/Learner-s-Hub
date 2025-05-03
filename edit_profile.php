<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

$server   = "localhost";
$username = "root";
$password = "";
$database = "hubdb"; // Adjust if needed

$conn = new mysqli($server, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_email = $_SESSION['email'];
$message    = "";

// If form is submitted, update the user record
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fname  = $_POST['fname'];
    $lname  = $_POST['lname'];
    $courses = $_POST['courses'];
    $doubt  = $_POST['doubt'];

    // Handle profile image upload if a file is provided
    if (!empty($_FILES['profile_image']['name'])) {
        // Basic file upload (for demonstration)
        $targetDir = "uploads/";
        // e.g. "profile_abc123.jpg"
        $fileName  = "profile_" . uniqid() . "." . pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $targetFile = $targetDir . $fileName;

        // Move uploaded file
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
            // Update user row with new image
            $sql = "UPDATE users 
                    SET fname = ?, lname = ?, course = ?, doubt = ?, profile_image = ?
                    WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $fname, $lname, $courses, $doubt, $fileName, $user_email);
        } else {
            $message = "Error uploading image.";
        }
    } else {
        // Update user row without changing profile_image
        $sql = "UPDATE users 
                SET fname = ?, lname = ?, course = ?, doubt = ?
                WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $fname, $lname, $courses, $doubt, $user_email);
    }

    // Execute if $stmt is set (i.e., no file upload error)
    if (isset($stmt)) {
        if ($stmt->execute()) {
            $message = "Profile updated successfully.";
        } else {
            $message = "Error updating profile: " . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch the current data to pre-fill the form
$sql = "SELECT fname, lname, course, doubt, profile_image 
        FROM users 
        WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $fname         = $row['fname'];
    $lname         = $row['lname'];
    $courses       = $row['course'];
    $doubt         = $row['doubt'];
    $profile_image = $row['profile_image'];
} else {
    // Default fallback
    $fname         = '';
    $lname         = '';
    $courses       = '';
    $doubt         = '';
    $profile_image = 'default.jpg';
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <style>
    body {
      margin: 0; padding: 0;
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      height: 80vh;
    }
    .edit-container {
      max-width: 600px;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    h2 {
      margin-top: 0;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    label {
      margin-bottom: 10px;
    }
    input[type="text"],
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    button[type="submit"] {
      padding: 10px 15px;
      background: blueviolet;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
    .message {
      margin-bottom: 15px;
      color: green;
    }
    .profile-preview {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }
    .profile-preview img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 20px;
    }
  </style>
</head>
<body>

  <?php require 'partials/_nav.php'; ?>
  <?php require 'partials/_ask.php' ?>
<div>
  <div class="edit-container">
    <h2>Edit Profile</h2>
    <?php if(!empty($message)): ?>
      <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <div class="profile-preview">
      <img src="uploads/<?php echo htmlspecialchars($profile_image); ?>" alt="Current Profile">
      <div>
        <p>Current Image: <strong><?php echo htmlspecialchars($profile_image); ?></strong></p>
      </div>
    </div>

    <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
      <label for="fname">First Name:
        <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($fname); ?>" required>
      </label>
      <label for="lname">Last Name:
        <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($lname); ?>" required>
      </label>
      <label for="profile_image">Profile Image:
        <input type="file" id="profile_image" name="profile_image">
      </label>
      <label for="courses">Courses (comma-separated):
        <input type="text" id="courses" name="courses" value="<?php echo htmlspecialchars($courses); ?>">
      </label>
      <button type="submit">Update Profile</button>
    </form>
  </div>
  </div>

  <?php require 'partials/_footer.php'; ?>
</body>
</html>
