<?php
// File: coordinates.php
include('../conf/config.php');

// Ambil tanggal yang dipilih pengguna dari URL (metode GET)
$selectedDate = isset($_GET['selected_date']) ? $_GET['selected_date'] : date('Y-m-d');

// Query untuk mengambil data lokasi dari tabel tb_korban berdasarkan tanggal
$queryLocation = mysqli_query($koneksi, "SELECT lokasi, COUNT(*) as count FROM tb_korban WHERE DATE(tanggal) = '$selectedDate' GROUP BY lokasi");
$locations = [];
while ($row = mysqli_fetch_assoc($queryLocation)) {
    $locations[] = ['lokasi' => $row['lokasi'], 'count' => $row['count']];
}

// Konversi data lokasi ke dalam format JSON untuk digunakan di JavaScript
$locations_js = json_encode($locations);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menampilkan Gambar dengan Titik Koordinat</title>
    <style>
        .container {
            position: relative;
            display: inline-block;
            width: 100%; /* Kontainer mengambil 100% lebar layar */
            max-width: 100%; /* Batas maksimal lebar */
        }

        #gridImage {
            width: 100%; /* Gambar mengikuti lebar kontainer */
            height: auto; /* Tinggi otomatis menyesuaikan agar proporsi gambar tetap terjaga */
        }

        #pointsContainer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .point {
            position: absolute;
            border-radius: 50%;
            width: 20px; /* Ukuran lebih besar */
            height: 20px; /* Ukuran lebih besar */
            transform: translate(-50%, -50%);
            animation: blink 1s infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <h1>Menampilkan Gambar dengan Titik Koordinat</h1>
    <div class="container">
        <img id="gridImage" src="../map.jpg" alt="Gridmap Juanda">
        <div id="pointsContainer"></div>
    </div>
    <select id="locationSelect">
        <option value="">Pilih Koordinat</option>
        <?php foreach ($locations as $location): ?>
            <option value="<?php echo $location['lokasi']; ?>"><?php echo $location['lokasi']; ?> (Jumlah Korban: <?php echo $location['count']; ?>)</option>
        <?php endforeach; ?>
    </select>

    <script>
        // Data lokasi dari PHP
        const locations = <?php echo $locations_js; ?>;

        // Peta koordinat berdasarkan lokasi (contoh)
        const coordinateMap = {
             //Koordinat L 
    "1L": {x: 161, y: 1117.5},
    "2L": {x: 230, y: 1123},
    "3L": {x: 310, y: 1122},
    "4L": {x: 382, y: 1119},
    "5L": {x: 468, y: 1120},  // Dihitung dari area rect dengan koordinat "464,1117,546,1124"
    "6L": {x: 546, y: 1124},    // Koordinat langsung dari area dengan shape="0"
    "7L": {x: 615, y: 1119},    // Koordinat langsung dari area dengan shape="0"
    "8L": {x: 689, y: 1117},    // Koordinat langsung dari area rect
    "9L": {x: 769, y: 1113},    // Koordinat langsung dari area dengan shape="0"
    "10L": {x: 844, y: 1117},   // Koordinat langsung dari area dengan shape="0"
    "11L": {x: 918, y: 1117},   // Koordinat langsung dari area dengan shape="0"
    "12L": {x: 993, y: 1112},   // Koordinat langsung dari area dengan shape="0"
    "13L": {x: 1069, y: 1108},  // Koordinat langsung dari area dengan shape="0"
    "14L": {x: 1147, y: 1116},  // Koordinat langsung dari area dengan shape="0"
    "15L": {x: 1222, y: 1118},  // Koordinat langsung dari area dengan shape="0"
    "16L": {x: 1298, y: 1120},  // Koordinat langsung dari area rect
    "17L": {x: 1371, y: 1113},  // Koordinat langsung dari area dengan shape="0"
    "18L": {x: 1447, y: 1126},  // Koordinat langsung dari area dengan shape="0"
    "19L": {x: 1527, y: 1115},  // Koordinat langsung dari area dengan shape="0"
    "20L": {x: 1594, y: 1122},  // Koordinat langsung dari area dengan shape="0"
    "21L": {x: 1674, y: 1120},  // Koordinat langsung dari area dengan shape="0"
    "22L": {x: 1758, y: 1120},  // Koordinat langsung dari area dengan shape="0"
    "23L": {x: 1829, y: 1118},  // Koordinat langsung dari area dengan shape="0"
    "24L": {x: 1909, y: 1123},  // Koordinat langsung dari area dengan shape="0"
    "25L": {x: 1981, y: 1119},  // Koordinat langsung dari area dengan shape="0"
    "26L": {x: 2056, y: 1123},  // Koordinat langsung dari area dengan shape="0"
    "27L": {x: 2130, y: 1124},  // Koordinat langsung dari area dengan shape="0"
    "28L": {x: 2208, y: 1125},   // Koordinat langsung dari area dengan shape="0"
    //Koordinat A
    "1A": {x: 163, y: 274},
    "2A": {x: 241, y: 265},
    "3A": {x: 308, y: 269},
    "4A": {x: 382, y: 273},
    "5A": {x: 462, y: 261},
    "6A": {x: 537, y: 268},
    "7A": {x: 617, y: 266},
    "8A": {x: 691, y: 273},
    "9A": {x: 769, y: 270},
    "10A": {x: 842, y: 272},
    "11A": {x: 926, y: 271},
    "12A": {x: 993, y: 271},
    "13A": {x: 1069, y: 268},
    "14A": {x: 1151, y: 278},
    "15A": {x: 1224, y: 270},
    "16A": {x: 1300, y: 275},
    "17A": {x: 1376, y: 268},
    "18A": {x: 1456, y: 285},
    "19A": {x: 1527, y: 275},
    "20A": {x: 1605, y: 283},
    "21A": {x: 1683, y: 274},
    "22A": {x: 1754, y: 270},
    "23A": {x: 1825, y: 271},
    "24A": {x: 1907, y: 271},
    "25A": {x: 1985, y: 268},
    "26A": {x: 2063, y: 272},
    "27A": {x: 2136, y: 273},
    "28A": {x: 2214, y: 268},
    "29A": {x: 2290, y: 272},

    //Koordinat B
    "1B": {x: 159, y: 352},
    "2B": {x: 235, y: 350},
    "3B": {x: 310, y: 352},
    "4B": {x: 390, y: 350},
    "5B": {x: 460, y: 356},
    "6B": {x: 539, y: 354},
    "7B": {x: 617, y: 353},
    "8B": {x: 691, y: 350},
    "9B": {x: 766, y: 356},
    "10B": {x: 840, y: 349},
    "11B": {x: 922, y: 352},
    "12B": {x: 1008, y: 350},
    "13B": {x: 1073, y: 354},
    "14B": {x: 1155, y: 356},
    "15B": {x: 1229, y: 361},
    "16B": {x: 1300, y: 358},
    "17B": {x: 1376, y: 358},
    "18B": {x: 1453, y: 352},
    "19B": {x: 1527, y: 348},
    "20B": {x: 1605, y: 347},
    "21B": {x: 1683, y: 350},
    "22B": {x: 1760, y: 356},
    "23B": {x: 1838, y: 353},
    "24B": {x: 1912, y: 349},
    "25B": {x: 1983, y: 353},
    "26B": {x: 2063, y: 354},
    "27B": {x: 2134, y: 345},
    "28B": {x: 2214, y: 345},
    "29B": {x: 2288, y: 350},

    //Koordinat C
    "1C": {x: 163, y: 436},
    "2C": {x: 235, y: 430},
    "3C": {x: 310, y: 421},
    "4C": {x: 384, y: 427},
    "5C": {x: 460, y: 430},
    "6C": {x: 542, y: 434},
    "7C": {x: 611, y: 425},
    "8C": {x: 693, y: 430},
    "9C": {x: 771, y: 430},
    "10C": {x: 842, y: 430},
    "11C": {x: 924, y: 427},
    "12C": {x: 995, y: 423},
    "13C": {x: 1067, y: 423},
    "14C": {x: 1153, y: 427},
    "15C": {x: 1224, y: 427},
    "16C": {x: 1304, y: 427},
    "17C": {x: 1380, y: 433},
    "18C": {x: 1449, y: 421},
    "19C": {x: 1525, y: 428},
    "20C": {x: 1598, y: 427},
    "21C": {x: 1676, y: 431},
    "22C": {x: 1754, y: 433},
    "23C": {x: 1836, y: 434},
    "24C": {x: 1909, y: 429},
    "25C": {x: 1985, y: 427},
    "26C": {x: 2059, y: 430},
    "27C": {x: 2136, y: 434},
    "28C": {x: 2214, y: 427},
    "29C": {x: 2288, y: 427},

    //Kordinat D
    "1D": {x: 155, y: 505},
    "2D": {x: 230, y: 504},
    "3D": {x: 313, y: 505},
    "4D": {x: 386, y: 503},
    "5D": {x: 462, y: 501},
    "6D": {x: 533, y: 504},
    "7D": {x: 617, y: 502},
    "8D": {x: 693, y: 498},
    "9D": {x: 771, y: 502},
    "10D": {x: 842, y: 497},
    "11D": {x: 922, y: 503},
    "12D": {x: 993, y: 496},
    "13D": {x: 1075, y: 501},
    "14D": {x: 1153, y: 494},
    "15D": {x: 1227, y: 501},
    "16D": {x: 1300, y: 498},
    "17D": {x: 1378, y: 496},
    "18D": {x: 1453, y: 499},
    "19D": {x: 1525, y: 506},
    "20D": {x: 1613, y: 510},
    "21D": {x: 1685, y: 500},
    "22D": {x: 1756, y: 501},
    "23D": {x: 1829, y: 499},
    "24D": {x: 1905, y: 503},
    "25D": {x: 1985, y: 503},
    "26D": {x: 2063, y: 503},
    "27D": {x: 2138, y: 506},
    "28D": {x: 2217, y: 505},
    "29D": {x: 2290, y: 504},

    //Koordinat E
    "1E": {x: 157, y: 576},
"2E": {x: 237, y: 581},
"3E": {x: 313, y: 581},
"4E": {x: 388, y: 583},
"5E": {x: 468, y: 578},
"6E": {x: 537, y: 576},
"7E": {x: 617, y: 586},
"8E": {x: 695, y: 582},
"9E": {x: 771, y: 573},
"10E": {x: 861, y: 581},
"11E": {x: 931, y: 576},
"12E": {x: 1000, y: 572},
"13E": {x: 1082, y: 566},
"14E": {x: 1149, y: 570},
"15E": {x: 1224, y: 578},
"16E": {x: 1302, y: 578},
"17E": {x: 1378, y: 581},
"18E": {x: 1456, y: 575},
"19E": {x: 1527, y: 578},
"20E": {x: 1603, y: 574},
"21E": {x: 1685, y: 579},
"22E": {x: 1762, y: 581},
"23E": {x: 1832, y: 581},
"24E": {x: 1909, y: 589},
"25E": {x: 1987, y: 585},
"26E": {x: 2065, y: 582},
"27E": {x: 2141, y: 583},
"28E": {x: 2218, y: 579},
"29E": {x: 2288, y: 566},

//Koordinat F
"1F": {x: 166, y: 657},
"2F": {x: 239, y: 658},
"3F": {x: 313, y: 660},
"4F": {x: 395, y: 661},
"5F": {x: 462, y: 666},
"6F": {x: 550, y: 653},
"7F": {x: 619, y: 659},
"8F": {x: 702, y: 661},
"9F": {x: 773, y: 661},
"10F": {x: 857, y: 662},
"11F": {x: 924, y: 661},
"12F": {x: 1002, y: 661},
"13F": {x: 1088, y: 662},
"14F": {x: 1149, y: 649},
"15F": {x: 1231, y: 657},
"16F": {x: 1313, y: 657},
"17F": {x: 1374, y: 656},
"18F": {x: 1460, y: 651},
"19F": {x: 1540, y: 650},
"20F": {x: 1600, y: 652},
"21F": {x: 1680, y: 651},
"22F": {x: 1756, y: 656},
"23F": {x: 1838, y: 657},
"24F": {x: 1909, y: 655},
"25F": {x: 1985, y: 654},
"26F": {x: 2076, y: 657},
"27F": {x: 2138, y: 651},
"28F": {x: 2218, y: 667},
"29F": {x: 2288, y: 660},

//Koordinat G
"1G": {x: 170, y: 736},
"2G": {x: 239, y: 736},
"3G": {x: 323, y: 743},
"4G": {x: 386, y: 733},
"5G": {x: 468, y: 736},
"6G": {x: 546, y: 738},
"7G": {x: 619, y: 727},
"8G": {x: 699, y: 733},
"9G": {x: 777, y: 731},
"10G": {x: 844, y: 734},
"11G": {x: 928, y: 736},
"12G": {x: 998, y: 738},
"13G": {x: 1078, y: 731},
"14G": {x: 1153, y: 735},
"15G": {x: 1227, y: 738},
"16G": {x: 1296, y: 738},
"17G": {x: 1380, y: 741},
"18G": {x: 1449, y: 740},
"19G": {x: 1523, y: 733},
"20G": {x: 1607, y: 731},
"21G": {x: 1680, y: 731},
"22G": {x: 1754, y: 729},
"23G": {x: 1834, y: 729},
"24G": {x: 1909, y: 728},
"25G": {x: 1985, y: 734},
"26G": {x: 2059, y: 739},
"27G": {x: 2143, y: 735},
"28G": {x: 2216, y: 737},
"29G": {x: 2294, y: 739},

//Koordinat H
"1H": {x: 161, y: 810},
"2H": {x: 239, y: 814},
"3H": {x: 317, y: 818},
"4H": {x: 388, y: 817},
"5H": {x: 468, y: 808},
"6H": {x: 542, y: 817},
"7H": {x: 619, y: 816},
"8H": {x: 695, y: 821},
"9H": {x: 771, y: 816},
"10H": {x: 846, y: 816},
"11H": {x: 928, y: 809},
"12H": {x: 998, y: 817},
"13H": {x: 1071, y: 816},
"14H": {x: 1155, y: 818},
"15H": {x: 1222, y: 821},
"16H": {x: 1298, y: 806},
"17H": {x: 1376, y: 814},
"18H": {x: 1456, y: 811},
"19H": {x: 1533, y: 820},
"20H": {x: 1607, y: 821},
"21H": {x: 1685, y: 820},
"22H": {x: 1762, y: 815},
"23H": {x: 1836, y: 818},
"24H": {x: 1916, y: 818},
"25H": {x: 1985, y: 816},
"26H": {x: 2065, y: 812},
"27H": {x: 2138, y: 820},
"28H": {x: 2210, y: 816},
"29H": {x: 2294, y: 817},

//Koordinat I
"1I": {x: 168, y: 888},
"2I": {x: 232, y: 892},
"3I": {x: 312, y: 890},
"4I": {x: 388, y: 888},
"5I": {x: 465, y: 899},
"6I": {x: 536, y: 890},
"7I": {x: 620, y: 899},
"8I": {x: 687, y: 905},
"9I": {x: 771, y: 890},
"10I": {x: 841, y: 892},
"11I": {x: 922, y: 901},
"12I": {x: 998, y: 903},
"13I": {x: 1067, y: 888},
"14I": {x: 1153, y: 886},
"15I": {x: 1222, y: 897},
"16I": {x: 1293, y: 901},
"17I": {x: 1382, y: 892},
"18I": {x: 1457, y: 899},
"19I": {x: 1529, y: 886},
"20I": {x: 1608, y: 907},
"21I": {x: 1673, y: 895},
"22I": {x: 1762, y: 907},
"23I": {x: 1835, y: 901},
"24I": {x: 1910, y: 893},
"25I": {x: 1986, y: 898},
"26I": {x: 2061, y: 894},
"27I": {x: 2128, y: 897},
"28I": {x: 2217, y: 884},
"29I": {x: 2286, y: 893},

//Koordint J
    "1J": { "x": 163, "y": 962 },
    "2J": { "x": 241, "y": 960 },
    "3J": { "x": 312, "y": 970 },
    "4J": { "x": 388, "y": 970 },
    "5J": { "x": 463, "y": 964 },
    "6J": { "x": 539, "y": 968 },
    "7J": { "x": 616, "y": 968 },
    "8J": { "x": 692, "y": 968 },
    "9J": { "x": 767, "y": 962 },
    "10J": { "x": 845, "y": 964 },
    "11J": { "x": 925, "y": 970 },
    "12J": { "x": 994, "y": 967 },
    "13J": { "x": 1076, "y": 970 },
    "14J": { "x": 1153, "y": 962 },
    "15J": { "x": 1231, "y": 966 },
    "16J": { "x": 1304, "y": 966 },
    "17J": { "x": 1373, "y": 958 },
    "18J": { "x": 1455, "y": 962 },
    "19J": { "x": 1533, "y": 957 },
    "20J": { "x": 1608, "y": 971 },
    "21J": { "x": 1686, "y": 977 },
    "22J": { "x": 1757, "y": 969 },
    "23J": { "x": 1833, "y": 967 },
    "24J": { "x": 1904, "y": 961 },
    "25J": { "x": 1984, "y": 967 },
    "26J": { "x": 2055, "y": 966 },
    "27J": { "x": 2135, "y": 965 },
    "28J": { "x": 2214, "y": 967 },
    "29J": { "x": 2296, "y": 965 },

//Koordninat K
    "1K": { "x": 161, "y": 1049 },
    "2K": { "x": 232, "y": 1040 },
    "3K": { "x": 314, "y": 1047 },
    "4K": { "x": 383, "y": 1036 },
    "5K": { "x": 459, "y": 1034 },
    "6K": { "x": 536, "y": 1046 },
    "7K": { "x": 614, "y": 1044 },
    "8K": { "x": 685, "y": 1046 },
    "9K": { "x": 765, "y": 1044 },
    "10K": { "x": 838, "y": 1048 },
    "11K": { "x": 918, "y": 1046 },
    "12K": { "x": 998, "y": 1045 },
    "13K": { "x": 1067, "y": 1045 },
    "14K": { "x": 1147, "y": 1045 },
    "15K": { "x": 1224, "y": 1051 },
    "16K": { "x": 1309, "y": 1041 },
    "17K": { "x": 1378, "y": 1047 },
    "18K": { "x": 1455, "y": 1046 },
    "19K": { "x": 1526, "y": 1041 },
    "20K": { "x": 1608, "y": 1042 },
    "21K": { "x": 1684, "y": 1049 },
    "22K": { "x": 1757, "y": 1050 },
    "23K": { "x": 1831, "y": 1053 },
    "24K": { "x": 1910, "y": 1044 },
    "25K": { "x": 1986, "y": 1042 },
    "26K": { "x": 2066, "y": 1044 },
    "27K": { "x": 2139, "y": 1044 },
    "28K": { "x": 2214, "y": 1049 },
    "29K": { "x": 2288, "y": 1036 }

        };
        document.getElementById('locationSelect').addEventListener('change', function() {
            const selectedLocation = this.value;
            if (selectedLocation) {
                placePoint(selectedLocation);
            }
        });

        function placePoint(location) {
            const pointsContainer = document.getElementById('pointsContainer');
            const gridImage = document.getElementById('gridImage');

            // Menghitung skala gambar saat ini
            const imgRect = gridImage.getBoundingClientRect();
            const scaleX = imgRect.width / gridImage.naturalWidth;
            const scaleY = imgRect.height / gridImage.naturalHeight;

            // Bersihkan container sebelumnya
            pointsContainer.innerHTML = '';

            if (coordinateMap.hasOwnProperty(location)) {
                const coords = coordinateMap[location];
                
                // Mengubah koordinat asli ke koordinat yang sesuai dengan skala gambar saat ini
                const xPos = coords.x * scaleX;
                const yPos = coords.y * scaleY;

                // Membuat elemen titik
                const point = document.createElement('div');
                point.classList.add('point');
                point.style.backgroundColor = 'red';
                point.style.left = `${xPos}px`;
                point.style.top = `${yPos}px`;

                // Menambahkan titik ke container
                pointsContainer.appendChild(point);
            }
        }
    </script>
</body>
</html>
