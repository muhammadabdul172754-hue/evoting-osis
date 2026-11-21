<?php
require_once __DIR__ . '/../config.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $q = $conn->query("SELECT * FROM admin WHERE username='" . $conn->real_escape_string($u) . "'");
    $a = $q->fetch_assoc();
    if ($a && password_verify($p, $a['password'])) {
        $_SESSION['admin'] = $a['username'];
        header('Location: dashboard.php');
        exit;
    }
    $err = 'Username atau password salah!';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
  body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); min-height: 100vh; display: flex; align-items: center; }
  .card-login { border: none; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
  .form-control { border-radius: 10px; padding: 12px; background: #f8fafc; }
  .btn-primary { background: #1e3a8a; border: none; border-radius: 10px; padding: 12px; font-weight: 600; }
  .btn-primary:hover { background: #2563eb; }
</style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
      <div class="card card-login p-4 p-md-5">
        <div class="text-center mb-4">
          <h3 class="fw-bold text-primary">Admin Login</h3>
          <p class="text-muted small">Sistem E-Voting OSIS</p>
        </div>
        <?php if($err) echo "<div class='alert alert-danger py-2 small'>$err</div>"; ?>
        <form method="POST">
          <div class="mb-3">
            <input name="username" class="form-control" placeholder="Username" required>
          </div>
          <div class="mb-3">
            <input name="password" type="password" class="form-control" placeholder="Password" required>
          </div>
          <button class="btn btn-primary w-100">Login 🔐</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>