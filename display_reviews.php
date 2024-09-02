
Apa kata mereka tentang kami?<?php
// Pastikan variabel $result tersedia
if (!isset($result) || !is_array($result)) {
    die("Error: Data ulasan tidak tersedia.");
}

// Tambahkan pesan sukses jika ada
if (isset($_GET['save_success']) && $_GET['save_success'] == 1) {
    echo '<div class="alert alert-success" role="alert">Ulasan berhasil disimpan!</div>';
}
?>

<div class="row">
    <?php if (!empty($result['reviews'])): ?>
        <?php foreach ($result['reviews'] as $review): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($review['nama']); ?></h5>
                        <div class="review-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $review['rating']): ?>
                                    <i class="fa fa-star"></i>
                                <?php else: ?>
                                    <i class="fa fa-star-o"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <p class="card-text"><?php echo htmlspecialchars($review['message']); ?></p>
                        <small class="text-muted"><?php echo date('d M Y', strtotime($review['created_at'])); ?></small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="col-12">Belum ada ulasan.</p>
    <?php endif; ?>
</div>

<div class="pagination justify-content-start mt-4"> <!-- Changed 'justify-content-center' to 'justify-content-start' -->
    <?php if ($result['current_page'] > 1): ?>
        <a href="?page=<?php echo $result['current_page'] - 1; ?>" class="btn btn-primary mr-2">Sebelumnya</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $result['total_pages']; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="btn btn-primary <?php echo ($i == $result['current_page']) ? 'active' : ''; ?> mr-2"><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($result['current_page'] < $result['total_pages']): ?>
        <a href="?page=<?php echo $result['current_page'] + 1; ?>" class="btn btn-primary">Selanjutnya</a>
    <?php endif; ?>
</div>