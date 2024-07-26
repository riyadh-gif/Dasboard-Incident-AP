<?php
include '../../conf/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all required POST data is present
    $required_fields = ['nama', 'kondisi', 'rumah_sakit', 'tanggal', 'lokasi', 'maskapai'];
    $missing_fields = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        die("Error: Missing form data for fields: " . implode(", ", $missing_fields));
    }

    $nama = $_POST['nama'];
    $kondisi = $_POST['kondisi'];
    $rumah_sakit = $_POST['rumah_sakit'];
    $tanggal = $_POST['tanggal'];
    $lokasi = $_POST['lokasi'];
    $maskapai = $_POST['maskapai'];

    // Prepare the statement
    $stmt = $koneksi->prepare("INSERT INTO tb_korban (nama, kondisi, rumah_sakit, tanggal, lokasi, maskapai) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Check for errors in statement preparation
    if (!$stmt) {
        die("Error: " . $koneksi->error);
    }

    // Bind parameters and execute for each row
    for ($i = 0; $i < count($nama); $i++) {
        $stmt->bind_param("ssssss", $nama[$i], $kondisi[$i], $rumah_sakit[$i], $tanggal[$i], $lokasi[$i], $maskapai[$i]);

        // Execute the query
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error . "<br>";
        }
    }

    // Close the statement
    $stmt->close();

    // Redirect to the desired page
    header('Location: ../index.php?page=data-insiden');
    exit;
}

// Close the connection
$koneksi->close();
?>
