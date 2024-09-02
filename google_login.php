<?php
session_start();

// Include Google API PHP Client Library
require_once 'vendor/autoload.php';

// Konfigurasi Google Client
$client = new Google_Client();
$client->setClientId('YOUR_CLIENT_ID'); // Ganti dengan Client ID Anda
$client->setClientSecret('YOUR_CLIENT_SECRET'); // Ganti dengan Client Secret Anda
$client->setRedirectUri('http://yourdomain.com/google_login.php'); // Ganti dengan URL redirect Anda
$client->addScope('email');
$client->addScope('profile');

// Jika ada kode yang diterima dari Google
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Mendapatkan informasi pengguna
    $google_service = new Google_Service_Oauth2($client);
    $user_info = $google_service->userinfo->get();

    // Simpan informasi pengguna ke session
    $_SESSION['user_email'] = $user_info->email;
    $_SESSION['user_name'] = $user_info->name;

    // Redirect ke halaman portal atau dashboard
    header('Location: portal.php');
    exit();
}

// Jika tidak ada kode, arahkan pengguna ke halaman login Google
$auth_url = $client->createAuthUrl();
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
exit();
?>