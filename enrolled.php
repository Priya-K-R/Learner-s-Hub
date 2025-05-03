<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolled - Learn and Grow</title>
</head>

<body>
    <?php require 'partials/_nav.php' ?>
    <?php require 'partials/_ask.php' ?>
    <div style="min-height: 85vh;">
        <p style="font-size: 50px; text-align: center; padding-top: 5vw;">Payment Done.</p>
        <p style="font-size: 25px; text-align:center; padding: 2vw;">You are Successfully Enrolled.</p>
        <div style="display: flex; justify-items: center; justify-content: center;">
            <img src="assets/Animation - 1743859354341.gif" alt="done-gif">
        </div>
        <p style="font-size: 60px; text-align: center; color: green; padding-top: 2vw;">Congratulations!</p>
        <p style="font-size: 20px; text-align: center; padding-top: 2vw;">Now You can watch all the Lectures of this Course.</p>

    </div>
    <?php require 'partials/_footer.php' ?>
</body>

</html>