<?php
session_start();
require 'partials/_dbconnect.php'; // your DB connection file

// 1. Get the course ID from the URL
$course_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
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
  <title>Explore Course -
    <?php echo htmlspecialchars($course['title']); ?>
  </title>
  <!-- <link rel="stylesheet" href="index.css"> -->
  <style>
    .explore-course-header {
      padding: 50px;
      /* padding-left: 10vw; */
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-bottom: 30px;
    }

    .buy-now-card {
      padding: 50px;
    }

    .explore-course-header img {
      border-radius: 8px;
    }

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
  <?php require 'partials/_nav.php'; ?>
  <?php require 'partials/_ask.php' ?>
  <div style="display: flex; gap: 50px; justify-content: center;">
    <div class="explore-course-header">
      <!-- Display the course cover, title, duration, faculty, description, etc. -->
      <img style="width: 40vw; height: 30vh; border: 1px solid blueviolet;"
        src="uploads/<?php echo htmlspecialchars($course['cover_img']); ?>" alt="Course Cover">
      <h1>
        <?php echo htmlspecialchars($course['title']); ?>
      </h1>
      <p style="width: 40vw; font-size: 18px;">
        <?php echo htmlspecialchars($course['description']); ?>
      </p>
      <p style="font-size: 17px;"><strong>Duration:</strong>
        <?php echo htmlspecialchars($course['duration']); ?>
      </p>
      <p style="font-size: 17px;"><strong>Price:</strong> $
        <?php echo htmlspecialchars($course['price']); ?>
      </p>
      <p style="font-size: 17px;"><strong>Faculty:</strong>
        <?php echo htmlspecialchars($course['faculty']); ?>
      </p>
      <!-- (Optional) Display the course lectures if you have them -->
      <div class="lectures">
        <h2>Demo Lecture</h2>
        <div class="lectures">
          <div style="display: flex; justify-content: space-between;">
            <div>
              <h3>
                Free Demo Lecture
              </h3>
            </div>
            <p><a href="<?php echo htmlspecialchars($course['video_link']); ?>" target="_blank">Watch Video</a></p>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="buy-now-card">
        <div style="margin-bottom: 10px; position: relative;">
          <img style="width:350px; height:200px;" class="card-m-img"
            src="uploads/<?php echo htmlspecialchars($course['cover_img']); ?>" alt="card-img">
          <h2 style="width:350px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
            <?php echo htmlspecialchars($course['title']); ?>
          </h2>
          <div
            style="display: flex; flex-direction: column; gap: 5px; margin-top: 10px; justify-content: space-between;">
            <p>Duration:
              <?php echo htmlspecialchars($course['duration']); ?>
            </p>
            <p>Faculty:
              <?php echo htmlspecialchars($course['faculty']); ?>
            </p>
            <p>Price:
              <?php echo htmlspecialchars($course['price']); ?>
            </p>
          </div>
          <div
            style="position: absolute; top:5px; background-color: green; padding: 8px; border-radius: 5px; color: white;">
            <p>Bestseller
            </p>
          </div>
        </div>
        <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
          <!-- Enroll Form -->
          <form action="payment.php" method="GET">
            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
            <input type="hidden" name="name" value="<?php echo htmlspecialchars($course['title']); ?>">
            <input type="hidden" name="price" value="<?php echo $course['price']; ?>">
            <input type="hidden" name="course_duration" value="<?php echo $course['duration']; ?>">
            <input type="hidden" name="course_faculity" value="<?php echo $course['faculty']; ?>">
            <a style="text-decoration: none; color: blueviolet;"
                href="enrolled_course.php?id=<?php echo $course['id']; ?>"><button
                style="border-radius: 5px; width:350px; padding: 10px; font-size: 18px; font-weight: 600; color: rgb(50, 5, 93); border:2px solid blueviolet;">Buy
                Now</button></a>

        </form>
          
        </div>
      </div>
    </div>
  </div>
  <?php require 'partials/_footer.php' ?>
</body>

</html>