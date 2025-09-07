<?php
// database connect
$host = "localhost";
$dbusername = "u936190766_findmystufflog";
$dbpassword = "Jeraldpogi07";
$dbname = "u936190766_findmystufflog"; 

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
