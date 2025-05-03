<?php
session_start();
$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Fetch user details from database
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);
        $role = $row["role"]; // Get role from database
        $fname = $row["fname"];
    
        // Start session and store user info
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        $_SESSION['fname'] = $fname;
    
        // Optionally, echo the role for debugging (remove in production)
        echo $_SESSION['role'];
    
        // Redirect based on role
        if ($role == 'student') {
            header("Location: index.php");
            exit;
        } elseif ($role == 'instructor') {
            header("Location: homeInstructor.php");
            exit;
        } else {
            $showError = "Invalid role assigned. Contact admin.";
        }
    } else {
        $showError = "Invalid Credentials";
    }
    
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php require 'partials/_nav.php' ?>
    <div class="loginContainer">
        <div class="container" id="signIn">
            <h1 class="form-title">Log In</h1>
            <form class="signuplog-form" method="post" action="/learnerHub/login.php"
                style="display:flex; flex-direction:column; gap:10px; margin-top: 15px;">
                <div class="input-group" style="display: flex; flex-direction: column; gap: 5px;">
                    <input class="input-class" style="padding: 5px;" type="email" name="email" id="email"
                        placeholder="Email" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-group" style="display: flex; padding-bottom:30px; flex-direction: column; gap: 5px;">
                    <input class="input-class" style="padding: 5px;" type="password" name="password" id="password"
                        placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                <!-- <p class="recover">
            <a href="#">Recover Password</a>
          </p> -->
                <input type="submit" class="btn33" value="Sign In" name="signIn">
            </form>
            <div class="links" style="display: flex; gap: 5px; padding: 20px 0px 0px 40px;">
                <p>Don't have account yet?</p>
                <a href="signup.php"><button id="signUpButton">Sign Up</button></a>
            </div>
        </div>
    </div>
    </div>
    <?php
    if($login){
        echo '  <div id="custom-alert" style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); width: 70%; padding: 15px; background-color: #46694c; color: white; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; transition: opacity 0.5s ease-out; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
     <strong style="margin-right: 10px;">Success Hurayyy!</strong> You are loggedin.
     <button onclick="closeAlert()" style="background: none; border: none; font-size: 20px; color: white; cursor: pointer; font-weight: bold;">×</button>
 </div>';
    }
    ?>

    <?php
    if($showError){
        echo '  <div id="custom-alert" style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); width: 70%; padding: 15px; background-color:rgb(139, 49, 49); color: white; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; transition: opacity 0.5s ease-out; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
     <strong style="margin-right: 10px;">Error Ohhh!</strong> '. $showError .'
     <button onclick="closeAlert()" style="background: none; border: none; font-size: 20px; color: white; cursor: pointer; font-weight: bold;">×</button>
 </div>';
    }
    ?>
    <script>
        function closeAlert() {
            const alertBox = document.getElementById("custom-alert");
            alertBox.style.opacity = "0";
            setTimeout(() => {
                alertBox.style.display = "none";
            }, 500); // Matches the transition duration
        }
    </script>
</body>

</html>