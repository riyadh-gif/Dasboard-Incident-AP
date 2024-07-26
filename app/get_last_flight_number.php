<?php
include('../conf/config.php');

if (!isset($koneksi)) {
    die("Database connection not established.");
}

$query = mysqli_query($koneksi, "SELECT maskapai FROM tb_maskapai ORDER BY id DESC LIMIT 1");
$last_flight_number = mysqli_fetch_assoc($query)['maskapai'] ?? '';
echo $last_flight_number;
?>
