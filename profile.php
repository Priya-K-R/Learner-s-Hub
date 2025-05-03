<?php
session_start();
include 'partials/_dbconnect.php';

// Redirect if user not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}


// Fetch user data
$user_email = $_SESSION['email'];
$sql = "SELECT fname, lname, role, doubt, profile_image FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $fname         = $row['fname'];
    $lname         = $row['lname'];
    $role          = $row['role'];
    $doubt         = $row['doubt'] ?? '';
    $profile_image = $row['profile_image'] ?? 'default.jpg';
} else {
    $fname = 'Unknown';
    $lname = 'User';
    $role = 'student';
    $doubt = '';
    $profile_image = 'default.jpg';
}
$stmt->close();

// Fetch enrolled course details
$enrolledCourses = [];
$sql = "SELECT c.id, c.title, c.description, c.cover_img, c.duration, c.price, c.faculty, c.video_link, c.course_category, ec.enrollment_date
        FROM enrolled_courses ec
        JOIN courses c ON ec.course_id = c.id
        WHERE ec.student_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $enrolledCourses[] = $row;
}

$stmt->close();

// Fetch doubts asked by the student
$studentDoubts = [];
$sql = "SELECT id, course_id, course_name, doubt_type, doubt_text, doubt_img, reply_text
        FROM doubts
        WHERE student_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $studentDoubts[] = $row;
}
$stmt->close();


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>My Profile</title>
  <style>
    .profile-container {
      font-family: Arial, sans-serif;
      max-width: 900px;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid #ddd;
      padding-bottom: 15px;
    }

    .profile-info {
      display: flex;
      align-items: center;
    }

    .profile-info img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 20px;
    }

    .profile-info h2 {
      margin: 0;
    }

    .profile-details {
      margin-top: 20px;
    }

    .profile-details h3 {
      margin-bottom: 10px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
    }

    .edit-btn {
      padding: 8px 12px;
      background: blueviolet;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
    }

    ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    li {
      margin-bottom: 5px;
    }

    .en-courses-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .en-course-card {
      border: 1px solid #ddd;
      padding: 15px;
      border-radius: 10px;
      width: 250px;
      background-color: #f9f9f9;
    }

    .en-course-card img {
      border-radius: 8px;
    }

    .st-doubts-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .st-doubt-card {
      border: 1px solid #ddd;
      padding: 15px;
      border-radius: 10px;
      width: 100%;
      /* max-width: 500px; */
      background-color: #fff;
    }

    .st-doubt-card img {
      border-radius: 6px;
      margin-top: 10px;
    }
  </style>
</head>

<body>

  <!-- Navbar (optional) -->
  <?php require 'partials/_nav.php'; ?>
  +<div style="min-height: 80vh;">
    <div class="profile-container">
      <div class="profile-header">
        <div class="profile-info">
          <!-- Profile Image -->
          <img src="uploads/<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image">
          <div>
            <!-- Name & Role -->
            <h2>
              <?php echo htmlspecialchars($fname . " " . $lname); ?>
            </h2>
            <p>Role:
              <?php echo htmlspecialchars($role); ?>
            </p>
          </div>
        </div>
        <!-- Link to Edit Page -->
        <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
      </div>

      <!-- Courses -->
      <div class="courses-wrapper">
        <h2 style="padding: 10px 20px 30px 5px;">Your Enrolled Courses</h2>
        <?php if (!empty($enrolledCourses)): ?>
        <div class="en-courses-grid">
          <?php foreach ($enrolledCourses as $course): ?>
          <div class="en-course-card">
            <img src="uploads/<?php echo htmlspecialchars($course['cover_img']); ?>" alt="Cover Image" width="250">
            <h3>
              <?php echo htmlspecialchars($course['title']); ?>
            </h3>
            <p><strong>Faculty:</strong>
              <?php echo htmlspecialchars($course['faculty']); ?>
            </p>
            <p><strong>Duration:</strong>
              <?php echo htmlspecialchars($course['duration']); ?>
            </p>
            <?php if (!empty($course['video_link'])): ?>
            <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
              <a href="<?php echo htmlspecialchars($course['video_link']); ?>" target="_blank"><button
                  class="btn11">Demo Lec</button></a>
                  <a href="enrolled_course.php?id=<?php echo $course['id']; ?>"><button type="submit" class="btn1">Start Study</button></a>
              
            </div>
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p>You are not enrolled in any courses.</p>
        <?php endif; ?>
      </div>



      <!-- Doubt -->
      <div class="profile-details">
        <div class="st-doubts-wrapper">
          <h2>Your Asked Doubts</h2>
          <?php if (!empty($studentDoubts)): ?>
          <div class="st-doubts-grid">
            <?php foreach ($studentDoubts as $doubt): ?>
            <div class="st-doubt-card">
              <!-- <p><strong>Course:</strong>
                <?php echo htmlspecialchars($doubt['course_name']); ?>
              </p>
              <p><strong>Type:</strong>
                <?php echo htmlspecialchars($doubt['doubt_type']); ?>
              </p> -->
              <p><strong>Doubt:</strong>
                <?php echo nl2br(htmlspecialchars($doubt['doubt_text'])); ?>
              </p>
              <?php if (!empty($doubt['doubt_img'])): ?>
              <img src="uploads/<?php echo htmlspecialchars($doubt['doubt_img']); ?>" alt="Doubt Image" width="200">
              <?php endif; ?>
              <p style="color: green;"><strong>Reply:</strong><br>
                <?php 
                      if (!empty($doubt['reply_text'])) {
                        echo nl2br(htmlspecialchars($doubt['reply_text']));
                      } else {
                        echo "<em>Reply not yet received.</em>";
                      }
                    ?>
              </p>
            </div>
            <?php endforeach; ?>
          </div>
          <?php else: ?>
          <p>You haven’t asked any doubts yet.</p>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>

  <!-- Footer (optional) -->
  <?php require 'partials/_footer.php'; ?>

</body>

</html>