<?php
include('../../conf/config.php');

$numRows = $_GET['numRows'] ?? 1;
$numRows = intval($numRows);

for ($i = 0; $i < $numRows; $i++) {
    $tanggal = $_GET['tanggal'][$i];
    $lokasi = $_GET['lokasi'][$i];
    $maskapai = $_GET['maskapai'][$i];

    $query = $koneksi->prepare("INSERT INTO tb_maskapai (tanggal, lokasi, maskapai) VALUES (?, ?, ?)");
    $query->bind_param("sss", $tanggal, $lokasi, $maskapai);

    if (!$query->execute()) {
        echo "Error: " . $query->error;
        break;
    }
}

header('Location: ../index.php?page=data-maskapai');

$query->close();
$koneksi->close();
?>
