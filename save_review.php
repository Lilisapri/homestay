<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_review'])) {
    $nama = $_POST['nama'];
    $rating = $_POST['rating'];
    $message = $_POST['message'];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "lodge_db");

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Simpan ulasan
    $stmt = $conn->prepare("INSERT INTO review (nama, rating, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nama, $rating, $message);
    $stmt->execute();

    // Tutup koneksi
    $stmt->close();
    $conn->close();

    // Redirect setelah menyimpan
    header("Location: index.php");
    exit();
}
?>