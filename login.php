<?php 
session_start(); 
require_once 'db.php';  

$errors = [];  

if ($_SERVER["REQUEST_METHOD"] === "POST") {     
    $email = trim($_POST["email"]);     
    $password = $_POST["password"];      
    
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");     
    $stmt->bind_param("s", $email);     
    $stmt->execute();     
    $stmt->store_result();      
    
    if ($stmt->num_rows === 1) {         
        $stmt->bind_result($id, $name, $hashed_password);         
        $stmt->fetch();         
        if (password_verify($password, $hashed_password)) {             
            $_SESSION["user_id"] = $id;             
            $_SESSION["user_name"] = $name;             
            $_SESSION["login"] = true;             
            header("Location: dashboard.php");             
            exit;         
        } else {             
            $errors[] = "كلمة المرور غير صحيحة.";         
        }     
    } else {         
        $errors[] = "لا يوجد حساب بهذا البريد.";     
    } 
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تسجيل الدخول</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Tajawal', sans-serif;
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7e22ce 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(139, 92, 246, 0.3), transparent);
      border-radius: 50%;
      top: -200px;
      right: -200px;
      animation: pulse 8s ease-in-out infinite;
    }

    body::after {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(59, 130, 246, 0.3), transparent);
      border-radius: 50%;
      bottom: -150px;
      left: -150px;
      animation: pulse 8s ease-in-out infinite 2s;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.1); opacity: 0.8; }
    }

    .login-wrapper {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
      max-width: 500px;
      width: 100%;
      position: relative;
      z-index: 1;
      overflow: hidden;
    }

    .login-wrapper::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
    }

    .login-header {
      text-align: center;
      padding: 3rem 2rem 1.5rem;
      background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(139, 92, 246, 0.05));
    }

    .logo-badge {
      width: 85px;
      height: 85px;
      background: linear-gradient(135deg, #3b82f6, #8b5cf6);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
      position: relative;
    }

    .logo-badge::after {
      content: '';
      position: absolute;
      inset: -3px;
      background: linear-gradient(135deg, #3b82f6, #8b5cf6);
      border-radius: 20px;
      z-index: -1;
      opacity: 0.3;
      filter: blur(10px);
    }

    .logo-badge i {
      color: #fff;
      font-size: 2.2rem;
    }

    .login-header h1 {
      font-size: 1.9rem;
      font-weight: 900;
      color: #1e293b;
      margin-bottom: 0.5rem;
    }

    .login-header p {
      color: #64748b;
      font-size: 1rem;
      font-weight: 400;
    }

    .login-form {
      padding: 2rem;
    }

    .error-alert {
      background: linear-gradient(135deg, #fee2e2, #fecaca);
      border: 2px solid #fca5a5;
      border-radius: 16px;
      padding: 1rem;
      margin-bottom: 1.5rem;
    }

    .error-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      color: #991b1b;
      font-size: 0.95rem;
      font-weight: 500;
      padding: 0.5rem 0;
    }

    .error-item i {
      color: #dc2626;
      font-size: 1.1rem;
    }

    .error-item:not(:last-child) {
      border-bottom: 1px solid rgba(220, 38, 38, 0.15);
    }

    .input-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .input-label {
      display: block;
      color: #334155;
      font-size: 0.95rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      padding-right: 0.25rem;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      pointer-events: none;
    }

    .form-input {
      width: 100%;
      padding: 1rem 3rem 1rem 1.25rem;
      border: 2px solid #e2e8f0;
      border-radius: 14px;
      font-size: 1rem;
      font-family: 'Tajawal', sans-serif;
      background: #ffffff;
      color: #1e293b;
      outline: none;
      transition: all 0.3s ease;
    }

    .form-input:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .form-input:focus ~ .input-icon {
      color: #3b82f6;
    }

    .form-input::placeholder {
      color: #cbd5e1;
    }

    .submit-btn {
      width: 100%;
      padding: 1.1rem;
      background: linear-gradient(135deg, #3b82f6, #8b5cf6);
      color: white;
      border: none;
      border-radius: 14px;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family: 'Tajawal', sans-serif;
      box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
      margin-top: 2rem;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
      background: linear-gradient(135deg, #2563eb, #7c3aed);
    }

    .submit-btn:active {
      transform: translateY(0);
    }

    .forgot-password {
      text-align: left;
      margin-top: 0.75rem;
    }

    .forgot-password a {
      color: #3b82f6;
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .forgot-password a:hover {
      color: #2563eb;
      text-decoration: underline;
    }

    .divider {
      text-align: center;
      margin: 2rem 0;
      position: relative;
    }

    .divider::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }

    .divider span {
      background: white;
      padding: 0 1rem;
      color: #94a3b8;
      font-size: 0.9rem;
      position: relative;
      z-index: 1;
    }

    .register-link {
      text-align: center;
      padding: 0 2rem 2rem;
    }

    .register-link p {
      color: #64748b;
      font-size: 1rem;
      margin-bottom: 0.75rem;
    }

    .register-link a {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      color: #3b82f6;
      text-decoration: none;
      font-weight: 700;
      font-size: 1.05rem;
      transition: all 0.3s ease;
      padding: 0.5rem 1rem;
      border-radius: 8px;
    }

    .register-link a:hover {
      background: rgba(59, 130, 246, 0.1);
      gap: 0.75rem;
    }

    @media (max-width: 580px) {
      .login-wrapper {
        margin: 10px;
        border-radius: 20px;
      }

      .login-header {
        padding: 2rem 1.5rem 1rem;
      }

      .login-header h1 {
        font-size: 1.6rem;
      }

      .login-form {
        padding: 1.5rem;
      }

      .logo-badge {
        width: 75px;
        height: 75px;
      }

      .logo-badge i {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="login-header">
      <div class="logo-badge">
        <i class="fas fa-user-shield"></i>
      </div>
      <h1>مرحباً بعودتك</h1>
      <p>سجل دخولك للوصول إلى حسابك</p>
    </div>

    <div class="login-form">
      <?php if (!empty($errors)): ?>
        <div class="error-alert">
          <?php foreach ($errors as $error): ?>
            <div class="error-item">
              <i class="fas fa-exclamation-circle"></i>
              <span><?= htmlspecialchars($error) ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="input-group">
          <label class="input-label">البريد الإلكتروني</label>
          <div class="input-wrapper">
            <input type="email" name="email" class="form-input" placeholder="example@domain.com" required autocomplete="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            <i class="fas fa-envelope input-icon"></i>
          </div>
        </div>

        <div class="input-group">
          <label class="input-label">كلمة المرور</label>
          <div class="input-wrapper">
            <input type="password" name="password" class="form-input" placeholder="أدخل كلمة المرور" required autocomplete="current-password">
            <i class="fas fa-lock input-icon"></i>
          </div>
          <div class="forgot-password">
            <a href="forgot-password.php">
              <i class="fas fa-question-circle"></i>
              نسيت كلمة المرور؟
            </a>
          </div>
        </div>

        <button type="submit" class="submit-btn">
          <i class="fas fa-sign-in-alt"></i>
          <span>تسجيل الدخول</span>
        </button>
      </form>
    </div>

    <div class="divider">
      <span>أو</span>
    </div>

    <div class="register-link">
      <p>لا تملك حساباً؟</p>
      <a href="register.php">
        <span>إنشاء حساب جديد</span>
        <i class="fas fa-arrow-left"></i>
      </a>
    </div>
  </div>
</body>
</html>