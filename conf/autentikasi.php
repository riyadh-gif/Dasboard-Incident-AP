<?php
session_start(); 
include('config.php');  // Ensure this file contains the correct database connection setup

// Retrieve values from the form
$nip = $_POST['nip'];
$password = $_POST['password'];

// Debug log
error_log("NIP: " . $nip);
error_log("Password: " . $password);

// Ensure nip and password are not empty
if (empty($nip) || empty($password)) {
    error_log("NIP or password is empty");
    header('Location: ../index.php?error=2'); // Error code 2 for empty fields
    exit();
}

// Correct SQL query
$query = "SELECT * FROM tb_user WHERE nip=?";

// Prepare statement for security
if ($stmt = $koneksi->prepare($query)) {
    // Bind parameters to avoid SQL injection
    $stmt->bind_param("s", $nip);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check query result
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Debug log
        error_log("User found: " . $user['nama']);
        error_log("Stored hash: " . $user['password']);

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables and redirect if login is successful
            $_SESSION['nip'] = $user['nip']; // Ensure nip is set
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['unit'] = $user['unit'];
            error_log("Login successful for NIP: " . $nip);
            header('Location: ../app');
            exit();
        } else {
            // Invalid password
            error_log("Invalid password for NIP: " . $nip);
            header('Location: ../index.php?error=1'); // Error code 1 for invalid password
            exit();
        }
    } else {
        // NIP not found
        error_log("NIP not found: " . $nip);
        header('Location: ../index.php?error=1'); // Error code 1 for NIP not found
        exit();
    }
} else {
    // Handle error if SQL statement preparation fails
    echo "Error: " . $koneksi->error;
}
?>
