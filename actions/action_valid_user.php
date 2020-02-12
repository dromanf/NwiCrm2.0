<?php 
//session_start();

$errors = array();

if (isset($_POST['InputUserLogin']) and isset($_POST['InputPasswordLogin'])) {
	# code...
	include('action_core.php');
	$usuario = mysqli_real_escape_string($connect,$_POST['InputUserLogin']);
	$contrasena = mysqli_real_escape_string($connect,$_POST['InputPasswordLogin']);

	$query = 'SELECT * FROM db_user_act WHERE Username="'.$usuario.'" ';	
	$res = $connect->query($query);

	if ($row = mysqli_fetch_array($res)) {
		# code...
		if ($row["Password"] == $contrasena) {
            # code...
            $_SESSION["ID"] = $row['ID'];
			$_SESSION["Username"] = $row['Username'];
			$_SESSION["Password"] = $row['Password'];
			$_SESSION["Name"]= $row['Name'];
			$_SESSION["Lastname_Paternal"]= $row['Lastname_Paternal'];
			$_SESSION["Role"]= $row['Role'];
			$_SESSION["Email"]= $row['Email'];
			$_SESSION["Active"]= $row['Active'];

			header('Location: ../views/fronts/index.php');
		}else{

			echo "<script  languaje=’javascript’>alert('La contraseña ingresada no es correcta, favor rectifique la informacion e intente el ingreso nuevamente');window.location='../login.php'</script>";

		}

	}else{
		echo "<script  languaje=’javascript’>alert('El nombre ingresado no se encuentra registrado, coloquese en contacto con el administrador del sistema para mas informacion');window.location='../login.php'</script>";
	}
	mysqli_free_result($res);

}else{
	header('Location: ../login.php');
}



mysqli_close($connect);

?>
