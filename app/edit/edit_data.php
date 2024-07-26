<?php
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM tb_korban WHERE id='$id'");
    $view = mysqli_fetch_array($query);
?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Data</h3>
            </div>
            <!-- /.card-header -->
            <form method='get' action='update/update_data.php'>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" name="nama" value="<?php echo $view['nama']; ?>">
                                <input type="text" class="form-control" placeholder="id" name="id" value="<?php echo $view['id']; ?>" hidden>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Condition</label>
                                <select class="custom-select" id="inputGroupSelect01" name="kondisi">
                                <option value="meninggal" <?php if ($view['kondisi'] == 'meninggal') echo 'selected'; ?>>Meninggal</option>
                                <option value="Ringan" <?php if ($view['kondisi'] == 'Ringan') echo 'selected'; ?>>Luka Ringan</option>
                                <option value="Berat" <?php if ($view['kondisi'] == 'Berat') echo 'selected'; ?>>Luka Berat</option>
                                <option value="Sedang" <?php if ($view['kondisi'] == 'Sedang') echo 'selected'; ?>>Luka Sedang</option>
                            </select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Hospital</label>
                                <select class="custom-select" id="inputGroupSelect02" name="rumah_sakit">
                                    <option value="">Pilih Rumah Sakit</option> <!-- Default option -->
                                    <?php
                                    $rumah_sakit_options = [
                                        "Rumkital dr. Soekantyo Jahja Lanudal",
                                        "RSUD DR. Soetomo Surabaya",
                                        "RSUD R.T Notopuro Sidoarjo",
                                        "RS. Darmo Surabaya",
                                        "RS. Delta Surya Sidoarjo",
                                        "RS. Mitra Keluarga Waru",
                                        "RS. Sheila Medika",
                                        "RS. Bunda Wadungasri",
                                        "RS. Islam Siti Hajar Sidoarjo",
                                        "Puskesmas Sedati",
                                        "RS. Bhayangkara Polda Jawa Timur"
                                    ];

                                    // Loop through options and generate <option> tags
                                    foreach ($rumah_sakit_options as $option) {
                                        $selected = ($view['rumah_sakit'] == $option) ? 'selected' : ''; // Check if current option is selected
                                        echo "<option value=\"$option\" $selected>$option</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" class="form-control" placeholder="Date" name="tanggal" required value="<?php echo $view['tanggal']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Flight Number</label>
                                <input type="text" class="form-control" placeholder="Flight Number" name="maskapai" value="<?php echo $view['maskapai']; ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Coordinate</label>
                                <input type="text" class="form-control" placeholder="Coordinate" name="lokasi" value="<?php echo $view['lokasi']; ?>">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </div>
                <!-- /.card-body -->
            </form>
        </div>
    </div>
</section>
