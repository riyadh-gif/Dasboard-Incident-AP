<?php
include('../../conf/config.php'); // Include the configuration file for database connection

session_start();

// Check if NIP is set in the session
if (!isset($_SESSION['nip'])) {
    die("NIP is not set in the session.<br>");
}

// Check if form is submitted with POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['new_password'])) {
        $nip = $_SESSION['nip'];
        $password = $_POST['new_password'];

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE `tb_user` SET `password` = ? WHERE `nip` = ?";
        $stmt = $koneksi->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("ss", $hashed_password, $nip);
            if ($stmt->execute()) {
                // Redirect to profile page with a success message flag
                header("Location: ../index.php?page=profil-user&passwordUpdated=true");
                exit();
            } else {
                echo "Error executing statement: " . $stmt->error . "<br>";
            }
            $stmt->close();
        } else {
            echo "Failed to prepare the statement: " . $koneksi->error . "<br>";
        }
        $koneksi->close();
    } else {
        echo "New password field is not set.<br>";
    }
}
?>
