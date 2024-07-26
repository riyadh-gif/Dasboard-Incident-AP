<?php
// data_insiden.php

include '../conf/config.php';

// Fetch the maskapai and lokasi data for today
$date_today = date('Y-m-d');
$query = "SELECT maskapai, lokasi FROM tb_maskapai WHERE tanggal = '$date_today'";
$result = mysqli_query($koneksi, $query);

$maskapai_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $maskapai_data[] = $row;
}

// Menambahkan pemeriksaan apakah ada data yang diperoleh
if (!empty($maskapai_data)) {
    $latest_maskapai = end($maskapai_data)['maskapai'];
    $latest_lokasi = end($maskapai_data)['lokasi'];
} else {
    $latest_maskapai = null;
    $latest_lokasi = null;
}

// Lanjutkan kode dengan memeriksa nilai $latest_maskapai dan $latest_lokasi
?>


<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Input Korban</h3>
          </div>
          <div class="card-body">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">Input Data</button>
            <br><br>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Kondisi</th>
                  <th>Rumah Sakit Rujukan</th>
                  <th>Tanggal Kejadian</th>
                  <th>Lokasi</th>
                  <th>Maskapai</th>
                  <th>ACTION</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                $query = mysqli_query($koneksi,"SELECT * FROM tb_korban");
                while($korban = mysqli_fetch_array($query)){
                    $no++;
                    ?>
                <tr>
                  <td width='5%'><?php echo $no; ?></td>
                  <td><?php echo $korban['nama']; ?></td>
                  <td><?php echo $korban['kondisi']; ?></td>
                  <td><?php echo $korban['rumah_sakit']; ?></td>
                  <td><?php echo $korban['tanggal']; ?></td>
                  <td><?php echo $korban['lokasi']; ?></td>
                  <td><?php echo $korban['maskapai']; ?></td>
                  <td>
                    <a onclick="hapus_data(<?php echo $korban['id'];?>)" class="btn btn-sm btn-danger">Delete</a>
                    <a href="index.php?page=edit-data&id=<?php echo $korban['id']; ?>" class="btn btn-sm btn-success">Edit Data</a>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal for input data -->
<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Input Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="add/tambah_data.php">
        <div class="modal-body">
          <div class="form-group">
            <label for="numRows">Number of Rows</label>
            <input type="number" class="form-control" id="numRows" name="numRows" value="1" min="1" max="10" required autocomplete="off">
          </div>
          <div id="inputRows">
            <!-- Dynamic input rows will be appended here -->
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
 document.addEventListener('DOMContentLoaded', function() {
  const numRowsInput = document.getElementById('numRows');
  const inputRows = document.getElementById('inputRows');
  let maskapaiData = <?php echo json_encode($maskapai_data); ?>;
  let latestMaskapai = '<?php echo $latest_maskapai; ?>';
  let latestLokasi = '<?php echo $latest_lokasi; ?>';

  numRowsInput.addEventListener('change', updateInputRows);
  updateInputRows(); // Initial call to set the default rows

  function updateInputRows() {
    const numRows = parseInt(numRowsInput.value);
    const existingData = getInputData();
    inputRows.innerHTML = ''; // Clear existing rows

    for (let i = 0; i < numRows; i++) {
      const previousIndex = i > 0 ? i - 1 : 0;
      const rowHtml = `
        <div class="form-row">
          <div class="col">
            <input type="text" class="form-control" placeholder="Name" name="nama[]" value="${existingData.nama[i] || ''}" required autocomplete="off">
          </div>
          <div class="col">
            <select class="custom-select" name="kondisi[]" required>
              <option value="" disabled ${!existingData.kondisi[i] ? 'selected' : ''}>Condition</option>
              <option value="meninggal" ${existingData.kondisi[i] === 'meninggal' ? 'selected' : ''}>Meninggal</option>
              <option value="Ringan" ${existingData.kondisi[i] === 'Ringan' ? 'selected' : ''}>Luka Ringan</option>
              <option value="Berat" ${existingData.kondisi[i] === 'Berat' ? 'selected' : ''}>Luka Berat</option>
              <option value="Sedang" ${existingData.kondisi[i] === 'Sedang' ? 'selected' : ''}>Luka Sedang</option>
            </select>
          </div>
          <div class="col">
            <select class="custom-select" name="rumah_sakit[]" required>
              <option value="" disabled ${!existingData.rumah_sakit[i] ? 'selected' : ''}>Hospital</option>
              <option value="Rumkital dr. Soekantyo Jahja Lanudal" ${existingData.rumah_sakit[i] === 'Rumkital dr. Soekantyo Jahja Lanudal' ? 'selected' : ''}>Rumkital dr. Soekantyo Jahja Lanudal</option>
              <option value="RSUD DR. Soetomo Surabaya" ${existingData.rumah_sakit[i] === 'RSUD DR. Soetomo Surabaya' ? 'selected' : ''}>RSUD DR. Soetomo Surabaya</option>
              <option value="RSUD R.T Notopuro Sidoarjo" ${existingData.rumah_sakit[i] === 'RSUD R.T Notopuro Sidoarjo' ? 'selected' : ''}>RSUD R.T Notopuro Sidoarjo</option>
              <option value="RS. Darmo Surabaya" ${existingData.rumah_sakit[i] === 'RS. Darmo Surabaya' ? 'selected' : ''}>RS. Darmo Surabaya</option>
              <option value="RS. Delta Surya Sidoarjo" ${existingData.rumah_sakit[i] === 'RS. Delta Surya Sidoarjo' ? 'selected' : ''}>RS. Delta Surya Sidoarjo</option>
              <option value="RS. Mitra Keluarga Waru" ${existingData.rumah_sakit[i] === 'RS. Mitra Keluarga Waru' ? 'selected' : ''}>RS. Mitra Keluarga Waru</option>
              <option value="RS. Sheila Medika" ${existingData.rumah_sakit[i] === 'RS. Sheila Medika' ? 'selected' : ''}>RS. Sheila Medika</option>
              <option value="RS. Bunda Wadungasri" ${existingData.rumah_sakit[i] === 'RS. Bunda Wadungasri' ? 'selected' : ''}>RS. Bunda Wadungasri</option>
              <option value="RS. Islam Siti Hajar Sidoarjo" ${existingData.rumah_sakit[i] === 'RS. Islam Siti Hajar Sidoarjo' ? 'selected' : ''}>RS. Islam Siti Hajar Sidoarjo</option>
              <option value="Puskesmas Sedati" ${existingData.rumah_sakit[i] === 'Puskesmas Sedati' ? 'selected' : ''}>Puskesmas Sedati</option>
              <option value="RS. Bhayangkara Polda Jawa Timur" ${existingData.rumah_sakit[i] === 'RS. Bhayangkara Polda Jawa Timur' ? 'selected' : ''}>RS. Bhayangkara Polda Jawa Timur</option>
            </select>
          </div>
          <div class="col">
            <select class="custom-select" name="maskapai[]" required>
              ${getOptionsHtml('maskapai', existingData.maskapai[i], previousIndex, latestMaskapai)}
            </select>
          </div>
          <div class="col">
            <input type="date" class="form-control" name="tanggal[]" value="${existingData.tanggal[i] || new Date().toISOString().split('T')[0]}" required autocomplete="off">
          </div>
          <div class="col">
            <select class="custom-select" name="lokasi[]" required>
              ${getOptionsHtml('lokasi', existingData.lokasi[i], previousIndex, latestLokasi)}
            </select>
          </div>
        </div>
      `;
      inputRows.insertAdjacentHTML('beforeend', rowHtml);
    }

    addCopyPasteListeners(); // Add listeners for the new rows
  }

  function getInputData() {
    const namaInputs = document.querySelectorAll('input[name="nama[]"]');
    const kondisiInputs = document.querySelectorAll('select[name="kondisi[]"]');
    const rumahSakitInputs = document.querySelectorAll('select[name="rumah_sakit[]"]');
    const maskapaiInputs = document.querySelectorAll('select[name="maskapai[]"]');
    const tanggalInputs = document.querySelectorAll('input[name="tanggal[]"]');
    const lokasiInputs = document.querySelectorAll('select[name="lokasi[]"]');
    
    return {
      nama: Array.from(namaInputs).map(input => input.value),
      kondisi: Array.from(kondisiInputs).map(input => input.value),
      rumah_sakit: Array.from(rumahSakitInputs).map(input => input.value),
      maskapai: Array.from(maskapaiInputs).map(input => input.value),
      tanggal: Array.from(tanggalInputs).map(input => input.value),
      lokasi: Array.from(lokasiInputs).map(input => input.value),
    };
  }

  function addCopyPasteListeners() {
    const inputs = document.querySelectorAll('input, select');
    
    inputs.forEach(input => {
      input.addEventListener('copy', (event) => {
        input.classList.add('copied');
        setTimeout(() => input.classList.remove('copied'), 2000); // Remove class after 2 seconds
      });

      input.addEventListener('paste', (event) => {
        input.classList.add('pasted');
        setTimeout(() => input.classList.remove('pasted'), 2000); // Remove class after 2 seconds
      });
    });
  }

  function getOptionsHtml(type, value, previousIndex, latestValue) {
    let optionsHtml = `<option value="" disabled ${!value ? 'selected' : ''}>Select an option</option>`;
    for (let i = 0; i < maskapaiData.length; i++) {
      const selected = maskapaiData[i][type] === value || (!value && maskapaiData[i][type] === latestValue) ? 'selected' : '';
      optionsHtml += `<option value="${maskapaiData[i][type]}" ${selected}>${maskapaiData[i][type]}</option>`;
    }
    return optionsHtml;
  }

  fetch('get_last_flight_number.php')
    .then(response => response.text())
    .then(lastFlightNumberFromServer => {
      lastFlightNumber = lastFlightNumberFromServer;
      return fetch('get_last_location.php');
    })
    .then(response => response.text())
    .then(lastLocationFromServer => {
      lastLocation = lastLocationFromServer;
      updateInputRows(); // Initial update after fetching the last flight number and location
    });
});

function hapus_data(data_id) {
  Swal.fire({
    title: "Apakah Anda Ingin Menghapus Data Ini?",
    showCancelButton: true,
    confirmButtonText: "Delete",
    confirmButtonColor: 'red'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = ("delete/hapus_data.php?id=" + data_id);
    } else if (result.isDenied) {
      Swal.fire("Changes are not saved", "", "info");
    }
  });
}
</script>
