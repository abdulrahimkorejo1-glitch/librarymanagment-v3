<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

$id = (int)$_GET['id'];

// Book details lao
$stmt = $conn->prepare("SELECT book_id, due_date FROM issued_books WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$book_id = $row['book_id'];
$due_date = $row['due_date'];

$today = date("Y-m-d");

// Fine calculate
$fine = 0;

if(strtotime($today) > strtotime($due_date)){
    $daysLate = floor((strtotime($today) - strtotime($due_date)) / 86400);
    $fine = $daysLate * 10; // Rs.10 per day
}

// Return update
$stmt = $conn->prepare("
UPDATE issued_books
SET
status='Returned',
return_date=?,
fine=?
WHERE id=?
");

$stmt->bind_param("sii", $today, $fine, $id);
$stmt->execute();

// Available books +1
$stmt = $conn->prepare("UPDATE books SET available = available + 1 WHERE id=?");
$stmt->bind_param("i", $book_id);
$stmt->execute();

header("Location: issued_books.php");
exit();
?>