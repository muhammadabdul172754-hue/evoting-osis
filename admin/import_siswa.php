<?php
require 'auth.php';

$pesan = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_excel'])) {
    $file = $_FILES['file_excel']['tmp_name'];
    $ext = strtolower(pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION));

    if ($ext !== 'csv') {
        $status = 'danger';
        $pesan = 'Format file salah! Harus berupa file .csv (bukan .xlsx). Baca panduan di bawah.';
    } else {
        $handle = fopen($file, "r");
        $berhasil = 0;
        $gagal = 0;

        // Hapus BOM (Byte Order Mark) jika file CSV dari Excel
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle); // Balik ke awal kalau nggak ada BOM
        }

        // Looping baca per baris
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Skip baris pertama (header: Nama, Kelas)
            if (strtolower(trim($data[0])) == 'nama' || strtolower(trim($data[1])) == 'kelas') {
                continue;
            }

            $nama = trim($data[0] ?? '');
            $kelas = trim($data[1] ?? '');

            if ($nama != '' && $kelas != '') {
                $nama_esc = $conn->real_escape_string($nama);
                $kelas_esc = $conn->real_escape_string($kelas);
                
                // Cek apakah nama & kelas sudah ada (biar nggak dobel)
                $cek = $conn->query("SELECT id FROM siswa WHERE nama='$nama_esc' AND kelas='$kelas_esc'");
                if ($cek->num_rows == 0) {
                    $conn->query("INSERT INTO siswa (nama, kelas) VALUES ('$nama_esc', '$kelas_esc')");
                    $berhasil++;
                } else {
                    $gagal++;
                }
            }
        }
        fclose($handle);

        $status = 'success';
        $pesan = "Import selesai! <b>$berhasil data berhasil ditambahkan.</b> ($gagal data dilewati karena sudah ada / kosong).";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Import Siswa Excel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
  body { font-family: 'Poppins', sans-serif; background: #f4f7f6; }
  .navbar { background: #1e3a8a; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 30px; }
  .navbar-brand, .nav-link { color: white !important; font-weight: 500; }
  .nav-link:hover { color: #93c5fd !important; }
  .card-custom { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
  .card-header { background: #fff; border-bottom: 1px solid #eee; border-radius: 15px 15px 0 0 !important; font-weight: 600; color: #1e3a8a; }
  .form-control { border-radius: 10px; padding: 12px; background: #f8fafc; }
  .btn-save { background: #16a34a; color: white; border-radius: 10px; font-weight: 600; padding: 10px 25px; border: none; }
  .btn-save:hover { background: #15803d; color: white; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">🗳️ Admin OSIS</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="dashboard.php">📊 Hasil</a></li>
      <li class="nav-item"><a class="nav-link" href="calon.php">👥 Calon</a></li>
      <li class="nav-item"><a class="nav-link active" href="siswa.php">🎓 Siswa</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php" style="color:#fca5a5 !important;">🚪 Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <?php if($pesan): ?>
        <div class="alert alert-<?= $status ?> alert-dismissible fade show shadow-sm">
          <?= $pesan ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <div class="card card-custom">
        <div class="card-header">📥 Import Data Siswa dari Excel (CSV)</div>
        <div class="card-body p-4">
          
          <div class="alert alert-info border-0 shadow-sm mb-4">
            <h6 class="fw-bold mb-2">📌 Panduan Import:</h6>
            <ol class="mb-0 ps-3">
              <li>Buka <b>Microsoft Excel</b> atau <b>Google Sheets</b>.</li>
              <li>Buat 2 kolom di baris pertama: <code>Nama</code> dan <code>Kelas</code>.</li>
              <li>Isi data di baris bawahnya (contoh: Budi Santoso | X-IPA-1).</li>
              <li>Simpan file dengan format <b>CSV (Comma Delimited) (*.csv)</b>.</li>
              <li>Upload file CSV-nya di form bawah ini.</li>
            </ol>
          </div>

          <form method="POST" enctype="multipart/form-data">
            <div class="mb-4">
              <label class="form-label fw-semibold">Pilih File CSV (.csv)</label>
              <input type="file" name="file_excel" class="form-control" accept=".csv" required>
            </div>
            <button type="submit" class="btn btn-save w-100 py-3">🚀 Mulai Import Data</button>
            <a href="siswa.php" class="btn btn-light w-100 mt-3 border py-2">Kembali ke Daftar Siswa</a>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>