<?php require_once 'action_core.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
			$sql = mysqli_query($connect, "SELECT * FROM db_sales WHERE id='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: ../views/fronts/table_order_pent_valid.php");
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
					$usuarioModif		= $_SESSION['Username'];
					$coment 			= "(".$fechaEditcoment." -- ".$_SESSION['Username'].") // ".$note." \n ".$noteComent;
					$comentPayment 		= "(".$fechaEditcoment." -- ".$_SESSION['Username'].") // ".$comentPaymentNew." \n ".$comentPaymentOld;
                    $status				= "Validada";

					$update = mysqli_query($connect, "UPDATE db_sales SET name_client='$nameClient', lastname_client='$lastNameClient', phone='$phone', phone_alt='$phoneAlt', gender='$genClient', age='$ageClient', address='$direccion', zip_code='$zipcode', zip_4='$zipfour', city='$city', state='$state', payment_type='$payment', procesadora='$cardProcess', coment_payment='$comentPayment', price='$price', re_order='$reOrder', coment='$coment', product1='$productOne',  qty1='$qtyOne', product2='$productTwo', qty2='$qtyTwo', product3='$productThree', qty3='$qtyThree', product4='$productFour', qty4='$qtyFour', product5='$productFive', qty5='$qtyFive', date_edit='$fechaEdit', status='$status', date_valid='$fechaEdit', valid_for='$usuarioModif' WHERE id='$nik'") or die(mysqli_error());
					if($update){
					header("Location: ../views/fronts/table_order_pent_valid.php");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}	
			if(isset($_POST['postfechate'])){
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
					$usuarioModif		= $_SESSION['Username'];
					$coment 			= "(".$fechaEditcoment." -- ".$_SESSION['Username'].") // ".$note." \n ".$noteComent;
					$comentPayment 		= "(".$fechaEditcoment." -- ".$_SESSION['Username'].") // ".$comentPaymentNew." \n ".$comentPaymentOld;
                    $status				= "Post_Fechada";

					$update = mysqli_query($connect, "UPDATE db_sales SET name_client='$nameClient', lastname_client='$lastNameClient', phone='$phone', phone_alt='$phoneAlt', gender='$genClient', age='$ageClient', address='$direccion', zip_code='$zipcode', zip_4='$zipfour', city='$city', state='$state', payment_type='$payment', procesadora='$cardProcess', coment_payment='$comentPayment', price='$price', re_order='$reOrder', coment='$coment', product1='$productOne',  qty1='$qtyOne', product2='$productTwo', qty2='$qtyTwo', product3='$productThree', qty3='$qtyThree', product4='$productFour', qty4='$qtyFour', product5='$productFive', qty5='$qtyFive', date_edit='$fechaEdit', status='$status', date_postf='$fechaEdit', postf_for='$usuarioModif' WHERE id='$nik'") or die(mysqli_error());
					if($update){
					header("Location: ../views/fronts/table_order_pent_valid.php");
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
					$usuarioModif		= $_SESSION['Username'];
					$comentPayment 		= "(".$fechaEditcoment." -- ".$_SESSION['Username'].") // ".$comentPaymentNew." \n ".$comentPaymentOld;
                    $coment 			= "(".$fechaEditcoment." -- ".$_SESSION['Username'].") // ".$note." \n ".$noteComent;

					$update = mysqli_query($connect, "UPDATE db_sales SET name_client='$nameClient', lastname_client='$lastNameClient', phone='$phone', phone_alt='$phoneAlt', gender='$genClient', age='$ageClient', address='$direccion', zip_code='$zipcode', zip_4='$zipfour', city='$city', state='$state', payment_type='$payment', procesadora='$cardProcess', coment_payment='$comentPayment', price='$price', re_order='$reOrder', coment='$coment', product1='$productOne',  qty1='$qtyOne', product2='$productTwo', qty2='$qtyTwo', product3='$productThree', qty3='$qtyThree', product4='$productFour', qty4='$qtyFour', product5='$productFive', qty5='$qtyFive', date_edit='$fechaEdit' WHERE id='$nik'") or die(mysqli_error());
					if($update){
						header("Location: action_edit_order_valid.php?nik=".$nik."&pesan=sukses");
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
					}
				}	
			if(isset($_POST['cancelate'])){
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
					$usuarioModif		= $_SESSION['Username'];
					$coment 			= "(".$fechaEditcoment." -- ".$_SESSION['Username'].") // ".$note." \n ".$noteComent;
					$comentPayment 		= "(".$fechaEditcoment." -- ".$_SESSION['Username'].") // ".$comentPaymentNew." \n ".$comentPaymentOld;
                    $status				= "Cancelada";

					$update = mysqli_query($connect, "UPDATE db_sales SET name_client='$nameClient', lastname_client='$lastNameClient', phone='$phone', phone_alt='$phoneAlt', gender='$genClient', age='$ageClient', address='$direccion', zip_code='$zipcode', zip_4='$zipfour', city='$city', state='$state', payment_type='$payment', procesadora='$cardProcess', coment_payment='$comentPayment', price='$price', re_order='$reOrder', coment='$coment', product1='$productOne',  qty1='$qtyOne', product2='$productTwo', qty2='$qtyTwo', product3='$productThree', qty3='$qtyThree', product4='$productFour', qty4='$qtyFour', product5='$productFive', qty5='$qtyFive', date_edit='$fechaEdit', status='$status', date_cancel='$fechaEdit', cancel_for='$usuarioModif' WHERE id='$nik'") or die(mysqli_error());
					if($update){
					header("Location: ../views/fronts/table_order_pent_valid.php");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}							
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con 茅xito.</div>';
			}
			?>
<div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <h2 class="text-center mb-4">Datos de la orden</h2>
              <div class="auto-form-wrapper">
                <form id="submitUsertForm" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" name="ID" class="form-control" value="<?php echo $row ['id']; ?>" class="form-control" placeholder="# de Orden" readonly="readonly">
                      <div class="input-group-append">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" name="agente" class="form-control" value="<?php echo $row ['agent']; ?>" class="form-control" placeholder="agente" readonly="readonly">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				          <div class="form-group">
                    <div class="input-group">
                    <input type="text" maxlength="50" name="nameClient" value="<?php echo $row ['name_client']; ?>" class="form-control" placeholder="Nombre" required="required">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" maxlength="50" name="lastNameClient" value="<?php echo $row ['lastname_client']; ?>" class="form-control" placeholder="Apellido" required="required">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" maxlength="10" name="phoneClient" value="<?php echo $row ['phone']; ?>" class="form-control" placeholder="Telefono Ppal.">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" maxlength="10" name="phoneAltClient" value="<?php echo $row ['phone_alt']; ?>" class="form-control" placeholder="Telefono Alt.">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" name="genderClient" value="<?php echo $row ['gender']; ?>" class="form-control" placeholder="Genero" readonly="readonly">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" name="ageClient" value="<?php echo $row ['age']; ?>" class="form-control" placeholder="Sexo del cliente" readonly="readonly">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" name="dirClient" value="<?php echo $row ['address']; ?>" class="form-control" placeholder="Dirección" required="required">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" maxlength="5" name="zipcodeClient" value="<?php echo $row ['zip_code']; ?>" class="form-control" placeholder="Zipcode" required="required">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" maxlength="4" name="zip4Client" value="<?php echo $row ['zip_4']; ?>" class="form-control" placeholder="Zip4" required="required">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" name="cityClient" value="<?php echo $row ['city']; ?>" class="form-control" placeholder="Ciudad" required="required">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" name="stateClient" value="<?php echo $row ['state']; ?>" class="form-control" placeholder="Estado" required="required">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control" name="paymentTypeClient"  required="required">
                          <option value="<?php echo $row['payment_type']; ?>"><?php echo $row['payment_type']; ?></option>
                          <option value="Credit Card">Credit card</option>
                          <option value="Bank Deposit">Bank deposit</option>
                          <option value="Money Order">Money order</option>
                          </select>
						  <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
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
				  <div class="form-group">
                    <div class="input-group">
                    <textarea type="text" name="comentPaymentOld" style="height: 100px;" class="form-control" readonly="readonly"><?php echo $row ['coment_payment']; ?></textarea>
						          <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <textarea type="text" name="comentPayment" style="height: 50px;" class="form-control"></textarea>
						          <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
				  <div class="form-group">
                    <div class="input-group">
                    <input type="text" name="priceClient" maxlength="3" value="<?php echo $row ['price']; ?>" class="form-control" placeholder="Monto de la compra" required="required">
						          <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
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
                    <div class="input-group">
                    <textarea type="text" name="noteComentOld" name="noteComentOld" style="height: 100px;" class="form-control" readonly="readonly"><?php echo $row ['coment']; ?></textarea>
						          <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <select class="form-control" name="product1">
                      <option value="<?php echo $row ['product1'] ?>"><?php echo $row ['product1'] ?></option>
                      <?php
                                    $query = $mysqli -> query ("SELECT * FROM db_products where Activo = 1");
                                    while ($valores = mysqli_fetch_array($query)) {
                                      echo '<option name="product1" value="'.$valores['nombre'].'">'.$valores['nombre'].'</option>';
                                    }
                                  ?>
                      </select>
                      <input type="text" name="qty1" maxlength="2" value="<?php echo $row ['qty1'] ?>" class="form-control" placeholder="Cantidad">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
				          </div>
                  <div class="form-group">
                    <div class="input-group">
                      <select class="form-control" name="product2">
                        <option value="<?php echo $row ['product2'] ?>"><?php echo $row ['product2'] ?></option>
                        <?php
                        $query = $mysqli -> query ("SELECT * FROM db_products where Activo = 1");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option name="product2" value="'.$valores['nombre'].'">'.$valores['nombre'].'</option>';
                        }
                      ?>
                      <input type="text" name="qty2" maxlength="2" value="<?php echo $row ['qty2'] ?>" class="form-control" placeholder="Cantidad">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
				          </div>
                  <div class="form-group">
                    <div class="input-group">
                    <select class="form-control" name="product3">
                      <option value="<?php echo $row ['product3'] ?>"><?php echo $row ['product3'] ?></option>
                      <?php
                        $query = $mysqli -> query ("SELECT * FROM db_products where Activo = 1");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option name="product3" value="'.$valores['nombre'].'">'.$valores['nombre'].'</option>';
                        }
                      ?>
                      <input type="text" name="qty3" maxlength="2" value="<?php echo $row ['qty3'] ?>" class="form-control" placeholder="Cantidad">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
				          </div>
                  <div class="form-group">
                    <div class="input-group">
                    <select class="form-control" name="product4">
                      <option value="<?php echo $row ['product4'] ?>"><?php echo $row ['product4'] ?></option>
                      <?php
                        $query = $mysqli -> query ("SELECT * FROM db_products where Activo = 1");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option name="product4" value="'.$valores['nombre'].'">'.$valores['nombre'].'</option>';
                        }
                      ?>
                      <input type="text" name="qty4" maxlength="2" value="<?php echo $row ['qty4'] ?>" class="form-control" placeholder="Cantidad">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
				          </div>
                  <div class="form-group">
                    <div class="input-group">
                    <select class="form-control" name="product5">
                      <option value="<?php echo $row ['product5'] ?>"><?php echo $row ['product5'] ?></option>
                      <?php
                        $query = $mysqli -> query ("SELECT * FROM db_products where Activo = 1");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option name="product5" value="'.$valores['nombre'].'">'.$valores['nombre'].'</option>';
                        }
                      ?>
                      <input type="text" name="qty5" maxlength="2" value="<?php echo $row ['qty5'] ?>" class="form-control" placeholder="Cantidad">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
				          </div>
                  <div class="form-group">
                    <div class="input-group">
                    <input type="text" name="statusOrder" value="<?php echo $row ['status']; ?>" class="form-control" readonly="readonly">
					            <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    		<input type="date" name="dateOrderUp" value="<?php echo $row ['date_add']; ?>" class="form-control" readonly="readonly">
						<div class="input-group-append">
                        	<span class="input-group-text">
                          	<i class="mdi mdi-check-circle-outline"></i>
                        	</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                    <textarea name="noteActual" maxlength="64000" style="height: 50px;" class="form-control" placeholder="Comentario"></textarea>
						          <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="etiquetar" class="btn btn-success submit-btn btn-block" value="Verificar">
                    <input type="submit" name="postfechate" class="btn btn-secondary submit-btn btn-block" value="Post-Fechar">
                    <input type="submit" name="modificate" class="btn btn-primary submit-btn btn-block" value="Guardar">
                    <input type="submit" name="cancelate" class="btn btn-danger submit-btn btn-block" value="Cancelar">					
                  </div>
                  <div class="text-block text-center my-3">
                    <span class="text-small font-weight-semibold"></span>
                    <a href="../views/fronts/table_order_pent_verif.php" class="text-black text-small">Regresar</a>
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