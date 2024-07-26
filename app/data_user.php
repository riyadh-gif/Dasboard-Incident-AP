<?php
include('../conf/config.php');
?>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Input User</h3>
          </div>
          <div class="card-body">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">Input Data</button>
            <br><br>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NIP</th>
                  <th>Password</th>
                  <th>Session User</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM tb_user");
                while ($user = mysqli_fetch_array($query)) {
                    ?>
                <tr>
                  <td width='5%'><?php echo $no++; ?></td>
                  <td><?php echo $user['nama']; ?></td>
                  <td><?php echo $user['nip']; ?></td>
                  <td><?php echo $user['password']; ?></td>
                  <td><?php echo $user['unit']; ?></td>
                  <td>
                    <button onclick="hapus_data(<?php echo $user['id']; ?>)" class="btn btn-sm btn-danger">Delete</button>
                    <button onclick="edit_data(<?php echo $user['id']; ?>)" class="btn btn-sm btn-success">Edit Data</button>
                  </td>
                </tr>
                <?php } ?>
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
      <form method="post" action="add/tambah_user.php" id="userForm">
        <div class="modal-body">
          <div id="errorMessages" class="alert alert-danger" style="display:none;"></div>
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
  const errorMessages = document.getElementById('errorMessages');

  numRowsInput.addEventListener('change', updateInputRows);
  updateInputRows(); // Initial call to set the default rows

  function updateInputRows() {
    const numRows = parseInt(numRowsInput.value);
    const currentRows = inputRows.querySelectorAll('.form-row');

    const values = Array.from(currentRows).map(row => {
      return {
        nama: row.querySelector('input[name="nama[]"]').value,
        nip: row.querySelector('input[name="nip[]"]').value,
        password: row.querySelector('input[name="password[]"]').value,
        unit: row.querySelector('select[name="unit[]"]').value
      };
    });

    inputRows.innerHTML = '';

    for (let i = 0; i < numRows; i++) {
      const value = values[i] || {};
      const prevUnit = (i > 0 && values[i - 1]) ? values[i - 1].unit : '';

      const rowHtml = `
        <div class="form-row">
          <div class="col">
            <input type="text" class="form-control" placeholder="Nama" name="nama[]" value="${value.nama || ''}" required autocomplete="off">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="NIP" name="nip[]" value="${value.nip || ''}" required autocomplete="off">
          </div>
          <div class="col">
            <input type="password" class="form-control" placeholder="Password" name="password[]" value="${value.password || ''}" required autocomplete="off">
          </div>
          <div class="col">
            <select class="form-control" name="unit[]" required>
              <option value="">Select Session</option>
              <option value="Admin" ${value.unit === 'Admin' || (!value.unit && prevUnit === 'Admin') ? 'selected' : ''}>Admin</option>
              <option value="User" ${value.unit === 'User' || (!value.unit && prevUnit === 'User') ? 'selected' : ''}>User</option>
            </select>
          </div>
        </div>
      `;
      inputRows.insertAdjacentHTML('beforeend', rowHtml);
    }
  }

  window.hapus_data = function(id) {
    Swal.fire({
      title: "Apakah Anda Ingin Menghapus Data Ini?",
      showCancelButton: true,
      confirmButtonText: "Delete",
      confirmButtonColor: 'red'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `delete/hapus_user.php?id=${id}`;
      } else if (result.isDenied) {
        Swal.fire("Changes are not saved", "", "info");
      }
    });
  }

  window.edit_data = function(id) {
    window.location.href = `index.php?page=edit-user&id=${id}`;
  }

  function highlightDuplicates(nips) {
    const nipArray = nips.split(',');
    nipArray.forEach(nip => {
      const nipInputs = document.querySelectorAll('input[name="nip[]"]');
      nipInputs.forEach(input => {
        if (input.value === nip) {
          input.classList.add('is-invalid');
        }
      });
    });
  }

  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('error') && urlParams.get('error') === 'nip_exists') {
    const nips = urlParams.get('nips');
    errorMessages.textContent = `The following NIPs already exist: ${nips}`;
    errorMessages.style.display = 'block';
    highlightDuplicates(nips);
  }
});
</script>
