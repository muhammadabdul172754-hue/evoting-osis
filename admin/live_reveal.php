<?php
require 'auth.php';

// Ambil pemenang Ketua (Urut suara terbanyak)
$ketua = $conn->query("
  SELECT c.nama, c.foto, c.visi_misi, COUNT(v.id) as suara
  FROM calon c LEFT JOIN votes v ON v.calon_id = c.id
  WHERE c.jabatan = 'ketua'
  GROUP BY c.id ORDER BY suara DESC LIMIT 1
")->fetch_assoc();

// Ambil pemenang Wakil (Urut suara terbanyak)
$wakil = $conn->query("
  SELECT c.nama, c.foto, c.visi_misi, COUNT(v.id) as suara
  FROM calon c LEFT JOIN votes v ON v.calon_id = c.id
  WHERE c.jabatan = 'wakil'
  GROUP BY c.id ORDER BY suara DESC LIMIT 1
")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>The Big Reveal!</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700;900&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<style>
  body { font-family: 'Poppins', sans-serif; background: #0f172a; color: white; min-height: 100vh; margin: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 20px 0;}
  
  /* LAYAR LOADING KETEGANGAN */
  #loading-screen { text-align: center; }
  .spinner { width: 100px; height: 100px; border: 10px solid rgba(255,255,255,0.1); border-top: 10px solid #3b82f6; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 20px auto; }
  @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
  .teks-tegang { font-size: 2rem; font-weight: 700; animation: blink 1s infinite alternate; }
  @keyframes blink { from { opacity: 0.5; } to { opacity: 1; } }

  /* LAYAR PEMENANG */
  #winner-screen { display: none; text-align: center; animation: zoomIn 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; width: 100%; max-width: 1000px; }
  @keyframes zoomIn { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
  
  .winner-card { 
    background: rgba(255, 255, 255, 0.05); 
    border: 2px solid rgba(255,255,255,0.1); 
    border-radius: 20px; 
    padding: 20px; 
    backdrop-filter: blur(10px); 
    box-shadow: 0 0 50px rgba(59, 130, 246, 0.3); 
    height: 100%;
    transition: 0.3s;
  }
  .winner-card:hover { box-shadow: 0 0 60px rgba(251, 191, 36, 0.5); border-color: #fbbf24; }
  
  /* FOTO KOTAK MELENGKUNG (KAYAK DI VOTING) */
  .winner-img { 
    width: 100%; 
    height: 250px; 
    object-fit: cover; 
    border-radius: 15px; 
    border: 4px solid #fbbf24; 
    box-shadow: 0 0 20px rgba(251, 191, 36, 0.4); 
    margin-bottom: 20px; 
  }
  
  .winner-title { color: #fbbf24; font-size: 1.1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; }
  .winner-name { font-size: 2.2rem; font-weight: 900; margin-top: 5px; background: -webkit-linear-gradient(#fff, #93c5fd); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1.2;}
  .winner-votes { font-size: 1.2rem; color: #4ade80; margin-top: 10px; font-weight: 700;}
  
  /* VISI MISI */
  .winner-vm { font-size: 0.9rem; color: #cbd5e1; margin-top: 15px; font-style: italic; background: rgba(0,0,0,0.3); padding: 15px; border-radius: 10px; min-height: 100px;}
</style>
</head>
<body>

<!-- LAYAR 1: LOADING KETEGANGAN -->
<div id="loading-screen">
  <div class="spinner"></div>
  <div class="teks-tegang" id="teks-tegang">Menghitung suara...</div>
</div>

<!-- LAYAR 2: PEMENANG -->
<div id="winner-screen">
  <h1 class="mb-5" style="font-weight:900; font-size:3rem; text-shadow: 0 0 20px rgba(255,255,255,0.5);">🎉 SELAMAT KEPADA 🎉</h1>
  
  <div class="row justify-content-center px-3">
    <!-- KETUA -->
    <div class="col-md-5 mb-4">
      <div class="winner-card">
        <div class="winner-title">Ketua OSIS Terpilih</div>
        <img src="../uploads/<?= htmlspecialchars($ketua['foto'] ?: 'default.png') ?>" class="winner-img" alt="Ketua">
        <div class="winner-name"><?= htmlspecialchars($ketua['nama']) ?></div>
        <div class="winner-votes">🏆 <?= $ketua['suara'] ?> Suara</div>
        <div class="winner-vm">"<?= nl2br(htmlspecialchars($ketua['visi_misi'])) ?>"</div>
      </div>
    </div>

    <!-- WAKIL -->
    <div class="col-md-5 mb-4">
      <div class="winner-card">
        <div class="winner-title">Wakil Ketua Terpilih</div>
        <img src="../uploads/<?= htmlspecialchars($wakil['foto'] ?: 'default.png') ?>" class="winner-img" alt="Wakil">
        <div class="winner-name"><?= htmlspecialchars($wakil['nama']) ?></div>
        <div class="winner-votes">🏆 <?= $wakil['suara'] ?> Suara</div>
        <div class="winner-vm">"<?= nl2br(htmlspecialchars($wakil['visi_misi'])) ?>"</div>
      </div>
    </div>
  </div>

  <div class="mt-4">
    <a href="dashboard.php" class="btn btn-outline-light btn-lg px-5" style="border-radius: 50px;">Kembali ke Dashboard</a>
  </div>
</div>

<!-- SCRIPT ANIMASI -->
<script>
  const teks = [
    "Menghitung suara...",
    "Memverifikasi data...",
    "Memeriksa keaslian surat suara...",
    "Menyiapkan pemenang...",
    "Siapakah yang akan terpilih? 🤔"
  ];

  let i = 0;
  const teksElement = document.getElementById('teks-tegang');

  const intervalTeks = setInterval(() => {
    teksElement.innerText = teks[i];
    i++;
    if (i >= teks.length) i = teks.length - 1;
  }, 1000);

  setTimeout(() => {
    clearInterval(intervalTeks);
    document.getElementById('loading-screen').style.display = 'none';
    
    const winnerScreen = document.getElementById('winner-screen');
    winnerScreen.style.display = 'block';

    // LEDAKAN CONFETTI! 🎉
    var duration = 5 * 1000;
    var animationEnd = Date.now() + duration;
    var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

    function randomInRange(min, max) {
      return Math.random() * (max - min) + min;
    }

    var interval = setInterval(function() {
      var timeLeft = animationEnd - Date.now();

      if (timeLeft <= 0) {
        return clearInterval(interval);
      }

      var particleCount = 50 * (timeLeft / duration);
      confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
      confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
    }, 250);

  }, 5000); // Waktu loading (5 detik)
</script>

</body>
</html>