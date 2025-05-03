<link rel="stylesheet" href="style.css">
<?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    $loggedin = true;
} else {
    $loggedin = false;
}

echo '<section class="nav-section">
        <nav>
            <div style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); background-color: white; height: 65px;" class="nav-container">
                <div>
                    <h1 class="logo"><a style="text-decoration: none; color: rgb(49, 3, 95);;" href="index.php">Learner\'s Hub</a></h1>
                </div>
                <div class="nav-item">
                <div class="nav-item-svg"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 30 30">
                        <path d="M 3 7 A 1.0001 1.0001 0 1 0 3 9 L 27 9 A 1.0001 1.0001 0 1 0 27 7 L 3 7 z M 3 14 A 1.0001 1.0001 0 1 0 3 16 L 27 16 A 1.0001 1.0001 0 1 0 27 14 L 3 14 z M 3 21 A 1.0001 1.0001 0 1 0 3 23 L 27 23 A 1.0001 1.0001 0 1 0 27 21 L 3 21 z"></path>
                        </svg></div>
                    <ul class="nav-items">
                        <li style="color: black;"><a style="text-decoration: none; color:black;" href="courses.php">Courses</a></li>
                        <li style="color: black;"><a style="text-decoration: none; color:black;" href="/learnerHub/test_series/exam.php">Test series</a></li>
                        <li style="color: black;"><a style="text-decoration: none; color:black;" href="doubt.php">Ask Doubt</a></li>
                        <li style="color: black;"><a style="text-decoration: none; color:black;" href="/learnerHub/Study_Material/view_material.php">Study Material</a></li>';
                        
if(!$loggedin){
    echo '
                        <li>
                            <button style="padding: 5px 8px; border:1px solid blueviolet; color:rgb(74, 5, 142); border-radius: 5px; background-color:white;">
                                <a onMouseOver="this.style.color=\'blueviolet\'" onMouseOut="this.style.color=\'rgb(69, 3, 135)\'" style="text-decoration: none; color:rgb(72, 2, 141);" href="/learnerHub/login.php">Login</a>
                            </button>
                        </li>
                        <li>
                            <button style="padding: 5px 8px; border:1px solid blueviolet; color:rgb(74, 5, 142); border-radius: 5px; background-color:white;">
                                <a onMouseOver="this.style.color=\'blueviolet\'" onMouseOut="this.style.color=\'rgb(69, 3, 135)\'" style="text-decoration: none; color:rgb(72, 2, 141);" href="/learnerHub/signup.php">Sign Up</a>
                            </button>
                        </li>';
}
if ($loggedin) {
    echo '
    <li>
        <div style="position: relative;">
            <button onclick="toggleDropdown()" style="background: none; border: none; color: blueviolet; cursor: pointer;">
                Hello, ' . $_SESSION['fname'] . '
            </button>
            <div id="userDropdown" style="display: none; position: absolute; top:20px; right: 0; background-color: #fff; min-width: 150px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); z-index: 1;">';

    if ($_SESSION['role'] === 'instructor') {
        // If the user is an instructor
        echo '
                <a href="/learnerHub/homeInstructor.php" style="color: #333; padding: 10px 15px; display: block; text-decoration: none;">Dashboard</a>
                <a href="/learnerHub/profile.php" style="color: #333; padding: 10px 15px; display: block; text-decoration: none;">My Profile</a>';
    } else {
        // If the user is a student
        echo '
                <!-- <a href="/learnerHub/classroom.php" style="color: #333; padding: 10px 15px; display: block; text-decoration: none;">Classroom</a> -->
                <a href="/learnerHub/profile.php" style="color: #333; padding: 10px 15px; display: block; text-decoration: none;">My Profile</a>';
    }

    echo '
            </div>
        </div>
    </li>
    <li>
        <button style="padding: 5px 8px; border:1px solid blueviolet; color:rgb(74, 5, 142); border-radius: 5px; background-color:white;">
            <a onMouseOver="this.style.color=\'blueviolet\'" onMouseOut="this.style.color=\'rgb(69, 3, 135)\'" style="text-decoration: none; color:rgb(72, 2, 141);" href="/learnerHub/logout.php">Logout</a>
        </button>
    </li>';
}

echo '              </ul>
                </div>
            </div>
        </nav>
    </section>';
?>

<script>
    function toggleDropdown() {
      var dropdown = document.getElementById("userDropdown");
      if (dropdown.style.display === "none" || dropdown.style.display === "") {
        dropdown.style.display = "block";
      } else {
        dropdown.style.display = "none";
      }
    }
    
    // Optional: Close the dropdown if clicking outside
    window.onclick = function(event) {
      if (!event.target.matches('button')) {
        var dropdown = document.getElementById("userDropdown");
        if (dropdown.style.display === "block") {
          dropdown.style.display = "none";
        }
      }
    }
  </script>
