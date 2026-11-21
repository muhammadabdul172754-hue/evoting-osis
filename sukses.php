<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Voting Berhasil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
  body { 
    font-family: 'Poppins', sans-serif; 
    min-height: 100vh; 
    display: flex; 
    align-items: center; 
    justify-content: center;
    margin: 0;
    overflow: hidden;
    background-color: #f0f4f8;
    /* Background Nuansa Pemilu & Sekolah (Sama kayak halaman login) */
    background-image: 
      radial-gradient(circle at 10% 20%, rgba(220, 38, 38, 0.1) 0%, transparent 20%),
      radial-gradient(circle at 90% 80%, rgba(30, 58, 138, 0.1) 0%, transparent 20%),
      url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path d="M50 0 L100 50 L50 100 L0 50 Z" fill="none" stroke="%23cbd5e1" stroke-width="2" opacity="0.4"/></svg>');
    background-size: cover, cover, 100px 100px;
  }
  
  .card-sukses {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 50px 40px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    text-align: center;
    max-width: 480px;
    width: 90%;
    animation: slideUp 0.6s ease-out forwards;
    position: relative;
    overflow: hidden;
  }

  /* Aksen Merah Putih di atas kartu */
  .card-sukses::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 8px;
    background: linear-gradient(to right, #dc2626 50%, #ffffff 50%);
  }

  /* Animasi Ikon Centang */
  .checkmark-circle {
    width: 110px;
    height: 110px;
    background: #d1fae5; /* Hijau muda */
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px auto;
    animation: popIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    animation-delay: 0.3s;
    opacity: 0;
    transform: scale(0);
    box-shadow: 0 0 20px rgba(22, 163, 74, 0.3);
  }
  
  .checkmark {
    font-size: 55px;
    color: #16a34a; /* Hijau tua */
  }

  h2 { color: #1e3a8a; font-weight: 700; margin-bottom: 10px; }
  p { color: #64748b; font-size: 15px; margin-bottom: 30px; }
  
  .btn-kembali {
    background: #1e3a8a;
    color: white;
    border-radius: 50px;
    padding: 12px 30px;
    font-weight: 600;
    border: none;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 4px 10px rgba(30, 58, 138, 0.2);
  }
  .btn-kembali:hover { background: #2563eb; color: white; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(30, 58, 138, 0.3); }

  /* Keyframes Animasi */
  @keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }
  @keyframes popIn {
    to { opacity: 1; transform: scale(1); }
  }

  /* Confetti CSS */
  .confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    background-color: #f2d74e;
    opacity: 0.8;
    animation: fall linear infinite;
  }
  @keyframes fall {
    to { transform: translateY(100vh) rotate(720deg); }
  }
</style>
</head>
<body>

<!-- Confetti Elements -->
<div class="confetti" style="left: 10%; animation-duration: 3s; background: #ef4444; width: 8px; height: 15px;"></div>
<div class="confetti" style="left: 30%; animation-duration: 4s; background: #3b82f6; width: 12px; height: 12px; animation-delay: 1s;"></div>
<div class="confetti" style="left: 50%; animation-duration: 2.5s; background: #16a34a; width: 8px; height: 8px; animation-delay: 0.5s;"></div>
<div class="confetti" style="left: 70%; animation-duration: 5s; background: #f2d74e; width: 15px; height: 10px;"></div>
<div class="confetti" style="left: 90%; animation-duration: 3.5s; background: #a855f7; width: 10px; height: 10px; animation-delay: 1.5s;"></div>
<div class="confetti" style="left: 20%; animation-duration: 4.5s; background: #f97316; width: 8px; height: 12px; animation-delay: 2s;"></div>
<div class="confetti" style="left: 80%; animation-duration: 2s; background: #06b6d4; width: 12px; height: 8px; animation-delay: 0.8s;"></div>

  <div class="card-sukses">
    <div class="checkmark-circle">
      <div class="checkmark">✔️</div>
    </div>
    <h2>Terima Kasih!</h2>
    <p>Suaramu telah berhasil disimpan dan diamankan.<br>Pilihanmu adalah bagian dari masa depan sekolah kita.</p>
    
    <!-- Tombol Kembali -->
    <a href="index.php" class="btn-kembali">Kembali ke Awal</a>
  </div>

</body>
</html>