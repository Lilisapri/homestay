<?php
session_start(); // Mulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Ulasan</title>
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
            width: 250px;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Ulasan Anda</h2>
        <form method="POST" action="save_review.php">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
            
            <label for="rating">Rating:</label>
            <div>
                        <input type="radio" id="star1" name="rating" value="1" required>
                        <label for="star1" style="display:inline;">⭐</label><br>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2" style="display:inline;">⭐⭐</label><br>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3" style="display:inline;">⭐⭐⭐</label><br>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4" style="display:inline;">⭐⭐⭐⭐</label><br>
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5" style="display:inline;">⭐⭐⭐⭐⭐</label><br>
                    </div>
            </select>
            
            <label for="message">Pesan:</label>
            <textarea id="message" name="message" required></textarea>
            
            <button type="submit" name="save_review">Kirim Ulasan</button>
        </form>
    </div>
</body>
</html>