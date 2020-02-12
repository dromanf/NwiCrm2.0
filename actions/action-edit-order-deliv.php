<?php
include ("core.php");
include ("../views/menus/menu-change-nav.php");
?>
<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Venta pendiente por confirmar pago</title>

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
		<?php echo $orderDelivNav;?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos de la orden &raquo; Editar datos</h2>
			<hr />
			
			<?php
			
			ini_set('date.timezone', 'America/Caracas');
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($connect,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($connect, "SELECT * FROM sales WHERE id='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: ../views/index-table-order-pent-deliv.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['etiquetar'])){
				$agente	 			= mysqli_real_escape_string($connect,(strip_tags($_POST["agente"],ENT_QUOTES)));//Escanpando caracteres 
					$nameClient		 	= mysqli_real_escape_string($connect,(strip_tags($_POST["nameClient"],ENT_QUOTES)));//Escanpando caracteres 
					$lastNameClient	 	= mysqli_real_escape_string($connect,(strip_tags($_POST["lastNameClient"],ENT_QUOTES)));//Escanpando caracteres 
					$phone		 		= mysqli_real_escape_string($connect,(strip_tags($_POST["phoneClient"],ENT_QUOTES)));//Escanpando caracteres 
					$phoneAlt	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["phoneAltClient"],ENT_QUOTES)));//Escanpando caracteres 
					$genClient	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["genderClient"],ENT_QUOTES)));//Escanpando caracteres 
					$ageClient	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["ageClient"],ENT_QUOTES)));//Escanpando caracteres 
					$direccion	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["dirClient"],ENT_QUOTES)));//Escanpando caracteres 
					$zipcode	    	= mysqli_real_escape_string($connect,(strip_tags($_POST["zipcodeClient"],ENT_QUOTES)));//Escanpando caracteres 
					$zipfour	   		= mysqli_real_escape_string($connect,(strip_tags($_POST["zip4Client"],ENT_QUOTES)));//Escanpando caracteres 
					$city	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["cityClient"],ENT_QUOTES)));//Escanpando caracteres 
					$state	    		= mysqli_real_escape_string($connect,(strip_tags($_POST["stateClient"],ENT_QUOTES)));//Escanpando caracteres 
					$payment	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["paymentTypeClient"],ENT_QUOTES)));//Escanpando caracteres 
					$cardProcess	    = mysqli_real_escape_string($connect,(strip_tags($_POST["cardProcess"],ENT_QUOTES)));//Escanpando caracteres 
					$comentPaymentOld	= mysqli_real_escape_string($connect,(strip_tags($_POST["comentPaymentOld"],ENT_QUOTES)));//Escanpando caracteres 
					$comentPaymentNew	= mysqli_real_escape_string($connect,(strip_tags($_POST["comentPayment"],ENT_QUOTES)));//Escanpando caracteres 
					$price	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["priceClient"],ENT_QUOTES)));//Escanpando caracteres 
					$reOrder	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["reOrderClient"],ENT_QUOTES)));//Escanpando caracteres 
					$productOne	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["product1"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyOne	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["qty1"],ENT_QUOTES)));//Escanpando caracteres 
					$productTwo	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["product2"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyTwo	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["qty2"],ENT_QUOTES)));//Escanpando caracteres 
					$productThree	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product3"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyThree	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty3"],ENT_QUOTES)));//Escanpando caracteres 
					$productFour	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product4"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyFour	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty4"],ENT_QUOTES)));//Escanpando caracteres 
					$productFive	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product5"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyFive	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty5"],ENT_QUOTES)));//Escanpando caracteres 
					$note	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["noteActual"],ENT_QUOTES)));//Escanpando caracteres 
					$noteComent	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["noteComentOld"],ENT_QUOTES)));//Escanpando caracteres 
					$fechaEdit	     	= date('y/m/d');
					$fechaEditcoment	= date('y/m/d h:m:s');
					$usuarioModif		= $_SESSION['inputUserLogin'];
					$coment 			= "(".$fechaEditcoment." -- ".$_SESSION['inputUserLogin'].") // ".$note." \n ".$noteComent;
					$comentPayment 		= "(".$fechaEditcoment." -- ".$_SESSION['inputUserLogin'].") // ".$comentPaymentNew." \n ".$comentPaymentOld;
					$status				= "Pago_Confirmado";

					$update = mysqli_query($connect, "UPDATE sales SET name_client='$nameClient', lastname_client='$lastNameClient', phone='$phone', phone_alt='$phoneAlt', gender='$genClient', age='$ageClient', address='$direccion', zip_code='$zipcode', zip_4='$zipfour', city='$city', state='$state', payment_type='$payment', procesadora='$cardProcess', coment_payment='$comentPayment', price='$price', re_order='$reOrder', coment='$coment', product1='$productOne',  qty1='$qtyOne', product2='$productTwo', qty2='$qtyTwo', product3='$productThree', qty3='$qtyThree', product4='$productFour', qty4='$qtyFour', product5='$productFive', qty5='$qtyFive', date_edit='$fechaEdit', status='$status', date_deliv='$fechaEdit', deliv_for='$usuarioModif' WHERE id='$nik'") or die(mysqli_error());
					if($update){
					header("Location: ../views/index-table-order-pent-deliv.php");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}	
			if(isset($_POST['retornate'])){
				$agente	 			= mysqli_real_escape_string($connect,(strip_tags($_POST["agente"],ENT_QUOTES)));//Escanpando caracteres 
					$nameClient		 	= mysqli_real_escape_string($connect,(strip_tags($_POST["nameClient"],ENT_QUOTES)));//Escanpando caracteres 
					$lastNameClient	 	= mysqli_real_escape_string($connect,(strip_tags($_POST["lastNameClient"],ENT_QUOTES)));//Escanpando caracteres 
					$phone		 		= mysqli_real_escape_string($connect,(strip_tags($_POST["phoneClient"],ENT_QUOTES)));//Escanpando caracteres 
					$phoneAlt	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["phoneAltClient"],ENT_QUOTES)));//Escanpando caracteres 
					$genClient	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["genderClient"],ENT_QUOTES)));//Escanpando caracteres 
					$ageClient	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["ageClient"],ENT_QUOTES)));//Escanpando caracteres 
					$direccion	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["dirClient"],ENT_QUOTES)));//Escanpando caracteres 
					$zipcode	    	= mysqli_real_escape_string($connect,(strip_tags($_POST["zipcodeClient"],ENT_QUOTES)));//Escanpando caracteres 
					$zipfour	   		= mysqli_real_escape_string($connect,(strip_tags($_POST["zip4Client"],ENT_QUOTES)));//Escanpando caracteres 
					$city	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["cityClient"],ENT_QUOTES)));//Escanpando caracteres 
					$state	    		= mysqli_real_escape_string($connect,(strip_tags($_POST["stateClient"],ENT_QUOTES)));//Escanpando caracteres 
					$payment	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["paymentTypeClient"],ENT_QUOTES)));//Escanpando caracteres 
					$cardProcess	    = mysqli_real_escape_string($connect,(strip_tags($_POST["cardProcess"],ENT_QUOTES)));//Escanpando caracteres 
					$comentPaymentOld	= mysqli_real_escape_string($connect,(strip_tags($_POST["comentPaymentOld"],ENT_QUOTES)));//Escanpando caracteres 
					$comentPaymentNew	= mysqli_real_escape_string($connect,(strip_tags($_POST["comentPayment"],ENT_QUOTES)));//Escanpando caracteres 
					$price	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["priceClient"],ENT_QUOTES)));//Escanpando caracteres 
					$reOrder	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["reOrderClient"],ENT_QUOTES)));//Escanpando caracteres 
					$productOne	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["product1"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyOne	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["qty1"],ENT_QUOTES)));//Escanpando caracteres 
					$productTwo	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["product2"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyTwo	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["qty2"],ENT_QUOTES)));//Escanpando caracteres 
					$productThree	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product3"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyThree	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty3"],ENT_QUOTES)));//Escanpando caracteres 
					$productFour	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product4"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyFour	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty4"],ENT_QUOTES)));//Escanpando caracteres 
					$productFive	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product5"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyFive	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty5"],ENT_QUOTES)));//Escanpando caracteres 
					$note	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["noteActual"],ENT_QUOTES)));//Escanpando caracteres 
					$noteComent	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["noteComentOld"],ENT_QUOTES)));//Escanpando caracteres 
					$fechaEdit	     	= date('y/m/d');
					$fechaEditcoment	= date('y/m/d h:m:s');
					$usuarioModif		= $_SESSION['inputUserLogin'];
					$coment 			= "(".$fechaEditcoment." -- ".$_SESSION['inputUserLogin'].") // ".$note." \n ".$noteComent;
					$comentPayment 		= "(".$fechaEditcoment." -- ".$_SESSION['inputUserLogin'].") // ".$comentPaymentNew." \n ".$comentPaymentOld;
					$status				= "Pendiente_Retorno";

					$update = mysqli_query($connect, "UPDATE sales SET name_client='$nameClient', lastname_client='$lastNameClient', phone='$phone', phone_alt='$phoneAlt', gender='$genClient', age='$ageClient', address='$direccion', zip_code='$zipcode', zip_4='$zipfour', city='$city', state='$state', payment_type='$payment', procesadora='$cardProcess', coment_payment='$comentPayment', price='$price', re_order='$reOrder', coment='$coment', product1='$productOne',  qty1='$qtyOne', product2='$productTwo', qty2='$qtyTwo', product3='$productThree', qty3='$qtyThree', product4='$productFour', qty4='$qtyFour', product5='$productFive', qty5='$qtyFive', date_edit='$fechaEdit', status='$status' WHERE id='$nik'") or die(mysqli_error());
					if($update){
					header("Location: ../views/index-table-order-pent-deliv.php");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}	
			if(isset($_POST['modificate'])){
				$agente	 			= mysqli_real_escape_string($connect,(strip_tags($_POST["agente"],ENT_QUOTES)));//Escanpando caracteres 
					$nameClient		 	= mysqli_real_escape_string($connect,(strip_tags($_POST["nameClient"],ENT_QUOTES)));//Escanpando caracteres 
					$lastNameClient	 	= mysqli_real_escape_string($connect,(strip_tags($_POST["lastNameClient"],ENT_QUOTES)));//Escanpando caracteres 
					$phone		 		= mysqli_real_escape_string($connect,(strip_tags($_POST["phoneClient"],ENT_QUOTES)));//Escanpando caracteres 
					$phoneAlt	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["phoneAltClient"],ENT_QUOTES)));//Escanpando caracteres 
					$genClient	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["genderClient"],ENT_QUOTES)));//Escanpando caracteres 
					$ageClient	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["ageClient"],ENT_QUOTES)));//Escanpando caracteres 
					$direccion	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["dirClient"],ENT_QUOTES)));//Escanpando caracteres 
					$zipcode	    	= mysqli_real_escape_string($connect,(strip_tags($_POST["zipcodeClient"],ENT_QUOTES)));//Escanpando caracteres 
					$zipfour	   		= mysqli_real_escape_string($connect,(strip_tags($_POST["zip4Client"],ENT_QUOTES)));//Escanpando caracteres 
					$city	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["cityClient"],ENT_QUOTES)));//Escanpando caracteres 
					$state	    		= mysqli_real_escape_string($connect,(strip_tags($_POST["stateClient"],ENT_QUOTES)));//Escanpando caracteres 
					$payment	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["paymentTypeClient"],ENT_QUOTES)));//Escanpando caracteres 
					$cardProcess	    = mysqli_real_escape_string($connect,(strip_tags($_POST["cardProcess"],ENT_QUOTES)));//Escanpando caracteres 
					$comentPaymentOld	= mysqli_real_escape_string($connect,(strip_tags($_POST["comentPaymentOld"],ENT_QUOTES)));//Escanpando caracteres 
					$comentPaymentNew	= mysqli_real_escape_string($connect,(strip_tags($_POST["comentPayment"],ENT_QUOTES)));//Escanpando caracteres 
					$price	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["priceClient"],ENT_QUOTES)));//Escanpando caracteres 
					$reOrder	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["reOrderClient"],ENT_QUOTES)));//Escanpando caracteres 
					$productOne	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["product1"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyOne	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["qty1"],ENT_QUOTES)));//Escanpando caracteres 
					$productTwo	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["product2"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyTwo	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["qty2"],ENT_QUOTES)));//Escanpando caracteres 
					$productThree	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product3"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyThree	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty3"],ENT_QUOTES)));//Escanpando caracteres 
					$productFour	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product4"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyFour	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty4"],ENT_QUOTES)));//Escanpando caracteres 
					$productFive	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product5"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyFive	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty5"],ENT_QUOTES)));//Escanpando caracteres 
					$note	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["noteActual"],ENT_QUOTES)));//Escanpando caracteres 
					$noteComent	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["noteComentOld"],ENT_QUOTES)));//Escanpando caracteres 
					$fechaEdit	     	= date('y/m/d');
					$fechaEditcoment	= date('y/m/d h:m:s');
					$usuarioModif		= $_SESSION['inputUserLogin'];
					$coment 			= "(".$fechaEditcoment." -- ".$_SESSION['inputUserLogin'].") // ".$note." \n ".$noteComent;
                    $comentPayment 		= "(".$fechaEditcoment." -- ".$_SESSION['inputUserLogin'].") // ".$comentPaymentNew." \n ".$comentPaymentOld;
                    
					$update = mysqli_query($connect, "UPDATE sales SET name_client='$nameClient', lastname_client='$lastNameClient', phone='$phone', phone_alt='$phoneAlt', gender='$genClient', age='$ageClient', address='$direccion', zip_code='$zipcode', zip_4='$zipfour', city='$city', state='$state', payment_type='$payment', procesadora='$cardProcess', coment_payment='$comentPayment', price='$price', re_order='$reOrder', coment='$coment', product1='$productOne',  qty1='$qtyOne', product2='$productTwo', qty2='$qtyTwo', product3='$productThree', qty3='$qtyThree', product4='$productFour', qty4='$qtyFour', product5='$productFive', qty5='$qtyFive', date_edit='$fechaEdit' WHERE id='$nik'") or die(mysqli_error());
					if($update){
						header("Location: action-edit-order-deliv.php?nik=".$nik."&pesan=sukses");
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
					}
				}
				if(isset($_POST['VolverStat'])){
					$agente	 			= mysqli_real_escape_string($connect,(strip_tags($_POST["agente"],ENT_QUOTES)));//Escanpando caracteres 
						$nameClient		 	= mysqli_real_escape_string($connect,(strip_tags($_POST["nameClient"],ENT_QUOTES)));//Escanpando caracteres 
						$lastNameClient	 	= mysqli_real_escape_string($connect,(strip_tags($_POST["lastNameClient"],ENT_QUOTES)));//Escanpando caracteres 
						$phone		 		= mysqli_real_escape_string($connect,(strip_tags($_POST["phoneClient"],ENT_QUOTES)));//Escanpando caracteres 
						$phoneAlt	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["phoneAltClient"],ENT_QUOTES)));//Escanpando caracteres 
						$genClient	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["genderClient"],ENT_QUOTES)));//Escanpando caracteres 
						$ageClient	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["ageClient"],ENT_QUOTES)));//Escanpando caracteres 
						$direccion	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["dirClient"],ENT_QUOTES)));//Escanpando caracteres 
						$zipcode	    	= mysqli_real_escape_string($connect,(strip_tags($_POST["zipcodeClient"],ENT_QUOTES)));//Escanpando caracteres 
						$zipfour	   		= mysqli_real_escape_string($connect,(strip_tags($_POST["zip4Client"],ENT_QUOTES)));//Escanpando caracteres 
						$city	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["cityClient"],ENT_QUOTES)));//Escanpando caracteres 
						$state	    		= mysqli_real_escape_string($connect,(strip_tags($_POST["stateClient"],ENT_QUOTES)));//Escanpando caracteres 
						$payment	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["paymentTypeClient"],ENT_QUOTES)));//Escanpando caracteres 
						$cardProcess	    = mysqli_real_escape_string($connect,(strip_tags($_POST["cardProcess"],ENT_QUOTES)));//Escanpando caracteres 
						$comentPaymentOld	= mysqli_real_escape_string($connect,(strip_tags($_POST["comentPaymentOld"],ENT_QUOTES)));//Escanpando caracteres 
						$comentPaymentNew	= mysqli_real_escape_string($connect,(strip_tags($_POST["comentPayment"],ENT_QUOTES)));//Escanpando caracteres 
						$price	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["priceClient"],ENT_QUOTES)));//Escanpando caracteres 
						$reOrder	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["reOrderClient"],ENT_QUOTES)));//Escanpando caracteres 
						$productOne	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["product1"],ENT_QUOTES)));//Escanpando caracteres 
						$qtyOne	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["qty1"],ENT_QUOTES)));//Escanpando caracteres 
						$productTwo	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["product2"],ENT_QUOTES)));//Escanpando caracteres 
						$qtyTwo	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["qty2"],ENT_QUOTES)));//Escanpando caracteres 
						$productThree	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product3"],ENT_QUOTES)));//Escanpando caracteres 
						$qtyThree	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty3"],ENT_QUOTES)));//Escanpando caracteres 
						$productFour	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product4"],ENT_QUOTES)));//Escanpando caracteres 
						$qtyFour	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty4"],ENT_QUOTES)));//Escanpando caracteres 
						$productFive	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product5"],ENT_QUOTES)));//Escanpando caracteres 
						$qtyFive	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty5"],ENT_QUOTES)));//Escanpando caracteres 
						$note	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["noteActual"],ENT_QUOTES)));//Escanpando caracteres 
						$noteComent	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["noteComentOld"],ENT_QUOTES)));//Escanpando caracteres 
						$fechaEdit	     	= date('y/m/d');
						$fechaEditcoment	= date('y/m/d h:m:s');
						$usuarioModif		= $_SESSION['inputUserLogin'];
						$coment 			= "(".$fechaEditcoment." -- ".$_SESSION['inputUserLogin'].") // ".$note." \n ".$noteComent;
						$comentPayment 		= "(".$fechaEditcoment." -- ".$_SESSION['inputUserLogin'].") // ".$comentPaymentNew." \n ".$comentPaymentOld;
						$status				= "Entregada";
	
						$update = mysqli_query($connect, "UPDATE sales SET name_client='$nameClient', lastname_client='$lastNameClient', phone='$phone', phone_alt='$phoneAlt', gender='$genClient', age='$ageClient', address='$direccion', zip_code='$zipcode', zip_4='$zipfour', city='$city', state='$state', payment_type='$payment', procesadora='$cardProcess', coment_payment='$comentPayment', price='$price', re_order='$reOrder', coment='$coment', product1='$productOne',  qty1='$qtyOne', product2='$productTwo', qty2='$qtyTwo', product3='$productThree', qty3='$qtyThree', product4='$productFour', qty4='$qtyFour', product5='$productFive', qty5='$qtyFive', date_edit='$fechaEdit', status='$status', date_cancel='$fechaEdit', cancel_for='$usuarioModif' WHERE id='$nik'") or die(mysqli_error());
						if($update){
						header("Location: ../views/index-table-order-postf.php");
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
					}
				}
			if(isset($_POST['reclamate'])){
				$agente	 			= mysqli_real_escape_string($connect,(strip_tags($_POST["agente"],ENT_QUOTES)));//Escanpando caracteres 
					$nameClient		 	= mysqli_real_escape_string($connect,(strip_tags($_POST["nameClient"],ENT_QUOTES)));//Escanpando caracteres 
					$lastNameClient	 	= mysqli_real_escape_string($connect,(strip_tags($_POST["lastNameClient"],ENT_QUOTES)));//Escanpando caracteres 
					$phone		 		= mysqli_real_escape_string($connect,(strip_tags($_POST["phoneClient"],ENT_QUOTES)));//Escanpando caracteres 
					$phoneAlt	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["phoneAltClient"],ENT_QUOTES)));//Escanpando caracteres 
					$genClient	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["genderClient"],ENT_QUOTES)));//Escanpando caracteres 
					$ageClient	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["ageClient"],ENT_QUOTES)));//Escanpando caracteres 
					$direccion	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["dirClient"],ENT_QUOTES)));//Escanpando caracteres 
					$zipcode	    	= mysqli_real_escape_string($connect,(strip_tags($_POST["zipcodeClient"],ENT_QUOTES)));//Escanpando caracteres 
					$zipfour	   		= mysqli_real_escape_string($connect,(strip_tags($_POST["zip4Client"],ENT_QUOTES)));//Escanpando caracteres 
					$city	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["cityClient"],ENT_QUOTES)));//Escanpando caracteres 
					$state	    		= mysqli_real_escape_string($connect,(strip_tags($_POST["stateClient"],ENT_QUOTES)));//Escanpando caracteres 
					$payment	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["paymentTypeClient"],ENT_QUOTES)));//Escanpando caracteres 
					$cardProcess	    = mysqli_real_escape_string($connect,(strip_tags($_POST["cardProcess"],ENT_QUOTES)));//Escanpando caracteres 
					$comentPaymentOld	= mysqli_real_escape_string($connect,(strip_tags($_POST["comentPaymentOld"],ENT_QUOTES)));//Escanpando caracteres 
					$comentPaymentNew	= mysqli_real_escape_string($connect,(strip_tags($_POST["comentPayment"],ENT_QUOTES)));//Escanpando caracteres 
					$price	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["priceClient"],ENT_QUOTES)));//Escanpando caracteres 
					$reOrder	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["reOrderClient"],ENT_QUOTES)));//Escanpando caracteres 
					$productOne	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["product1"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyOne	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["qty1"],ENT_QUOTES)));//Escanpando caracteres 
					$productTwo	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["product2"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyTwo	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["qty2"],ENT_QUOTES)));//Escanpando caracteres 
					$productThree	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product3"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyThree	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty3"],ENT_QUOTES)));//Escanpando caracteres 
					$productFour	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product4"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyFour	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty4"],ENT_QUOTES)));//Escanpando caracteres 
					$productFive	    = mysqli_real_escape_string($connect,(strip_tags($_POST["product5"],ENT_QUOTES)));//Escanpando caracteres 
					$qtyFive	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["qty5"],ENT_QUOTES)));//Escanpando caracteres 
					$note	     		= mysqli_real_escape_string($connect,(strip_tags($_POST["noteActual"],ENT_QUOTES)));//Escanpando caracteres 
					$noteComent	     	= mysqli_real_escape_string($connect,(strip_tags($_POST["noteComentOld"],ENT_QUOTES)));//Escanpando caracteres 
					$fechaEdit	     	= date('y/m/d');
					$fechaEditcoment	= date('y/m/d h:m:s');
					$usuarioModif		= $_SESSION['inputUserLogin'];
					$coment 			= "(".$fechaEditcoment." -- ".$_SESSION['inputUserLogin'].") // ".$note." \n ".$noteComent;
					$comentPayment 		= "(".$fechaEditcoment." -- ".$_SESSION['inputUserLogin'].") // ".$comentPaymentNew." \n ".$comentPaymentOld;
					$status				= "Pendiente_Reclamo_Pago";

					$update = mysqli_query($connect, "UPDATE sales SET name_client='$nameClient', lastname_client='$lastNameClient', phone='$phone', phone_alt='$phoneAlt', gender='$genClient', age='$ageClient', address='$direccion', zip_code='$zipcode', zip_4='$zipfour', city='$city', state='$state', payment_type='$payment', procesadora='$cardProcess', coment_payment='$comentPayment', price='$price', re_order='$reOrder', coment='$coment', product1='$productOne',  qty1='$qtyOne', product2='$productTwo', qty2='$qtyTwo', product3='$productThree', qty3='$qtyThree', product4='$productFour', qty4='$qtyFour', product5='$productFive', qty5='$qtyFive', date_edit='$fechaEdit', status='$status' WHERE id='$nik'") or die(mysqli_error());
					if($update){
					header("Location: ../views/index-table-order-pent-deliv.php");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}					
			
				if(isset($_POST['tracking'])){
					$orderNumber = $row['ship_order_number'];
					$goUrlApi = "https://ssapi.shipstation.com/shipments?orderNumber=".$orderNumber;

					$ch = curl_init();					
					curl_setopt($ch, CURLOPT_URL, $goUrlApi);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, FALSE);
					
					$entrada = 'MzQ2YTEzZDE3ODMyNGViOWIwZWE2OTM3MGQ1Mjk2OGQ6OGY1ZjgzMDMyYjFlNGU3NWFlNzg0YjNhMWIxYzk2MmM=';
														
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						"Content-Type: application/json",
						"Authorization: Basic $entrada",
							));
					
					$response = curl_exec($ch);
					curl_close($ch);
					
					$cadena = explode(",", $response);
					$array = explode(":", $cadena[10]);
					$arreglo = explode('"', $array[1]);
					$track = $arreglo[1];
					$update = mysqli_query($connect, "UPDATE sales SET tracking_number='$track' WHERE id='$nik'") or die(mysqli_error());
					if($update){
						header("Location: action-edit-order-deliv.php?nik=".$nik."&pesan=sukses");
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
					}
				}							
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con ��xito.</div>';
			}
			?>
			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label"># de Orden</label>
					<div class="col-sm-2">
						<input type="text" name="ID" value="<?php echo $row ['id']; ?>" class="form-control" placeholder="# de Orden" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Agente</label>
					<div class="col-sm-4">
						<input type="text" name="agente" value="<?php echo $row ['agent']; ?>" class="form-control" placeholder="agente" readonly="readonly">
					</div>
				</div>
				<hr />
				<strong><h4 style="text-align: center; background: black; color: white;">Datos del cliente</h4></strong>
				<hr />
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-4">
						<input type="text" maxlength="50" name="nameClient" value="<?php echo $row ['name_client']; ?>" class="form-control" placeholder="Nombre" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Apellido</label>
					<div class="col-sm-4">
						<input type="text" maxlength="50" name="lastNameClient" value="<?php echo $row ['lastname_client']; ?>" class="form-control" placeholder="Apellido" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Telefono Ppal.</label>
					<div class="col-sm-4">
						<input type="text" maxlength="10" name="phoneClient" value="<?php echo $row ['phone']; ?>" class="form-control" placeholder="Telefono Ppal.">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Telefono Alt.</label>
					<div class="col-sm-4">
						<input type="text" maxlength="10" name="phoneAltClient" value="<?php echo $row ['phone_alt']; ?>" class="form-control" placeholder="Telefono Alt.">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Genero</label>
					<div class="col-sm-4">
						<input type="text" name="genderClient" value="<?php echo $row ['gender']; ?>" class="form-control" placeholder="Genero" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Edad</label>
					<div class="col-sm-4">
						<input type="text" name="ageClient" value="<?php echo $row ['age']; ?>" class="form-control" placeholder="Sexo del cliente" readonly="readonly">
					</div>
				</div>
				<hr />
				<strong><h4 style="text-align: center; background: black; color: white;">Datos del envio</h4></strong>
				<hr />
				<div class="form-group">
					<label class="col-sm-3 control-label">Direcci��n</label>
					<div class="col-sm-4">
						<input type="text" name="dirClient" value="<?php echo $row ['address']; ?>" class="form-control" placeholder="Direcci��n" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Zipcode</label>
					<div class="col-sm-4">
						<input type="text" maxlength="5" name="zipcodeClient" value="<?php echo $row ['zip_code']; ?>" class="form-control" placeholder="Zipcode" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Zip4</label>
					<div class="col-sm-4">
						<input type="text" maxlength="4" name="zip4Client" value="<?php echo $row ['zip_4']; ?>" class="form-control" placeholder="Zip4" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Ciudad</label>
					<div class="col-sm-4">
						<input type="text" name="cityClient" value="<?php echo $row ['city']; ?>" class="form-control" placeholder="Ciudad" required="required">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-4">
						<input type="text" name="stateClient" value="<?php echo $row ['state']; ?>" class="form-control" placeholder="Estado" required="required">
					</div>
				</div>
				<hr />
				<strong><h4 style="text-align: center; background: black; color: white;">Datos de pago</h4></strong>
				<hr />
				<div class="form-group">
					<label class="col-sm-3 control-label">Tipo de pago</label>
					<div class="col-sm-4">
						<select class="form-control" name="paymentTypeClient"  required="required">
						<option value="<?php echo $row['payment_type']; ?>"><?php echo $row['payment_type']; ?></option>
						<option value="Credit Card">Credit card</option>
						<option value="Bank Deposit">Bank deposit</option>
						<option value="Money Order">Money order</option>
						</select>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Procesadora de tarjeta</label>
					<div class="col-sm-4">
					<?php if($row ['procesadora']=="Visa"){
						echo '<select class="form-control" name="cardProcess"  required="required">
						<option value="Visa">Visa</option>
						<option value="Mastercard">Mastercard</option>
						</select>';
					}else{
						echo '<select class="form-control" name="cardProcess" required="required">
						<option value="Mastercard">Mastercard</option>
						<option value="Visa">Visa</option>						
						</select>';
					}?>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Comentario(s) del pago</label>
					<div class="col-sm-4">
					<textarea type="text" name="comentPaymentold" style="height: 100px;" class="form-control" readonly="readonly"><?php echo $row ['coment_payment']; ?></textarea>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Nuevo comentario de pago</label>
					<div class="col-sm-4">
					<textarea type="text" name="comentPayment" style="height: 50px;" class="form-control"></textarea>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Monto de la compra</label>
					<div class="col-sm-4">
						<input type="text" name="priceClient" maxlength="3" value="<?php echo $row ['price']; ?>" class="form-control" placeholder="Monto de la compra" required="required">
					</div>
				</div>
				<hr />
				<strong><h4 style="text-align: center; background: black; color: white;">Datos de la compra	</h4></strong>
				<hr />
				<div class="form-group">
					<label class="col-sm-3 control-label">Re-order</label>
					<div class="col-sm-4">
					<?php if($row ['re_order']==1){
						echo '<select class="form-control" name="reOrderClient"  required="required">
						<option value"1">Si</option>
						<option value"0">No</option>
						</select>';
					}else{
						echo '<select class="form-control" name="reOrderClient" required="required">
						<option value"0">No</option>
						<option value"1">Si</option>
						</select>';
					}?>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Numero de Tracking</label>
					<div class="col-sm-4">
						<a name="tracking" value="<?php echo $row ['tracking_number']; ?>" class="form-control" href="https://tools.usps.com/go/TrackConfirmAction.action?tLabels=<?php echo $row ['tracking_number']; ?>" target="blank"><?php echo $row ['tracking_number']; ?></a>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Comentario(s)</label>
					<div class="col-sm-4">
					<textarea type="text" name="noteComentOld" name="noteComentOld" style="height: 100px;" class="form-control" readonly="readonly"><?php echo $row ['coment']; ?></textarea>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Producto 1</label>
					<div class="col-sm-4">
					<select class="form-control" name="product1">
					<option value="<?php echo $row ['product1'] ?>"><?php echo $row ['product1'] ?></option>
					<?php
                        $query = $mysqli -> query ("SELECT * FROM products where Activo = 1");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option name="product1" value="'.$valores['nombre'].'">'.$valores['nombre'].'</option>';
                        }
                      ?>
					</select>
						<input type="text" name="qty1" maxlength="2" value="<?php echo $row ['qty1'] ?>" class="form-control" placeholder="Cantidad">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Producto 2</label>
					<div class="col-sm-4">
					<select class="form-control" name="product2">
					<option value="<?php echo $row ['product2'] ?>"><?php echo $row ['product2'] ?></option>
					<?php
                        $query = $mysqli -> query ("SELECT * FROM products where Activo = 1");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option name="product2" value="'.$valores['nombre'].'">'.$valores['nombre'].'</option>';
                        }
                      ?><input type="text" name="qty2" maxlength="2" value="<?php echo $row ['qty2'] ?>" class="form-control" placeholder="Cantidad">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Producto 3</label>
					<div class="col-sm-4">
					<select class="form-control" name="product3">
					<option value="<?php echo $row ['product3'] ?>"><?php echo $row ['product3'] ?></option>
					<?php
                        $query = $mysqli -> query ("SELECT * FROM products where Activo = 1");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option name="product3" value="'.$valores['nombre'].'">'.$valores['nombre'].'</option>';
                        }
                      ?><input type="text" name="qty3" maxlength="2" value="<?php echo $row ['qty3'] ?>" class="form-control" placeholder="Cantidad">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Producto 4</label>
					<div class="col-sm-4">
					<select class="form-control" name="product4">
					<option value="<?php echo $row ['product4'] ?>"><?php echo $row ['product4'] ?></option>
					<?php
                        $query = $mysqli -> query ("SELECT * FROM products where Activo = 1");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option name="product4" value="'.$valores['nombre'].'">'.$valores['nombre'].'</option>';
                        }
                      ?><input type="text" name="qty4" maxlength="2" value="<?php echo $row ['qty4'] ?>" class="form-control" placeholder="Cantidad">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Producto 5</label>
					<div class="col-sm-4">
					<select class="form-control" name="product5">
					<option value="<?php echo $row ['product5'] ?>"><?php echo $row ['product5'] ?></option>
					<?php
                        $query = $mysqli -> query ("SELECT * FROM products where Activo = 1");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option name="product5" value="'.$valores['nombre'].'">'.$valores['nombre'].'</option>';
                        }
                      ?><input type="text" name="qty5" maxlength="2" value="<?php echo $row ['qty5'] ?>" class="form-control" placeholder="Cantidad">
					</div>
				</div>			
				<div class="form-group">
					<label class="col-sm-3 control-label">Status de la orden</label>
					<div class="col-sm-4">
						<input type="text" name="statusOrder" value="<?php echo $row ['status']; ?>" class="form-control" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Status de la Aprobaci&oacute;n</label>
					<div class="col-sm-4">
						<input type="text" name="statusApproval" value="<?php echo $row ['status_approval']; ?>" class="form-control" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Fecha de la venta</label>
					<div class="col-sm-4">
						<input type="date" name="dateOrderUp" value="<?php echo $row ['date_add']; ?>" class="form-control" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Fecha de env&iacute;o</label>
					<div class="col-sm-4">
						<input type="date" name="dateOrderUp" value="<?php echo $row ['date_deliv']; ?>" class="form-control" readonly="readonly">
					</div>
				</div>				
					<div class="form-group">
					<label class="col-sm-3 control-label">Comentario(s)</label>
					<div class="col-sm-4">
						<textarea name="noteActual" maxlength="64000" style="height: 100px;" class="form-control" placeholder="Comentario"></textarea>
						</div>
					</div>	
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="etiquetar" class="btn btn-sm btn-success" value="Confirmar pago">
						<input type="submit" name="VolverStat" class="btn btn-sm btn-warning" value="Devolver Status">		
						<input type="submit" name="retornate" class="btn btn-sm btn-secondary" value="Retornar">
						<input type="submit" name="reclamate" class="btn btn-sm btn-danger" value="Reclamo de pago">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="tracking" class="btn btn-sm btn-warning" value="Actualizar Track-number">
						<input type="submit" name="modificate" class="btn btn-sm btn-primary" value="Guardar">
						<a href="../views/index-table-order-pent-deliv.php" class="btn btn-sm btn-info">Regresar</a>
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