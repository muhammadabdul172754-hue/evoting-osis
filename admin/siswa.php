<?php
require 'auth.php';

// Hapus
if (isset($_GET['hapus'])) {
    $conn->query("DELETE FROM siswa WHERE id=".intval($_GET['hapus']));
    header('Location: siswa.php'); exit;
}

// Tambah / Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $nama = $conn->real_escape_string($_POST['nama']);
    $kelas = $conn->real_escape_string($_POST['kelas']);
    if ($id) {
        $conn->query("UPDATE siswa SET nama='$nama', kelas='$kelas' WHERE id=$id");
    } else {
        $conn->query("INSERT INTO siswa (nama, kelas) VALUES ('$nama','$kelas')");
    }
    header('Location: siswa.php'); exit;
}

$edit = null;
if (isset($_GET['edit'])) {
    $edit = $conn->query("SELECT * FROM siswa WHERE id=".intval($_GET['edit']))->fetch_assoc();
}
$list = $conn->query("SELECT * FROM siswa ORDER BY kelas, nama");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Siswa</title>
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
      <li class="nav-item"><a class="nav-link" href="export_excel.php">📥 Export</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php" style="color:#fca5a5 !important;">🚪 Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <div class="row">
    <!-- FORM INPUT -->
    <div class="col-lg-4 mb-4">
      <div class="card card-custom">
        <div class="card-header"><?= $edit ? '✏️ Edit Siswa' : '➕ Tambah Siswa' ?></div>
        <div class="card-body">
          <form method="POST">
            <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
            
            <div class="mb-3">
              <label class="form-label fw-semibold">Nama Siswa</label>
              <input name="nama" class="form-control" placeholder="Contoh: Budi Santoso" value="<?= htmlspecialchars($edit['nama'] ?? '') ?>" required>
            </div>
            
            <div class="mb-4">
              <label class="form-label fw-semibold">Kelas</label>
              <input name="kelas" class="form-control" placeholder="Contoh: XI-IPA-1" value="<?= htmlspecialchars($edit['kelas'] ?? '') ?>" required>
            </div>
            
            <button class="btn btn-save w-100"><?= $edit ? 'Update Data' : 'Simpan Data' ?></button>
            <?php if ($edit): ?>
              <a href="siswa.php" class="btn btn-light w-100 mt-2 border">Batal Edit</a>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>

    <!-- TABEL DATA -->
    <div class="col-lg-8">
      <div class="card card-custom">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>📋 Daftar Siswa</span>
            <a href="import_siswa.php" class="btn btn-primary btn-sm" style="border-radius: 8px;">📥 Import Excel</a>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status Voting</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($s = $list->fetch_assoc()): ?>
              <tr>
                <td class="fw-bold"><?= htmlspecialchars($s['nama']) ?></td>
                <td><?= htmlspecialchars($s['kelas']) ?></td>
                <td><?= $s['sudah_voting'] ? '<span class="badge bg-success">✅ Sudah</span>' : '<span class="badge bg-warning text-dark">⏳ Belum</span>' ?></td>
                <td class="text-center">
                  <a href="?edit=<?= $s['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                  <a href="?hapus=<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus siswa ini? Suara juga terhapus.')">🗑️</a>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>