<?php
include "includes/config.php";

if(isset($_POST['register'])){

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Password Hash
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admins(full_name, username, email, password)
            VALUES('$fullname','$username','$email','$password')";

    if($conn->query($sql)){
        echo "<script>alert('Admin Registered Successfully');</script>";
    }else{
        echo "Error: ".$conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
</head>
<body>

<h2>Admin Registration</h2>

<form method="POST">

<input type="text" name="fullname" placeholder="Full Name" required><br><br>

<input type="text" name="username" placeholder="Username" required><br><br>

<input type="email" name="email" placeholder="Email" required><br><br>

<input type="password" name="password" placeholder="Password" required><br><br>

<button name="register">Register</button>

</form>

</body>
</html>