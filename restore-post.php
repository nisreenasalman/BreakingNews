<?php
include('../config.php');
$id = $_GET['id'];
$conn->query("UPDATE posts SET Is_Active=1 WHERE id=$id");
header("Location: trash-posts.php");
