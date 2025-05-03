<?php
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';
    $fName = $_POST["fName"];
    $lName = $_POST["lName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $role = $_POST["role"];
    // $exists=false;
        // Check whether this username exists
        $existSql = "SELECT * FROM `users` WHERE email = '$email'";
        $result = mysqli_query($conn, $existSql);
        $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0){
        // $exists = true;
        $showError = "Email Already Exists";
    }
    else{
         if($password == $cpassword){
            // $sql = "INSERT INTO `users` ( `username`, `password`, `dt`) VALUES ('$username', '$password', current_timestamp())";
             $sql = "INSERT INTO `users` (`fname`, `lname`, `email`, `password`, `role`, `pic`, `id`, `course`, `dt`) VALUES ('$fName', '$lName', '$email', '$password', '$role', NULL, NULL, NULL, current_timestamp())";
             $result = mysqli_query($conn, $sql);
            if ($result){
                 $showAlert = true;
             }
        }
        else{
            $showError = "Passwords do not match";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php require 'partials/_nav.php' ?>
    <div class="container" id="signup" >
        <h1 class="form-title">Sign Up to Our Plateform</h1>
        <form class="signuplog-form" method="post" action="/learnerHub/signup.php"
            style="display:flex; flex-direction:column; gap:10px; margin-top: 15px;">
            <div class="input-group" style="display: flex; flex-direction: column; gap: 5px;">
                <input class="input-class" style="padding: 5px;" type="text" name="fName" id="fName" placeholder="First Name" required>
                <label for="fname">First Name</label>
            </div>
            <div class="input-group" style="display: flex; flex-direction: column; gap: 5px;">
                <input class="input-class" style="padding: 5px;" type="text" name="lName" id="lName" placeholder="Last Name" required>
                <label for="lName">Last Name</label>
            </div>
            <div class="input-group" style="display: flex; flex-direction: column; gap: 5px;">
                <input class="input-class" style="padding: 5px;" type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>

            <div class="signup-role-container">
                <div>
                    <div class="input-group" style="display: flex; flex-direction: column; gap: 5px;">
                        <input style="padding: 5px;" type="password" name="password" id="password"
                            placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                    <div class="input-group" style="display: flex; flex-direction: column; gap: 5px;">
                        <input style="padding: 5px;" type="password" name="cpassword" id="cpassword"
                            placeholder="Password" required>
                        <label for="cpassword">Confirm Password</label>
                    </div>
                </div>

                <div>
                    <label for="role">Choose Role:</label>
                    <select id="role" name="role" style="padding: 5px;">
                        <option value="student">Student</option>
                        <option value="instructor">Instructor</option>
                    </select>
                </div>
            </div>


            <input type="submit" class="btn33" value="Sign Up" name="signUp">
        </form>
        <!-- <p class="or">
        ----------or--------
      </p> -->
        <!-- <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
      </div> -->
        <div class="links" style="display: flex; gap: 5px; padding:20px 0px 0px 40px;">
            <p>Already Have Account ?</p>
            <a href="login.php"><button id="signInButton">Log In</button></a>
        </div>
    </div>
    <?php
    if($showAlert){
        echo '  <div id="custom-alert" style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); width: 70%; padding: 15px; background-color: #46694c; color: white; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; transition: opacity 0.5s ease-out; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
     <strong style="margin-right: 10px;">Success Hurayyy!</strong> You have successfully sign in now you can login.
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