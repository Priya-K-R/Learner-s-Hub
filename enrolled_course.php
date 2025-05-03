<?php
session_start();
require 'partials/_dbconnect.php'; // your DB connection file

// Get the course ID from the URL
// $course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
$course_id = isset($_GET['id']) ? $_GET['id'] : null;
if ($course_id <= 0) {
    echo "Invalid course ID.";
    exit;
}

// 2. Fetch the course from the database
$sqlCourse = "SELECT * FROM courses WHERE id = ?";
$stmtCourse = $conn->prepare($sqlCourse);
$stmtCourse->bind_param("i", $course_id);
$stmtCourse->execute();
$resultCourse = $stmtCourse->get_result();

if ($resultCourse->num_rows !== 1) {
    echo "Course not found.";
    exit;
}
$course = $resultCourse->fetch_assoc();
$stmtCourse->close();


// (Optional) If you have a `lectures` table, fetch the lectures for this course
$sqlLectures = "SELECT * FROM lectures WHERE course_id = ? ORDER BY order_num ASC";
$stmtLectures = $conn->prepare($sqlLectures);
$stmtLectures->bind_param("i", $course_id);
$stmtLectures->execute();
$resultLectures = $stmtLectures->get_result();
$lectures = [];
while ($row = $resultLectures->fetch_assoc()) {
    $lectures[] = $row;
}
$stmtLectures->close();

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enrolled Courses</title>
  <style>
    .lectures {
      margin-top: 30px;
    }

    .lectures {
      background: #fff;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 5px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .lecture h3 {
      margin: 0 0 5px;
    }
  </style>
</head>

<body>
  <?php require 'partials/_nav.php' ?>
  <?php require 'partials/_ask.php' ?>

  <div style="width: 70vw; margin: auto; min-height: 82vh;">

    <h1 style="padding: 15px;">
      <?php echo htmlspecialchars($course['title']); ?>
    </h1>
    <div class="lectures">
      <h2>Lectures</h2>
      <?php if (!empty($lectures)): ?>
      <?php foreach ($lectures as $lecture): ?>
      <div class="lectures">
        <div style="display: flex; justify-content: space-between;">
          <div>
            <h3>
              <?php echo htmlspecialchars($lecture['title']); ?>
            </h3>
            <p>
              <?php echo nl2br(htmlspecialchars($lecture['description'])); ?>
            </p>
          </div>
          <?php if (!empty($lecture['video_link'])): ?>
          <div style="display: flex; gap: 10px; flex-direction: column; width: 140px;">
            <p><a href="<?php echo htmlspecialchars($lecture['video_link']); ?>" target="_blank">Watch Video</a></p>
            <p>Download Notes</p>
          </div>
          
        </div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
      <?php else: ?>
      <p>No lectures available for this course.</p>
      <?php endif; ?>
    </div>

  </div>
  <!-- Congratulations! -->
  <?php require 'partials/_footer.php' ?>
</body>

</html>