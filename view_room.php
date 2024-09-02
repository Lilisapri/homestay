<?php 
if(isset($_GET['id'])){
    $room = $conn->query("SELECT * FROM room_list where md5(id) = '{$_GET['id']}'");
    if($room->num_rows > 0){
        $roomData = $room->fetch_assoc(); // Fetch room data
        $price = $roomData['price']; // Ensure price is fetched
        foreach($roomData as $k => $v){
            $$k = $v;
        }
    }

    if(is_dir(base_app.'uploads/room_'.$id)){
        $ofile = scandir(base_app.'uploads/room_'.$id);
        foreach($ofile as $img){
            if(in_array($img, array('.','..')))
                continue;
            $files[] = validate_image('uploads/room_'.$id.'/'.$img);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>

<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div id="tourCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                    <div class="carousel-inner h-100">
                        <?php if(isset($files)) foreach($files as $k => $img): ?>
                        <div class="carousel-item h-100 <?php echo $k == 0 ? 'active' : '' ?>">
                            <img class="d-block w-100 h-100" src="<?php echo $img ?>" alt="">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="w-100">
                <hr>
                    <div class="w-100 d-flex justify-content-between">
                    <span class="rounded-0 btn-flat btn-sm btn-primary d-flex align-items-center justify-content-between">
                    <i class="fa fa-tag"></i> <span class="ml-1"><?php echo (string)$price ?></span> <!-- Ubah $price menjadi tipe data text -->
                    </span>
                        <button class="btn btn-flat btn-primary" type="button" data-toggle="modal" data-target="#bookingModal">Reservasi</button>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <h3><?php echo $room ?></h3>
                <hr class="border-warning">
                <div><?php echo stripslashes(html_entity_decode($description)) ?></div>
                <h5>Lokasi Homestay</h5>
                <div class="d-flex justify-content-between"> <!-- Added flexbox for side-by-side layout -->
                    <div>
                        <h6>Homestay Cokro 1 & Cokro 2</h6>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12042.245268443452!2d110.373616!3d-7.860843000000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a572fe894211b%3A0xd99f7250b48276cd!2sHomestay%20Tjokro%20Boulevard%20Jogja!5e1!3m2!1sid!2sid!4v1724213866699!5m2!1sid!2sid"  
                                width="85%" 
                                height="150" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy"></iframe>
                    </div>
                    <div>
                        <h6>Homestay Kirana</h6>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24002.764604337557!2d110.37245538476556!3d-7.850216385886926!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a56d98e8d6531%3A0x17b281f9f83fa20f!2s5C66%2B4WX%2C%20Mertosanan%20Kulon%2C%20Potorono%2C%20Kec.%20Banguntapan%2C%20Kabupaten%20Bantul%2C%20Daerah%20Istimewa%20Yogyakarta%2055196!5e1!3m2!1sid!2sid!4v1724302798775!5m2!1sid!2sid"
                                width="85%" 
                                height="150" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy"></iframe>
                    </div>
                </div>
            </div>

        <!-- Booking Modal -->
        <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Reservasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="bookingForm">
                  <div class="form-group">
                    <label for="roomName">Nama Homestay</label>
                    <input type="text" class="form-control" id="roomName" value="<?php echo $room ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="guestName">Nama Tamu</label>
                    <input type="text" class="form-control" id="guestName" required>
                  </div>
                  <div class="form-group">
                    <label for="checkInDate">Tanggal Check-In</label>
                    <input type="date" class="form-control" id="checkInDate" required min="<?php echo date('Y-m-d'); ?>"> <!-- Set min to today -->
                  </div>
                  <div class="form-group">
                    <label for="checkOutDate">Tanggal Check-Out</label>
                    <input type="date" class="form-control" id="checkOutDate" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" onchange="validateCheckOut()"> <!-- Set min to tomorrow -->
                  </div>
                  <div class="form-group">
                    <label for="numberOfNights">Jumlah Hari</label>
                    <input type="number" class="form-control" id="numberOfNights" readonly>
                  </div>
                  <div class="form-group">
                    <label for="location">Pilih Lokasi</label>
                    <select class="form-control" id="location" required>
                        <option value="">Pilih Lokasi</option>
                        <option value="Homestay Cokro 1" data-map="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12042.245268443452!2d110.373616!3d-7.860843000000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a572fe894211b%3A0xd99f7250b48276cd!2sHomestay%20Tjokro%20Boulevard%20Jogja!5e1!3m2!1sid!2sid!4v1724213866699!5m2!1sid!2sid">Homestay Cokro 1</option>
                        <option value="Homestay Cokro 2" data-map="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12042.245268443452!2d110.373616!3d-7.860843000000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a572fe894211b%3A0xd99f7250b48276cd!2sHomestay%20Tjokro%20Boulevard%20Jogja!5e1!3m2!1sid!2sid!4v1724213866699!5m2!1sid!2sid" selected>Homestay Cokro 2</option>
                        <option value="Homestay Kirana" data-map="https://maps.app.goo.gl/BwrGYg2XGneHGYgw8">Homestay Kirana</option>
                    </select>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="book">Reservasi</button>
              </div>
            </div>
          </div>
        </div>

        <script>
            function validateCheckOut() {
                var checkInDate = new Date($('#checkInDate').val());
                var checkOutDate = new Date($('#checkOutDate').val());
                if (checkOutDate <= checkInDate) {
                    alert('Tanggal Check-Out harus setelah Tanggal Check-In.');
                    $('#checkOutDate').val(''); // Reset Check-Out date
                    $('#numberOfNights').val(''); // Reset number of nights
                } else {
                    // Calculate the number of nights
                    var timeDifference = checkOutDate.getTime() - checkInDate.getTime();
                    var numberOfNights = timeDifference / (1000 * 3600 * 24);
                    $('#numberOfNights').val(numberOfNights); // Set number of nights
                }
            }

            $(document).ready(function(){
                $('#location').change(function() {
                    var selectedMap = $(this).find(':selected').data('map');
                    if (selectedMap) {
                        window.open(selectedMap, '_blank'); // Open the map link in a new tab
                    }
                    // Disable location selection if Homestay Cokro 1 is selected
                    if ($(this).val() === 'Homestay Cokro 1') {
                        $(this).prop('disabled', true); // Disable the dropdown
                    } else {
                        $(this).prop('disabled', false); // Enable the dropdown
                    }
                });

                // Automatically select location based on room name
                var roomName = $('#roomName').val();
                if (roomName.includes('Cokro 1')) {
                    $('#location').val('Homestay Cokro 1').change(); // Set and trigger change for Cokro 1
                    $('#location').prop('disabled', true); // Disable the dropdown for Cokro 1
                } else if (roomName.includes('Cokro 2')) {
                    $('#location').val('Homestay Cokro 2').change(); // Set and trigger change for Cokro 2
                    $('#location').prop('disabled', true); // Disable the dropdown for Cokro 2
                } else if (roomName.includes('Kirana')) {
                    $('#location').val('Homestay Kirana').change(); // Set and trigger change for Kirana
                    $('#location').prop('disabled', true); // Disable the dropdown for Kirana
                }
                
                $('#book').click(function(){
                    var phoneNumber = '62895343006866'; // Replace with your WhatsApp number
                    var roomName = $('#roomName').val();
                    var checkInDate = $('#checkInDate').val();
                    var checkOutDate = $('#checkOutDate').val();
                    var guestName = $('#guestName').val();
                    var location = $('#location').val(); // Get selected location
                    var locationMap; // Declare locationMap variable

                    // Set locationMap based on selected location
                    if (location === 'Homestay Cokro 1') {
                        locationMap = 'https://maps.app.goo.gl/m2iRBCC5nQpxXYXG6?g_st=ic'; // Link for Cokro 1
                    } else if (location === 'Homestay Cokro 2') {
                        locationMap = 'https://maps.app.goo.gl/m2iRBCC5nQpxXYXG6?g_st=ic'; // Link for Cokro 2
                    } else if (location === 'Homestay Kirana') {
                        locationMap = 'https://maps.app.goo.gl/JQdKjLrePAGdMVyp9?g_st=i'; // Link for Kirana
                    }

                    // Calculate the number of nights
                    var date1 = new Date(checkInDate);
                    var date2 = new Date(checkOutDate);
                    var timeDifference = date2.getTime() - date1.getTime();
                    var numberOfNights = timeDifference / (1000 * 3600 * 24);

                    // Ensure all input is filled and valid
                    if(roomName && checkInDate && checkOutDate && guestName && location && numberOfNights > 0) {
                        // Hide other locations based on room name
                        if (roomName.includes('Cokro 2')) {
                            $('#location option:not([value="Homestay Cokro 2"])').hide(); // Hide other options
                        } else if (roomName.includes('Kirana')) {
                            $('#location option:not([value="Homestay Kirana"])').hide(); // Hide other options
                        } else {
                            $('#location option').show(); // Show all options
                        }

                        // Disable location selection if it doesn't match room name
                        if (location !== roomName) {
                            $('#location').prop('disabled', true); // Disable the dropdown
                        } else {
                            $('#location').prop('disabled', false); // Enable the dropdown
                        }

                        var message = encodeURIComponent('Hai Admin, Saya ' + guestName + ' ingin reservasi ' + roomName + ' dari tanggal ' + checkInDate + ' sampai dengan ' + checkOutDate + '  (durasi   ' + numberOfNights + ' hari). Apakah homestay tersebut masih tersedia?. Lokasi: ' + location + ' (' + locationMap + ')');
                        var whatsappURL = 'https://wa.me/' + phoneNumber + '?text=' + message;

                        // Redirect to WhatsApp link
                        window.location.href = whatsappURL;
                    } else {
                        alert('Tolong lengkapi semua informasi sebelum memesan.');
                    }
                });
            });
        </script>

    </div>
</section>

</body>
</html>