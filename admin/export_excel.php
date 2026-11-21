<?php
require 'auth.php';

// Nama file yang akan di-download
$filename = "Hasil_Voting_OSIS_" . date('Y-m-d_H-i') . ".csv";

// Set header biar browser otomatis nge-download sebagai file Excel/CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Buka output stream
$output = fopen('php://output', 'w');

// Tambahkan BOM (Byte Order Mark) biar Excel bisa baca karakter khusus dengan benar
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Tulis Judul Kolom
fputcsv($output, array('No', 'Nama Siswa', 'Kelas', 'Status Voting', 'Pilihan Calon', 'Waktu Memilih'));

// Ambil data dari database
$q = $conn->query("
 SELECT s.nama, s.kelas, s.sudah_voting, c.nama calon, v.waktu
 FROM siswa s
 LEFT JOIN votes v ON v.siswa_id=s.id
 LEFT JOIN calon c ON c.id=v.calon_id
 ORDER BY v.waktu DESC, s.nama
");

$no = 1;
while ($r = $q->fetch_assoc()) {
    $status = $r['sudah_voting'] ? 'Sudah' : 'Belum';
    $pilihan = $r['calon'] ?? '-';
    $waktu = $r['waktu'] ?? '-';
    
    // Tulis baris data
    fputcsv($output, array($no, $r['nama'], $r['kelas'], $status, $pilihan, $waktu));
    $no++;
}

fclose($output);
exit;
?>