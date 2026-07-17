<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

// Approve Reservation
if(isset($_GET['approve'])){
    $id = (int)$_GET['approve'];
    $conn->query("UPDATE reservations SET status='Approved' WHERE id=$id");
    header("Location: reservations.php");
    exit();
}

// Reject Reservation
if(isset($_GET['reject'])){
    $id = (int)$_GET['reject'];
    $conn->query("UPDATE reservations SET status='Rejected' WHERE id=$id");
    header("Location: reservations.php");
    exit();
}

// Fetch Reservations
$result = $conn->query("
SELECT
reservations.id,
students.full_name,
books.title,
reservations.reservation_date,
reservations.status
FROM reservations
JOIN students ON students.id = reservations.student_id
JOIN books ON books.id = reservations.book_id
ORDER BY reservations.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Reservations</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<h2>📚 Book Reservations</h2>

<a class="btn" href="dashboard.php">🏠 Dashboard</a>
<br><br>

<table border="1" cellpadding="10" cellspacing="0" width="100%">

<tr>
    <th>ID</th>
    <th>Student Name</th>
    <th>Book Name</th>
    <th>Reservation Date</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['full_name']); ?></td>

<td><?php echo htmlspecialchars($row['title']); ?></td>

<td><?php echo $row['reservation_date']; ?></td>

<td><?php echo $row['status']; ?></td>

<td>

<?php if($row['status']=="Pending"){ ?>

<a class="btn edit"
href="reservations.php?approve=<?php echo $row['id']; ?>">
✅ Approve
</a>

<a class="btn delete"
href="reservations.php?reject=<?php echo $row['id']; ?>"
onclick="return confirm('Reject this reservation?');">
❌ Reject
</a>

<?php } else { ?>

Completed

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>