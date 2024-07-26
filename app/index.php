<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
if(!$_SESSION['nama']){
  header('Location: ../');
}
include('header.php');
include('../conf/config.php');

// Definisikan base URL
$base_url = "http://localhost:8080/AngkasaPura/app/";
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <?php include('preloader.php');?>

  <!-- Navbar -->
  <?php include('navbar.php');?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php include('logo.php');?>

    <!-- Sidebar -->
    <?php include('sidebar.php');?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include('contentHeader.php');?>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php 
    if (isset($_GET['page'])) {
        // Sanitize the page parameter to prevent directory traversal attacks
        $page = basename($_GET['page']);

        switch ($page) {
            case 'dashboard':
                include('dashboard.php');
                break;
            case 'data-insiden':
                include('data_insiden.php');
                break;
            case 'data-maskapai':
                include('data_maskapai.php');
                break;
            case 'edit-data':
                include('edit/edit_data.php');
                break;
            case 'edit-data-maskapai':
                include('edit/edit_maskapai.php');
                break;
            case 'location':
                include('coordinates.php');
                break;
            case 'data-user':
                include('data_user.php');
                break;
            case 'edit-user':
                include('edit/edit_user.php');
                break;
            case 'profil-user':
                include('profil_user.php');
                break;
            default:
                include('dashboard.php');
                break;
        }
    } else {
        include('dashboard.php');
    }
    ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('footer.php');?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</body>
</html>
