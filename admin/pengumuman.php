<?php require 'auth.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Mulai Pengumuman</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
  body { font-family: 'Poppins', sans-serif; background: #1e3a8a; color: white; height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; }
  .btn-reveal { background: #ef4444; color: white; font-size: 24px; font-weight: 700; padding: 20px 50px; border-radius: 50px; border: none; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.5); animation: pulse 2s infinite; }
  .btn-reveal:hover { background: #dc2626; transform: scale(1.05); color: white; }
  @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }
</style>
</head>
<body>
  <div>
    <h1 class="mb-4 fw-bold">Siapakah Pemenangnya? 🤔</h1>
    <p class="lead mb-5">Pastikan proyektor/Layar sudah terlihat oleh seluruh siswa.</p>
    <a href="live_reveal.php" class="btn btn-reveal">🔴 MULAI PENGUMUMAN!</a>
  </div>
</body>
</html>