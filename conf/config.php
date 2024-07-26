<?php
$koneksi = mysqli_connect('localhost','root','','db_incident');

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
//echo "Koneksi berhasil";
?>
