<?php
session_start();
include('db.php');

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    die("طلب غير صالح.");
}

$id = (int) $_GET['id'];
$action = $_GET['action'];

if ($action === 'delete') {
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: trash-posts.php");
    exit;
}

if ($action === 'activate') {
    $stmt = $conn->prepare("UPDATE posts SET Is_Active = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: trash-posts.php");
    exit;
}