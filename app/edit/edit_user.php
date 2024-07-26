<?php
include('../conf/config.php');

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE id='$id'");
$view = mysqli_fetch_array($query);
?>
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Edit Data</h3>
      </div>
      <form method='post' action='update/update_user.php'>
        <div class="card-body">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Nama</label>
                <input type="text" class="form-control" placeholder="Nama" name="nama" value="<?php echo $view['nama']; ?>" required>
                <input type="hidden" class="form-control" name="id" value="<?php echo $view['id']; ?>">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>NIP</label>
                <input type="text" class="form-control" placeholder="NIP" name="nip" required value="<?php echo $view['nip']; ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Password (leave blank if not changing)</label>
                <input type="password" class="form-control" placeholder="Password" name="password">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Session User</label>
                <select class="form-control" name="unit" required>
                  <option value="">Select Session</option>
                  <option value="Admin" <?php echo ($view['unit'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                  <option value="User" <?php echo ($view['unit'] == 'User') ? 'selected' : ''; ?>>User</option>
                </select>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-sm btn-info">Save</button>
        </div>
      </form>
    </div>
  </div>
</section>
