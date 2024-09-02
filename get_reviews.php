<?php
// Aktifkan pelaporan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mulai sesi
session_start();



// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lodge_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set jumlah ulasan per halaman
$reviews_per_page = 3;

// Ambil semua ulasan dari database
$sql = "SELECT nama, rating, message, created_at FROM review ORDER BY created_at DESC";
$result = $conn->query($sql);

// Periksa jika query berhasil
if ($result === false) {
    die("Error menjalankan query: " . $conn->error);
}

// Hitung total ulasan dan halaman
$total_reviews = $result->num_rows;
$total_pages = ceil($total_reviews / $reviews_per_page);

// Mulai output HTML
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ulasan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
<div class="container">

            <h3 class="text-center">Ulasan Pengguna</h3>
    <div class="row" id="reviewContainer">
        <?php
        if ($total_reviews > 0) {
            $review_count = 0;
            while ($row = $result->fetch_assoc()) {
                $review_count++;
                $page_number = ceil($review_count / $reviews_per_page);
                ?>
                <div class="col-md-4 mb-4 review-item" data-page="<?php echo $page_number; ?>">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['nama']); ?></h5>
                            <div class="review-rating">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $row['rating']) {
                                        echo '<i class="fa fa-star"></i>';
                                    } else {
                                        echo '<i class="fa fa-star-o"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <p class="card-text"><?php echo htmlspecialchars($row['message']); ?></p>
                            <small class="text-muted"><?php echo date('d M Y', strtotime($row['created_at'])); ?></small>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="col-12">Belum ada ulasan.</p>';
        }
        ?>
    </div>
    <div class="row mt-4">
        <div class="col-12 text-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <button class="btn btn-primary mr-2" onclick="changePage(<?php echo $i; ?>)"><?php echo $i; ?></button> <!-- Changed btn-secondary to btn-primary -->
            <?php endfor; ?>
        </div>
    </div>
    </div>
</div>

<script>
let currentPage = 1;
const totalPages = <?php echo $total_pages; ?>;

function showPage(page) {
    document.querySelectorAll('.review-item').forEach(item => {
        if (parseInt(item.dataset.page) === page) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });

    document.getElementById('prevButton').disabled = (page === 1);
    document.getElementById('nextButton').disabled = (page === totalPages);
}

function changePage(page) {
    currentPage = page; // Update to set currentPage directly to the selected page
    if (currentPage < 1) currentPage = 1;
    if (currentPage > totalPages) currentPage = totalPages;
    showPage(currentPage);
}

// Tampilkan halaman pertama saat halaman dimuat
showPage(1);
</script>

<?php
// Tutup koneksi database
if ($conn && $conn->ping()) {
    $conn->close();
}
?>
</body>
</html>