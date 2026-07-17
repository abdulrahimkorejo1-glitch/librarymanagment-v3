<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

$search = "";

$books = null;
$students = null;

if(isset($_GET['search'])){

    $search = trim($_GET['search']);
    $keyword = "%".$search."%";

    // Search Books
    $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR category LIKE ?");
    $stmt->bind_param("sss",$keyword,$keyword,$keyword);
    $stmt->execute();
    $books = $stmt->get_result();

    // Search Students
    $stmt2 = $conn->prepare("SELECT * FROM students WHERE full_name LIKE ? OR email LIKE ?");
    $stmt2->bind_param("ss",$keyword,$keyword);
    $stmt2->execute();
    $students = $stmt2->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<h2>🔍 Library Search</h2>

<a class="btn" href="dashboard.php">🏠 Dashboard</a>

<br><br>

<form method="GET">

<input type="text"
name="search"
placeholder="Search Book or Student"
value="<?php echo htmlspecialchars($search); ?>">

<button type="submit">Search</button>

</form>

<?php if($books){ ?>

<h3>📚 Books</h3>

<table border="1" cellpadding="10">

<tr>
<th>Title</th>
<th>Author</th>
<th>Category</th>
</tr>

<?php while($row=$books->fetch_assoc()){ ?>

<tr>
<td><?php echo htmlspecialchars($row['title']); ?></td>
<td><?php echo htmlspecialchars($row['author']); ?></td>
<td><?php echo htmlspecialchars($row['category']); ?></td>
</tr>

<?php } ?>

</table>

<?php } ?>

<?php if($students){ ?>

<h3>👨‍🎓 Students</h3>

<table border="1" cellpadding="10">

<tr>
<th>Name</th>
<th>Email</th>
</tr>

<?php while($row=$students->fetch_assoc()){ ?>

<tr>
<td><?php echo htmlspecialchars($row['full_name']); ?></td>
<td><?php echo htmlspecialchars($row['email']); ?></td>
</tr>

<?php } ?>

</table>

<?php } ?>

</body>
</html>