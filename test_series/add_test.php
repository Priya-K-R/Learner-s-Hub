<style>
.form-wrapper {
  max-width: 400px;
  margin: 40px auto;
  padding: 10px;
}

.back-button {
  display: inline-block;
  margin-bottom: 20px;
  color: #4a90e2;
  text-decoration: none;
  font-size: 16px;
  font-weight: bold;
  transition: color 0.3s ease;
}
.home-button{
    display: inline-block;
  margin-bottom: 20px;
  color: #4a90e2;
  text-decoration: none;
  font-size: 16px;
  font-weight: bold;
  transition: color 0.3s ease;
}

.back-button:hover {
  color: #357ab8;
}

.add-test-form {
  padding: 25px;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.add-test-form h2 {
  text-align: center;
  margin-bottom: 20px;
  font-family: Arial, sans-serif;
  color: #333;
}

.add-test-form input {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-sizing: border-box;
  font-size: 14px;
}

.add-test-form input:focus {
  border-color: #4a90e2;
  outline: none;
}

.add-test-form button {
  width: 100%;
  padding: 10px;
  background-color: #4a90e2;
  color: white;
  font-size: 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.add-test-form button:hover {
  background-color: #357ab8;
}

</style>
<div class="form-wrapper">
    
<form method="POST" action="" class="add-test-form">
    <a href="../homeInstructor.php" class="back-button">← Back</a>
    <a href="../index.php" class="home-button">Home</a>
    <h2>Add New Test</h2>
    <input type="text" name="test_name" placeholder="Add Test Name" required>
    <input type="text" name="title" placeholder="Test Title" required>
    <input type="text" name="subject" placeholder="Subject" required>
    <input type="number" name="total_questions" placeholder="Total Questions" required>
    <input type="number" name="duration" placeholder="Duration (in minutes)" required>
    <button type="submit" name="addTest">Add Test</button>
</form>
</div>


<?php
include("../partials/_dbconnect.php");
if(isset($_POST['addTest'])) {
    $test_name=$_post['test_name'];
    $title = $_POST['title'];
    $subject = $_POST['subject'];
    $total = $_POST['total_questions'];
    $duration = $_POST['duration'];

    $query = "INSERT INTO test_series (test_name,title,subject,total_questions, duration)
              VALUES ('$test_name','$title', '$subject', $total, $duration)";
    if(mysqli_query($conn, $query)) {
        // echo "<script>alert('Test Added Successfully');</script>";
        header("Location: add_question.php");
       
    } else {
        echo "<script>alert('Error adding test');</script>";
    }
}
?>