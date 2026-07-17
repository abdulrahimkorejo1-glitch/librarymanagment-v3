<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

$sql = "SELECT
            issued_books.id,
            students.full_name,
            books.title,
            issued_books.issue_date,
            issued_books.due_date,
            issued_books.return_date,
            issued_books.status,
            issued_books.fine
        FROM issued_books
        JOIN students ON issued_books.student_id = students.id
        JOIN books ON issued_books.book_id = books.id
        ORDER BY issued_books.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issued Books</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<h2>📖 Issued Books</h2>

<a class="btn add" href="issue_book.php">➕ Issue New Book</a>
<a class="btn" href="dashboard.php">🏠 Dashboard</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>ID</th>
    <th>Student</th>
    <th>Book</th>
    <th>Issue Date</th>
    <th>Due Date</th>
    <th>Return Date</th>
    <th>Status</th>
    <th>Fine</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>

    <td><?php echo $row['id']; ?></td>

    <td><?php echo htmlspecialchars($row['full_name']); ?></td>

    <td><?php echo htmlspecialchars($row['title']); ?></td>

    <td><?php echo $row['issue_date']; ?></td>

    <td><?php echo $row['due_date']; ?></td>

    <td><?php echo $row['return_date']; ?></td>

    <td><?php echo $row['status']; ?></td>

    <td>Rs. <?php echo $row['fine']; ?></td>

    <td>
        <?php if($row['status']=="Issued"){ ?>
            <a class="btn edit" href="return_book.php?id=<?php echo $row['id']; ?>">Return</a>
        <?php } else { ?>
            Returned
        <?php } ?>
    </td>

</tr>

<?php } ?>

</table>

</body>
</html>