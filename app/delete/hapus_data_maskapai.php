<?php
include('../../conf/config.php');

// Mengambil data dari URL
$id = $_GET['id'];

// Query untuk memasukkan data ke dalam tabel
$query = mysqli_query($koneksi,"DELETE FROM `tb_maskapai` WHERE id = '$id'");
header('Location: ../index.php?page=data-maskapai');

// Eksekusi query dan penanganan kesalahan
if (mysqli_query($koneksi, $query)) {
    echo "Data berhasil dihapus!";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

// Menutup koneksi
mysqli_close($koneksi);
?>
