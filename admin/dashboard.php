<?php 
require 'auth.php'; 

if (isset($_GET['hapus_vote'])) {
    $siswa_id = intval($_GET['hapus_vote']);
    $conn->query("DELETE FROM votes WHERE siswa_id=$siswa_id");
    $conn->query("UPDATE siswa SET sudah_voting=0 WHERE id=$siswa_id");
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
  body { font-family: 'Poppins', sans-serif; background: #f4f7f6; }
  .navbar { background: #1e3a8a; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
  .navbar-brand, .nav-link { color: white !important; font-weight: 500; }
  .nav-link:hover { color: #93c5fd !important; }
  .card-custom { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 30px; }
  .card-header { background: #fff; border-bottom: 1px solid #eee; border-radius: 15px 15px 0 0 !important; font-weight: 600; color: #1e3a8a; }
  .bar { background: linear-gradient(90deg, #3b82f6, #1e3a8a); height: 25px; border-radius: 5px; transition: 0.5s; }
  .table th { background: #f8fafc; color: #475569; font-weight: 600; border-bottom: 2px solid #e2e8f0; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg mb-4">
  <div class="container">
    <a class="navbar-brand" href="#">🗳️ Admin OSIS</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="pengumuman.php" style="color:#fbbf24 !important; font-weight:bold;">🔴 Live Pengumuman</a></li>
      <li class="nav-item"><a class="nav-link active" href="dashboard.php">📊 Hasil</a></li>
      <li class="nav-item"><a class="nav-link" href="calon.php">👥 Calon</a></li>
      <li class="nav-item"><a class="nav-link" href="siswa.php">🎓 Siswa</a></li>
      <li class="nav-item"><a class="nav-link" href="export_excel.php">📥 Export</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php" style="color:#fca5a5 !important;">🚪 Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">

  <div class="row">
    <!-- HASIL KETUA -->
    <div class="col-lg-6">
      <div class="card card-custom">
        <div class="card-header">👤 Hasil Calon Ketua</div>
        <div class="card-body">
          <?php
          $total_ketua = $conn->query("SELECT COUNT(*) t FROM votes v JOIN calon c ON v.calon_id=c.id WHERE c.jabatan='ketua'")->fetch_assoc()['t'];
          $q = $conn->query("SELECT c.nama, COUNT(v.id) jml FROM calon c LEFT JOIN votes v ON v.calon_id=c.id WHERE c.jabatan='ketua' GROUP BY c.id ORDER BY jml DESC");
          $no=1;
          while ($r = $q->fetch_assoc()) {
            $persen = $total_ketua ? round($r['jml']/$total_ketua*100) : 0;
            echo "<div class='d-flex justify-content-between mt-3'><span><b>#$no {$r['nama']}</b></span> <span>{$r['jml']} suara ({$persen}%)</span></div>";
            echo "<div class='progress mt-1' style='height: 25px; border-radius: 5px;'><div class='progress-bar bar' style='width:{$persen}%'></div></div>";
            $no++;
          }
          echo "<h6 class='mt-4 text-muted'>Total suara ketua: <b>$total_ketua</b></h6>";
          ?>
        </div>
      </div>
    </div>

    <!-- HASIL WAKIL -->
    <div class="col-lg-6">
      <div class="card card-custom">
        <div class="card-header">👤 Hasil Calon Wakil</div>
        <div class="card-body">
          <?php
          $total_wakil = $conn->query("SELECT COUNT(*) t FROM votes v JOIN calon c ON v.calon_id=c.id WHERE c.jabatan='wakil'")->fetch_assoc()['t'];
          $q = $conn->query("SELECT c.nama, COUNT(v.id) jml FROM calon c LEFT JOIN votes v ON v.calon_id=c.id WHERE c.jabatan='wakil' GROUP BY c.id ORDER BY jml DESC");
          $no=1;
          while ($r = $q->fetch_assoc()) {
            $persen = $total_wakil ? round($r['jml']/$total_wakil*100) : 0;
            echo "<div class='d-flex justify-content-between mt-3'><span><b>#$no {$r['nama']}</b></span> <span>{$r['jml']} suara ({$persen}%)</span></div>";
            echo "<div class='progress mt-1' style='height: 25px; border-radius: 5px;'><div class='progress-bar bar' style='width:{$persen}%'></div></div>";
            $no++;
          }
          echo "<h6 class='mt-4 text-muted'>Total suara wakil: <b>$total_wakil</b></h6>";
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- TABEL PEMILIH -->
  <div class="card card-custom">
    <div class="card-header">📋 Daftar Pemilih</div>
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>No</th><th>Nama</th><th>Kelas</th><th>Status</th><th>Pilihan Ketua</th><th>Pilihan Wakil</th><th>Waktu</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $q = $conn->query("
            SELECT s.id as s_id, s.nama, s.kelas, s.sudah_voting, 
                   GROUP_CONCAT(CASE WHEN c.jabatan='ketua' THEN c.nama END) as pilihan_ketua,
                   GROUP_CONCAT(CASE WHEN c.jabatan='wakil' THEN c.nama END) as pilihan_wakil,
                   MAX(v.waktu) as waktu
            FROM siswa s LEFT JOIN votes v ON v.siswa_id=s.id LEFT JOIN calon c ON c.id=v.calon_id
            GROUP BY s.id ORDER BY waktu DESC, s.nama
          ");
          $i=1;
          while ($r = $q->fetch_assoc()) {
            $status = $r['sudah_voting'] ? '<span class="badge bg-success">Sudah</span>' : '<span class="badge bg-warning text-dark">Belum</span>';
            $pilihan_ketua = $r['pilihan_ketua'] ?? '-';
            $pilihan_wakil = $r['pilihan_wakil'] ?? '-';
            $waktu = $r['waktu'] ?? '-';
            
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td><b>".htmlspecialchars($r['nama'])."</b></td>";
            echo "<td>".htmlspecialchars($r['kelas'])."</td>";
            echo "<td>$status</td>";
            echo "<td>".htmlspecialchars($pilihan_ketua)."</td>";
            echo "<td>".htmlspecialchars($pilihan_wakil)."</td>";
            echo "<td><small class='text-muted'>$waktu</small></td>";
            
            echo "<td>";
            if ($r['sudah_voting'] == 1) {
                echo "<a href='?hapus_vote={$r['s_id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Hapus suara siswa ini?')\">🗑️ Reset</a>";
            } else {
                echo "-";
            }
            echo "</td></tr>";
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
</body>
</html>