<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if(isset($_POST['update'])){

    $full_name = $_POST['full_name'];
    $roll_no = $_POST['roll_no'];
    $class = $_POST['class'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE students SET full_name=?, roll_no=?, class=?, phone=?, email=? WHERE id=?");

    $stmt->bind_param("sssssi",$full_name,$roll_no,$class,$phone,$email,$id);

    if($stmt->execute()){
        header("Location: students.php");
        exit();
    }else{
        echo "Error!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>

<h2>Edit Student</h2>

<form method="POST">

<input type="text" name="full_name" value="<?php echo $row['full_name']; ?>" required>

<input type="text" name="roll_no" value="<?php echo $row['roll_no']; ?>" required>

<input type="text" name="class" value="<?php echo $row['class']; ?>" required>

<input type="text" name="phone" value="<?php echo $row['phone']; ?>">

<input type="email" name="email" value="<?php echo $row['email']; ?>">

<br><br>

<button name="update">Update Student</button>

</form>

</body>
</html>