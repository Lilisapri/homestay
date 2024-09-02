<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lodge_db"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname); // Perbaiki variabel yang digunakan

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debug: Cek data yang diterima
var_dump($_POST); // Tambahkan ini untuk melihat data yang diterima

// Cek apakah data dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $conn->real_escape_string(trim($_POST['nama'])); // Trim untuk menghapus spasi
    $email = $conn->real_escape_string(trim($_POST['email'])); // Trim untuk menghapus spasi
    $username = $conn->real_escape_string(trim($_POST['username'])); // Trim untuk menghapus spasi
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Validasi input
    if(empty($nama) || empty($email) || empty($username) || empty($_POST['password'])) {
        echo "<script>alert('Semua kolom harus diisi.');</script>";
        exit;
    }

    // Cek apakah username sudah ada
    $checkUsername = $conn->query("SELECT * FROM pengguna WHERE username='$username'");
    if ($checkUsername === FALSE) {
        echo "<script>alert('Error: " . $conn->error . "');</script>"; // Tampilkan pesan kesalahan
        exit;
    }
    if ($checkUsername->num_rows > 0) {
        echo "<script>alert('Username sudah ada.');</script>";
        exit;
    }

    // Query untuk menyimpan data
    $sql = "INSERT INTO pengguna (nama, email, username, password) VALUES ('$nama', '$email', '$username', '$password')";
    
    // Debug: Tampilkan query
    echo $sql; // Tambahkan ini untuk melihat query yang dijalankan

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registrasi berhasil!');</script>";
        // Notifikasi tambahan untuk berhasil
        echo "<script>console.log('Pengguna berhasil terdaftar.');</script>";
        // Redirect ke halaman get_reviews.php
        echo "<script>window.location.href = 'get_reviews.php';</script>"; // Ganti 'success.php' dengan 'get_reviews.php'
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>"; // Tampilkan pesan kesalahan
    }
} else {
    echo "<script>alert('Metode permintaan tidak valid.');</script>";
}

$conn->close();
?>