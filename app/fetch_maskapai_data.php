<?php
// fetch_maskapai_data.php
include '../conf/config.php';

$date_today = date('Y-m-d');
$query = "SELECT maskapai, lokasi FROM tb_maskapai WHERE tanggal = '$date_today'";
$result = mysqli_query($koneksi, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
