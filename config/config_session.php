<?php
// config_session.php
// Cek versi PHP, kalau di atas 7.3 bisa pakai array parameter
if (version_compare(PHP_VERSION, '7.3.0') >= 0) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '', // Kosongin aja
        'secure' => true, // WAJIB TRUE untuk SameSite=None
        'httponly' => true,
        'samesite' => 'None' // KUNCI UTAMA BIAR MAU DARI IFRAME DOMAIN LAIN
    ]);
} else {
    // Kalau PHP lama (di bawah 7.3), pakai cara manual header
    // Ini jarang kejadian di hosting modern sih
    ini_set('session.cookie_samesite', 'None');
    ini_set('session.cookie_secure', '1');
}

// Mulai sessionnya di sini
session_start();
?>