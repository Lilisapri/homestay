<!-- Form login HTML -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            margin-top: 10px;
            display: block;
            color: #555;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        textarea,
        select {
            width: 90%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        #registerPrompt {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form id="loginForm" method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <p id="registerPrompt">Anda belum memiliki akun? <a href="#" id="showRegister">Daftar</a></p>

        <div id="registerForm" style="display:none;">
            <h2>Pendaftaran</h2>
            <form method="POST" action="">
                <label for="register_username">Username:</label>
                <input type="text" id="register_username" name="register_username" required>
                <label for="register_email">Email:</label>
                <input type="email" id="register_email" name="register_email" required>
                <label for="register_contact">No HP:</label>
                <input type="text" id="register_contact" name="register_contact" required>
                <label for="register_password">Password:</label>
                <input type="password" id="register_password" name="register_password" required>
                <button type="submit" name="register">Daftar</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('showRegister').onclick = function() {
            document.getElementById('loginForm').style.display = 'none'; // Sembunyikan form login
            document.getElementById('registerForm').style.display = 'block'; // Tampilkan form pendaftaran
            document.getElementById('registerPrompt').style.display = 'none'; // Sembunyikan prompt pendaftaran
        };
    </script>

<?php
    session_start(); // Mulai sesi

    // Koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'lodge_db'); // Ganti dengan detail koneksi yang benar
    
    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    
    // Penanganan pendaftaran
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        // Ambil data dari formulir
        $username = $_POST['register_username'];
        $email = $_POST['register_email'];
        $contact = $_POST['register_contact'];
        $password = password_hash($_POST['register_password'], PASSWORD_DEFAULT); // Hash password
    
        // Query untuk menyimpan data
        $sql = "INSERT INTO users (username, email, contact, password) VALUES (?, ?, ?, ?)"; // Gunakan prepared statements untuk keamanan
        $stmt = $conn->prepare($sql); // Siapkan pernyataan
        $stmt->bind_param("ssss", $username, $email, $contact, $password); // Ikat parameter
    
        if ($stmt->execute()) { // Eksekusi pernyataan
            echo "<script>alert('Pendaftaran berhasil!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>"; // Gunakan $stmt->error untuk kesalahan
        }
        $stmt->close(); // Tutup pernyataan
    }

    // Penanganan login
    // Penanganan login
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        // Ambil data dari formulir
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Cek kredensial pengguna
        $sql = "SELECT password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username; // Simpan username di session
                header("Location: review_form.php"); // Arahkan ke halaman form ulasan
                exit();
            } else {
                echo "<script>alert('Password salah!');</script>";
            }
        } else {
            echo "<script>alert('Username tidak ditemukan!');</script>";
        }
        $stmt->close();
    }

    // Form ulasan setelah login
    if (isset($_SESSION['username'])) { // Pastikan session username ada
?>
        <div class="review-container" style="display:none;"> <!-- Sembunyikan form ulasan -->
            <h2>Ulasan Anda</h2>
            <form method="POST" action="save_review.php">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="rating">Rating:</label>
                <select id="rating" name="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                
                <label for="message">Pesan:</label>
                <textarea id="message" name="message" required></textarea>
                
                <button type="submit" name="save_review">Kirim Ulasan</button>
            </form>
        </div>
<?php
    }

    $conn->close(); // Tutup koneksi
?>
</body>
</html>