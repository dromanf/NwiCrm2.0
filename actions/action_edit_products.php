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
	<title>Datos de productos</title>

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
		<?php echo $productosNav;?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos del producto &raquo; Editar producto</h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($connect,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($connect, "SELECT * FROM products WHERE id='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: ./views/index-table-products.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){
				$nombre	 = mysqli_real_escape_string($connect,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
				$peso	 = mysqli_real_escape_string($connect,(strip_tags($_POST["weight"],ENT_QUOTES)));//Escanpando caracteres 
				$costo	 = mysqli_real_escape_string($connect,(strip_tags($_POST["cost"],ENT_QUOTES)));//Escanpando caracteres 
				$activo		 = mysqli_real_escape_string($connect,(strip_tags($_POST["activo"],ENT_QUOTES)));//Escanpando caracteres 
				$fechaCreate	 = mysqli_real_escape_string($connect,(strip_tags($_POST["fecha_create"],ENT_QUOTES)));//Escanpando caracteres 
				$fechaEdit		 = mysqli_real_escape_string($connect,(strip_tags($_POST["fecha_edit"],ENT_QUOTES)));//Escanpando caracteres 
				$fechaEditNow = date('y/m/d');
				$update = mysqli_query($connect, "UPDATE products SET nombre='$nombre', weight='$peso', cost='$costo', activo='$activo', fecha_edit='$fechaEditNow;' WHERE id='$nik'") or die(mysqli_error());
				if($update){
					header("Location: action-edit-products.php?nik=".$nik."&pesan=sukses");
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
						<input type="text" name="ID" value="<?php echo $row ['id']; ?>" class="form-control" placeholder="Num#" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-4">
						<input type="text" name="nombre" value="<?php echo $row ['nombre']; ?>" class="form-control" placeholder="Nombre del producto" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Peso del producto</label>
					<div class="col-sm-4">
						<input type="text" name="weight" value="<?php echo $row ['weight']; ?>" class="form-control" placeholder="Peso del producto" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Costo del producto</label>
					<div class="col-sm-4">
						<input type="text" name="cost" value="<?php echo $row ['cost']; ?>" class="form-control" placeholder="Nombre del producto" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Fecha de creación</label>
					<div class="col-sm-4">
						<input type="date" name="fechaCreate" value="<?php echo $row ['fecha_create']; ?>" class="form-control" placeholder="Fecha de creación" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Ultima fecha de modificación</label>
					<div class="col-sm-4">
						<input type="date" name="fechaCreate" value="<?php echo $row ['fecha_edit']; ?>" class="form-control" placeholder="Fecha de creación" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Activo</label>
					<div class="col-sm-3">
					<select class="form-control" title="1 es activo y 0 es inactivo" name="activo" style="width: 250px;" required="required">
						<option value="">Activo?</option>
						<option value="1">Si</option>
						<option value="0">No</option>
					</select>
					</div>
				</div>
							
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="save" class="btn btn-sm btn-success" value="Guardar datos">
						<a href="../views/index-table-products.php" class="btn btn-sm btn-primary">Regresar</a>
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