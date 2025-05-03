<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask Doubt</title>
    <style>
        /* Floating Button */
        .ask-doubt-floating-btn {
            position: fixed;
            bottom: 60px;
            right: 50px;
            background: blueviolet;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }
        .ask-doubt-floating-icon {
            position: fixed;
            bottom: 100px;
            right: 70px;
            cursor: pointer;
        }
        .ask-doubt-floating-btn:hover {
            background: #0056b3;
        }
        
        /* Modal Styling */
        .ask-doubt-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .ask-doubt-modal-content {
            background: white;
            width: 40%;
            margin: 2% auto;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }
        
        .ask-doubt-close-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
        }
        
        .ask-doubt-close-btn:hover {
            color: red;
        }
        
        /* Form Styling */
        .ask-doubt-modal-content form {
            display: flex;
            flex-direction: column;
        }
        
        .ask-doubt-modal-content input,
        .ask-doubt-modal-content select,
        .ask-doubt-modal-content textarea {
            margin-top: 5px;
            margin-bottom: 10px;
            padding: 10px;
            width: 95%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        .ask-doubt-submit-btn {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .ask-doubt-submit-btn:hover {
            background: #0056b3;
        }
        </style>
</head>
<body>

   <!-- Floating Ask Doubt Button -->
<img class="ask-doubt-floating-icon" src="assets/wired-gradient-2739-logo-circle-viber-hover-pinch.gif" alt="Animated GIF" width="90px">
<button id="floatingAskDoubtBtn" class="ask-doubt-floating-btn">Ask Doubt</button>

<!-- Ask Doubt Modal -->
<div id="askDoubtModal" class="ask-doubt-modal">
    <div class="ask-doubt-modal-content">
        <span class="ask-doubt-close-btn">&times;</span>

        <form action="process_doubt.php" method="POST" enctype="multipart/form-data">
            <h1>We are here to solve your Doubts</h1>
            <p>Submit your doubt in the form below, our team will reach back to you.</p>

            <!-- <label>First Name</label>
            <input type="text" name="first_name" placeholder="Full Name" required> -->

            <label>Email Address</label>
            <input type="email" name="email" placeholder="Email" required>

            <label>Course Name</label>
            <input type="text" name="course_name" placeholder="Course Name" required>

            <label>Doubt Type</label>
            <select name="doubt_type" required>
                <option value="course_related">Course Related</option>
                <option value="test_related">Test Related</option>
                <option value="quiz_related">Quiz Related</option>
                <option value="payment_related">Payment Related</option>
            </select>

            <label>Doubt Description (Max 255 words)</label>
            <textarea name="doubt_text" rows="3" placeholder="Write your doubt here..." required></textarea>

            <label>Upload Doubt Image</label>
            <input type="file" name="upimg" accept="image/*" required>

            <button type="submit" class="ask-doubt-submit-btn">Submit</button>
        </form>
    </div>
</div>

<!-- CSS -->


<!-- JavaScript -->
<script>
document.getElementById("floatingAskDoubtBtn").addEventListener("click", function() {
    document.getElementById("askDoubtModal").style.display = "block";
});

document.querySelector(".ask-doubt-close-btn").addEventListener("click", function() {
    document.getElementById("askDoubtModal").style.display = "none";
});

window.onclick = function(event) {
    var modal = document.getElementById("askDoubtModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};
</script>


</body>
</html>
