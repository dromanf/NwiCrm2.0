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
	<title>Datos del User</title>

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
			<h2>Datos del Usuario &raquo; Perfil</h2>
			<hr />
			
            <?php
			$nik = mysqli_real_escape_string($connect,(strip_tags($_GET["nik"],ENT_QUOTES)));
            $sql = mysqli_query($connect, "SELECT * FROM user WHERE id='$nik'");
            if(mysqli_num_rows($sql) == 0){
				header("Location: ../views/index-table-user.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){
				$username	 = mysqli_real_escape_string($connect,(strip_tags($_POST["username"],ENT_QUOTES)));//Escanpando caracteres 
				$nombre		 = mysqli_real_escape_string($connect,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
				$apellido	 = mysqli_real_escape_string($connect,(strip_tags($_POST["apellido"],ENT_QUOTES)));//Escanpando caracteres 
				$rol		 = mysqli_real_escape_string($connect,(strip_tags($_POST["rol"],ENT_QUOTES)));//Escanpando caracteres 
				$activo	     = mysqli_real_escape_string($connect,(strip_tags($_POST["activo"],ENT_QUOTES)));//Escanpando caracteres 
				
				$update = mysqli_query($connect, "UPDATE user SET username='$username', nombre='$nombre', apellido='$apellido', rol='$rol', activo='$activo' WHERE id='$nik'") or die(mysqli_error());
				if($update){
					header("Location: action-edit-user.php?nik=".$nik."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}?>
			
			<table class="table table-striped table-condensed">
				<tr>
					<th width="20%">N#</th>
					<td><?php echo $row['id']; ?></td>
				</tr>
				<tr>
					<th>Nombre</th>
					<td><?php echo $row['nombre']; ?></td>
				</tr>
				<tr>
					<th>Apellido</th>
					<td><?php echo $row['apellido']; ?></td>
				</tr>
				<tr>
					<th>Cargo</th>
					<td><?php $sqlrole= "SELECT * FROM cargo WHERE rol = {$row['rol']}";
								$resultado=mysqli_query($mysqli,$sqlrole);
								$resultado=mysqli_query($mysqli,$sqlrole);
								$mostrar=mysqli_fetch_assoc($resultado);
								echo $mostrar['cargo'];
								?></td>
				</tr>
				<tr>
					<th>Fecha de incio</th>
					<td><?php echo $row['fecha_create']; ?></td>
				</tr>				
				<tr>
					<th>Ventas enviadas</th>
					<td>
					<?php 	$sqlA = "SELECT COUNT(*) from sales where status = 'Verificada' and 'agente' = {$row['username']}";
								$queryA = $connect->query($sqlA);								
								$countSalesUserVer = $queryA->num_rows;
								echo $countSalesUserVer;
						?>
					</td>
					</tr>
				<tr>
					<th>Ventas aprobadas</th>
					<td>
					<?php 	$sqlD = "SELECT * FROM `sales` where `status` = 'Validada' AND `agente` = {$row['username']}";
								$queryD = $connect->query($sqlD);
								$countSalesUserVer = $queryD->num_rows;
								echo $countSalesUserVer;
						?>
					</td>
					</tr>
				<tr>
					<th>Ventas canceladas</th>
					<td>
		<?php 	$sqlD = "SELECT * FROM `sales` where status = 'Cancelada' and status = {$row['username']}";
								$queryD = $connect->query($sqlD);
								$countSalesUserVer = $queryD->num_rows;
								echo $countSalesUserVer;
						?>
					</td>
				</tr>
				
			</table>
			
			<a href="../views/index-table-user.php" class="btn btn-sm btn-primary"><i class="fas fa-share"></i> Regresar</a>
			</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>