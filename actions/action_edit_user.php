<?php
include ("core.php");
include ("../views/menus/menu-change-nav.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de empleados</title>

	<!-- Bootstrap -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/bootstrap-datepicker.css" rel="stylesheet">
	<link href="../css/style_nav.css" rel="stylesheet">
	<style>
		.content {
			margin-top: 80px;
		}
	</style>
	
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php echo $empleadosNav;?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos del empleados &raquo; Editar datos</h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($connect,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($connect, "SELECT * FROM user WHERE id='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: ./views/index-table-user.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){
				$username	 = mysqli_real_escape_string($connect,(strip_tags($_POST["username"],ENT_QUOTES)));//Escanpando caracteres 
				$nombre		 = mysqli_real_escape_string($connect,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
				$apellido	 = mysqli_real_escape_string($connect,(strip_tags($_POST["apellido"],ENT_QUOTES)));//Escanpando caracteres 
				$rol		 = mysqli_real_escape_string($connect,(strip_tags($_POST["rol"],ENT_QUOTES)));//Escanpando caracteres 
				$activo	     = mysqli_real_escape_string($connect,(strip_tags($_POST["activo"],ENT_QUOTES)));//Escanpando caracteres 
				/*$telefono		 = mysqli_real_escape_string($connect,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
				$puesto		 = mysqli_real_escape_string($connect,(strip_tags($_POST["puesto"],ENT_QUOTES)));//Escanpando caracteres 
				$estado			 = mysqli_real_escape_string($connect,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres  */
				
				$update = mysqli_query($connect, "UPDATE user SET username='$username', nombre='$nombre', apellido='$apellido', rol='$rol', activo='$activo' WHERE id='$nik'") or die(mysqli_error());
				if($update){
					header("Location: action-edit-user.php?nik=".$nik."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}
			
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			}
			?>
			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label">ID</label>
					<div class="col-sm-2">
						<input type="text" name="ID" value="<?php echo $row ['id']; ?>" class="form-control" placeholder="NIK" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">username</label>
					<div class="col-sm-4">
						<input type="text" name="username" value="<?php echo $row ['username']; ?>" class="form-control" placeholder="username" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-4">
						<input type="text" name="nombre" value="<?php echo $row ['nombre']; ?>" class="form-control" placeholder="Nombre" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Apellido</label>
					<div class="col-sm-4">
						<input type="text" name="apellido" value="<?php echo $row ['apellido']; ?>" class="form-control" placeholder="apellido" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Cargo</label>
					<div class="col-sm-4">
					<select class="form-control" id="rol" name="rol" style="width: 250px;" required="required">
                                        <option value="">Cargo?</option>
                                        <?php															   
                        $query = $mysqli -> query ("SELECT * FROM cargo where activo = 1 AND rol <> 8 AND rol <> 9");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option id="rol" value="'.$valores['rol'].'">'.$valores['cargo'].'</option>';
                        }
                      ?>
                                    </select>
				</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Activo</label>
					<div class="col-sm-3">
					<?php if ($row['activo']==1){
					echo'<select class="form-control" id="activo" name="activo" style="width: 250px;" required="required">
						<option value=1>Activo</option>
						<option value=2>No activo</option>
						</select>';
						}else{
						echo'<select>
						<option value=2>No activo</option>
						<option value=1>Activo</option>
						</select>';
						}?>
					</div>
				</div>
							
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="save" class="btn btn-sm btn-success" value="Guardar datos">
						<a href="../views/index-table-user.php" class="btn btn-sm btn-primary">Regresar</a>
					</div>
				</div>
			</form>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
	$('.date').datepicker({
		format: 'dd-mm-yyyy',
	})
	</script>
</body>
</html>