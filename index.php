<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>E-Voting OSIS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
  body { 
    font-family: 'Poppins', sans-serif; 
    min-height: 100vh; 
    display: flex; 
    align-items: center; 
    overflow: hidden;
    background-color: #f0f4f8;
    /* Background Nuansa Pemilu & Sekolah */
    background-image: 
      radial-gradient(circle at 10% 20%, rgba(220, 38, 38, 0.1) 0%, transparent 20%),
      radial-gradient(circle at 90% 80%, rgba(30, 58, 138, 0.1) 0%, transparent 20%),
      url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path d="M50 0 L100 50 L50 100 L0 50 Z" fill="none" stroke="%23cbd5e1" stroke-width="2" opacity="0.4"/></svg>');
    background-size: cover, cover, 100px 100px;
  }

  .card-login { 
    border: none; 
    border-radius: 20px; 
    box-shadow: 0 15px 35px rgba(0,0,0,0.15); 
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    opacity: 0;
    transform: translateY(30px);
    animation: slideUpFade 0.8s ease-out forwards;
    position: relative;
    overflow: hidden;
  }

  /* Aksen Merah Putih di atas kartu */
  .card-login::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 8px;
    background: linear-gradient(to right, #dc2626 50%, #ffffff 50%);
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
  }

  .vote-icon {
    animation: float 3s ease-in-out infinite;
    display: inline-block;
  }

  .form-group-anim {
    opacity: 0;
    animation: fadeIn 0.8s ease-out forwards;
    animation-delay: 0.5s;
  }

  .btn-primary { background: #1e3a8a; border: none; border-radius: 10px; padding: 12px; font-weight: 600; transition: 0.3s; }
  .btn-primary:hover { background: #2563eb; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3); }
  .form-control, .form-select { border-radius: 10px; padding: 12px; border: 1px solid #cbd5e1; background: #f8fafc; }
  .form-control:focus, .form-select:focus { box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.25); border-color: #1e3a8a; }

  @keyframes slideUpFade { to { opacity: 1; transform: translateY(0); } }
  @keyframes fadeIn { to { opacity: 1; } }
  @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }
</style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card card-login p-4 p-md-5">
        <div class="text-center mb-4">
          <img src="https://cdn-icons-png.flaticon.com/512/3439/3439717.png" alt="Vote Icon" width="80" class="mb-3 vote-icon">
          <h3 class="fw-bold text-primary" style="letter-spacing: 1px;">E-VOTING OSIS</h3>
          <p class="text-muted small">Pemilihan Ketua & Wakil Ketua OSIS</p>
        </div>
        
        <form action="voting.php" method="GET" class="form-group-anim">
          <div class="mb-4">
            <label class="form-label fw-semibold">Pilih Nama Kamu</label>
            <select name="siswa_id" class="form-select" required>
              <option value="">-- Cari Nama --</option>
              <?php
              $q = $conn->query("SELECT * FROM siswa WHERE sudah_voting = 0 ORDER BY kelas, nama");
              while ($s = $q->fetch_assoc()) {
                  echo "<option value='{$s['id']}'>{$s['nama']} — {$s['kelas']}</option>";
              }
              ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100 mb-3">Masuk ke Bilik Suara 🗳️</button>
          <div class="text-center">
            <small class="text-muted">Jika namamu tidak muncul, hubungi panitia.</small>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>