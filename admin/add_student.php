<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<h2>👨‍🎓 Add New Student</h2>

<form action="save_student.php" method="POST">

<label>Full Name</label><br>
<input type="text" name="full_name" required><br><br>

<label>Roll No</label><br>
<input type="text" name="roll_no" required><br><br>

<label>Class</label><br>
<input type="text" name="class" required><br><br>

<label>Phone</label><br>
<input type="text" name="phone"><br><br>

<label>Email</label><br>
<input type="email" name="email"><br><br>

<button type="submit" name="save">Save Student</button>

</form>

<br>

<a href="students.php">⬅ Back to Students</a>

</body>
</html>