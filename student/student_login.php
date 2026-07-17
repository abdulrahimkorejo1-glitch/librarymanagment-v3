<?php
session_start();

include("../includes/config.php");

$error = "";

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM students WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $row = $result->fetch_assoc();

        $_SESSION['student_id'] = $row['id'];
        $_SESSION['student_name'] = $row['full_name'];

        header("Location: student_dashboard.php");
        exit();

    }else{

        $error = "Invalid Email or Password!";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>

    <link rel="stylesheet" href="../style.css">

</head>

<body>

<div class="login-container">

<div class="login-box">

<h2>Student Login</h2>

<?php
if($error!=""){
    echo "<p style='color:red;'>$error</p>";
}
?>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<br><br>

<button type="submit" name="login">Login</button>

</form>

</div>

</div>

</body>
</html>