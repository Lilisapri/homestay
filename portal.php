<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it hasn't been started yet
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homestay Tjkro Jogja</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="path/to/your/styles.css">
    <style>
        header.masthead {
            background-image: url('<?php echo validate_image($_settings->info('cover')) ?>') !important;
        }
        header.masthead .container {
            background: #0000006b;
            text-align: center;
        }
        .review-rating {
            display: flex;
            justify-content: center;
            margin-bottom: 5px; /* Diperpendek */
        }
        .review-rating .fa-star {
            color: gold; /* Adjust color if needed */
            font-size: 24px; /* Adjust size if needed */
            margin: 0 1px; /* Diperpendek */
        }
        .footer {
            padding: 15px 0; /* Diperpendek */
            background-color: #333;
            color: #fff;
        }
        .footer h5 {
            font-weight: bold;
        }
        .footer ul {
            list-style: none;
            padding: 0;
        }
        .footer ul li {
            margin-bottom: 5px; /* Diperpendek */
        }
        .footer a {
            color: #fff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        #map-container {
            height: 150px; /* Diperpendek */
        }
        .card-img-top {
            object-fit: cover;
        }
        /* Mengatur jarak antar section */
        .page-section {
            padding: 20px 0; /* Diperpendek */
        }
        /* Jika Anda ingin mengatur jarak khusus untuk section tertentu */
        #home {
            padding-top: 10px; /* Diperpendek */
            padding-bottom: 10px; /* Diperpendek */
        }
        #about {
            padding-top: 5px; /* Diperpendek */
            padding-bottom: 5px; /* Diperpendek */
        }
        #contact {
            padding-top: 5px; /* Diperpendek */
            padding-bottom: 5px; /* Diperpendek */
        }
        /* Mengatur jarak untuk elemen card dalam section */
        .card {
            margin-bottom: 15px; /* Diperpendek */
        }
        @media (max-width: 767px) {
            .footer .col-md-6 {
                margin-bottom: 15px; /* Diperpendek */
            }
        }

        /* Mengatur jarak antara heading dan form */
        #contact .section-heading {
            margin-bottom: 5px; /* Diperpendek */
        }

        /* Mengatur jarak antara elemen form */
        #contact .form-group {
            margin-bottom: 5px; /* Diperpendek */
        }

        /* Mengatur jarak antara kolom form */
        #contact .row.align-items-stretch {
            margin-bottom: 5px; /* Diperpendek */
        }

        /* Mengatur jarak antara tombol kirim dan elemen lainnya */
        #contact .text-center button {
            margin-top: 5px; /* Diperpendek */
        }
        .btn-wa {
            display: inline-block;
            padding: 8px 12px; /* Diperpendek */
            font-size: 12px; /* Diperpendek */
            color: #fff;
            background-color: #25D366; /* WhatsApp green */
            border: none;
            border-radius: 0; /* Square button */
            text-decoration: none;
            margin: 5px 0; /* Diperpendek */
        }

        .btn-wa:hover {
            background-color: #128C7E; /* Darker green for hover */
        }

    </style>
</head>
<body>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container">
            <div class="review-rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </div>
            <div class="masthead-subheading">Selamat Datang Di Homestay Tjkro Jogja <br>Liburan Ke Jogja Makin Happy</div>
            <a class="btn btn-primary btn-xl text-uppercase" href="#home" style="background: blue; font-size: 14px; padding: 8px 16px; border-radius: 5px;">Lihat Homestay</a>
        </div>
    </header>
    <!-- Services-->
    <section class="page-section bg-dark" id="home">
        <div class="container">
            <h3 class="text-center">Katalog Homestay</h3>
            <div class="d-flex w-100 justify-content-center">
                <hr class="border-warning" style="border:3px solid" width="15%">
            </div>
            <div class="row">
                <?php
                $rooms = $conn->query("SELECT * FROM room_list order by rand() limit 5");
                while($row = $rooms->fetch_assoc() ):
                    $cover = '';
                    if(is_dir(base_app.'uploads/room_'.$row['id'])){
                        $img = scandir(base_app.'uploads/room_'.$row['id']);
                        $k = array_search('.', $img);
                        if($k !== false)
                            unset($img[$k]);
                        $k = array_search('..', $img);
                        if($k !== false)
                            unset($img[$k]);
                        $cover = isset($img[2]) ? 'uploads/room_'.$row['id'].'/'.$img[2] : "";
                    }
                    // $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description']))); // Dihapus
                ?>
                    <div class="col-md-4 p-2"> <!-- Diperpendek -->
                        <div class="card w-100 rounded-0">
                            <img class="card-img-top" src="<?php echo validate_image($cover) ?>" alt="<?php echo $row['room'] ?>" height="200rem">
                            <div class="card-body">
                                <h5 class="card-title truncate-1 w-100"><?php echo $row['room'] ?></h5><br>
                                <!-- Deskripsi dihapus dari sini -->
                                <div class="w-100 d-flex justify-content-end">
                               <!-- ... existing code ... -->
                               <a href="./?page=view_room&id=<?php echo md5($row['id']) ?>" class="btn btn-primary btn-xl text-uppercase" style="background: blue; font-size: 14px; padding: 8px 16px; border-radius: 5px;">Lihat Kamar</a> <!-- Diperpendek: menghapus tanda panah -->
<!-- ... existing code ... -->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="d-flex w-100 justify-content-end">
          <!-- ... existing code ... -->
<a href="./?page=rooms" class="btn btn-primary btn-xl text-uppercase" style="background: blue; font-size: 14px; padding: 8px 16px; border-radius: 5px;">Detail Kamar</a> <!-- Diperpendek: menghapus tanda panah -->
<!-- ... existing code ... -->
            </div>
        </div>
    </section>

    <!-- Galeri -->
    <section class="page-section" id="gallery">
        <div class="container">
        <h3 class="text-center">Galeri</h3>
            <div class="d-flex w-100 justify-content-center">
                <hr class="border-warning" style="border:3px solid" width="15%">
            </div>
            <div class="row">
                <!-- Tambahkan gambar-gambar galeri di sini -->
                <div class="col-md-4 mb-2"> <!-- Diperpendek -->
                    <img src="uploads/ini.jpeg" class="img-fluid" alt="vila">
                </div>
                <div class="col-md-4 mb-2"> <!-- Diperpendek -->
                    <img src="uploads/3.jpeg" class="img-fluid" alt="Gambar 3">
                </div>
                <div class="col-md-4 mb-2"> <!-- Diperpendek -->
                    <img src="uploads/0.jpeg" class="img-fluid" alt="Gambar 3">
                </div>
                <div class="col-md-4 mb-2"> <!-- Diperpendek -->
                    <img src="uploads/itu.jpeg" class="img-fluid" alt="Gambar 3">
                </div>
                <div class="col-md-4 mb-2"> <!-- Diperpendek -->
                    <img src="uploads/ipa.jpeg" class="img-fluid" alt="Gambar 3">
                </div>
                <div class="col-md-4 mb-2"> <!-- Diperpendek -->
                    <img src="uploads/iy.jpeg" class="img-fluid" alt="Gambar 3">
                </div>
                <!-- Tambahkan lebih banyak gambar sesuai kebutuhan -->
            </div>
        </div>
    </section>
    
    <!-- About-->
    <section class="page-section bg-dark" id="about">
    <div class="container">
        <div class="text-center">
            <h3 class="section-heading text-center" style="color: white;">Alur Pemesanan</h3> <!-- Menambahkan style untuk teks hitam -->
        </div>
        <div>
        <div class="card w-100">
                <div class="card-body" style="color: black; padding: 10px;"> <!-- Menambahkan style untuk teks hitam dan mengurangi padding -->
                    <!-- ... existing code ... -->
                    <div style="text-align: center;"> <!-- Menambahkan div untuk menengahkan gambar -->
                        <img src="uploads/al.png" alt="Alur Pemesanan" class="img-fluid mb-2" style="max-width: 100%;"> <!-- Diperbesar menjadi 100% -->
                    </div>
<!-- ... existing code ... -->
                    <?php echo file_get_contents(base_app.'about.html') ?>
                </div>
            </div>
        </div>
    </div>
</section>

    <section class="page-section" id="review">
    <!-- Reviews -->
      <!-- Reviews -->
      <section class="page-section" id="reviews">
        <div class="container">
            <div class="row">
                <!-- Contoh review -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">John Doe</h5>
                            <div class="review-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                            </div>
                            <p class="card-text">Great experience! The room was clean and the service was excellent. Highly recommended!</p>
                        </div>
                    </div>
                </div>
                <!-- Tambahkan review lain sesuai kebutuhan -->
            </div>
            <!-- Tambahkan tombol untuk menambahkan ulasan baru -->
            <div class="text-center mt-3"> <!-- Diperpendek -->
                <button class="btn btn-primary btn-xl text-uppercase" id="addReviewButton" style="font-size: 14px; padding: 8px 16px;">Tambah Ulasan</button> <!-- Diperpendek -->
            </div>
        </div>
    </section>
   
    <!-- Formulir untuk menambahkan ulasan baru -->
     
    <div id="addReviewForm" class="container mt-2" style="display:none;"> <!-- Diperpendek -->
        <h3 class="text-center">Tambahkan Ulasan Anda</h3>
        <form id="reviewForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control" id="reviewName" name="reviewName" type="text" placeholder="Nama Lengkap *" required />
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="reviewEmail" name="reviewEmail" type="email" placeholder="Email *" required />
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="reviewRating" name="reviewRating" required>
                            <option value="">Pilih Rating</option>
                            <option value="5">5 Bintang</option>
                            <option value="4">4 Bintang</option>
                            <option value="3">3 Bintang</option>
                            <option value="2">2 Bintang</option>
                            <option value="1">1 Bintang</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea class="form-control" id="reviewMessage" name="reviewMessage" placeholder="Ulasan Anda *" required></textarea>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary btn-xl text-uppercase" id="submitReviewButton" type="submit">Kirim Ulasan</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(function(){
        // Toggle visibilitas formulir
        $('#addReviewButton').click(function() {
            // Cek apakah pengguna sudah login
            <?php if(!isset($_SESSION['auth_user'])): ?>
                window.location.href = "login.php"; // Arahkan ke halaman login
            <?php else: ?>
                $('#addReviewForm').toggle(); // Menampilkan atau menyembunyikan formulir
            <?php endif; ?>
        });

        // Kirim formulir
        $('#reviewForm').submit(function(e){
            e.preventDefault();
            // Cek apakah pengguna sudah login
            <?php if(!isset($_SESSION['auth_user'])): ?>
                alert("Anda harus login terlebih dahulu untuk mengirim ulasan.");
                window.location.href = "login.php"; // Arahkan ke halaman login
            <?php else: ?>
                $.ajax({
                    url: 'save_review.php',
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(resp) {
                        if (typeof resp == 'object' && resp.status == 'success') {
                            alert("Ulasan Anda telah dikirim!");
                            $('#reviewForm').get(0).reset();
                            $('#addReviewForm').hide();
                            loadReviews();
                        } else {
                            alert("Terjadi kesalahan: " + (resp.message || "Silakan coba lagi."));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Status XHR: " + status);
                        console.log("Error: " + error);
                        console.log("Teks Respons: " + xhr.responseText);
                        alert("Terjadi kesalahan saat mengirim ulasan. Silakan coba lagi.");
                    }
                });
            <?php endif; ?>
        });    
        // Fungsi untuk memuat ulasan
        function loadReviews() {
            $.ajax({
                url: 'get_reviews.php',
                method: "GET",
                dataType: "html",
                success: function(resp) {
                    $('#reviews .row').html(resp);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        // Panggil fungsi untuk memuat ulasan ketika halaman dimuat
        loadReviews();
    });
    </script>
</section>
  <!-- Contact-->
<section class="page-section" id="contact">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading">Pertanyaan?</h2>
        </div>
        <!-- Form -->
        <form id="contactForm">
            <div class="row align-items-stretch mb-0"> <!-- Diperpendek: mengubah mb-1 menjadi mb-0 -->
                <div class="col-md-6">
                    <div class="form-group">
                        <!-- Name input-->
                        <input class="form-control" id="name" name="name" type="text" placeholder="Nama Lengkap *" required />
                    </div>
                    <div class="form-group">
                        <!-- Email address input-->
                        <input class="form-control" id="email" name="email" type="text" placeholder="No Whatsapp *" data-sb-validations="required,email" />
                    </div>
                    <div class="form-group mb-md-0">
                        <input class="form-control" id="subject" name="subject" type="email" placeholder="Email *" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-textarea mb-md-0">
                        <!-- Message input-->
                        <textarea class="form-control" id="message" name="message" placeholder="Detail Pertanyaan *" required></textarea>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary btn-xl" id="submitButton" type="submit" style="padding: 15px 30px; font-size: 16px;">Kirim Pesan</button> <!-- Menambahkan style untuk memperbesar button -->
            </div>
        </form>
    </div>
</section>

    <!-- Footer -->
    <section class="page-section" id="alamat">
        <div class="container">
            <div class="row">
                <!-- Kontak Kami -->
                <div class="col-lg-3 col-md-6 mb-2 mb-md-0">
                    <h5 class="text-uppercase">Kontak Kami</h5>
                    <ul class="list-unstyled mb-0">
                        <li><i class="fa fa-map-marker"></i> Alamat: Perumahan Tjokro Boulevard K4, Jl. Imogiri Barat No.KM7, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55187</li>
                        <li><i class="fa fa-phone"></i> Telepon: 0895343006866</li>
                        <!-- ... existing code ... -->
<li><i class="fa fa-envelope"></i> Email: <span style="display:inline-block; width: 200px;">Homestaytjkrojogja@gmail.com</span></li>
<!-- ... existing code ... -->
                    </ul>
                </div>
                <!-- Rekomendasi Kuliner Terdekat -->
                <div class="col-lg-3 col-md-6 mb-2 mb-md-0">
                    <h5 class="text-uppercase">Rekomendasi Kuliner Terdekat</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="https://www.google.com/maps/place/Gudeg+Yu+Djum/@-7.7939173,110.362675,689m/data=!3m2!1e3!4b1!4m6!3m5!1s0x2e7a5827b486d57b:0x3c0e9dec5b366c5f!8m2!3d-7.7939226!4d110.3652499!16s%2Fg%2F1ptyp443w?entry=ttu" class="text-dark"><i class="fa fa-"></i> Gudeg Yu Jum</a></li>
                        <li><a href="https://www.google.com/maps/place/Geplak+Mbok+Tumpuk/@-7.897061,110.3207109,689m/data=!3m2!1e3!4b1!4b6!3m5!1s0x2e7aff6500000001:0xf1057df9d7154d21!8m2!3d-7.8970663!4d110.3232858!16s%2Fg%2F1pzs0p3w4?entry=ttu" class="text-dark"><i class="fa fa-"></i> Geplak Mbok Tumpuk</a></li>
                        <li><a href="https://www.google.com/maps/place/Bakso+Pajero+Kasongan/@-7.8492381,110.3403758,689m/data=!3m2!1e3!4b1!4b6!3m5!1s0x2e7a57e04d886c8b:0x4d27caf09d9b8c5f!8m2!3d-7.8492434!4d110.3429507!16s%2Fg%2F11svqyk_pf?entry=ttu" class="text-dark"><i class="fa fa-"></i> Bakso Pajero</a></li>
                        <li><a href="https://www.google.com/maps/place/Sate+Klathak+Pak+Pong/@-7.8714645,110.3689708,2756m/data=!3m2!1e3!4b1!4m6!3m5!1s0x2e7a56854a9b3e95:0xdbe6f91fd89db72e!8m2!3d-7.8714862!4d110.3874249!16s%2Fg%2F11bzzpmqjq!5m1!1e1?entry=ttu&g_ep=EgoyMDI0MDgyMS4wIKXMDSoASAFQAw%3D%3D"class="text-dark"><i class="fa fa-"></i> Sate Klathak Pak Pong</a></li>
                        <li><a href="https://www.google.com/maps/place/Enthok+Rempah+Imogiri/@-7.8316378,110.3202695,11024m/data=!3m1!1e3!4m11!1m3!2m2!1skuliner+terdekat+dari+lokasi+saat+ini!6e5!3m6!1s0x2e7a56f20ed03ca3:0x7773f7352ebca1bc!8m2!3d-7.8524718!4d110.3902013!15sCiVrdWxpbmVyIHRlcmRla2F0IGRhcmkgbG9rYXNpIHNhYXQgaW5pIgOQAQFaJyIla3VsaW5lciB0ZXJkZWthdCBkYXJpIGxva2FzaSBzYWF0IGluaZIBCnJlc3RhdXJhbnSaASRDaGREU1VoTk1HOW5TMFZKUTBGblNVUTJkVzkxYXpOQlJSQULgAQA!16s%2Fg%2F11c3pmypr1!5m1!1e1?entry=ttu&g_ep=EgoyMDI0MDgyMS4wIKXMDSoASAFQAw%3D%3D"class="text-dark"><i class="fa fa-"></i> Enthok Rempah Imogiri</a></li>
                        <li><a href="https://www.google.com/maps/place/Sego+Godog+Pak+Pethel/@-7.8638176,110.2833951,11024m/data=!3m1!1e3!4m13!1m3!2m2!1skuliner+terdekat+dari+lokasi+saat+ini!6e5!3m8!1s0x2e7a56173263c105:0x3210097c2be0a7f7!8m2!3d-7.8638159!4d110.3449703!9m1!1b1!15sCiVrdWxpbmVyIHRlcmRla2F0IGRhcmkgbG9rYXNpIHNhYXQgaW5pIgOQAQFaJyIla3VsaW5lciB0ZXJkZWthdCBkYXJpIGxva2FzaSBzYWF0IGluaZIBFWluZG9uZXNpYW5fcmVzdGF1cmFudJoBJENoZERTVWhOTUc5blMwVkpRMEZuU1VOUGFYRnBUREpSUlJBQuABAA!16s%2Fg%2F11b7rxkbzf!5m1!1e1?entry=ttu&g_ep=EgoyMDI0MDgyMS4wIKXMDSoASAFQAw%3D%3D"class="text-dark"><i class="fa fa-"></i> Sego Godog Pak Pethel</a></li>
                        <li><a href="https://www.google.com/maps/place/Soto+Bathok+Mbah+Katro/@-7.7609264,110.4444712,689m/data=!3m2!1e3!4b1!4m6!3m5!1s0x2e7a5a377f9daf43:0xcd38d6da90007b86!8m2!3d-7.7609317!4d110.4470461!16s%2Fg%2F11b7lpdj39!5m1!1e1?entry=ttu&g_ep=EgoyMDI0MDgyMS4wIKXMDSoASAFQAw%3D%3D"class="text-dark"><i class="fa fa-"></i> Soto Bathok Mbah Katro</a></li>
                    </ul>
                </div>
                <!-- Rekomendasi Wisata Terdekat -->
                <div class="col-lg-3 col-md-6 mb-2 mb-md-0">
                    <h5 class="text-uppercase">Rekomendasi Wisata Terdekat</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="https://www.google.com/maps/place/Alun-Alun+Kidul+Yogyakarta/@-7.8118782,110.3586993,689m/data=!3m1!1e3!4m10!1m2!2m1!1salun+alun+jogja!3m6!1s0x2e7a5739525ede4d:0x1759713f6a304135!8m2!3d-7.8118782!4d110.3632054!15sCg9hbHVuIGFsdW4gam9namFaESIPYWx1biBhbHVuIGpvZ2phkgEJY2l0eV9wYXJrmgEjQ2haRFNVaE5NRzluUzBWSlEwRm5TVVJQTFRoaVVGUlJFQUXgAQA!16s%2Fg%2F11hdq9v6s5?entry=ttu" class="text-dark">Alun-Alun Jogja</a></li>
                        <li><a href="https://www.google.com/maps/place/Pantai+Parangtritis" class="text-dark">Pantai Parangtritis</a></li>
                        <li><a href="https://www.google.com/maps/place/Keraton+Ngayogyakarta+Hadiningrat/@-7.8052792,110.3616282,689m/data=!3m2!1e3!4b1!4b6!3m5!1s0x2e7a5796db06c7ef:0x395271cf052b276c!8m2!3d-7.8052845!4d110.3642031!16s%2Fm%2F0vb3k_5?entry=ttu" class="text-dark">Kraton Yogyakarta</a></li>
                        <li><a href="https://www.google.com/maps/place/Kampung+Wisata+Taman+Sari/@-7.8099735,110.3564158,689m/data=!3m2!1e3!4b1!4b6!3m5!1s0x2e7a5793d0c2cf2b:0x276a21f8a01cbe13!8m2!3d-7.8099788!4d110.3589907!16s%2Fm%2F0b6gg2m?entry=ttu" class="text-dark">Taman Sari</a></li>
                        <li><a href="https://www.google.com/maps/place/Malioboro+Yogyakarta/@-7.7925547,110.3473889,2756m/data=!3m2!1e3!4b1!4b1!4m6!3m5!1s0x2e7a5742a17e8c33:0xf92dc9a55003beb0!8m2!3d-7.7925764!4d110.365843!16s%2Fg%2F11j2fk1qwl?entry=ttu" class="text-dark">Jalan Malioboro</a></li>
                        <li><a href="https://www.google.com/maps/place/Kampung+Wisata+Warungboto/@-7.831986,110.3202697,11024m/data=!3m1!1e3!4m10!1m2!2m1!1swisata+terdekat+dari+lokasi+saat+ini!3m6!1s0x2e7a57e2083b1b59:0xd58c23699705d0d0!8m2!3d-7.8133932!4d110.392982!15sCiR3aXNhdGEgdGVyZGVrYXQgZGFyaSBsb2thc2kgc2FhdCBpbmkiA5ABAVomIiR3aXNhdGEgdGVyZGVrYXQgZGFyaSBsb2thc2kgc2FhdCBpbmmSARJ0b3VyaXN0X2F0dHJhY3Rpb26aASNDaFpEU1VoTk1HOW5TMFZKUTBGblNVTXRaMUJoWlZCUkVBReABAA!16s%2Fg%2F11rfd6mky3!5m1!1e1?entry=ttu&g_ep=EgoyMDI0MDgyMS4wIKXMDSoASAFQAw%3D%3D"class="text-dark">Kampung Wisata Warungboto</a></li>
                        <li><a href="https://www.google.com/maps/place/Museum+Benteng+Vredeburg/@-7.831986,110.3202697,11024m/data=!3m1!1e3!4m10!1m2!2m1!1swisata+terdekat+dari+lokasi+saat+ini!3m6!1s0x2e7a5788c0b3eecf:0xb9611ce0232a9ff8!8m2!3d-7.800293!4d110.3661642!15sCiR3aXNhdGEgdGVyZGVrYXQgZGFyaSBsb2thc2kgc2FhdCBpbmkiA5ABAVomIiR3aXNhdGEgdGVyZGVrYXQgZGFyaSBsb2thc2kgc2FhdCBpbmmSAQ5oaXN0b3J5X211c2V1bZoBI0NoWkRTVWhOTUc5blMwVkpRMEZuU1VRdGJHVlRSRlYzRUFF4AEA!16zL20vMGJyZmY4!5m1!1e1?entry=ttu&g_ep=EgoyMDI0MDgyMS4wIKXMDSoASAFQAw%3D%3D" class="text-dark">Museum Benteng Vredeburg</a></li>
                    </ul>
                </div>
                 <!-- Lokasi Kami -->
                 <div class="col-lg-3 col-md-6 mb-2 mb-md-0">
                    <h5 class="text-uppercase">Lokasi Kami</h5>
                    <div id="map-container" class="z-depth-1-half map-container mb-2">
                        <!-- Ganti dengan embed code Google Maps -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000.2688346480577!2d110.37104147356038!3d-7.8608381781395185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a572fe894211b%3A0xd99f7250b48276cd!2sHomestay%20Tjokro%20Boulevard%20Jogja!5e1!3m2!1sid!2sid!4v1722478831446!5m2!1sid!2sid"
                                width="100%" height="150" frameborder="0" style="border:0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> <!-- Diperpendek -->
                    </div>
                    <!-- Tombol WhatsApp -->
                    <div class="container text-center" style="padding: 5px;"> <!-- Diperpendek -->
                        <a href="https://wa.me/62895343006866" class="btn-wa">
                            Hubungi CS via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    $(function(){
        $('#contactForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_inquiry",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        alert_toast("Inquiry sent", 'success');
                        $('#contactForm').get(0).reset();
                    } else {
                        console.log(resp);
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    }
                }
            });
        });
    });
    </script>
    
</body>
</html>