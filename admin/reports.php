<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

// Statistics
$totalBooks = $conn->query("SELECT COUNT(*) AS total FROM books")->fetch_assoc()['total'];

$totalStudents = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()['total'];

$totalIssued = $conn->query("SELECT COUNT(*) AS total FROM issued_books WHERE status='Issued'")->fetch_assoc()['total'];

$totalReturned = $conn->query("SELECT COUNT(*) AS total FROM issued_books WHERE status='Returned'")->fetch_assoc()['total'];

$totalFine = $conn->query("SELECT SUM(fine) AS total FROM issued_books")->fetch_assoc()['total'];

if($totalFine == NULL){
    $totalFine = 0;
}

$todayIssues = $conn->query("SELECT COUNT(*) AS total FROM issued_books WHERE issue_date=CURDATE()")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>

<title>Library Reports</title>

<link rel="stylesheet" href="../style.css">

<style>

.report-box{
width:80%;
margin:30px auto;
background:white;
padding:30px;
box-shadow:0 0 10px #ccc;
border-radius:10px;
}

.report-box h2{
text-align:center;
margin-bottom:30px;
}

.report-table{
width:100%;
border-collapse:collapse;
}

.report-table th,
.report-table td{
border:1px solid #ccc;
padding:12px;
text-align:left;
}

.report-table th{
background:#1565c0;
color:white;
}

.print-btn{
padding:10px 20px;
background:#1565c0;
color:white;
border:none;
cursor:pointer;
border-radius:5px;
margin-top:20px;
}

.print-btn:hover{
background:#0d47a1;
}

</style>

</head>

<body>

<div class="report-box">

<h2>📊 Library Reports</h2>

<table class="report-table">

<tr>
<th>Report</th>
<th>Value</th>
</tr>

<tr>
<td>Total Books</td>
<td><?php echo $totalBooks; ?></td>
</tr>

<tr>
<td>Total Students</td>
<td><?php echo $totalStudents; ?></td>
</tr>

<tr>
<td>Issued Books</td>
<td><?php echo $totalIssued; ?></td>
</tr>

<tr>
<td>Returned Books</td>
<td><?php echo $totalReturned; ?></td>
</tr>

<tr>
<td>Today's Issued Books</td>
<td><?php echo $todayIssues; ?></td>
</tr>

<tr>
<td>Total Fine Collected</td>
<td>Rs. <?php echo $totalFine; ?></td>
</tr>

</table>

<br>

<button class="print-btn" onclick="window.print()">🖨 Print Report</button>

<a class="print-btn" href="dashboard.php" style="text-decoration:none;">🏠 Dashboard</a>

</div>

</body>
</html>