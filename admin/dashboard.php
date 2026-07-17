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

// Recent Issued Books
$recentBooks = $conn->query("
SELECT students.full_name,
       books.title,
       issued_books.issue_date
FROM issued_books
JOIN students ON students.id = issued_books.student_id
JOIN books ON books.id = issued_books.book_id
ORDER BY issued_books.id DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Library Dashboard</title>

<link rel="stylesheet" href="../style.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main">

<h1 style="text-align:center;">
Welcome <?php echo $_SESSION['admin']; ?>
</h1>

<h2 style="text-align:center;color:#1565c0;">
📚 Library Management Dashboard
</h2>

<div class="dashboard">

<div class="card">
<h2><?php echo $totalBooks; ?></h2>
<p>Total Books</p>
</div>

<div class="card">
<h2><?php echo $totalStudents; ?></h2>
<p>Total Students</p>
</div>

<div class="card">
<h2><?php echo $totalIssued; ?></h2>
<p>Issued Books</p>
</div>

<div class="card">
<h2><?php echo $totalReturned; ?></h2>
<p>Returned Books</p>
</div>

</div>

<br>

<div class="menu-buttons">

 <a class="btn" href="reports.php">📊 Reports</a>

<a class="btn" href="search.php">🔍 Search</a>

<a class="btn" href="reservations.php">📚 Reservations</a>

<a class="btn" href="books.php">📚 Manage Books</a>

<a class="btn" href="students.php">👨‍🎓 Students</a>

<a class="btn" href="issue_book.php">📖 Issue Book</a>

<a class="btn" href="issued_books.php">📋 Issued Books</a>

<a class="btn logout" href="logout.php">🚪 Logout</a>

</div>

<br><br>

<div style="width:80%;margin:auto;">

<canvas id="libraryChart"></canvas>

</div>

<br><br>

<h2 style="text-align:center;">📖 Recent Issued Books</h2>

<table border="1" cellpadding="10" cellspacing="0" width="90%" style="margin:auto;">

<tr>
<th>Student</th>
<th>Book</th>
<th>Issue Date</th>
</tr>

<?php while($row = $recentBooks->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['full_name']; ?></td>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['issue_date']; ?></td>

</tr>

<?php } ?>

</table>

<br><br>

<script>

const ctx = document.getElementById('libraryChart');

new Chart(ctx,{

type:'bar',

data:{

labels:['Books','Students','Issued','Returned'],

datasets:[{

label:'Library Statistics',

data:[
<?php echo $totalBooks; ?>,
<?php echo $totalStudents; ?>,
<?php echo $totalIssued; ?>,
<?php echo $totalReturned; ?>
]

}]

},

options:{
responsive:true,
plugins:{
legend:{
display:true
}
}
}

});

</script>

</div>

</body>
</html>