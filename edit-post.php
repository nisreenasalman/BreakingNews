<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("معرف غير صالح.");
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("هذا الخبر غير موجود أو لا تملك صلاحية تعديله.");
}

$post = $result->fetch_assoc();
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title   = $_POST['title'];
    $cat     = (int)$_POST['category'];
    $subcat  = (int)$_POST['subcategory'];
    $details = $_POST['details'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "assets/uploads/" . $image);

        $sql = "UPDATE posts SET PostTitle=?, CategoryId=?, SubCategoryId=?, PostDetails=?, PostImage=? WHERE id=? AND user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siissii", $title, $cat, $subcat, $details, $image, $id, $user_id);
    } else {
        $sql = "UPDATE posts SET PostTitle=?, CategoryId=?, SubCategoryId=?, PostDetails=? WHERE id=? AND user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siisii", $title, $cat, $subcat, $details, $id, $user_id);
    }

    $stmt->execute();
    $successMessage = "✅ تم تعديل الخبر بنجاح!";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تعديل الخبر</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      padding: 2rem;
    }
    .form-container {
      background-color: #fff;
      padding: 2.5rem;
      border-radius: 20px;
      max-width: 900px;
      margin: auto;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    h2 {
      font-weight: bold;
      margin-bottom: 1.5rem;
      text-align: center;
      color: #2c3e50;
    }
    .form-label {
      font-weight: 600;
    }
    .btn-group {
      display: flex;
      justify-content: space-between;
      margin-top: 2rem;
    }
    .preview-img {
      max-height: 120px;
      margin-top: 10px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .alert-success {
      text-align: center;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>تعديل الخبر</h2>

  <?php if (!empty($successMessage)): ?>
    <div class="alert alert-success"><?= $successMessage ?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">عنوان الخبر</label>
      <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($post['PostTitle']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">التصنيف الرئيسي</label>
      <select class="form-select" name="category" required>
        <?php
        $cats = $conn->query("SELECT * FROM tblcategory");
        while ($c = $cats->fetch_assoc()) {
          $selected = $c['id'] == $post['CategoryId'] ? 'selected' : '';
          echo "<option value='{$c['id']}' $selected>{$c['CategoryName']}</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">التصنيف الفرعي</label>
      <select class="form-select" name="subcategory" required>
        <?php
        $subs = $conn->query("SELECT * FROM tblsubcategory");
        while ($s = $subs->fetch_assoc()) {
          $selected = $s['SubCategoryId'] == $post['SubCategoryId'] ? 'selected' : '';
          echo "<option value='{$s['SubCategoryId']}' $selected>{$s['Subcategory']}</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">تفاصيل الخبر</label>
      <textarea name="details" rows="5" class="form-control" required><?= htmlspecialchars($post['PostDetails']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">تحديث الصورة (اختياري)</label>
      <input type="file" name="image" class="form-control" accept="image/*">
      <?php if (!empty($post['PostImage'])): ?>
        <img src="assets/uploads/<?= htmlspecialchars($post['PostImage']) ?>" class="preview-img" alt="صورة الخبر">
      <?php endif; ?>
    </div>

    <div class="btn-group">
      <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
      <a href="manage-posts.php" class="btn btn-danger">إلغاء</a>
    </div>
  </form>
</div>

</body>
</html>
