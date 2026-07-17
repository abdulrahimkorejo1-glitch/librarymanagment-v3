<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        header("Location: students.php?deleted=1");
        exit();
    }else{
        echo "Error deleting student!";
    }

}else{
    header("Location: students.php");
    exit();
}
?>