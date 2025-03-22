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
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard Example</title>
  <style>
    /* Container Layout */
    .dashboard-container {
      display: flex;
      min-height: 100vh;
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
      background-color: #fff;
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
    .item-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 20px;
      margin-top: 10px;
    }

    .item {
      display: flex;
      align-items: center;
      background-color: #fff;
      padding: 10px;
      border-radius: 6px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      justify-content: space-between;
    }

    .item-name {
      font-weight: 500;
    }

    .item-actions button {
      margin-left: 8px;
      padding: 5px 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      background-color: #888;
      color: #fff;
      transition: background-color 0.3s ease;
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
              <div style="font-size: xx-large;">5672</div>
              <div>Total Students</div>

            </div>
            <div class="dashboard-card">
              <div style="font-size: xx-large;">7476$</div>
              <div>Total Revenue</div>

            </div>
            <div class="dashboard-card">
              <div style="font-size: xx-large;">434</div>
              <div>Total Courses</div>
            </div>
            <div class="dashboard-card">Sales Graph</div>
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
                  <button style="background-color:rgb(222, 117, 254); border-radius: 5px; padding: 8px 12px;"><a
                      style="text-decoration: none; color:rgb(255, 255, 255);"
                      href="edit_course.php?id=<?php echo $course['id']; ?>">Edit</a></button>
                  <button style="background-color:rgb(222, 117, 254); border-radius: 5px; padding: 8px 12px;"><a
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
        <div class="item-list">
          <!-- Example items -->
          <div class="item">
            <span class="item-name">Test 1</span>
            <div class="item-actions">
              <button>Edit</button>
              <button>Delete</button>
            </div>
          </div>
          <div class="item">
            <span class="item-name">Test 2</span>
            <div class="item-actions">
              <button>Edit</button>
              <button>Delete</button>
            </div>
          </div>
        </div>
        <div class="add-actions">
          <button>Add Test</button>
        </div>
      </div>

      <!-- Doubts Section -->
      <div id="doubts-section" class="section">
        <h1>Doubts</h1>
        <div class="item-list">
          <!-- Example items -->
          <div class="item">
            <span class="item-name">Student's doubt about Course X</span>
            <div class="item-actions">
              <button>Reply</button>
            </div>
          </div>
          <div class="item">
            <span class="item-name">Student's doubt about Test Y</span>
            <div class="item-actions">
              <button>Reply</button>
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
  </script>

</body>

</html>