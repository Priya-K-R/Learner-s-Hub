<?php
session_start();
include 'partials/_dbconnect.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    // $phone = $_POST['phone'];
    $course_name = $_POST['course_name'];
    $doubt_type = $_POST['doubt_type'];
    $doubt_text = $_POST['doubt_text'];

    // Validate required fields
    if (empty($first_name) || empty($email) || empty($course_name) || empty($doubt_type) || empty($doubt_text)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit;
    }

    // Handle file upload
    $doubt_img = NULL; // Default to NULL if no file is uploaded
    if (isset($_FILES["upimg"]) && $_FILES["upimg"]["error"] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["upimg"]["name"]);
        $target_file = $target_dir . $file_name;

        // Allow certain file formats
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png", "gif");

        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.'); window.history.back();</script>";
            exit;
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["upimg"]["tmp_name"], $target_file)) {
            $doubt_img = $target_file; // Store file path in the database
        } else {
            echo "<script>alert('Error uploading file.'); window.history.back();</script>";
            exit;
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO doubts (student_email, course_id, doubt_text, doubt_type, course_name, phone, doubt_img) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $course_id = 0; // Change this logic to fetch actual course_id if necessary
    $stmt->bind_param("sisssss", $email, $course_id, $doubt_text, $doubt_type, $course_name, $phone, $doubt_img);

    if ($stmt->execute()) {
        $message ="Your doubt has been submitted successfully!";
    } else {
        echo "<script>alert('Error submitting doubt! Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask Doubt</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php require 'partials/_nav.php' ?>
<?php if(!empty($message)): ?>
      <p id="message-box" class="message submit-action-message" style="width: 100%;
   height: auto;
   background-color: rgb(204, 248, 204);
   text-align: center;
   padding: 8px;
   margin: auto;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
<?php require 'partials/_ask.php' ?>
    <section style="padding: 20px 60px 20px 60px; border-radius: 5px;">
        <div style="display: flex; justify-content:space-around; height: 50vh;">
            <div>
                <h1 style="padding-top: 70px; padding-bottom: 30px;">
                    Go from questioning to understanding!
                </h1>
                <p>Discover the benefits of Ask a Doubts!</p>
            </div>
            <div>
                <img style="width: 400px; height: 300px;" src="./assets/doubt.png" alt="">
            </div>
        </div>
        <div style="height: 1px; width: 100%; background-color: rgb(194, 194, 194);"></div>
        <div>
            <h1
                style="display: flex; font-weight: 900; font-size: xx-large; justify-content: center; align-items: center; padding: 40px;">
                Ask a question. Get a verified answer.</h1>
        </div>
        <!-- Begin Form -->
        <form style="display: flex; justify-content: center;" action="" method="POST" enctype="multipart/form-data">
            <div style="align-items: center; width: 80%; border: 0.5px solid rgb(226, 225, 225);">
                <div style="padding: 30px">
                    <h1>We are here to solve your Doubts</h1>
                    <p>Submit your doubt in the form listed below, our team will reach back to you with the solution.
                    </p>
                    <p>*Note: Submit your doubt with your registered mobile number.</p>
                </div>
                <div style="padding: 10px 30px;">
                    <p>First Name</p>
                    <input style="width: 80%; padding: 10px;" type="text" name="first_name" placeholder="Full Name"
                        required>
                </div>
                <div style="padding: 10px 30px;">
                    <p>Email Address</p>
                    <input style="width: 80%; padding: 10px;" type="email" name="email" placeholder="Email" required>
                </div>
                <!-- <div style="padding: 10px 30px;">
                    <p>Phone Number</p>
                    <input style="width: 80%; padding: 10px;" type="number" name="phone" placeholder="Phone Number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        required>
                </div> -->
                <div style="padding: 10px 30px;">
                    <p>Course Name</p>
                    <input style="width: 80%; padding: 10px;" type="text" name="course_name" placeholder="Course Name"
                        required>
                </div>
                <div style="padding: 10px 30px;">
                    <p>Doubt Type</p>
                    <select style="width: 81.5%; padding: 10px;" name="doubt_type" id="doubt_type" required>
                        <option value="course_related">Course Related</option>
                        <option value="test_related">Test Related</option>
                        <option value="quiz_related">Quiz Related</option>
                        <option value="payment_related">Payment Related</option>
                    </select>
                </div>
                <div style="padding: 10px 30px;">
                    <p>Doubts in Words (Up to 255 words)</p>
                    <textarea style="width: 80%; padding: 10px;" name="doubt_text" id="doubt_text" rows="12"
                        placeholder="Write your doubt here..." required></textarea>
                </div>
                <div style="padding: 10px 30px;">
                    <p>Upload Doubts image</p>
                    <input style="width: 80%; padding: 10px; border: 0.5px solid rgb(201, 201, 201);" type="file"
                        name="upimg" accept="image/*">
                </div>
                <div style="padding: 10px 30px;">
                    <button type="submit" class="btn">Submit</button>
                </div>
            </div>
        </form>
        <!-- End Form -->

        </div>
        </div>
    </section>
    <script src="script.js"></script>
    <!-- <script>
        document.getElementById("phone").addEventListener("input", function() {
         if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
    }
    });
    </script> -->
    <script>
        // Hide message after 10 seconds (10000 milliseconds)
        setTimeout(function() {
            var messageBox = document.getElementById("message-box");
            if (messageBox) {
                messageBox.style.display = "none";
            }
        }, 5000);
    </script>
    <?php require 'partials/_footer.php' ?>
</body>

</html>