<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->set_charset('utf8mb4');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $catId   = (int)($_POST['category'] ?? 0);
    $subId   = (int)($_POST['subcategory'] ?? 0);
    $details = trim($_POST['details'] ?? '');
    $user_id = $_SESSION['user_id'];

    // التحقق من وجود التصنيفين في قاعدة البيانات
    $catExists = $conn->query("SELECT id FROM tblcategory WHERE id = $catId")->num_rows > 0;
    $subExists = $conn->query("SELECT SubCategoryId FROM tblsubcategory WHERE SubCategoryId = $subId")->num_rows > 0;

    if (!$catExists || !$subExists) {
        die("❌ التصنيف الرئيسي أو الفرعي غير موجود.");
    }

    // رفع الصورة إن وجدت
    $imgName = null;
    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imgName = 'post_' . uniqid() . ($ext ? ".$ext" : '');
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/uploads/$imgName");
    }

    // إدخال البيانات في جدول الأخبار
    $stmt = $conn->prepare("
        INSERT INTO posts (PostTitle, CategoryId, SubCategoryId, PostDetails, Is_Active, PostImage, user_id)
        VALUES (?, ?, ?, ?, 1, ?, ?)
    ");
    $stmt->bind_param('siissi', $title, $catId, $subId, $details, $imgName, $user_id);

    try {
        $stmt->execute();
        header('Location: manage-posts.php?added=1');
        exit;
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            die('❌ العنوان مستخدم من قبل. يرجى تغييره.');
        }
        throw $e;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إضافة خبر</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .add-post-container {
      background: rgba(255,255,255,0.95);
      padding: 2.5rem;
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 800px;
    }

    h2 {
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: #2d3748;
      text-align: center;
    }

    label {
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
      border-radius: 12px;
      padding: 0.75rem 1rem;
    }

    button[type="submit"], .btn-cancel {
      font-weight: 600;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      font-size: 1rem;
    }

    .btn-cancel {
      background-color: #e53e3e;
      color: #fff;
      text-decoration: none;
    }

    .btn-cancel:hover {
      background-color: #c53030;
    }

    .form-footer {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
      justify-content: center;
    }

    small.text-muted {
      font-size: 0.85rem;
    }
  </style>
</head>
<body>

<div class="add-post-container">
  <h2><i class="fas fa-plus-circle text-primary"></i> إضافة خبر جديد</h2>

  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="title">عنوان الخبر</label>
      <input type="text" name="title" id="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="category">التصنيف الرئيسي</label>
      <select class="form-select" name="category" id="category" required>
        <option disabled selected>-- اختر تصنيفاً رئيسياً --</option>
        <?php
        $cats = $conn->query("SELECT * FROM tblcategory");
        while ($row = $cats->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['CategoryName']}</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="subcategory">التصنيف الفرعي</label>
      <select class="form-select" name="subcategory" id="subcategory" required>
        <option disabled selected>-- اختر تصنيفاً فرعياً --</option>
        <?php
        $subs = $conn->query("SELECT * FROM tblsubcategory");
        while($row = $subs->fetch_assoc()) {
            echo "<option value='{$row['SubCategoryId']}'>{$row['Subcategory']}</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="details">تفاصيل الخبر</label>
      <textarea name="details" id="details" rows="5" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
      <label for="image">صورة الخبر (اختياري)</label>
      <input type="file" name="image" id="image" accept="image/*" class="form-control">
    </div>

    <div class="form-footer">
      <button type="submit" class="btn btn-success"><i class="fas fa-check-circle me-1"></i>نشر الخبر</button>
      <a href="dashboard.php" class="btn btn-cancel"><i class="fas fa-times-circle me-1"></i>إلغاء</a>
    </div>
  </form>
</div>

</body>
</html>
