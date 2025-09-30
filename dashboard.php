<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>لوحة التحكم | نظام إدارة الأخبار</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      margin: 0;
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }

    .dashboard-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(15px);
      padding: 3rem;
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.2);
      max-width: 800px;
      width: 100%;
      text-align: center;
    }

    h2 {
      color: #2d3748;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .welcome {
      color: #4a5568;
      margin-bottom: 2rem;
    }

    .action-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 1.2rem;
      margin-bottom: 2rem;
    }

    .card-link {
      display: block;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      padding: 1.5rem;
      border-radius: 15px;
      text-decoration: none;
      font-weight: 600;
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      transition: all 0.3s ease;
    }

    .card-link:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
    }

    .card-link i {
      font-size: 1.5rem;
      display: block;
      margin-bottom: 0.5rem;
    }

    .logout-btn {
      background: #e53e3e;
      color: white;
      border: none;
      padding: 0.8rem 1.5rem;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 10px;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .logout-btn:hover {
      background: #c53030;
    }

    footer {
      margin-top: 3rem;
      text-align: center;
      font-size: 0.875rem;
      color: #777;
    }
  </style>
</head>
<body>

<div class="dashboard-container">
  <h2>لوحة التحكم</h2>
  <p class="welcome">
    مرحبًا <strong><?= htmlspecialchars($_SESSION["user_name"]); ?></strong> 👋 في نظام إدارة الأخبار.
  </p>

  <div class="action-cards">
    <a href="add-post.php" class="card-link"><i class="fas fa-plus-circle"></i>إضافة خبر</a>
    <a href="manage-posts.php" class="card-link"><i class="fas fa-edit"></i>إدارة الأخبار</a>
    <a href="trash-posts.php" class="card-link"><i class="fas fa-trash"></i>الأخبار المحذوفة</a>
    <a href="post-list.php" class="card-link"><i class="fas fa-eye"></i>عرض أخباري</a>
  </div>

  <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>

  <footer>
    &copy; <?= date('Y') ?> - جميع الحقوق محفوظة لنظام الأخبار.
  </footer>
</div>

</body>
</html>
