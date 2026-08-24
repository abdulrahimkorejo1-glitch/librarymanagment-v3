$host = "sql106.infinityfree.com";
$user = "if0_42740575";
$pass = "APNA_INFINITYFREE_MYSQL_PASSWORD";
$dbname = "if0_42740575_librarydb";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
