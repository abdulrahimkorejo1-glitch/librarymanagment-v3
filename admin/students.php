<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../includes/config.php");

$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
    <a class="btn add" href="add_student.php">➕ Add Student</a>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<h2>👨‍🎓 Student Management</h2>
<?php
if(isset($_GET['deleted'])){
    echo "<p style='color:green; font-weight:bold;'>✅ Student Deleted Successfully!</p>";
}
?>

<a class="btn add" href="dashboard.php">🏠 Dashboard</a>
<a class="btn add" href="add_student.php">➕ Add Student</a>

<br><br>
<th>Action</th>
<table>

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Roll No</th>
    <th>Class</th>
    <th>Phone</th>
    <th>Email</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['full_name']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['issue_date']; ?></td>
    <td><?php echo $row['return_date']; ?></td>
    <td><?php echo $row['status']; ?></td>

    <td>
        <?php if($row['status']=="Issued"){ ?>
            <a class="btn edit"
               href="return_book.php?id=<?php echo $row['id']; ?>">
               Return
            </a>
        <?php }else{ ?>
            Returned
        <?php } ?>
    </td>

</tr>

<?php } ?>
</table>

</body>
</html>