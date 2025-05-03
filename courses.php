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
    <title>Courses</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require 'partials/_nav.php' ?>
    <?php require 'partials/_ask.php' ?>
<section style="width: 70vw; display: flex; justify-content: center; margin: auto; margin-top: 40px;">
        <div>
            <div>
                <h1 style="font-weight: 900; font-size: xx-large;">
                    All Exam Courses, Notes, Practice Test and Mock Test Are Available Here. Please Explore Our Couses
                    You Definetly get Insightful Contents...
                </h1>
                <p style="padding-bottom: 20px; padding-top: 20px;">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus iusto totam tenetur ducimus
                    necessitatibus sint corrupti cum pariatur accusantium architecto. Quas nobis non iure rem ratione
                    saepe culpa expedita ea.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam nihil beatae placeat eum quaerat
                    officia ut, similique, et ea fuga numquam eligendi quae laboriosam porro sed praesentium asperiores,
                    soluta illo aperiam doloribus accusamus. Voluptates laboriosam reiciendis doloribus accusamus
                    architecto, nulla id sunt totam, nobis nostrum saepe consequatur! Nesciunt aliquid accusamus
                    obcaecati doloremque expedita, provident nihil modi vero eligendi maiores excepturi inventore
                    voluptatibus autem? Placeat aliquid odio dolore ducimus obcaecati qui illum nemo fuga totam
                    veritatis. Quae maiores quam consectetur aut laudantium rem deleniti inventore? Nesciunt labore
                    aspernatur sequi amet soluta aut fuga eaque enim officia delectus. Totam officia quasi quae!
                </p>
            </div>
            <!-- <div style="display: flex; gap: 20px; justify-content: space-between;">
                <div class="courses-card"
                    style="background-color:aliceblue; padding: 30px 80px 30px 80px; border-radius: 5px;">Courses</div>
                <div class="courses-card"
                    style="background-color:aliceblue; padding: 30px 80px 30px 80px; border-radius: 5px;">Notes</div>
                <div class="courses-card"
                    style="background-color:aliceblue; padding: 30px 80px 30px 80px; border-radius: 5px;">Practice Test
                </div>
                <div class="courses-card"
                    style="background-color:aliceblue; padding: 30px 80px 30px 80px; border-radius: 5px;">Mock Test
                </div>
                <div class="courses-card"
                    style="background-color:aliceblue; padding: 30px 80px 30px 80px; border-radius: 5px;">Blogs</div>
            </div> -->

        </div>
    </section>
    <section style="width: 70vw; margin: auto;">
        <div >
            <ul class="courses-option-link"
                style="list-style: none; display: flex; gap: 10px; padding: 5px; color: rgb(16, 16, 89); margin-top: 40px;">
                <li onclick="filterCards('all', 'courses-Allheading')">All Courses</li>
                <li class="small-line"></li>
                <li onclick="filterCards('gov', 'courses-heading1')">Gov. Exams</li>
                <li class="small-line"></li>
                <li onclick="filterCards('neet', 'courses-heading2')">NEET</li>
                <li class="small-line"></li>
                <li onclick="filterCards('iit', 'courses-heading3')">IIT/JEE</li>
                <li class="small-line"></li>
                <li onclick="filterCards('tech', 'courses-heading4')">Tech</li>
                <li class="small-line"></li>
                <li onclick="filterCards('management', 'courses-heading5')">Management</li>
                <li class="small-line"></li>
                <li onclick="filterCards('accounts' , 'courses-heading6')">Accounts</li>
            </ul>
        </div>
        <div style="height: 1px; width: 100%; background-color: rgb(194, 194, 194);"></div>
        <div>
            <div >
                <div>
                    <div>
                        <h1 id="courses-heading1" class="courses-heading" style="margin: 20px 0 20px 0; font-weight: 800; font-size: xx-large;">
                            Government Exam Preparation Best Courses
                        </h1>
                        <div class="card-container">
                            <?php if (!empty($courses)): ?>
                            <?php foreach($courses as $course): ?>
                            <?php if ($course['course_category'] === 'gov'): // Show only "gov" category ?>
                            <div class="card" data-category="<?php echo htmlspecialchars($course['course_category']); ?>">
                                <div style="margin-bottom: 10px;">
                                    <img style="width:280px; height:150px;" class="card-m-img" src="uploads/<?php echo htmlspecialchars($course['cover_img']); ?>" alt="card-img">
                                    <h1 style="width:280px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><?php echo htmlspecialchars($course['title']); ?></h1>
                                    <!-- <p style="margin-bottom: 20px; margin-top: 20px;"><?php echo htmlspecialchars($course['description']); ?></p> -->
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
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>No government category courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <h1 id="courses-heading2" class="courses-heading" style="margin: 20px 0 20px 0; font-weight: 800; font-size: xx-large;">
                            Class 12 NEET Courses
                        </h1>
                        <div class="card-container">
                            <?php if (!empty($courses)): ?>
                            <?php foreach($courses as $course): ?>
                            <?php if ($course['course_category'] === 'neet'): // Show only "gov" category ?>
                            <div class="card" data-category="<?php echo htmlspecialchars($course['course_category']); ?>">
                                <div style="margin-bottom: 10px;">
                                    <img style="width:280px; height:150px;" class="card-m-img" src="uploads/<?php echo htmlspecialchars($course['cover_img']); ?>" alt="card-img">
                                    <h1 style="width:280px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><?php echo htmlspecialchars($course['title']); ?></h1>
                                    <!-- <p style="margin-bottom: 20px; margin-top: 20px;"><?php echo htmlspecialchars($course['description']); ?></p> -->
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
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>No government category courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <h1 id="courses-heading3" class="courses-heading" style="margin: 20px 0 20px 0; font-weight: 800; font-size: xx-large;">
                            Class 11 IIT/JEE Courses
                        </h1>
                        <div class="card-container">
                            <?php if (!empty($courses)): ?>
                            <?php foreach($courses as $course): ?>
                            <?php if ($course['course_category'] === 'iit'): // Show only "gov" category ?>
                            <div class="card" data-category="<?php echo htmlspecialchars($course['course_category']); ?>">
                                <div style="margin-bottom: 10px;">
                                    <img style="width:280px; height:150px;" class="card-m-img" src="uploads/<?php echo htmlspecialchars($course['cover_img']); ?>" alt="card-img">
                                    <h1 style="width:280px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><?php echo htmlspecialchars($course['title']); ?></h1>
                                    <!-- <p style="margin-bottom: 20px; margin-top: 20px;"><?php echo htmlspecialchars($course['description']); ?></p> -->
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
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>No government category courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <h1 id="courses-heading4" class="courses-heading" style="margin: 20px 0 20px 0; font-weight: 800; font-size: xx-large;">
                            Modern Tools and Technology Courses
                        </h1>
                        <div class="card-container">
                            <?php if (!empty($courses)): ?>
                            <?php foreach($courses as $course): ?>
                            <?php if ($course['course_category'] === 'tech'): // Show only "gov" category ?>
                            <div class="card" data-category="<?php echo htmlspecialchars($course['course_category']); ?>">
                                <div style="margin-bottom: 10px;">
                                    <img style="width:280px; height:150px;" class="card-m-img" src="uploads/<?php echo htmlspecialchars($course['cover_img']); ?>" alt="card-img">
                                    <h1 style="width:280px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><?php echo htmlspecialchars($course['title']); ?></h1>
                                    <!-- <p style="margin-bottom: 20px; margin-top: 20px;"><?php echo htmlspecialchars($course['description']); ?></p> -->
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
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>No government category courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <h1 id="courses-heading4" class="courses-heading" style="margin: 20px 0 20px 0; font-weight: 800; font-size: xx-large;">
                            Management Courses by Top Faculilty
                        </h1>
                        <div class="card-container">
                            <?php if (!empty($courses)): ?>
                            <?php foreach($courses as $course): ?>
                            <?php if ($course['course_category'] === 'management'): // Show only "gov" category ?>
                            <div class="card" data-category="<?php echo htmlspecialchars($course['course_category']); ?>">
                                <div style="margin-bottom: 10px;">
                                    <img style="width:280px; height:150px;" class="card-m-img" src="uploads/<?php echo htmlspecialchars($course['cover_img']); ?>" alt="card-img">
                                    <h1 style="width:280px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><?php echo htmlspecialchars($course['title']); ?></h1>
                                    <!-- <p style="margin-bottom: 20px; margin-top: 20px;"><?php echo htmlspecialchars($course['description']); ?></p> -->
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
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>No government category courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <h1 id="courses-heading4" class="courses-heading" style="margin: 20px 0 20px 0; font-weight: 800; font-size: xx-large;">
                            Accountancy Courses
                        </h1>
                        <div class="card-container">
                            <?php if (!empty($courses)): ?>
                            <?php foreach($courses as $course): ?>
                            <?php if ($course['course_category'] === 'accounts'): // Show only "gov" category ?>
                            <div class="card" data-category="<?php echo htmlspecialchars($course['course_category']); ?>">
                                <div style="margin-bottom: 10px;">
                                    <img style="width:280px; height:150px;" class="card-m-img" src="uploads/<?php echo htmlspecialchars($course['cover_img']); ?>" alt="card-img">
                                    <h1 style="width:280px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><?php echo htmlspecialchars($course['title']); ?></h1>
                                    <!-- <p style="margin-bottom: 20px; margin-top: 20px;"><?php echo htmlspecialchars($course['description']); ?></p> -->
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
                                    <form action="payment.php" method="GET">
                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                        <input type="hidden" name="name" value="<?php echo htmlspecialchars($course['title']); ?>">
                                        <input type="hidden" name="price" value="<?php echo $course['price']; ?>">
                                        <input type="hidden" name="course_duration" value="<?php echo $course['duration']; ?>">
                                        <input type="hidden" name="course_faculity" value="<?php echo $course['faculty']; ?>">
                                        <a style="text-decoration: none; color: blueviolet;"
                                            href=""><button type="submit" class="btn1">Buy Now</button></a>
                    
                                    </form>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>No accounts category courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="script.js"></script>
    <?php require 'partials/_footer.php' ?>
</body>
</html>