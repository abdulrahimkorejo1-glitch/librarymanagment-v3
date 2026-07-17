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
    <title>Add Book</title>
</head>
<body>

<h2>Add New Book</h2>

<form action="save_book.php" method="POST" enctype="multipart/form-data">

<label>Book Title</label><br>
<input type="text" name="title" required><br><br>

<label>Author</label><br>
<input type="text" name="author" required><br><br>

<label>Category</label><br>
<input type="text" name="category" required><br><br>

<label>ISBN</label><br>
<input type="text" name="isbn" required><br><br>

<label>Quantity</label><br>
<input type="number" name="quantity" required><br><br>
<label>Book Cover</label><br>
<input type="file" name="image"><br><br>

<button type="submit" name="save">Save Book</button>

</form>

<br>
<a href="books.php">⬅ Back to Books</a>

</body>
</html>