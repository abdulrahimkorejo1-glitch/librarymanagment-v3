<?php
session_start();

if(!isset($_SESSION['student_id'])){
    header("Location: student_login.php");
    exit();
}

include("../includes/config.php");

$student_id = $_SESSION['student_id'];

// Reserve Book
if(isset($_GET['book_id'])){

    $book_id = (int)$_GET['book_id'];

    // Check if already reserved
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE student_id=? AND book_id=? AND status='Pending'");
    $stmt->bind_param("ii",$student_id,$book_id);
    $stmt->execute();

    if($stmt->get_result()->num_rows==0){

        $today = date("Y-m-d");

        $stmt = $conn->prepare("INSERT INTO reservations(student_id,book_id,reservation_date) VALUES(?,?,?)");
        $stmt->bind_param("iis",$student_id,$book_id,$today);
        $stmt->execute();

        echo "<script>alert('Book Reserved Successfully');</script>";

    }else{

        echo "<script>alert('You have already reserved this book');</script>";

    }

}

// Show Books
$books = $conn->query("SELECT * FROM books WHERE available>0 ORDER BY title ASC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Reserve Book</title>

<link rel="stylesheet" href="../style.css">

</head>

<body>

<h2 style="text-align:center;">📚 Reserve Book</h2>

<table border="1" cellpadding="10" width="90%" style="margin:auto;">

<tr>
<th>Title</th>
<th>Author</th>
<th>Available</th>
<th>Action</th>
</tr>

<?php while($row=$books->fetch_assoc()){ ?>

<tr>

<td><?php echo htmlspecialchars($row['title']); ?></td>

<td><?php echo htmlspecialchars($row['author']); ?></td>

<td><?php echo $row['available']; ?></td>

<td>

<a href="reserve_book.php?book_id=<?php echo $row['id']; ?>">
Reserve
</a>

</td>

</tr>

<?php } ?>

</table>

<br><br>

<div style="text-align:center;">
<a href="student_dashboard.php">🏠 Back to Dashboard</a>
</div>

</body>
</html>