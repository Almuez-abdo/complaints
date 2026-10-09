<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "complaints";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
