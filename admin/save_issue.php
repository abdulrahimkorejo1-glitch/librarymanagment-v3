<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

if(isset($_POST['issue'])){

    $student_id = $_POST['student_id'];
    $book_id = $_POST['book_id'];
    $issue_date = $_POST['issue_date'];
    $return_date = $_POST['return_date'];

    // Check available books
    $check = $conn->prepare("SELECT available FROM books WHERE id=?");
    $check->bind_param("i", $book_id);
    $check->execute();
    $result = $check->get_result();
    $book = $result->fetch_assoc();

    if($book['available'] <= 0){
        die("❌ This book is not available.");
    }

    // Save issue record
    $stmt = $conn->prepare("INSERT INTO issued_books (student_id, book_id, issue_date, return_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $student_id, $book_id, $issue_date, $return_date);

    if($stmt->execute()){

        // Reduce available books by 1
        $update = $conn->prepare("UPDATE books SET available = available - 1 WHERE id=?");
        $update->bind_param("i", $book_id);
        $update->execute();

        header("Location: issued_books.php");
        exit();

    }else{
        echo "Error: " . $conn->error;
    }

}
?>