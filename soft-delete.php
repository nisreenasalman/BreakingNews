<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // تحقق من أن الخبر يخص المستخدم الحالي
    $stmt = $conn->prepare("SELECT id FROM posts WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        // تعطيل الخبر
        $update = $conn->prepare("UPDATE posts SET Is_Active = 0 WHERE id = ?");
        $update->bind_param("i", $id);
        $update->execute();
    }
}

header("Location: manage-posts.php");
exit;
