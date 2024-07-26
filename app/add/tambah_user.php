<?php
include '../../conf/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $password = $_POST['password'];
    $unit = $_POST['unit'];

    // Check for duplicate NIP entries within the submitted data
    $nip_counts = array_count_values($nip);
    $duplicates = array_filter($nip_counts, function($count) {
        return $count > 1;
    });

    if (!empty($duplicates)) {
        $duplicate_nips = implode(", ", array_keys($duplicates));
        echo "<script>
            alert('Error: Duplicate NIP entries detected within the submitted data: $duplicate_nips');
            window.history.back();
        </script>";
        exit;
    }

    // Check for existing NIP entries in the database
    $existing_nips = [];
    foreach ($nip as $nip_value) {
        $stmt = $koneksi->prepare("SELECT nip FROM tb_user WHERE nip = ?");
        $stmt->bind_param("s", $nip_value);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $existing_nips[] = $nip_value;
        }

        $stmt->close();
    }

    if (!empty($existing_nips)) {
        $existing_nips_str = implode(", ", $existing_nips);
        echo "<script>
            alert('Error: The following NIPs already exist in the database: $existing_nips_str');
            window.history.back();
        </script>";
        exit;
    }

    // Prepare the statement
    $stmt = $koneksi->prepare("INSERT INTO tb_user (nama, nip, password, unit) VALUES (?, ?, ?, ?)");
    
    if (!$stmt) {
        die("Error: " . $koneksi->error);
    }

    // Bind parameters and execute for each row
    for ($i = 0; $i < count($nama); $i++) {
        $hashed_password = password_hash($password[$i], PASSWORD_BCRYPT); // Hash the password with bcrypt
        $stmt->bind_param("ssss", $nama[$i], $nip[$i], $hashed_password, $unit[$i]);

        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error . "<br>";
        }
    }

    $stmt->close();

    // Redirect to the desired page
    header('Location: ../index.php?page=data-user');
    exit;
}

$koneksi->close();
?>
