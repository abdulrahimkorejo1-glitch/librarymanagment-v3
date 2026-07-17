<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM books WHERE id=?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        header("Location: books.php?msg=deleted");
        exit();
    }else{
        echo "Error deleting book!";
    }

}else{
    header("Location: books.php");
    exit();
}
?>