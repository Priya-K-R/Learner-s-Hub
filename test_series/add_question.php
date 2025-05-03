<?php
include("../partials/_dbconnect.php");

// Fetch all test series for the dropdown
$testQuery = "SELECT * FROM test_series";
$testResult = mysqli_query($conn, $testQuery);
?>
<style>
    .question-form-wrapper {
  max-width: 600px;
  margin: 40px auto;
  padding: 15px;
}

.back-button {
  display: inline-block;
  margin-bottom: 20px;
  color: #4a90e2;
  text-decoration: none;
  font-size: 16px;
  font-weight: bold;
}

.back-button:hover {
  color: #357ab8;
}

.add-question-form {
  background-color: #fdfdfd;
  border: 1px solid #ddd;
  border-radius: 10px;
  padding: 25px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.add-question-form h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.add-question-form label {
  display: block;
  margin-top: 15px;
  margin-bottom: 5px;
  font-weight: bold;
  color: #555;
}

.add-question-form input[type="text"],
.add-question-form select,
.add-question-form textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  box-sizing: border-box;
}

.add-question-form textarea {
  resize: vertical;
}

.add-question-form input:focus,
.add-question-form textarea:focus,
.add-question-form select:focus {
  border-color: #4a90e2;
  outline: none;
}

.add-question-form button {
  width: 100%;
  margin-top: 20px;
  padding: 12px;
  background-color: #4a90e2;
  color: white;
  font-size: 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.add-question-form button:hover {
  background-color: #357ab8;
}

</style>

<div class="question-form-wrapper">

  <form method="POST" action="" class="add-question-form">
  <a href="../homeInstructor.php" class="back-button">← Back</a>
    <h2>Add Question to a Test</h2>

    <label for="test_id">Select Test:</label>
    <select name="test_id" id="test_id" required>
      <option value="">-- Select Test --</option>
      <?php while($row = mysqli_fetch_assoc($testResult)) { ?>
        <option value="<?= $row['id'] ?>"><?= $row['title'] ?> (<?= $row['subject'] ?>)</option>
      <?php } ?>
    </select>

    <label for="question">Question:</label>
    <textarea name="question" id="question" rows="4" required></textarea>

    <label for="option_a">Option A:</label>
    <input type="text" name="option_a" id="option_a" required>

    <label for="option_b">Option B:</label>
    <input type="text" name="option_b" id="option_b" required>

    <label for="option_c">Option C:</label>
    <input type="text" name="option_c" id="option_c" required>

    <label for="option_d">Option D:</label>
    <input type="text" name="option_d" id="option_d" required>

    <label for="correct_question">Correct Option (a/b/c/d):</label>
    <input type="text" name="correct_question" id="correct_question" maxlength="1" required>

    <button type="submit" name="add_question">Add Question</button>
  </form>
</div>

<?php
if (isset($_POST['add_question'])) {
    $test_id = $_POST['test_id'];
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $a = mysqli_real_escape_string($conn, $_POST['option_a']);
    $b = mysqli_real_escape_string($conn, $_POST['option_b']);
    $c = mysqli_real_escape_string($conn, $_POST['option_c']);
    $d = mysqli_real_escape_string($conn, $_POST['option_d']);
    $correct = strtolower($_POST['correct_question']);

    $query = "INSERT INTO question_series 
              (test_id, question, option_a, option_b, option_c, option_d, correct_question)
              VALUES ('$test_id', '$question', '$a', '$b', '$c', '$d', '$correct')";
              
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Question added successfully');</script>";
    } else {
        echo "<script>alert('Error adding question');</script>";
    }
}
?>