<?php
session_start();
// Ensure the instructor is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'instructor') {
    header("Location: login.php");
    exit;
}

$server   = "localhost";
$username = "root";
$password = "";
$database = "hubdb";

$conn = new mysqli($server, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Instead of selecting only courses for a specific instructor_email,
// we select ALL courses from the table.
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

$courses = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Fetch doubts
//first_name, email, course_name, doubt_type, doubt_text 
$sqlDoubt = "SELECT * FROM doubts";
$resultDoubt = $conn->query($sqlDoubt);

$doubts = array();
if ($resultDoubt && $resultDoubt->num_rows > 0) {
   while ($row = $resultDoubt->fetch_assoc()) {
       $doubts[] = $row;
    }
}

// Run the SQL query to count users
$sqlCount = "SELECT COUNT(*) AS total_students FROM users WHERE role = 'student'";
$resultCount = $conn->query($sqlCount);

// Fetch the result
$total_students = 0;
if ($resultCount->num_rows > 0) {
  $row = $resultCount->fetch_assoc();
  $total_students = $row['total_students'];
}

// Run the SQL query to count courses
$sqlCourseCount = "SELECT COUNT(*) AS total_courses FROM courses";
$resultCourseCount = $conn->query($sqlCourseCount);

// Fetch the result
$total_courses = 0;
if ($resultCourseCount->num_rows > 0) {
  $row = $resultCourseCount->fetch_assoc();
  $total_courses = $row['total_courses'];
}


// Fetch test series data
$sqlTest = "SELECT * FROM test_series ORDER BY created_at DESC";
$resultTest = mysqli_query($conn, $sqlTest);

$tests = [];
if ($resultTest && mysqli_num_rows($resultTest) > 0) {
    while ($row = mysqli_fetch_assoc($resultTest)) {
        $tests[] = $row;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Instructor Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Container Layout */
    .dashboard-container {
      display: flex;
      min-height: 92vh;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background-color: #222;
      /* Dark sidebar color */
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 20px;
    }

    .sidebar h2 {
      margin-bottom: 20px;
      font-weight: 500;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      margin: 15px 0;
      padding: 8px;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .sidebar ul li:hover {
      background-color: #333;
    }

    /* Active Menu Highlight */
    .sidebar ul li.active {
      background-color: #444;
    }

    /* Main Content */
    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    /* Top Bar */
    .topbar {
      background-color: #111;
      color: #fff;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      justify-content: flex-end;
    }

    .topbar .user-greeting {
      font-size: 16px;
    }

    /* Content Wrapper */
    .content-wrapper {
      padding: 20px;
    }

    /* Hide/Show Sections */
    .section {
      display: none;
      /* All sections hidden by default */
    }

    .section.active {
      display: block;
      /* Show the active section */
    }

    /* Dashboard Cards */
    .card-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 20px;
    }

    .dashboard-card {
      background-color: #f3f3f3;
      padding: 20px;
      border-radius: 6px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
      font-size: 16px;
      font-weight: bold;
      min-height: 100px;
      display: flex;
      align-items: center;
      flex-direction: column;
      gap: 10px;
      justify-content: center;
    }

    /* Courses/Tests List */
    .d-item-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 20px;
      margin-top: 10px;
    }

    .d-item {
      display: flex;
      width: 70vw;
      margin: auto;
      align-items: center;
      background-color: #fff;
      padding: 10px;
      border-radius: 6px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      justify-content: space-between;
    }

    .d-item-name {
      font-weight: 500;
    }

    .d-item-actions button {
      margin-left: 8px;
      padding: 10px 15px 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      background-color: blueviolet;
      color: #fff;
      font-weight: 400;
      transition: background-color 0.3s ease;
    }
    .d-item-actions button:hover {
      background-color: rgb(69, 3, 130);
      color: #fff;
      transition: background-color 0.5s ease;
    }

    .item-actions button:hover {
      background-color: #555;
    }

    /* Add Buttons */
    .add-actions {
      margin-bottom: 10px;
      display: flex;
      justify-content: flex-end;
      padding-right: 100px;
    }

    .add-actions button {
      margin-right: 10px;
      padding: 12px 16px;
      background-color: rgb(55, 151, 69);
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .add-actions button:hover {
      background-color: #7a0f9b;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    .tcourse-card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .tcourse-card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 5px;
      width: 70vw;
      display: flex;
      justify-content: space-between;
      padding: 15px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .tcourse-card h3 {
      margin-top: 0;
      margin-bottom: 10px;
      color: #444;
    }

    .tcourse-card p {
      margin: 5px 0;
      color: #666;
    }

    .tcourse-card a {
      display: inline-block;
      margin-right: 10px;
      text-decoration: none;
      color: #007BFF;
    }

    .tcourse-card a:hover {
      text-decoration: underline;
    }
    .reply-form{
      display: flex;
      width: 70vw;
      margin: auto;
      align-items: center;
      background-color: #fff;
      padding: 10px;
      border-radius: 6px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      justify-content: space-between;
    }
    .reply-form textarea{
      width: 69vw;
      padding: 10px;
      border-radius: 6px;
    }
    .reply-form button{
      width: 5vw;
      padding: 10px 0 10px 0;
      border-radius: 6px;
      border: 2px solid blueviolet;
      color: blueviolet;
      font-weight: 400;
    }
    .reply-form button:hover{
      border: 2px solid rgb(104, 11, 192);
      background-color: blueviolet;
      color: rgb(243, 242, 245);
    }
    .instructor-banner-box {
    background-color: #f3f0ff;
    border-left: 6px solid blueviolet;
    padding: 20px;
    margin: 20px 0;
    border-radius: 12px;
    font-family: Arial, sans-serif;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
  }

  .instructor-banner-text {
    font-size: 20px;
    color: #333;
    margin: 0;
  }

  .instructor-highlight {
    color: blueviolet;
    font-weight: bold;
  }
  .edit-delete-button{
    background-color:rgb(222, 117, 254); 
    border-radius: 5px; 
    padding: 8px 12px;
  }

  .instructor-banner-icon {
    margin-right: 8px;
    color: blueviolet;
  }
  </style>
</head>

<body>
  <?php require 'partials/_nav.php' ?>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
      <h2>Learners Hub</h2>
      <ul>
        <li class="active" onclick="showSection('dashboard', this)">Dashboard</li>
        <li onclick="showSection('courses', this)">Courses</li>
        <li onclick="showSection('tests', this)">Tests</li>
        <li onclick="showSection('doubts', this)">Doubts</li>
        <li onclick="window.location.href='/learnerHub/Study_Material/upload_material.php'">Study Material</li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Top Bar -->
      <!-- <div class="topbar">
      <div class="user-greeting">Hello, User Name</div>
    </div> -->

      <!-- Main Content Wrapper -->
      <div class="content-wrapper">

        <!-- Dashboard Section -->
        <div id="dashboard-section" class="section active">
          <h1>Dashboard</h1>
          <div class="card-grid">
            <div class="dashboard-card">
              <div style="font-size: xx-large;"><?php echo $total_students; ?></div>
              <div>Total Students</div>
            </div>
            <div class="dashboard-card">
              <div style="font-size: xx-large;">746 ₹</div>
              <div>Total Revenue</div>

            </div>
            <div class="dashboard-card">
              <div style="font-size: xx-large;"><?php echo $total_courses; ?></div>
              <div>Total Courses</div>
            </div>
            <!-- <div class="dashboard-card">Sales Graph</div> -->
          </div>
          <div class="instructor-banner-box">
            <h2 class="instructor-banner-text">
              <i class="fas fa-chalkboard-teacher instructor-banner-icon"></i>
              Hey, Instructor! You can <span class="instructor-highlight">ADD, UPDATE, DELETE</span> 
              the <span class="instructor-highlight">COURSES</span>, <span class="instructor-highlight">TESTS</span>,<span class="instructor-highlight"> Study Material</span>, and 
              <span class="instructor-highlight">REPLY DOUBT</span>.
            </h2>
          </div>
          <div style="margin-left: 30vw; padding-top: 2vw;">
            <img src="assets/dash-png.png" alt="dash-img">
          </div>
        </div>

        <!-- Courses Section -->
        <div id="courses-section" class="section">
          <h1>All Courses</h1>
          <div class="add-actions">
            <button><a style="text-decoration: none; color:rgb(255, 255, 255);" href="/learnerHub/add_course.php">+Add
                Course</a></button>
          </div>
          <div class="tcourse-card-container">
            <?php if (!empty($courses)): ?>
            <?php foreach($courses as $course): ?>
            <div class="tcourse-card">
              <div>
                <h3>
                  <?php echo htmlspecialchars($course['title']); ?>
                </h3>
                <p><strong>Duration:</strong>
                  <?php echo htmlspecialchars($course['duration']); ?>
                </p>
              </div>

              <!-- Additional details can be added here if needed -->
              <div>
                <p>
                  <button class="edit-delete-button"><a
                      style="text-decoration: none; color:rgb(255, 255, 255);"
                      href="edit_course.php?id=<?php echo $course['id']; ?>">Edit</a></button>
                  <button class="edit-delete-button"><a
                      style="text-decoration: none; color:rgb(255, 255, 255);"
                      href="delete_course.php?id=<?php echo $course['id']; ?>"
                      onclick="return confirm('Are you sure you want to delete this course?');">
                      Delete
                    </a></button>
                </p>
              </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No courses found.</p>
            <?php endif; ?>
          </div>

        </div>

      </div>

      <!-- Tests Section -->
      <div id="tests-section" class="section">
          <h1>Tests</h1>
          <div class="add-actions">
            <button><a style="text-decoration: none; color:rgb(255, 255, 255);" href="/learnerHub/test_series/add_test.php">+Add
                Test</a></button>
          </div>
          <div class="tcourse-card-container">
            <?php if (!empty($tests)): ?>
            <?php foreach($tests as $test): ?>
            <div class="tcourse-card">
              <div>
                <h3>
                  <?php echo htmlspecialchars($test['test_name']); ?>
                </h3>
                <div style="display: flex; gap: 10px;">
                  <p><strong>Total Questions:</strong> 
                    <?php echo htmlspecialchars($test['total_questions']); ?>
                  </p>
                  <p><strong>Subject:</strong> 
                    <?php echo htmlspecialchars($test['subject']); ?>
                  </p>
                </div> 
              </div>

              <!-- Additional details can be added here if needed -->
              <div>
                <p>
                  <button class="edit-delete-button"><a
                      style="text-decoration: none; color:rgb(255, 255, 255);"
                      href="test_series/add_question.php?id=<?php echo $test['id']; ?>">Add Questions</a></button>
                </p>
              </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No courses found.</p>
            <?php endif; ?>
          </div>








      </div>

      <!-- Doubts Section -->
      <div id="doubts-section" class="section">
        <h1>Doubts</h1>
        <div class="d-item-list">
          <!-- Example items -->
          <?php if (!empty($doubts)): ?>
          <?php foreach($doubts as $doubt): ?>
          <div class="d-item">
            <div style="width: 15vw;">
              <h3 style="padding-bottom: 10px;">
                <?php echo htmlspecialchars($doubt['doubt_text']); ?>
              </h3>
              <div style="display: flex; gap: 10px;">
                <div>
                  <p>
                    <?php echo htmlspecialchars($doubt['doubt_type']); ?>
                  </p>
                  <p>
                    <?php echo htmlspecialchars($doubt['student_email']); ?>
                  </p>
                </div>
                <div>
                  <p>
                    <?php echo htmlspecialchars($doubt['course_name']); ?>
                  </p>
                </div>
              </div>
            </div>
            <div>
              <img src="uploads/<?php echo htmlspecialchars($doubt['doubt_img']); ?>" alt="doubt-img">
            </div>
            <!-- Display existing reply if available -->
            <?php if (!empty($doubt['reply_text'])): ?>
            <div class="reply-box">
              <strong>Instructor's Reply:</strong>
              <p>
                <?php echo htmlspecialchars($doubt['reply_text']); ?>
              </p>
            </div>
            <?php endif; ?>
            <div class="d-item-actions">
              <button class="reply-btn" data-id="<?php echo $doubt['id']; ?>">Reply</button>
            </div>
            
          </div>
          <!-- Hidden Reply Form -->
          <div class="reply-form" id="reply-form-<?php echo $doubt['id']; ?>" style="display: none;">
            <textarea id="reply-text-<?php echo $doubt['id']; ?>" placeholder="Type your reply..."></textarea>
            <button onclick="submitReply(<?php echo $doubt['id']; ?>)">Submit</button>
          </div>
          <?php endforeach; ?>
          <?php else: ?>
          <p>No doubts found.</p>
          <?php endif; ?>
        </div>
      </div>





<!-- Doubts Section -->
<div id="study-material-section" class="section">
  <h1>Study Material</h1>
  <div class="d-item-list">
    <!-- Example items -->
    <div class="content">
      <div class="profile-card">
          <!-- <h2>Welcome,  <?php echo htmlspecialchars($name); ?></h2>
          <p><?php echo htmlspecialchars($email); ?></p> -->
          <button class="logout" onclick="window.location.href=''">Add Study Material</button>
      </div>
  </div>

  </div>
</div>







    </div>
  </div>
  </div>

  <script>
    function showSection(sectionId, menuItem) {
      // Hide all sections
      document.getElementById('dashboard-section').classList.remove('active');
      document.getElementById('courses-section').classList.remove('active');
      document.getElementById('tests-section').classList.remove('active');
      document.getElementById('doubts-section').classList.remove('active');

      // Show the selected section
      document.getElementById(sectionId + '-section').classList.add('active');

      // Remove 'active' class from all sidebar li elements
      const allMenuItems = document.querySelectorAll('.sidebar ul li');
      allMenuItems.forEach(item => item.classList.remove('active'));

      // Add 'active' class to the clicked item
      menuItem.classList.add('active');
    }

    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".reply-btn").forEach(button => {
        button.addEventListener("click", function () {
          let doubtId = this.getAttribute("data-id");
          let replyForm = document.getElementById("reply-form-" + doubtId);

          if (replyForm) {
            replyForm.style.display = replyForm.style.display === "none" ? "block" : "none";
          } else {
            console.error("Reply form not found for doubt ID:", doubtId);
          }
        });
      });
    });

    function submitReply(doubtId) {
      let replyText = document.getElementById("reply-text-" + doubtId).value;

      if (replyText.trim() === "") {
        alert("Reply cannot be empty!");
        return;
      }

      // Send reply to the server via AJAX
      fetch("submit_reply.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${doubtId}&reply_text=${encodeURIComponent(replyText)}`
      })
        .then(response => response.text())
        .then(data => {
          console.log("Server response:", data); // Debugging

          if (data.trim() === "success") {
            alert("Reply submitted successfully!");
            location.reload();
          } else {
            alert("Failed to submit reply. Server says: " + data);
          }
        })
        .catch(error => console.error("Fetch error:", error));
    }


  </script>

</body>

</html>