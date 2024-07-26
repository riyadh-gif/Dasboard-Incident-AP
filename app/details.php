<?php
include("../conf/config.php");

// Debugging: cetak parameter GET yang diterima


$type = isset($_GET['type']) ? $_GET['type'] : '';
$condition = isset($_GET['condition']) ? $_GET['condition'] : '';
$selectedDate = isset($_GET['selected_date']) ? $_GET['selected_date'] : date('Y-m-d');

if ($type == 'korban') {
    $queryKorban = mysqli_query($koneksi, "SELECT id, nama, rumah_sakit FROM tb_korban WHERE DATE(tanggal) = '$selectedDate'");
    echo "<h4>Details of Korban</h4>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>ID</th><th>Nama</th><th>Rumah Sakit</th></tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_array($queryKorban)) {
        $id = isset($row['id']) ? $row['id'] : 'N/A';
        $nama = isset($row['nama']) ? $row['nama'] : 'N/A';
        $rumah_sakit = isset($row['rumah_sakit']) ? $row['rumah_sakit'] : 'N/A';
        echo "<tr><td>$id</td><td>$nama</td><td>$rumah_sakit</td></tr>";
    }
    echo "</tbody></table>";
    
} elseif ($type == 'maskapai') {
    $queryMaskapai = mysqli_query($koneksi, "SELECT id, maskapai FROM tb_korban WHERE DATE(tanggal) = '$selectedDate'");
    echo "<h4>Details of Maskapai</h4>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>ID</th><th>Maskapai</th></tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_array($queryMaskapai)) {
        $id = isset($row['id']) ? $row['id'] : 'N/A';
        $maskapai = isset($row['maskapai']) ? $row['maskapai'] : 'N/A';
        echo "<tr><td>$id</td><td>$maskapai</td></tr>";
    }
    echo "</tbody></table>";
    
} elseif ($type == 'date') {
    echo "<h4>Date Information</h4>";
    $queryDate = mysqli_query($koneksi, "SELECT id, tanggal FROM tb_korban WHERE DATE(tanggal) = '$selectedDate'");
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>ID</th><th>Date</th></tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_array($queryDate)) {
        $id = isset($row['id']) ? $row['id'] : 'N/A';
        $tanggal = isset($row['tanggal']) ? $row['tanggal'] : 'N/A';
        echo "<tr><td>$id</td><td>$tanggal</td></tr>";
    }
    echo "</tbody></table>";
    
} elseif ($type == 'location') {
    echo "<h4>Location Information</h4>";
    echo '<img src="../map.jpg" alt="Map" class="img-fluid" style="width: 100%; height: auto;">';
    
} elseif ($type == 'condition' && !empty($condition)) {
    $queryConditionSQL = "SELECT id, nama, rumah_sakit, kondisi FROM tb_korban WHERE kondisi='$condition' AND DATE(tanggal) = '$selectedDate'";
    $queryCondition = mysqli_query($koneksi, $queryConditionSQL);
    echo "<h4>Details for Condition: $condition</h4>";
    if (mysqli_num_rows($queryCondition) > 0) {
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>ID</th><th>Nama</th><th>Rumah Sakit</th><th>Kondisi</th></tr></thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_array($queryCondition)) {
            $id = isset($row['id']) ? $row['id'] : 'N/A';
            $nama = isset($row['nama']) ? $row['nama'] : 'N/A';
            $rumah_sakit = isset($row['rumah_sakit']) ? $row['rumah_sakit'] : 'N/A';
            $kondisi = isset($row['kondisi']) ? $row['kondisi'] : 'N/A';
            echo "<tr>
            <td>$id</td>
            <td>$nama</td>
            <td>$rumah_sakit</td>
            <td>$kondisi</td>
            </tr>";
        }
        echo "</tbody></table>";
        
        $queryTotalRumahSakit = mysqli_query($koneksi, "SELECT rumah_sakit, COUNT(*) AS total FROM tb_korban WHERE kondisi='$condition' AND DATE(tanggal) = '$selectedDate' GROUP BY rumah_sakit");
        if (mysqli_num_rows($queryTotalRumahSakit) > 0) {
            echo "<h4>Total Kemunculan per Rumah Sakit untuk Kondisi: $condition</h4>";
            echo "<table class='table table-striped'>";
            echo "<thead><tr><th>Rumah Sakit</th><th>Total</th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_array($queryTotalRumahSakit)) {
                $rumah_sakit = isset($row['rumah_sakit']) ? $row['rumah_sakit'] : 'N/A';
                $total = isset($row['total']) ? $row['total'] : 0;
                echo "<tr><td>$rumah_sakit</td><td>$total</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No records found for condition: $condition</p>";
        }
    } else {
        echo "<p>No records found for condition: $condition</p>";
    }
    
} else {
    echo "<p>Invalid type or missing condition</p>";
}
?>
