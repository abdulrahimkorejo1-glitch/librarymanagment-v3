<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

$search = "";

if(isset($_GET['search']) && $_GET['search'] != ""){

    $search = trim($_GET['search']);
    $keyword = "%".$search."%";

    $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR category LIKE ? ORDER BY id DESC");
    $stmt->bind_param("sss", $keyword, $keyword, $keyword);
    $stmt->execute();
    $result = $stmt->get_result();

}else{

    $result = $conn->query("SELECT * FROM books ORDER BY id DESC");

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Books</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<h2>📚 Manage Books</h2>

<a class="btn add" href="dashboard.php">🏠 Dashboard</a>
<a class="btn add" href="add_book.php">➕ Add Book</a>
<a class="btn logout" href="logout.php">🚪 Logout</a>

<br><br>

<form method="GET">
    <input type="text"
           name="search"
           placeholder="Search by Title, Author or Category"
           value="<?php echo htmlspecialchars($search); ?>">

    <button type="submit">🔍 Search</button>

    <a class="btn" href="books.php">Reset</a>
</form>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Author</th>
    <th>Category</th>
    <th>ISBN</th>
    <th>Quantity</th>
    <th>Available</th>
    <th>Image</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['author']; ?></td>

<td><?php echo $row['category']; ?></td>

<td><?php echo $row['isbn']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td><?php echo $row['available']; ?></td>

<td>

<?php
if(!empty($row['image'])){
?>
    <img src="../images/<?php echo $row['image']; ?>" width="70" height="90" style="border-radius:5px;">
<?php
}else{
    echo "No Image";
}
?>

</td>

<td>

<a class="btn edit" href="edit_book.php?id=<?php echo $row['id']; ?>">
✏ Edit
</a>

<a class="btn delete"
href="delete_book.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Are you sure you want to delete this book?');">
🗑 Delete
</a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>