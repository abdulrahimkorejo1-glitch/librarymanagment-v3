<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

$students = $conn->query("SELECT * FROM students");
$books = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
<title>Issue Book</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>

<h2>📖 Issue Book</h2>

<form action="save_issue.php" method="POST">

<label>Select Student</label><br>

<select name="student_id" required>

<option value="">Select Student</option>

<?php while($s = $students->fetch_assoc()){ ?>

<option value="<?php echo $s['id']; ?>">
<?php echo $s['full_name']; ?>
</option>

<?php } ?>

</select>

<br><br>

<label>Select Book</label><br>

<select name="book_id" required>

<option value="">Select Book</option>

<?php while($b = $books->fetch_assoc()){ ?>

<option value="<?php echo $b['id']; ?>">
<?php echo $b['title']; ?>
</option>

<?php } ?>

</select>

<br><br>

<label>Issue Date</label><br>

<input type="date" name="issue_date" required>

<br><br>

<label>Return Date</label><br>

<input type="date" name="return_date" required>

<br><br>

<button type="submit" name="issue">Issue Book</button>

</form>

</body>
</html>