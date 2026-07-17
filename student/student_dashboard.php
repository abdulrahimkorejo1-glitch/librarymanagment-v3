<?php
session_start();

if(!isset($_SESSION['student_id'])){
    header("Location: student_login.php");
    exit();
}

include("../includes/config.php");

$student_id = $_SESSION['student_id'];

// Student Information
$stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
$stmt->bind_param("i",$student_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

// Total Issued Books
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM issued_books WHERE student_id=?");
$stmt->bind_param("i",$student_id);
$stmt->execute();
$totalIssued = $stmt->get_result()->fetch_assoc()['total'];

// Total Fine
$stmt = $conn->prepare("SELECT SUM(fine) AS totalFine FROM issued_books WHERE student_id=?");
$stmt->bind_param("i",$student_id);
$stmt->execute();
$fineRow = $stmt->get_result()->fetch_assoc();
$totalFine = $fineRow['totalFine'];
if($totalFine==""){
    $totalFine = 0;
}

// My Issued Books
$stmt = $conn->prepare("
SELECT books.title,
       issued_books.issue_date,
       issued_books.return_date,
       issued_books.status,
       issued_books.fine
FROM issued_books
JOIN books ON books.id=issued_books.book_id
WHERE issued_books.student_id=?
ORDER BY issued_books.id DESC
");
$stmt->bind_param("i",$student_id);
$stmt->execute();
$books = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>

<title>Student Dashboard</title>

<link rel="stylesheet" href="../style.css">

</head>

<body>

<h1 style="text-align:center;">
Welcome <?php echo htmlspecialchars($_SESSION['student_name']); ?>
</h1>

<h2 style="text-align:center;">
🎓 Student Dashboard
</h2>

<table border="1" cellpadding="10" width="60%" style="margin:auto;">

<tr>
<td><b>Name</b></td>
<td><?php echo htmlspecialchars($student['full_name']); ?></td>
</tr>

<tr>
<td><b>Email</b></td>
<td><?php echo htmlspecialchars($student['email']); ?></td>
</tr>

<tr>
<td><b>Total Issued Books</b></td>
<td><?php echo $totalIssued; ?></td>
</tr>

<tr>
<td><b>Total Fine</b></td>
<td>Rs. <?php echo $totalFine; ?></td>
</tr>

</table>

<br>

<h2 style="text-align:center;">📚 My Issued Books</h2>

<table border="1" cellpadding="10" width="90%" style="margin:auto;">

<tr>

<th>Book</th>
<th>Issue Date</th>
<th>Return Date</th>
<th>Status</th>
<th>Fine</th>

</tr>

<?php while($row = $books->fetch_assoc()){ ?>

<tr>

<td><?php echo htmlspecialchars($row['title']); ?></td>

<td><?php echo $row['issue_date']; ?></td>

<td><?php echo $row['return_date']; ?></td>

<td><?php echo $row['status']; ?></td>

<td>Rs. <?php echo $row['fine']; ?></td>

</tr>

<?php } ?>

</table>

<br><br>

<div style="text-align:center;">
    <a href="reserve_book.php">📚 Reserve Book</a>

<br><br>

<a href="student_logout.php">🚪 Logout</a>

</div>

</body>
</html>