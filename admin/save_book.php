<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

if (isset($_POST['save'])) {

    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $isbn = trim($_POST['isbn']);
    $quantity = (int)$_POST['quantity'];
    $available = $quantity;

    // Image Upload
    $image = "";

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

        $image = time() . "_" . basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../images/" . $image
        );
    }

    $stmt = $conn->prepare("INSERT INTO books (title, author, category, isbn, quantity, available, image)
    VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ssssiis",
        $title,
        $author,
        $category,
        $isbn,
        $quantity,
        $available,
        $image
    );

    if($stmt->execute()){
        header("Location: books.php?success=1");
        exit();
    }else{
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>