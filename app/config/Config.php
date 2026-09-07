<?php
// Definisikan Base URL Aplikasi
define('BASEURL', 'http://localhost/dimsum-cece/public');

// Menyalakan session jika belum aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}