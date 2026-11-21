<?php
require 'config.php';
$siswa_id = intval($_GET['siswa_id'] ?? 0);
$s = $conn->query("SELECT * FROM siswa WHERE id=$siswa_id")->fetch_assoc();

if (!$s) die('Siswa tidak ditemukan. <a href="index.php">Kembali</a>');
if ($s['sudah_voting']) die('Kamu sudah memilih! <a href="index.php">Kembali</a>');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bilik Suara - <?= htmlspecialchars($s['nama']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
  body { 
    font-family: 'Poppins', sans-serif; 
    background-color: #f4f7f6; 
    padding-bottom: 50px;
    /* Motif pemilu tipis di background */
    background-image: url('data:image/svg+xml;utf8,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><path d="M30 0 L60 30 L30 60 L0 30 Z" fill="%23e2e8f0" fill-opacity="0.3"/></svg>');
  }

  /* HEADER */
  .header-bilik { 
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); 
    color: white; 
    padding: 30px 20px; 
    border-bottom-left-radius: 30px; 
    border-bottom-right-radius: 30px; 
    box-shadow: 0 10px 20px rgba(30, 58, 138, 0.2); 
    text-align: center;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
  }
  /* Aksen Bendera di Header */
  .header-bilik::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; width: 100%; height: 5px;
    background: linear-gradient(to right, #dc2626 50%, #f8fafc 50%);
  }

  /* QUOTE MOTIVASI */
  .quote-box {
    background: white;
    border-left: 5px solid #fbbf24;
    padding: 15px 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    margin: 0 auto 30px auto;
    max-width: 800px;
    font-style: italic;
    color: #475569;
    text-align: center;
    animation: fadeIn 1s ease-in-out;
  }

  /* KARTU CALON */
  .card-calon { 
    border: none; 
    border-radius: 15px; 
    transition: 0.3s; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
    cursor: pointer; 
    background: white;
    position: relative;
    overflow: hidden;
    /* Animasi muncul satu per satu */
    opacity: 0;
    transform: translateY(20px);
    animation: staggerFadeIn 0.6s ease-out forwards;
  }
  .card-calon:hover { transform: translateY(-8px); box-shadow: 0 15px 25px rgba(0,0,0,0.1); }
  .card-calon.selected { border: 3px solid #16a34a; background: #f0fdf4; transform: scale(1.02); }
  
  /* Badge Nomor Urut di pojok */
  .nomor-urut {
    position: absolute;
    top: 10px; left: 10px;
    background: rgba(30, 58, 138, 0.9);
    color: white;
    width: 35px; height: 35px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    font-weight: bold;
    z-index: 10;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  }

  .card-img-top { border-top-left-radius: 15px; border-top-right-radius: 15px; height: 220px; object-fit: cover; }
  .btn-pilih { background: #e2e8f0; color: #475569; border-radius: 10px; font-weight: 600; width: 100%; padding: 10px; border: none; transition: 0.3s;}
  .card-calon.selected .btn-pilih { background: #16a34a; color: white; }
  
  .btn-submit { background: #1e3a8a; color: white; font-size: 18px; font-weight: 700; border-radius: 50px; padding: 15px 40px; border: none; box-shadow: 0 5px 15px rgba(30,58,138,0.3); transition: 0.3s; opacity: 0; animation: fadeIn 1s ease-out forwards; animation-delay: 1.5s;}
  .btn-submit:hover { background: #2563eb; transform: translateY(-2px); }

  @keyframes staggerFadeIn {
    to { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeIn {
    to { opacity: 1; }
  }
</style>
</head>
<body>

<div class="header-bilik">
  <h2 class="fw-bold mb-1">Bilik Suara</h2>
  <p class="mb-0">Pemilih: <b><?= htmlspecialchars($s['nama']) ?></b> (<?= htmlspecialchars($s['kelas']) ?>)</p>
</div>

<div class="container">
  
  <!-- QUOTE MOTIVASI -->
  <div class="quote-box">
    <i class="text-warning fw-bold">"Suaramu adalah senjatamu. Pilihlah dengan hati nurani, karena masa depan sekolah kita ada di tanganmu."</i>
  </div>

  <form action="proses_vote.php" method="POST" onsubmit="return validasiForm()">
    <input type="hidden" name="siswa_id" value="<?= $s['id'] ?>">
    <input type="hidden" name="calon_ketua_id" id="input_ketua" required>
    <input type="hidden" name="calon_wakil_id" id="input_wakil" required>

    <!-- KETUA -->
    <div class="mb-5">
      <h4 class="fw-bold text-primary mb-3 border-bottom pb-2">👤 Calon Ketua OSIS</h4>
      <div class="row g-4">
        <?php
        $ketua = $conn->query("SELECT * FROM calon WHERE jabatan='ketua' ORDER BY id");
        $no_ketua = 1;
        while ($c = $ketua->fetch_assoc()):
        ?>
        <div class="col-md-6 col-lg-4">
          <!-- Kita pakai inline style buat delay animasinya biar munculnya gantian -->
          <div class="card card-calon h-100" id="card-ketua-<?= $c['id'] ?>" onclick="pilih('ketua', <?= $c['id'] ?>, '<?= htmlspecialchars($c['nama']) ?>')" style="animation-delay: <?= $no_ketua * 0.15 ?>s;">
            <div class="nomor-urut"><?= $no_ketua++ ?></div>
            <img src="uploads/<?= htmlspecialchars($c['foto'] ?: 'default.png') ?>" class="card-img-top" alt="foto">
            <div class="card-body text-center d-flex flex-column">
              <h5 class="fw-bold text-dark mb-2"><?= htmlspecialchars($c['nama']) ?></h5>
              <p class="text-muted small flex-grow-1"><?= nl2br(htmlspecialchars($c['visi_misi'])) ?></p>
              <button type="button" class="btn-pilih mt-2" id="btn-ketua-<?= $c['id'] ?>">Pilih Ketua</button>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>

    <!-- WAKIL -->
    <div class="mb-5">
      <h4 class="fw-bold text-primary mb-3 border-bottom pb-2">👤 Calon Wakil Ketua OSIS</h4>
      <div class="row g-4">
        <?php
        $wakil = $conn->query("SELECT * FROM calon WHERE jabatan='wakil' ORDER BY id");
        $no_wakil = 1;
        while ($c = $wakil->fetch_assoc()):
        ?>
        <div class="col-md-6 col-lg-4">
          <div class="card card-calon h-100" id="card-wakil-<?= $c['id'] ?>" onclick="pilih('wakil', <?= $c['id'] ?>, '<?= htmlspecialchars($c['nama']) ?>')" style="animation-delay: <?= $no_wakil * 0.15 ?>s;">
            <div class="nomor-urut"><?= $no_wakil++ ?></div>
            <img src="uploads/<?= htmlspecialchars($c['foto'] ?: 'default.png') ?>" class="card-img-top" alt="foto">
            <div class="card-body text-center d-flex flex-column">
              <h5 class="fw-bold text-dark mb-2"><?= htmlspecialchars($c['nama']) ?></h5>
              <p class="text-muted small flex-grow-1"><?= nl2br(htmlspecialchars($c['visi_misi'])) ?></p>
              <button type="button" class="btn-pilih mt-2" id="btn-wakil-<?= $c['id'] ?>">Pilih Wakil</button>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>

    <div class="text-center mt-5">
      <button type="submit" class="btn-submit">🗳️ KIRIM SUARA SAYA</button>
    </div>
  </form>
</div>

<script>
  let pilihanKetua = null, pilihanWakil = null;
  let namaKetua = "", namaWakil = "";

  function pilih(jabatan, id, nama) {
    if (jabatan === 'ketua') {
      if (pilihanKetua) {
        document.getElementById('card-ketua-' + pilihanKetua).classList.remove('selected');
        document.getElementById('btn-ketua-' + pilihanKetua).innerText = "Pilih Ketua";
      }
      pilihanKetua = id; namaKetua = nama;
      document.getElementById('input_ketua').value = id;
      document.getElementById('card-ketua-' + id).classList.add('selected');
      document.getElementById('btn-ketua-' + id).innerText = "✔️ Terpilih";
    } else {
      if (pilihanWakil) {
        document.getElementById('card-wakil-' + pilihanWakil).classList.remove('selected');
        document.getElementById('btn-wakil-' + pilihanWakil).innerText = "Pilih Wakil";
      }
      pilihanWakil = id; namaWakil = nama;
      document.getElementById('input_wakil').value = id;
      document.getElementById('card-wakil-' + id).classList.add('selected');
      document.getElementById('btn-wakil-' + id).innerText = "✔️ Terpilih";
    }
  }

  function validasiForm() {
    if (!pilihanKetua || !pilihanWakil) {
    alert("Kamu harus memilih 1 Calon Ketua dan 1 Calon Wakil Ketua!");
    return false;
    }
    return confirm("Yakin dengan pilihanmu?\n\nKetua: " + namaKetua + "\nWakil: " + namaWakil + "\n\nSuara tidak bisa diubah.");
  }
</script>
</body>
</html>