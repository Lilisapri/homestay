<div id="loginRegisterModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Login atau Daftar</h2>
        <div id="loginForm">
            <h3>Login</h3>
            <form id="loginFormSubmit">
                <div class="form-group">
                    <label for="loginEmail">Email:</label>
                    <input type="email" id="loginEmail" name="email" placeholder="Masukkan email Anda" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password:</label>
                    <input type="password" id="loginPassword" name="password" placeholder="Masukkan password Anda" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
        <div id="registerForm" style="display:none;">
            <h3>Daftar</h3>
            <form id="registerFormSubmit">
                <div class="form-group">
                    <label for="registerName">Nama:</label>
                    <input type="text" id="registerName" name="name" placeholder="Masukkan nama Anda" required>
                </div>
                <div class="form-group">
                    <label for="registerEmail">Email:</label>
                    <input type="email" id="registerEmail" name="email" placeholder="Masukkan email Anda" required>
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password:</label>
                    <input type="password" id="registerPassword" name="password" placeholder="Masukkan password Anda" required>
                </div>
                <button type="submit" class="btn btn-primary">Daftar</button>
            </form>
        </div>
        <p>Belum punya akun? <a href="#" id="showRegister">Daftar di sini</a></p>
        <p>Sudah punya akun? <a href="#" id="showLogin">Login di sini</a></p>
    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.btn:hover {
    background-color: #0056b3;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginRegisterModal = document.getElementById('loginRegisterModal');
    const closeBtn = loginRegisterModal.querySelector('.close');
    const showRegisterLink = document.getElementById('showRegister');
    const showLoginLink = document.getElementById('showLogin');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    function showLoginRegisterModal() {
        loginRegisterModal.style.display = "block";
        loginForm.style.display = "block";
        registerForm.style.display = "none";
    }

    closeBtn.onclick = function() {
        loginRegisterModal.style.display = "none";
    }

    showRegisterLink.onclick = function(e) {
        e.preventDefault();
        loginForm.style.display = "none";
        registerForm.style.display = "block";
    }

    showLoginLink.onclick = function(e) {
        e.preventDefault();
        registerForm.style.display = "none";
        loginForm.style.display = "block";
    }

    window.onclick = function(event) {
        if (event.target == loginRegisterModal) {
            loginRegisterModal.style.display = "none";
        }
    }

    // Tambahkan event listener untuk form login
    document.getElementById('loginFormSubmit').addEventListener('submit', function(e) {
        e.preventDefault();
        // Implementasikan logika login di sini
        console.log('Login form submitted');
        // Setelah login berhasil, tutup modal dan kirim ulasan
        loginRegisterModal.style.display = "none";
        // Lakukan pengiriman ulasan di sini
    });

    // Tambahkan event listener untuk form register
    document.getElementById('registerFormSubmit').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this); // Ambil data dari form
        fetch('path/to/your/register_endpoint.php', { // Ganti dengan URL endpoint pendaftaran
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                console.log('Register form submitted successfully');
                loginRegisterModal.style.display = "none"; // Tutup modal setelah berhasil
                window.location.href = "review.php"; // Ganti dengan URL halaman ulasan Anda
            } else {
                console.error(data.message); // Tampilkan pesan kesalahan
                alert(data.message); // Tampilkan alert untuk kesalahan
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghubungi server.'); // Tampilkan alert untuk kesalahan
        });
    });
});
</script>