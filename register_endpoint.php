<?php
// Konfigurasi database
$host = 'localhost'; // Ganti dengan host database Anda
$dbname = 'lodge_db'; // Ganti dengan nama database Anda
$username = 'username'; // Ganti dengan username database Anda
$password = 'password'; // Ganti dengan password database Anda

// Buat koneksi ke database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Ambil data dari request
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input
if (empty($name) || empty($email) || empty($password)) {
    echo json_encode(['status' => 'failed', 'message' => 'Semua field harus diisi.']);
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Siapkan dan eksekusi query untuk menyimpan data
try {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    
    // Tambahkan log untuk memeriksa apakah query berhasil
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Pendaftaran berhasil.']);
    } else {
        echo json_encode(['status' => 'failed', 'message' => 'Gagal menyimpan data.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'failed', 'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
}
?>