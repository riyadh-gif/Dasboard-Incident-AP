<?php
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM tb_maskapai WHERE id='$id'");
    $view = mysqli_fetch_array($query);
?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Data</h3>
            </div>
            <!-- /.card-header -->
            <form method='get' action='update/update_maskapai.php'>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Flight Number</label>
                                <input type="text" class="form-control" placeholder="Flight Number" name="maskapai" value="<?php echo $view['maskapai']; ?>">
                                <input type="text" class="form-control" placeholder="id" name="id" value="<?php echo $view['id']; ?>" hidden>
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
