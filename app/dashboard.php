<?php
// File: index.php

include("../conf/config.php");

// Ambil tanggal yang dipilih pengguna atau gunakan tanggal hari ini sebagai default
$selectedDate = isset($_GET['selected_date']) ? $_GET['selected_date'] : date('Y-m-d');

// Filter data berdasarkan tanggal yang dipilih
$queryKorban = mysqli_query($koneksi, "SELECT count(id) AS jmlkorban FROM tb_korban WHERE DATE(tanggal) = '$selectedDate'");
$viewKorban = mysqli_fetch_array($queryKorban);

$queryKondisi = mysqli_query($koneksi, "SELECT kondisi, COUNT(*) AS jumlah FROM tb_korban WHERE DATE(tanggal) = '$selectedDate' GROUP BY kondisi");
$dataKondisi = array();
while ($row = mysqli_fetch_assoc($queryKondisi)) {
    $dataKondisi[$row['kondisi']] = $row['jumlah'];
}

$queryMaskapai = mysqli_query($koneksi, "SELECT maskapai FROM tb_korban WHERE DATE(tanggal) = '$selectedDate' ORDER BY id DESC LIMIT 1");
$viewMaskapai = mysqli_fetch_array($queryMaskapai);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
  <style>
    .row > .col-lg-3.col-6 {
      padding-left: 7px;
      padding-right: 7px;
    }

    .small-box {
      margin-bottom: 7px;
    }
    #date-input-form {
      display: none;
    }
  </style>
</head>
<body>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3 style="font-size: 31px;"><?php echo $viewKorban['jmlkorban']; ?><sup style="font-size: 20px"></sup></h3>
            <p>Jumlah Korban</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-injured"></i>
          </div>
          <a href="#" class="small-box-footer" data-target="details.php?type=korban">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
          <h4 style="font-size: 31px;"><?php echo isset($viewMaskapai['maskapai']) ? $viewMaskapai['maskapai'] : 'N/A'; ?><sup style="font-size: 20px"></sup></h4>
          <p>Flight Number</p>
          </div>
          <div class="icon">
            <i class="ion ion-plane"></i>
          </div>
          <a href="#" class="small-box-footer" data-target="details.php?type=maskapai">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3 style="font-size: 31px;"><?php echo $selectedDate; ?><sup style="font-size: 20px"></sup></h3>
            <p>Date</p>
          </div>
          <div class="icon">
            <i class="ion ion-calendar"></i>
          </div>
          <a href="#" class="small-box-footer" data-target="details.php?type=date" id="date-more-info">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
  <div class="small-box bg-danger">
    <div class="inner">
        <h3 style="font-size: 31px;">New Tab Click<sup style="font-size: 20px"></sup></h3>
        <p>Location</p>
    </div>
    <div class="icon">
        <i class="ion ion-map"></i>
    </div>
    <a href="http://localhost:8080/AngkasaPura/app/index.php?page=location" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>




<div class="row" id="date-input-form">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Select Date</h3>
      </div>
      <div class="card-body">
        <form action="index.php" method="get">
          <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="selected_date" class="form-control" required value="<?php echo $selectedDate; ?>">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

    </div>
  </div>
</section>

<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Pie Chart</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
  <div class="card-body">
    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
  </div>
</div>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoModalLabel">More Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
<script>
  $(document).ready(function() {
    var pieData = {
      labels: <?php echo json_encode(array_keys($dataKondisi)); ?>,
      datasets: [{
        data: <?php echo json_encode(array_values($dataKondisi)); ?>,
        backgroundColor: ['#ff0047', '#000000', '#3cb371', '#ffa500', '#3c8dbc', '#d2d6de'],
      }]
    };

    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
    };

    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    });

    $('#pieChart').click(function(evt) {
      var activePoint = pieChart.getElementAtEvent(evt);
      if (activePoint.length > 0) {
        var clickedElementIndex = activePoint[0]._index;
        var condition = pieChart.data.labels[clickedElementIndex];
        console.log('Clicked Element Index:', clickedElementIndex); // Debugging
        console.log('Condition:', condition); // Debugging
        $.ajax({
          url: 'details.php',
          method: 'GET',
          data: { type: 'condition', condition: condition },
          success: function(response) {
            $('#infoModal .modal-body').html(response);
            $('#infoModal').modal('show');
          },
          error: function() {
            $('#infoModal .modal-body').html('<p>An error has occurred</p>');
            $('#infoModal').modal('show');
          }
        });
      }
    });

    $('#date-more-info').click(function(event) {
      event.preventDefault();
      $('#date-input-form').toggle();
    });

    $('.small-box-footer').not('#date-more-info').click(function(event) {
      event.preventDefault();
      var target = $(this).data('target');
      $.ajax({
        url: target,
        method: 'GET',
        success: function(response) {
          $('#infoModal .modal-body').html(response);
          $('#infoModal').modal('show');
        },
        error: function() {
          $('#infoModal .modal-body').html('<p>An error has occurred</p>');
          $('#infoModal').modal('show');
        }
      });
    });
  });
</script>

</body>
</html>
