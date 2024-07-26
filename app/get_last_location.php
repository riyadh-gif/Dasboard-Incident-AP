<?php
include('../conf/config.php');

if (!isset($koneksi)) {
    die("Database connection not established.");
}

$query = mysqli_query($koneksi, "SELECT lokasi FROM tb_maskapai ORDER BY id DESC LIMIT 1");
$last_location = mysqli_fetch_assoc($query)['lokasi'] ?? '';
echo $last_location;
?>
