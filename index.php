<?php
session_start();
include 'partials/_dbconnect.php'; // Database connection

// Fetch all courses
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learner's Hub - Most Trusted Platform</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<?php require 'partials/_nav.php' ?>
<?php require 'partials/_ask.php' ?>
<section style="width: 80vw; margin: auto;">
    <div class="below-nav">
        <div class="main-text">
            <h1>India's No. 1 <span style="color: blueviolet;">Free Education</span> Hub For Learners</h1>
            <p>Explore the most awaited bigest free education hub for all!</p>
            <button onclick="goToCourses()" class="btn">
                Explore Now
            </button>
        </div>
        <div>
            <img class="below-nav-img" src="./assets/teacher-and-student.jpg" alt="main-img">
        </div>
    </div>
</section>
<section style="background-color: beige;">
    <div class="popular-courses-container">
        <div style="margin-bottom: 50px;">
            <h1 style="font-size: xx-large;">Our Popular Courses</h1>
        </div>
        <div class="card-container">
            <?php if (!empty($courses)): ?>
                <?php foreach($courses as $course): ?>
                    <div class="card">
                        <div style="margin-bottom: 10px; position: relative;">
                            <img style="width:280px; height:150px;" class="card-m-img" src="uploads/<?php echo htmlspecialchars($course['cover_img']); ?>" alt="card-img">
                            <h1 style="width:280px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><?php echo htmlspecialchars($course['title']); ?></h1>
                            <div style="display: flex; align-items: center; margin-top: 10px; justify-content: space-between;">
                                <p>Duration: <?php echo htmlspecialchars($course['duration']); ?></p>
                                <p>Faculty: <?php echo htmlspecialchars($course['faculty']); ?></p>
                            </div>
                            <div style="position: absolute; top:5px; background-color: green; padding: 5px; border-radius: 5px; color: white;">
                                <p>Price: <?php echo htmlspecialchars($course['price']); ?></p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
                            <button class="btn11"><a style="text-decoration: none; color: blueviolet;" href="explore_course.php?id=<?php echo $course['id']; ?>">Explore</a></button>
                            <button class="btn1">Grab Now</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No courses found.</p>
            <?php endif; ?>
   
            </div>
        </div>
        <div style="display: flex; justify-content: center; align-items: center; padding-bottom: 20px; padding-top: 100px;">
            <button onclick="goToCourses()" class="btn">Explore More..</button>
        </div>
    </div>
</section>
<section>
    <div>
        <div class="p-guide">
            <h2 style="text-align: center;">Personalised Doubt Assistance</h2>
            <h3>Trusted Experts</h3>
            <p>Get in touch with our expert Mentors</p>
            <ul>
                <li><input placeholder='Name' type="text" /></li>
                <li><input placeholder='Mobile' type="text" /></li>
                <li><input placeholder='Email' type="text" /></li>
                <li><input placeholder='Your Doubt' type="text" /></li>
            </ul>
            <div class="call-back"><button>Ask Doubt</button></div>
            <div class="terms-policy">
                <p>By proceeding ahead you expressly agree to the </p>
                <p>Learner's Hub <span>terms of use</span> and <span>privacy policy.</span></p>
            </div>
        </div>
    </div>
</section>
<?php require 'partials/_footer.php' ?>
</body>
</html>
