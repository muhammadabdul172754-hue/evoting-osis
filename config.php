<?php
$host = 'localhost';
$user = 'root';
$pass = '';           // sesuaikan XAMPP kamu
$db   = 'voting-osis';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
session_start();
?>