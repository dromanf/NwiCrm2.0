<?php include_once ('../actions/core.php');?>
<?php include ('../bots/bot-security-seconds.php'); ?>  
<?php if($_SESSION['cargo'] == 7 OR $_SESSION['cargo'] >= 2){}else{header('Location: ../index.php');}?>
<?php include_once ('../views/menus/menu-nav-second.php'); ?>  
<?php include_once ('../views/modals/modal-report-export.php'); ?>
<?php include ('../views/modals/modal-logout.php'); ?>         
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Ordenes retornando</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
  <IMG class="logo" src="../img/crm-logo.svg" style="width: 10%; margin-left: 10px;">
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars" style="margin-left: 25px;"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
      <a class="navbar-brand mr-1" href="../index.php">Bienvenido Sr(a) <?php echo $_SESSION['inputUserLogin'];?></a>
      <div class="input-group-append"> >
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <?php echo $navBar; ?>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
          
       <?php if ($_SESSION['cargo'] == 1) {
			          			# code...
          echo  $menuAgente;
       }else{}
        if ($_SESSION['cargo'] == 2) {
         # code...
         echo  $menuSupervisor;
        }else{}
          if ($_SESSION['cargo'] == 3) {
          # code...
          echo  $menuVerificador;
        }else{}
          if ($_SESSION['cargo'] == 4) {
          # code...
          echo  $menuValidador;
        }else{}
          if ($_SESSION['cargo'] == 5) {
          # code...           
        }else{}
          if ($_SESSION['cargo'] == 6) {
          # code...          
        }else{}
          if ($_SESSION['cargo'] == 7) {
          # code...
          echo  $menuErr;
        }else{}
          if ($_SESSION['cargo'] == 8) {
          # code...
          echo  $menuGerente;
        }else{}
          if ($_SESSION['cargo'] == 9) {
          # code...
          echo  $menuAdministrador;
        }
           
?>      

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="../index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>


<div id="content-wrapper">

<div class="container-fluid">



  <!-- DataTables Example -->
  
  <div class="card mb-3">
    <div class="card-header"><i class="fas fa-table"></i> Ordenes retornando</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Nº</th>
              <th>Agente</th>
              <th>Cliente</th>
              <th>Monto</th>
              <th>Tipo de pago</th>
              <th>Status</th>
              <th>Fecha Add</th>
              <th>Tracking</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nº</th>
              <th>Cliente</th>
              <th>Agente</th>
              <th>Monto</th>
              <th>Tipo de pago</th>
              <th>Status</th>
              <th>Fecha Add</th>
              <th>Tracking</th>
              <th>Acciones</th>
            </tr>
          </tfoot>
          <tbody>
<?php 
$sql= "SELECT * from sales where status = 'Retornando' ORDER BY date_add ASC";
$result=mysqli_query($mysqli,$sql);

while($mostrar=mysqli_fetch_array($result)){  
?>
<tr>
<td><?php echo $mostrar['id'] ?></td>
<td><?php echo $mostrar['agent'] ?></td>
<td><?php echo $mostrar['name_client'] ?></td>
<td><?php echo $mostrar['price'] ?></td>
<td><?php echo $mostrar['payment_type'] ?></td>
<td><?php echo $mostrar['status'] ?></td>
<td><?php echo $mostrar['date_add']; ?></td>
<td><a href="https://tools.usps.com/go/TrackConfirmAction.action?tLabels=<?php echo $mostrar ['tracking_number']; ?>" target="blank"><?php echo $mostrar ['tracking_number']; ?></a></td>
<td><?php
echo '<a href="../actions/action-edit-order-return.php?nik='.$mostrar['id'].'" title="Editar datos" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>';
}
?>
</td>
</tr>
          </tbody> 
        </table>
      </div>
    </div>
    <div class="card-footer small text-muted">Ultima actualización <?php $fecha = date('d/m/Y'); echo $fecha;?></div>
  </div>

  <p class="small text-center text-muted my-5">
    <em></em>
  </p>

</div>

<!-- Sticky Footer -->
<footer class="sticky-footer">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright © Niwali 2019</span>
    </div>
  </div>
</footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php echo $modalLogout; ?>

  <!-- Report Modal-->
  <?php
  if ($_SESSION['cargo'] == 9) {
          # code...
          echo  $modalReport;
        }           
?> 

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../js/demo/datatables-demo.js"></script>
  <script src="../js/demo/chart-area-demo.js"></script>

</body>

</html>