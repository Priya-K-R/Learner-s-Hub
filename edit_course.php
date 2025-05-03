<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'instructor') {
    header("Location: login.php");
    exit;
}

require 'partials/_dbconnect.php';
$server   = "localhost";
$username = "root";
$password = "";
$database = "hubdb";

$conn = new mysqli($server, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure a course ID is provided
if (!isset($_GET['id'])) {
    echo "Course ID not provided.";
    exit;
}
$course_id = $_GET['id'];
$message = "";
$addlecture = ""; // Define variable before using

// Process form submission to update course
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_course"])) {
    $title       = $_POST["title"];
    $duration    = $_POST["duration"];
    $price       = $_POST["price"];
    $description = $_POST["description"];
    $video_link  = $_POST["video_link"] ?? '';
    $faculty     = $_POST["faculty"] ?? '';    

    $cover_img = $_POST["existing_cover_img"]; // Default to existing image
    if (!empty($_FILES["cover_img"]["name"])) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileExt  = pathinfo($_FILES["cover_img"]["name"], PATHINFO_EXTENSION);
        $fileName = "cover_" . uniqid() . "." . $fileExt;
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($_FILES["cover_img"]["tmp_name"], $targetFile)) {
            $cover_img = $fileName;
        } else {
            $message = "Error uploading cover image.";
        }
    }

    $sql = "UPDATE courses SET title = ?, cover_img = ?, duration = ?, price = ?, description = ?, video_link = ?, faculty = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $title, $cover_img, $duration, $price, $description, $video_link, $faculty, $course_id);
    
    if ($stmt->execute()) {
        $message = "Course updated successfully!";
    } else {
        $message = "Error updating course: " . $conn->error;
    }
    $stmt->close();
}

// Process form submission to add a lecture
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_lecture"])) {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $video_link  = $_POST['video_link'];
    $order_num   = $_POST['order_num'];

    $sql = "INSERT INTO lectures (course_id, title, description, video_link, order_num) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssi", $course_id, $title, $description, $video_link, $order_num);

    if ($stmt->execute()) {
        $addlecture = "Lecture added successfully!";
    } else {
        $addlecture = "Error: " . $conn->error;
    }
    $stmt->close();
}

// Fetch current course details before closing the connection
$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    echo "Course not found.";
    exit;
}
$course = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <style>
        .edit-course-container {
            display: flex;
            margin: auto;
            background: #fff;
            justify-content: center;
            padding: 50px;
            gap: 10vw;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background: blueviolet;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .message {
            margin-bottom: 20px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>

<body>
    <?php require 'partials/_nav.php' ?>

    <div class="edit-course-container">
        <div style="width: 40vw; padding-bottom:80px;">
            <h1>Edit Course</h1>
            <?php if (!empty($message)): ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            
            <form action="edit_course.php?id=<?php echo $course_id; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="update_course" value="1">

                <label for="title">Course Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>

                <label for="cover_img">Cover Image (current: <?php echo htmlspecialchars($course['cover_img']); ?>)</label>
                <input type="file" id="cover_img" name="cover_img">
                <input type="hidden" name="existing_cover_img" value="<?php echo htmlspecialchars($course['cover_img']); ?>">

                <label for="duration">Duration</label>
                <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($course['duration']); ?>" required>

                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($course['price']); ?>" required>

                <label for="description">Description</label>
                <textarea id="description" name="description"><?php echo htmlspecialchars($course['description']); ?></textarea>

                <label for="video_link">Video Link</label>
                <input type="text" id="video_link" name="video_link" value="<?php echo htmlspecialchars($course['video_link']); ?>">

                <label for="faculty">Faculty</label>
                <input type="text" id="faculty" name="faculty" value="<?php echo htmlspecialchars($course['faculty']); ?>" required>

                <button type="submit">Update Course</button>
            </form>
        </div>

        <div style="width:30vw; ">
            <h1>Add Lecture</h1>
            <p class="message"><?php echo htmlspecialchars($addlecture); ?></p>
            <form action="" method="post">
                <input type="hidden" name="add_lecture" value="1">
                <label>Lecture Title:</label>
                <input type="text" name="title" required>
                <label>Description:</label>
                <textarea name="description"></textarea>
                <label>Video Link:</label>
                <input type="text" name="video_link">
                <label>Order Number:</label>
                <input type="number" name="order_num">
                <button type="submit">Add Lecture</button>
            </form>
        </div>
    </div>

    <?php require 'partials/_footer.php' ?>
</body>
</html>
