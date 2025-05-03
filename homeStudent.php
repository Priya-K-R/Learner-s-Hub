<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Student on Learners Hub</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<?php require 'partials/_nav.php' ?>
<?php require 'partials/_ask.php' ?>
<section>
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
                <h1 style="font-size: xx-large;">
                    Our Popular Courses
                </h1>
            </div>
            <div class="card-container">
                <div class="card">
                    <div style="margin-bottom: 10px;">
                        <img class="card-m-img" src="bg-slide-1-new-1.jpg" alt="card-img">
                        <h1>Learn Java in 50 Days</h1>
                        <!-- <p style="margin-bottom: 20px; margin-top: 20px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum tenetur ea ipsum libero illum magni dolor sint eaque fugit suscipit?</p> -->
                        <p style="margin-top: 10px;">Faculity: IIT, NIT</p>
                    </div>

                    <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
                        <button class="btn11">Explore</button>
                        <button class="btn1">Grab Now</button>
                    </div>
                </div>
                <div class="card">
                    <div style="margin-bottom: 10px;">
                        <img class="card-m-img" src="bg-slide-1-new-1.jpg" alt="card-img">
                        <h1>Learn Java in 50 Days</h1>
                        <!-- <p style="margin-bottom: 20px; margin-top: 20px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum tenetur ea ipsum libero illum magni dolor sint eaque fugit suscipit?</p> -->
                        <p style="margin-top: 10px;">Faculity: IIT, NIT</p>
                    </div>

                    <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
                        <button class="btn11">Explore</button>
                        <button class="btn1">Grab Now</button>
                    </div>
                </div>
                <div class="card">
                    <div style="margin-bottom: 10px;">
                        <img class="card-m-img" src="bg-slide-1-new-1.jpg" alt="card-img">
                        <h1>Learn Java in 50 Days</h1>
                        <!-- <p style="margin-bottom: 20px; margin-top: 20px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum tenetur ea ipsum libero illum magni dolor sint eaque fugit suscipit?</p> -->
                        <p style="margin-top: 10px;">Faculity: IIT, NIT</p>
                    </div>

                    <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
                        <button class="btn11">Explore</button>
                        <button class="btn1">Grab Now</button>
                    </div>
                </div>
                <div class="card">
                    <div style="margin-bottom: 10px;">
                        <img class="card-m-img" src="bg-slide-1-new-1.jpg" alt="card-img">
                        <h1>Learn Java in 50 Days</h1>
                        <!-- <p style="margin-bottom: 20px; margin-top: 20px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum tenetur ea ipsum libero illum magni dolor sint eaque fugit suscipit?</p> -->
                        <p style="margin-top: 10px;">Faculity: IIT, NIT</p>
                    </div>

                    <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
                        <button class="btn11">Explore</button>
                        <button class="btn1">Grab Now</button>
                    </div>
                </div>
                <div class="card">
                    <div style="margin-bottom: 10px;">
                        <img class="card-m-img" src="bg-slide-1-new-1.jpg" alt="card-img">
                        <h1>Learn Java in 50 Days</h1>
                        <!-- <p style="margin-bottom: 20px; margin-top: 20px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum tenetur ea ipsum libero illum magni dolor sint eaque fugit suscipit?</p> -->
                        <p style="margin-top: 10px;">Faculity: IIT, NIT</p>
                    </div>

                    <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
                        <button class="btn11">Explore</button>
                        <button class="btn1">Grab Now</button>
                    </div>
                </div>
                <div class="card">
                    <div style="margin-bottom: 10px;">
                        <img class="card-m-img" src="bg-slide-1-new-1.jpg" alt="card-img">
                        <h1>Learn Java in 50 Days</h1>
                        <!-- <p style="margin-bottom: 20px; margin-top: 20px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum tenetur ea ipsum libero illum magni dolor sint eaque fugit suscipit?</p> -->
                        <p style="margin-top: 10px;">Faculity: IIT, NIT</p>
                    </div>

                    <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
                        <button class="btn11">Explore</button>
                        <button class="btn1">Grab Now</button>
                    </div>
                </div>
                <div class="card">
                    <div style="margin-bottom: 10px;">
                        <img class="card-m-img" src="bg-slide-1-new-1.jpg" alt="card-img">
                        <h1>Learn Java in 50 Days</h1>
                        <!-- <p style="margin-bottom: 20px; margin-top: 20px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum tenetur ea ipsum libero illum magni dolor sint eaque fugit suscipit?</p> -->
                        <p style="margin-top: 10px;">Faculity: IIT, NIT</p>
                    </div>

                    <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
                        <button class="btn11">Explore</button>
                        <button class="btn1">Grab Now</button>
                    </div>
                </div>
                <div class="card">
                    <div style="margin-bottom: 10px;">
                        <img class="card-m-img" src="bg-slide-1-new-1.jpg" alt="card-img">
                        <h1>Learn Java in 50 Days</h1>
                        <!-- <p style="margin-bottom: 20px; margin-top: 20px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum tenetur ea ipsum libero illum magni dolor sint eaque fugit suscipit?</p> -->
                        <p style="margin-top: 10px;">Faculity: IIT, NIT</p>
                    </div>

                    <div style="display: flex; gap: 20px; margin-top: 10px; justify-content: space-around;">
                        <button class="btn11">Explore</button>
                        <button class="btn1">Grab Now</button>
                    </div>
                </div>

            </div>
            <div
                style="display: flex; justify-content: center; align-items: center; padding-bottom: 20px; padding-top: 100px;">
                <button onclick="goToCourses()" class="btn">
                    Explore More..
                </button>
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