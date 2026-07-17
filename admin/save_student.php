<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

if(isset($_POST['save'])){

    $full_name = trim($_POST['full_name']);
    $roll_no = trim($_POST['roll_no']);
    $class = trim($_POST['class']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("INSERT INTO students(full_name, roll_no, class, phone, email) VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param("sssss", $full_name, $roll_no, $class, $phone, $email);

    if($stmt->execute()){
        header("Location: students.php");
        exit();
    }else{
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>