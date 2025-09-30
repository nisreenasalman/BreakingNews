<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إدارة الأخبار</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      margin: 0;
      padding: 2rem;
    }

    .manage-container {
      background: #fff;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.1);
      max-width: 1000px;
      margin: auto;
    }

    h2 {
      font-weight: 700;
      margin-bottom: 2rem;
      text-align: center;
      color: #2d3748;
    }

    .post-card {
      border: 1px solid #e2e8f0;
      border-radius: 15px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      background-color: #fdfdfd;
    }

    .post-title {
      font-weight: 700;
      font-size: 1.2rem;
      color: #2b2b2b;
    }

    .post-meta {
      color: #555;
      font-size: 0.95rem;
    }

    .post-actions .btn {
      margin-right: 0.5rem;
    }

    .post-image {
      max-height: 120px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .no-posts {
      text-align: center;
      padding: 2rem;
      color: #555;
    }
  </style>
</head>
<body>

<div class="manage-container">
  <h2><i class="fas fa-newspaper text-primary me-2"></i>إدارة الأخبار</h2>

  <?php
  $stmt = $conn->prepare("
    SELECT posts.*, tblcategory.CategoryName, tblsubcategory.Subcategory 
    FROM posts 
    JOIN tblcategory ON posts.CategoryId = tblcategory.id 
    JOIN tblsubcategory ON posts.SubCategoryId = tblsubcategory.SubCategoryId 
    WHERE posts.Is_Active = 1 AND posts.user_id = ?
    ORDER BY posts.id DESC
  ");
  $stmt->bind_param('i', $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
  ?>
    <div class="post-card row align-items-center">
      <div class="col-md-9">
        <div class="post-title"><?= htmlspecialchars($row['PostTitle']) ?></div>
        <div class="post-meta mb-2">
          <strong>التصنيف:</strong> <?= htmlspecialchars($row['CategoryName']) ?> / <?= htmlspecialchars($row['Subcategory']) ?>
        </div>
        <div class="post-meta mb-3">
          <?= mb_strimwidth(strip_tags($row['PostDetails']), 0, 100, "...") ?>
        </div>
        <div class="post-actions">
          <a href="post.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> عرض</a>
          <a href="edit-post.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> تعديل</a>
          <a href="soft-delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning" onclick="return confirm('هل تريد تعطيل هذا الخبر؟')">
            <i class="fas fa-trash-alt"></i> تعطيل
          </a>
        </div>
      </div>
      <div class="col-md-3 text-center">
        <?php if (!empty($row['PostImage'])): ?>
          <img src="uploads/<?= htmlspecialchars($row['PostImage']) ?>" class="img-fluid post-image" alt="صورة الخبر">
        <?php else: ?>
          <span class="text-muted">لا توجد صورة</span>
        <?php endif; ?>
      </div>
    </div>
  <?php
    endwhile;
  else:
    echo "<div class='no-posts'><i class='fas fa-info-circle'></i> لا توجد أخبار حالياً.</div>";
  endif;
  ?>
</div>

</body>
</html>
