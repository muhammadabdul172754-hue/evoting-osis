<?php
require 'config.php';

$siswa_id = intval($_POST['siswa_id']);
$ketua_id = intval($_POST['calon_ketua_id']);
$wakil_id = intval($_POST['calon_wakil_id']);

// Cek validitas siswa
$cek = $conn->query("SELECT sudah_voting FROM siswa WHERE id=$siswa_id")->fetch_assoc();
if (!$cek || $cek['sudah_voting']) {
    die('Tidak valid / sudah memilih. <a href="index.php">Kembali</a>');
}

// Cek validitas calon
if ($ketua_id === 0 || $wakil_id === 0 || $ketua_id === $wakil_id) {
    die('Pilihan tidak valid. <a href="javascript:history.back()">Kembali</a>');
}

// Simpan suara Ketua
$stmt = $conn->prepare("INSERT INTO votes (siswa_id, calon_id) VALUES (?, ?)");
$stmt->bind_param('ii', $siswa_id, $ketua_id);
$stmt->execute();

// Simpan suara Wakil
$stmt->bind_param('ii', $siswa_id, $wakil_id);
$stmt->execute();

// Update status siswa
$conn->query("UPDATE siswa SET sudah_voting=1 WHERE id=$siswa_id");
header('Location: sukses.php');
?>