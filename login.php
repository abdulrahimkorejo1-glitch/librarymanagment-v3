session_start();
include "includes/config.php";

$error = "";

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows==1){

        $row = $result->fetch_assoc();


          $_SESSION['admin'] = $row['username'];
             header("Location: admin/dashboard.php");
    exit();
}

        
        else{
            $error="Wrong Password!";
        }

    }else{
        $error="Username Not Found!";
    }

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-container">

<div class="login-box">

<h2>Library Login</h2>

<?php
if(isset($_POST['login']) && !empty($error)){
    echo "<p style='color:red;'>$error</p>";
}
?>

<form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<br><br>

<button name="login">Login</button>

</form>

</div>

</div>

</body>

</html>
