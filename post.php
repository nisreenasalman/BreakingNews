<?php
require_once 'db.php';
session_start();

// تحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// تحقق من المعرف
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("معرّف الخبر غير صالح.");
}

$post_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT PostTitle, PostDetails, PostImage, created_at 
                        FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("الخبر غير موجود أو ليس لديك صلاحية الوصول إليه.");
}

$post = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($post['PostTitle']) ?></title>
<style>
body {
    font-family:'Cairo',sans-serif;
    background:#f7f7f7;
    direction:rtl;
    padding:2rem;
}
.post-container {
    max-width:800px;
    margin:auto;
    background:white;
    padding:2rem;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}
h1 { color:#2d3748; }
.date { color:#999; font-size:0.9rem; margin-bottom:1rem; }
.content { line-height:1.8; font-size:1rem; }
img { max-width:100%; border-radius:10px; margin-bottom:1rem; }
</style>
</head>
<body>
<div class="post-container">
  <h1><?= htmlspecialchars($post['PostTitle']) ?></h1>
  <div class="date"><?= date("Y-m-d H:i", strtotime($post['created_at'])) ?></div>
  <?php if ($post['PostImage']): ?>
    <img src="uploads/<?= htmlspecialchars($post['PostImage']) ?>" alt="<?= htmlspecialchars($post['PostTitle']) ?>">
  <?php endif; ?>
  <div class="content"><?= nl2br(htmlspecialchars($post['PostDetails'])) ?></div>
</div>
</body>
</html>
