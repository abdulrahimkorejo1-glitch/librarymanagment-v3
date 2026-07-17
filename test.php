
<?php
phpinfo();
?>

include "includes/config.php";

echo "Database Connected Successfully!";

?>
<?php
session_start();

$_SESSION['admin'] = "admin";

echo session_id();
echo "<br>";

print_r($_SESSION);
?>
