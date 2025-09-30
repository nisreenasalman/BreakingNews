<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// جلب الأخبار غير الفعالة الخاصة بالمستخدم
$stmt = $conn->prepare("SELECT id, PostTitle, PostImage FROM posts WHERE Is_Active = 0 AND user_id = ? ORDER BY id DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>سلة المحذوفات - الأخبار</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      padding: 2rem;
    }

    .trash-container {
      background: #fff;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.1);
      max-width: 900px;
      margin: auto;
    }

    h2 {
      font-weight: 700;
      margin-bottom: 2rem;
      text-align: center;
      color: #2d3748;
    }

    .trash-card {
      border: 1px solid #e2e8f0;
      border-radius: 15px;
      padding: 1.5rem;
      margin-bottom: 1rem;
      background-color: #fdfdfd;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .trash-title {
      font-weight: 700;
      font-size: 1.1rem;
      color: #2b2b2b;
      margin-bottom: 0.5rem;
    }

    .trash-actions .btn {
      margin-right: 0.5rem;
    }

    .trash-image {
      max-height: 80px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .no-posts {
      text-align: center;
      padding: 2rem;
      color: #555;
    }
  </style>
</head>
<body>

<div class="trash-container">
  <h2><i class="fas fa-trash text-danger me-2"></i>سلة المحذوفات (أخباري المحذوفة)</h2>

  <?php if ($res->num_rows === 0): ?>
    <div class="no-posts"><i class="fas fa-info-circle"></i> لا توجد أخبار في سلة المحذوفات.</div>
  <?php else: ?>
    <?php while ($row = $res->fetch_assoc()): ?>
      <div class="trash-card row align-items-center">
        <div class="col-md-9">
          <div class="trash-title"><?= htmlspecialchars($row['PostTitle'], ENT_QUOTES, 'UTF-8') ?></div>
          <div class="trash-actions mt-2">
            <a class="btn btn-success btn-sm"
               href="delete-post.php?id=<?= (int)$row['id'] ?>&action=activate">
              <i class="fas fa-undo"></i> استرجاع
            </a>
            <a class="btn btn-danger btn-sm"
               href="delete-post.php?id=<?= (int)$row['id'] ?>&action=delete"
               onclick="return confirm('هل أنت متأكد من الحذف النهائي؟ لا يمكن التراجع.');">
              <i class="fas fa-trash-alt"></i> حذف نهائي
            </a>
          </div>
        </div>
        <div class="col-md-3 text-center">
          <?php if (!empty($row['PostImage'])): ?>
            <img src="uploads/<?= htmlspecialchars($row['PostImage']) ?>" class="trash-image" alt="صورة الخبر">
          <?php else: ?>
            <span class="text-muted">لا توجد صورة</span>
          <?php endif; ?>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

</body>
</html>
