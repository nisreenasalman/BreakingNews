<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "news_db";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
  die("فشل الاتصال: " . $conn->connect_error);
}
?>
