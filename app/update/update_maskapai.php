<?php
include('../../conf/config.php');

// Mengambil data dari URL (metode GET)
$id = $_GET['id'];
$tanggal = $_GET['tanggal'];
$lokasi = $_GET['lokasi'];
$maskapai = $_GET['maskapai'];

// Query untuk melakukan UPDATE data ke dalam tabel
$query = "UPDATE `tb_maskapai` SET 
            `tanggal`='$tanggal', 
            `lokasi`='$lokasi', 
            `maskapai`='$maskapai' 
          WHERE `id`='$id'";

// Eksekusi query dan penanganan kesalahan
if (mysqli_query($koneksi, $query)) {
    // Jika query berhasil dieksekusi, alihkan ke halaman lain
    header('Location: ../index.php?page=data-maskapai');
    exit(); // Pastikan kode berhenti di sini setelah pengalihan header
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

// Menutup koneksi
mysqli_close($koneksi);
?>
