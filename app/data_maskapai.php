<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Input Maskapai</h3>
          </div>
          <div class="card-body">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">Input Data</button>
            <br><br>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal Kejadian</th>
                  <th>Lokasi</th>
                  <th>Maskapai</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                $query = mysqli_query($koneksi,"SELECT * FROM tb_maskapai");
                while($maskapai = mysqli_fetch_array($query)){
                    $no++;
                    ?>
                <tr>
                  <td width='5%'><?php echo $no; ?></td>
                  <td><?php echo $maskapai['tanggal']; ?></td>
                  <td><?php echo $maskapai['lokasi']; ?></td>
                  <td><?php echo $maskapai['maskapai']; ?></td>
                  <td>
                    <a onclick="hapus_data(<?php echo $maskapai['id'];?>)" class="btn btn-sm btn-danger">Delete</a>
                    <a onclick="edit_data(<?php echo $maskapai['id']; ?>)" class="btn btn-sm btn-success">Edit Data</a>
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

<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Input Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="get" action="add/tambah_maskapai.php">
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
  let lastFlightNumber = '';
  let lastLocation = '';

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
            <input type="text" class="form-control" placeholder="Flight Number" name="maskapai[]" value="${existingData.maskapai[i] || existingData.maskapai[previousIndex] || lastFlightNumber}" required autocomplete="off">
          </div>
          <div class="col">
            <input type="date" class="form-control" name="tanggal[]" value="${existingData.tanggal[i] || new Date().toISOString().split('T')[0]}" required autocomplete="off">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="Coordinate" name="lokasi[]" value="${existingData.lokasi[i] || existingData.lokasi[previousIndex] || lastLocation}" required autocomplete="off">
          </div>
        </div>
      `;
      inputRows.insertAdjacentHTML('beforeend', rowHtml);
    }

    addCopyPasteListeners(); // Add listeners for the new rows
  }

  function getInputData() {
    const maskapaiInputs = document.querySelectorAll('input[name="maskapai[]"]');
    const tanggalInputs = document.querySelectorAll('input[name="tanggal[]"]');
    const lokasiInputs = document.querySelectorAll('input[name="lokasi[]"]');
    
    return {
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

  // Fetch the last flight number and last location from the server and set them as the default values
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
      window.location = ("delete/hapus_data_maskapai.php?id=" + data_id);
    } else if (result.isDenied) {
      Swal.fire("Changes are not saved", "", "info");
    }
  });
}

function edit_data(data_id) {
  window.location = ("index.php?page=edit-data-maskapai&id=" + data_id);
}
</script>
