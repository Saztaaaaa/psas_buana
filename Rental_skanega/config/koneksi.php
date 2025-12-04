<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_rental_skanega';

try {
    $koneksi = new mysqli($host, $username, $password, $database);
    
    // Check connection
    if ($koneksi->connect_error) {
        die("Koneksi database gagal: " . $koneksi->connect_error);
    }
    
    $koneksi->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
