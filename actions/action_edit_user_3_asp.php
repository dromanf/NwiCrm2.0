<?php require_once 'action_core.php'; ?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php echo '<title>Editar usuario numero: '.$_GET["nik"].'</title>';?>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="../assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="../assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"> 
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="../assets/images/favicon.png" />
  </head>
  <body>
  <?php		
  ini_set('date.timezone', 'America/Caracas');
  // escaping, additionally removing everything that could be (html/javascript-) code
  $nik = mysqli_real_escape_string($connect,(strip_tags($_GET["nik"],ENT_QUOTES)));
  $sql = mysqli_query($connect, "SELECT * FROM db_human_talent WHERE id='$nik'"); 
  if(mysqli_num_rows($sql) == 0){
	var_dump($sql);
	die();
	  header("Location: ../views/fronts/table_users_3_pos.php");
  }else{
	  $row = mysqli_fetch_assoc($sql);
  }
  if(isset($_POST['modificar'])){
		  $Name	 							            = mysqli_real_escape_string($connect,(strip_tags($_POST["Name"],ENT_QUOTES)));//Escanpando caracteres 
		  $Lastname_Paternal				      = mysqli_real_escape_string($connect,(strip_tags($_POST["Lastname_Paternal"],ENT_QUOTES)));//Escanpando caracteres 
		  $Lastname_Maternal				      = mysqli_real_escape_string($connect,(strip_tags($_POST["Lastname_Maternal"],ENT_QUOTES)));//Escanpando caracteres 
		  $CI		 						              = mysqli_real_escape_string($connect,(strip_tags($_POST["CI"],ENT_QUOTES)));//Escanpando caracteres 
		  $Age                            = mysqli_real_escape_string($connect,(strip_tags($_POST["Age"],ENT_QUOTES)));//Escanpando caracteres 
		  $Address	     					        = mysqli_real_escape_string($connect,(strip_tags($_POST["Address"],ENT_QUOTES)));//Escanpando caracteres 
		  $Date_Of_Birth	    			      = mysqli_real_escape_string($connect,(strip_tags($_POST["Date_Of_Birth"],ENT_QUOTES)));//Escanpando caracteres 
		  $Phone_Cell	     				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Phone_Cell"],ENT_QUOTES)));//Escanpando caracteres 
		  $Phone_Hab	    				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Phone_Hab"],ENT_QUOTES)));//Escanpando caracteres 
		  $Email	   						          = mysqli_real_escape_string($connect,(strip_tags($_POST["Email"],ENT_QUOTES)));//Escanpando caracteres 
		  $Recruiter	     				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Recruiter"],ENT_QUOTES)));//Escanpando caracteres 
		  $Management	    				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Management"],ENT_QUOTES)));//Escanpando caracteres 
		  $Appointment	     				      = mysqli_real_escape_string($connect,(strip_tags($_POST["Appointment"],ENT_QUOTES)));//Escanpando caracteres 
		  $Time_Appointment	    			    = mysqli_real_escape_string($connect,(strip_tags($_POST["Time_Appointment"],ENT_QUOTES)));//Escanpando caracteres 
		  $Medium	   						          = mysqli_real_escape_string($connect,(strip_tags($_POST["Medium"],ENT_QUOTES)));//Escanpando caracteres 
		  $Assistance	     				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Assistance"],ENT_QUOTES)));//Escanpando caracteres 
		  $Work_Turn	     				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Work_Turn"],ENT_QUOTES)));//Escanpando caracteres 
		  $Recruitmen_Source				      = mysqli_real_escape_string($connect,(strip_tags($_POST["Recruitmen_Source"],ENT_QUOTES)));//Escanpando caracteres 
      $Recruitmen_Analyst	     		    = mysqli_real_escape_string($connect,(strip_tags($_POST["Recruitmen_Analyst"],ENT_QUOTES)));//Escanpando caracteres 
		  $Experience_Time_In_Sales	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["Experience_Time_In_Sales"],ENT_QUOTES)));//Escanpando caracteres 
		  $Experience_Time_In_Call_Center	= mysqli_real_escape_string($connect,(strip_tags($_POST["Experience_Time_In_Call_Center"],ENT_QUOTES)));//Escanpando caracteres 
		  $Pretensions	    			      	= mysqli_real_escape_string($connect,(strip_tags($_POST["Pretensions"],ENT_QUOTES)));//Escanpando caracteres 
		  $Status	     				          	= mysqli_real_escape_string($connect,(strip_tags($_POST["Status"],ENT_QUOTES)));//Escanpando caracteres 

		  $update = mysqli_query($connect, "UPDATE db_human_talent SET Name='$Name', Lastname_Maternal='$Lastname_Maternal', Lastname_Paternal='$Lastname_Paternal', CI='$CI', Age='$Age', Address='$Address', Date_Of_Birth='$Name', Phone_Cell='$Phone_Cell', Phone_Hab='$Phone_Hab', Email='$Email', Recruiter='$Recruiter', Management='$Management', Appointment='$Appointment', Time_Appointment='$Time_Appointment', Medium='$Medium', Assistance='$Assistance', Work_Turn='$Work_Turn', Recruitmen_Source='$Recruitmen_Source', Recruitmen_Analyst='$Recruitmen_Analyst', Experience_Time_In_Sales='$Experience_Time_In_Sales', Experience_Time_In_Call_Center='$Experience_Time_In_Call_Center', Pretensions='$Pretensions', Status='$Status' WHERE id='$nik'") or die(mysqli_error());
		  if($update){
		  header("Location: ../views/fronts/table_users_3_pos.php");
	  }else{
		  echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
	  }
  }
  if(isset($_POST['etiquetar'])){
    $Name	 							            = mysqli_real_escape_string($connect,(strip_tags($_POST["Name"],ENT_QUOTES)));//Escanpando caracteres 
    $Lastname_Paternal				      = mysqli_real_escape_string($connect,(strip_tags($_POST["Lastname_Paternal"],ENT_QUOTES)));//Escanpando caracteres 
    $Lastname_Maternal				      = mysqli_real_escape_string($connect,(strip_tags($_POST["Lastname_Maternal"],ENT_QUOTES)));//Escanpando caracteres 
    $CI		 						              = mysqli_real_escape_string($connect,(strip_tags($_POST["CI"],ENT_QUOTES)));//Escanpando caracteres 
    $Age                            = mysqli_real_escape_string($connect,(strip_tags($_POST["Age"],ENT_QUOTES)));//Escanpando caracteres 
    $Address	     					        = mysqli_real_escape_string($connect,(strip_tags($_POST["Address"],ENT_QUOTES)));//Escanpando caracteres 
    $Date_Of_Birth	    			      = mysqli_real_escape_string($connect,(strip_tags($_POST["Date_Of_Birth"],ENT_QUOTES)));//Escanpando caracteres 
    $Phone_Cell	     				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Phone_Cell"],ENT_QUOTES)));//Escanpando caracteres 
    $Phone_Hab	    				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Phone_Hab"],ENT_QUOTES)));//Escanpando caracteres 
    $Email	   						          = mysqli_real_escape_string($connect,(strip_tags($_POST["Email"],ENT_QUOTES)));//Escanpando caracteres 
    $Recruiter	     				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Recruiter"],ENT_QUOTES)));//Escanpando caracteres 
    $Management	    				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Management"],ENT_QUOTES)));//Escanpando caracteres 
    $Appointment	     				      = mysqli_real_escape_string($connect,(strip_tags($_POST["Appointment"],ENT_QUOTES)));//Escanpando caracteres 
    $Time_Appointment	    			    = mysqli_real_escape_string($connect,(strip_tags($_POST["Time_Appointment"],ENT_QUOTES)));//Escanpando caracteres 
    $Medium	   						          = mysqli_real_escape_string($connect,(strip_tags($_POST["Medium"],ENT_QUOTES)));//Escanpando caracteres 
    $Assistance	     				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Assistance"],ENT_QUOTES)));//Escanpando caracteres 
    $Work_Turn	     				        = mysqli_real_escape_string($connect,(strip_tags($_POST["Work_Turn"],ENT_QUOTES)));//Escanpando caracteres 
    $Recruitmen_Source				      = mysqli_real_escape_string($connect,(strip_tags($_POST["Recruitmen_Source"],ENT_QUOTES)));//Escanpando caracteres 
    $Recruitmen_Analyst	     		    = mysqli_real_escape_string($connect,(strip_tags($_POST["Recruitmen_Analyst"],ENT_QUOTES)));//Escanpando caracteres 
    $Experience_Time_In_Sales	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["Experience_Time_In_Sales"],ENT_QUOTES)));//Escanpando caracteres 
    $Experience_Time_In_Call_Center	= mysqli_real_escape_string($connect,(strip_tags($_POST["Experience_Time_In_Call_Center"],ENT_QUOTES)));//Escanpando caracteres 
    $Pretensions	    			      	= mysqli_real_escape_string($connect,(strip_tags($_POST["Pretensions"],ENT_QUOTES)));//Escanpando caracteres 
    $Status = "Activo";

    $update = mysqli_query($connect, "UPDATE db_human_talent SET Name='$Name', Lastname_Maternal='$Lastname_Maternal', Lastname_Paternal='$Lastname_Paternal', CI='$CI', Age='$Age', Address='$Address', Date_Of_Birth='$Name', Phone_Cell='$Phone_Cell', Phone_Hab='$Phone_Hab', Email='$Email', Recruiter='$Recruiter', Management='$Management', Appointment='$Appointment', Time_Appointment='$Time_Appointment', Medium='$Medium', Assistance='$Assistance', Work_Turn='$Work_Turn', Recruitmen_Source='$Recruitmen_Source', Recruitmen_Analyst='$Recruitmen_Analyst', Experience_Time_In_Sales='$Experience_Time_In_Sales', Experience_Time_In_Call_Center='$Experience_Time_In_Call_Center', Pretensions='$Pretensions', Status='$Status' WHERE id='$nik'") or die(mysqli_error());
    if($update){
    header("Location: ../views/fronts/table_users_3_con.php");
  }else{
    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
  }
}
?>
   <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <h2 class="text-center mb-4">Datos del postulante</h2>
              <div class="auto-form-wrapper">
                <form id="submitUsertForm" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="ID" placeholder="ID" value="<?php echo $row ['ID']; ?>" readonly="readonly">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Name" placeholder="Nombre(s)" value="<?php echo $row ['Name']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				          <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Lastname_Paternal" placeholder="Apellido Paterno" value="<?php echo $row ['Lastname_Paternal']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Lastname_Maternal" placeholder="Apellido Materno" value="<?php echo $row ['Lastname_Maternal']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="CI" placeholder="Cedula" value="<?php echo $row ['CI']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Age" placeholder="Edad" value="<?php echo $row ['Age']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Address" placeholder="Direccion" value="<?php echo $row ['Address']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Date_Of_Birth" placeholder="Fecha de nacimiento" value="<?php echo $row ['Date_Of_Birth']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Phone_Cell" placeholder="Telefono celular" value="<?php echo $row ['Phone_Cell']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Phone_Hab" placeholder="Telefono alternativo" value="<?php echo $row ['Phone_Hab']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Email" placeholder="Correo electronico" value="<?php echo $row ['Email']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Recruiter" placeholder="Reclutadora" value="<?php echo $row ['Recruiter']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Management" placeholder="Gestion" value="<?php echo $row ['Management']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Appointment" placeholder="Cita" value="<?php echo $row ['Appointment']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Time_Appointment" placeholder="Hora de la cita" value="<?php echo $row ['Time_Appointment']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Medium" placeholder="Medio" value="<?php echo $row ['Medium']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Assistance" placeholder="Asistencia" value="<?php echo $row ['Assistance']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Work_Turn" placeholder="Turno de trabajo" value="<?php echo $row ['Work_Turn']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Recruitmen_Source" placeholder="Fuente de reclutamiento" value="<?php echo $row ['Recruitmen_Source']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Recruitmen_Analyst" placeholder="Analista de reclutamiento" value="<?php echo $row ['Recruitmen_Analyst']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Experience_Time_In_Sales" placeholder="Tiempo de experiencia en ventas" value="<?php echo $row ['Experience_Time_In_Sales']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Experience_Time_In_Call_Center" placeholder="Tiempo de experiencia en call centers" value="<?php echo $row ['Experience_Time_In_Call_Center']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Pretensions" placeholder="Pretenciones" value="<?php echo $row ['Pretensions']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="Status" placeholder="Status actual" value="<?php echo $row ['Status']; ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
				          </div>
                  <div class="form-group">
				            <input type="submit" name="etiquetar" class="btn btn-success submit-btn btn-block" value="Aprobar formacion">						
                    <input type="submit" name="modificar" class="btn btn-primary submit-btn btn-block" value="Modificar">						
                  </div>
                  <div class="text-block text-center my-3">
                    <span class="text-small font-weight-semibold"></span>
                    <a href="../views/fronts/table_users_3_pos.php" class="text-black text-small">Regresar</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
		</div>		
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../assets/js/shared/off-canvas.js"></script>
    <script src="../assets/js/shared/misc.js"></script>
    <!-- endinject -->
  </body>  
</html>