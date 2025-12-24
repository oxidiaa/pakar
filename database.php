<?php
// File: database.php

/**
 * Membuat koneksi ke database menggunakan PDO.
 * @return PDO|null
 */
function getDbConnection() {
    static $conn = null;
    if ($conn === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        try {
            $conn = new PDO($dsn, DB_USER, DB_PASS);
            // Atur mode error PDO ke exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Hentikan eksekusi dan tampilkan pesan error jika koneksi gagal
            die("Koneksi Database Gagal: " . $e->getMessage());
        }
    }
    return $conn;
}
?>