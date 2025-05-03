<?php
session_start();
include 'partials/_dbconnect.php';
// Fetch course details from URL parameters
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
$course_name = isset($_GET['name']) ? $_GET['name'] : 'Unknown Course';
$course_price = isset($_GET['price']) ? $_GET['price'] : 0;
$course_duration = isset($_GET['course_duration']) ? $_GET['course_duration'] : 0;
$course_faculity = isset($_GET['course_faculity']) ? $_GET['course_faculity'] : 'Unknown Course';

// Apply 10% discount
$discount = round($course_price * 0.10); // 10% of the original price
$final_price = $course_price - $discount;

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // or your login page
    exit;
}

$student_email = $_SESSION['email'];

// Check if course ID exists
if (!$course_id) {
    echo "Invalid course.";
    exit;
}

// Check if user already enrolled
$checkSql = "SELECT * FROM enrolled_courses WHERE student_email = ? AND course_id = ?";
$stmt = $conn->prepare($checkSql);
$stmt->bind_param("si", $student_email, $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Already enrolled - redirect or show message
    echo "<script>alert('You are already enrolled in this course! Redirecting...'); window.location.href='index.php';</script>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Payment</title>
    <!-- <link rel="stylesheet" href="style.css">  -->
    <style>
        /* Popup Styles */
        .popup {
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: white;
            padding: 20px;
            text-align: center;
            width: 40vw;
            border-radius: 5px;
            box-shadow: 0px 0px 10px #333;
            display: flex;
            flex-direction: column;
        }
        .payment-popup-img-content{
            display: flex;
            gap: 8vw;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .payment-popup-img-content img{
            width: 18vw;
        }
        .payment-popup-img-content p{
            text-align: right;
        }
        .payment-popup-img-content h2{
            padding-bottom: 5vh;
        }

        .close {
            float: left;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
        }

        #payNow {
            background: green;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <!-- Payment Popup -->
    <div id="paymentPopup" class="popup">

        <div class="popup-content">
            <div>
                <span
                    style="padding: 5px 15px 5px 15px; background-color: #bdbdbd; font-size: 14px; color: blue; font-weight: 200; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"
                    class="close" onclick="closePopup()">Back</span>
            </div>
            <div style="font-size: 30px; color: blueviolet; padding-top: 20px;">Complete Payment and Get Enrolled</div>
            <div class="payment-popup-img-content">
                <div><img src="assets/secure_payment.png" alt="secure-payment"></div>
                <div>
                    <h2>
                        <?php echo htmlspecialchars($course_name); ?>
                    </h2>
                    <p>Duration:
                        <?php echo $course_duration ?>
                    </p>
                    <p>Faculity:
                        <?php echo $course_faculity ?>
                    </p>
                    <p>Original Price: <strike>₹
                            <?php echo htmlspecialchars($course_price); ?>
                        </strike></p>
                    <p>Discount (10% Off): ₹
                        <?php echo $discount; ?>
                    </p>
                    <p><strong>Final Price: ₹
                            <?php echo $final_price; ?>
                        </strong></p>
                    <form action="enroll.php" method="POST" onsubmit="return validateForm()">
                        <input type="hidden" id="course_id" name="course_id" value="<?php echo intval($course_id); ?>">
                        <a style="text-decoration: none; color: blueviolet;"
                                href="enrolled_course.php?id=<?php echo $course['course_id']; ?>"><button id="payNow" type="submit">Pay Now</button></a>
                        <!-- <button id="payNow" type="submit">Pay Now</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closePopup() {
            window.history.back(); // Go to the previous page
        }

        function confirmPayment(courseId) {
            alert("Payment Successful! You have enrolled in the course.");
            window.location.href = "index.php?enrolled=" + courseId; // Redirect to dashboard after payment
        }

        function validateForm() {
            let courseId = document.getElementById("course_id").value;
            if (!courseId || courseId === "0") {
                alert("Error: Course ID is missing!");
                return false; // Prevent form submission
            }
            return true;
        }
    </script>

</body>

</html>