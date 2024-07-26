<?php
include('config.php');

// Ambil semua pengguna
$query = "SELECT id, password FROM tb_user";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

while ($user = mysqli_fetch_assoc($result)) {
    $id = $user['id'];
    $password = $user['password'];

    // Jika password tidak di-hash dengan bcrypt (panjang hash bcrypt adalah 60 karakter)
    if (strlen($password) != 60 || substr($password, 0, 4) !== '$2y$') {
        // Hash password dengan bcrypt
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Update password yang di-hash ke database
        $update_query = "UPDATE tb_user SET password='$hashed_password' WHERE id='$id'";
        if (!mysqli_query($koneksi, $update_query)) {
            echo "Update error for user ID $id: " . mysqli_error($koneksi) . "<br>";
        } else {
            echo "Password for user ID $id has been re-hashed to bcrypt.<br>";
        }
    }
}

echo "Password hashing complete.";
?>
