<?php
require 'auth.php';

// Hapus
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $f = $conn->query("SELECT foto FROM calon WHERE id=$id")->fetch_assoc();
    if ($f && $f['foto'] && file_exists("../uploads/".$f['foto'])) unlink("../uploads/".$f['foto']);
    $conn->query("DELETE FROM calon WHERE id=$id");
    header('Location: calon.php'); exit;
}

// Tambah / Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $jabatan = $conn->real_escape_string($_POST['jabatan']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $visi = $conn->real_escape_string($_POST['visi_misi']);
    $foto = $_POST['foto_lama'] ?? '';

    if (!empty($_FILES['foto']['name'])) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp'];
        if (in_array($ext, $allowed)) {
            $foto = uniqid('calon_') . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/$foto");
        }
    }

    if ($id) {
        $conn->query("UPDATE calon SET jabatan='$jabatan', nama='$nama', visi_misi='$visi', foto='$foto' WHERE id=$id");
    } else {
        $conn->query("INSERT INTO calon (jabatan, nama, visi_misi, foto) VALUES ('$jabatan','$nama','$visi','$foto')");
    }
    header('Location: calon.php'); exit;
}

$edit = null;
if (isset($_GET['edit'])) {
    $edit = $conn->query("SELECT * FROM calon WHERE id=".intval($_GET['edit']))->fetch_assoc();
}
$list = $conn->query("SELECT * FROM calon ORDER BY jabatan, id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Calon</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
  body { font-family: 'Poppins', sans-serif; background: #f4f7f6; }
  .navbar { background: #1e3a8a; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 30px; }
  .navbar-brand, .nav-link { color: white !important; font-weight: 500; }
  .nav-link:hover { color: #93c5fd !important; }
  .card-custom { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
  .card-header { background: #fff; border-bottom: 1px solid #eee; border-radius: 15px 15px 0 0 !important; font-weight: 600; color: #1e3a8a; }
  .form-control, .form-select { border-radius: 10px; padding: 12px; background: #f8fafc; }
  .btn-save { background: #16a34a; color: white; border-radius: 10px; font-weight: 600; padding: 10px 25px; border: none; }
  .btn-save:hover { background: #15803d; color: white; }
  .preview { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">🗳️ Admin OSIS</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="dashboard.php">📊 Hasil</a></li>
      <li class="nav-item"><a class="nav-link active" href="calon.php">👥 Calon</a></li>
      <li class="nav-item"><a class="nav-link" href="siswa.php">🎓 Siswa</a></li>
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
        <div class="card-header"><?= $edit ? '✏️ Edit Calon' : '➕ Tambah Calon' ?></div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
            <input type="hidden" name="foto_lama" value="<?= $edit['foto'] ?? '' ?>">
            
            <div class="mb-3">
              <label class="form-label fw-semibold">Jabatan</label>
              <select name="jabatan" class="form-select" required>
                <option value="ketua" <?= (isset($edit['jabatan']) && $edit['jabatan'] == 'ketua') ? 'selected' : '' ?>>Calon Ketua</option>
                <option value="wakil" <?= (isset($edit['jabatan']) && $edit['jabatan'] == 'wakil') ? 'selected' : '' ?>>Calon Wakil Ketua</option>
              </select>
            </div>
            
            <div class="mb-3">
              <label class="form-label fw-semibold">Nama Calon</label>
              <input name="nama" class="form-control" value="<?= htmlspecialchars($edit['nama'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
              <label class="form-label fw-semibold">Visi & Misi</label>
              <textarea name="visi_misi" class="form-control" rows="3"><?= htmlspecialchars($edit['visi_misi'] ?? '') ?></textarea>
            </div>
            
            <div class="mb-4">
              <label class="form-label fw-semibold">Foto (jpg/png/webp)</label>
              <input type="file" name="foto" class="form-control" accept="image/*">
            </div>
            
            <button class="btn btn-save w-100"><?= $edit ? 'Update Data' : 'Simpan Data' ?></button>
            <?php if ($edit): ?>
              <a href="calon.php" class="btn btn-light w-100 mt-2 border">Batal Edit</a>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>

    <!-- TABEL DATA -->
    <div class="col-lg-8">
      <div class="card card-custom">
        <div class="card-header">📋 Daftar Calon</div>
        <div class="card-body table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Foto</th>
                <th>Nama & Jabatan</th>
                <th>Visi/Misi</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($c = $list->fetch_assoc()): ?>
              <tr>
                <td><img class="preview" src="../uploads/<?= htmlspecialchars($c['foto'] ?: 'default.png') ?>"></td>
                <td>
                  <div class="fw-bold"><?= htmlspecialchars($c['nama']) ?></div>
                  <span class="badge bg-secondary"><?= ucfirst($c['jabatan']) ?></span>
                </td>
                <td><small class="text-muted"><?= htmlspecialchars(substr($c['visi_misi'],0,50)) ?>...</small></td>
                <td class="text-center">
                  <a href="?edit=<?= $c['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                  <a href="?hapus=<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus calon ini?')">🗑️</a>
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