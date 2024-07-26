<?php
include('../../conf/config.php');

$id = $_POST['id'];
$nama = $_POST['nama'];
$nip = $_POST['nip'];
$password = $_POST['password'];
$unit = $_POST['unit'];

// Check for existing NIP entries in the database, excluding the current user's NIP
$stmt = $koneksi->prepare("SELECT nip FROM tb_user WHERE nip = ? AND id != ?");
$stmt->bind_param("si", $nip, $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    echo "<script>
        alert('Error: The NIP $nip already exists in the database.');
        window.history.back();
    </script>";
    exit();
}

$stmt->close();

if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = "UPDATE `tb_user` SET 
                `nama` = ?, 
                `nip` = ?, 
                `password` = ?, 
                `unit` = ? 
              WHERE `id` = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ssssi", $nama, $nip, $hashed_password, $unit, $id);
} else {
    $query = "UPDATE `tb_user` SET 
                `nama` = ?, 
                `nip` = ?, 
                `unit` = ? 
              WHERE `id` = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssi", $nama, $nip, $unit, $id);
}

if ($stmt->execute()) {
    header('Location: http://localhost:8080/AngkasaPura/app/index.php?page=data-user');
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$koneksi->close();
?>
