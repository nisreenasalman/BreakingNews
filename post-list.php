<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, PostTitle, PostImage FROM posts WHERE user_id = ? AND Is_Active = 1 ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>أخباري</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      padding: 2rem;
      min-height: 100vh;
    }
    .container {
      background: white;
      border-radius: 20px;
      padding: 2rem;
      max-width: 900px;
      margin: auto;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .post-item {
      padding: 1rem;
      border-bottom: 1px solid #ddd;
    }
    .post-item:last-child {
      border-bottom: none;
    }
    .post-item h5 {
      margin-bottom: 0.5rem;
    }
    .post-item img {
      max-height: 100px;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 class="mb-4 text-center text-primary">أخباري الخاصة</h2>

  <?php if ($res->num_rows === 0): ?>
    <div class="alert alert-info text-center">لا توجد أخبار حالياً.</div>
  <?php else: ?>
    <?php while($row = $res->fetch_assoc()): ?>
      <div class="post-item d-flex justify-content-between align-items-center">
        <div>
          <h5><a href="post.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['PostTitle']) ?></a></h5>
        </div>
        <div>
          <?php if (!empty($row['PostImage'])): ?>
            <img src="uploads/<?= htmlspecialchars($row['PostImage']) ?>" alt="صورة الخبر">
          <?php endif; ?>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

</body>
</html>
