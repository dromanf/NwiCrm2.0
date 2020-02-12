<?php include ('../../actions/action_core.php'); ?>
<?php include ('../../bots/bot_security.php'); ?>
<?php include ("../particles/navbar.php")?>
<?php include ("../particles/sidebar.php")?>
<?php include ("../particles/footer.php")?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tabla de postulantes - Niwali CRM</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="../../assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="../../assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- data table -->
    <link rel="stylesheet" type="text/css" href="../../assets/dtbl/DataTables-1.10.20/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/dtbl/Responsive-2.2.3/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/dtbl/SearchPanes-1.0.1/css/searchPanes.dataTables.min.css" />
    <!-- end data table -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php echo $navBar; ?>
      
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar"> 
          <?php echo $menu; ?>          
        </nav>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Postulantes para personal</h4>
                    <table id="example" class="table table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nombre</th>
                          <th>Apellido Paterno</th>
                          <th>Apellido Materno</th>
                          <th>CI</th>
                          <th>Celular</th>
                          <th>Reclutador(a)</th>
                          <th>Acciones</th>                          
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>Nombre</th>
                          <th>Apellido Paterno</th>
                          <th>Apellido Materno</th>
                          <th>CI</th>
                          <th>Celular</th>
                          <th>Reclutador(a)</th>
                          <th>Acciones</th>
                        </tr>
                      </tfoot>
                    <tbody>
                      <?php 
                      $sql= "SELECT * from sales";
                      $result=mysqli_query($mysqli,$sql);

                      while($mostrar=mysqli_fetch_array($result)){  
                      ?>
                      <tr>
                      <td class="py-1"><?php echo $mostrar['id'] ?></td>
                      <td class="py-1"><?php echo $mostrar['name_client'] ?></td>
                      <td class="py-1"><?php echo $mostrar['procesadora'] ?></td>
                      <td class="py-1"><?php echo $mostrar['status'] ?></td>
                      <td class="py-1"><?php echo $mostrar['price'] ?></td>
                      <td class="py-1"><?php echo $mostrar['re_order'] ?></td>
                      <td class="py-1"><?php echo $mostrar['suffering']; ?></td>
                      <td class="py-1"><?php
                        echo '<a href="../../actions/action_edit_user_3_pos.php?nik='.$mostrar['id'].'" title="Editar datos" class="btn btn-primary btn-sm"><i class="fa-pencil-square-o" style="color: whithe;"></i></a>';
                      }                      
                      ?>
                      
                          </td>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- Page Title Header Ends-->
          </div>
          
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <?php echo $footer; ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/vendors/js/vendor.bundle.addons.js"></script>
    <script src="../../assets/vendors/chart.js/Chart.min.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="../../assets/js/shared/off-canvas.js"></script>
    <script src="../../assets/js/shared/misc.js"></script>
    <script type="text/javascript" src="../../assets/dtbl/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../assets/dtbl/Responsive-2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="../../assets/dtbl/SearchPanes-1.0.1/js/dataTables.searchPanes.min.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../../assets/js/demo_1/dashboard.js"></script>
    <!-- End custom js for this page-->
  </body>
</html>