<?php 

require_once 'action_core.php';

$valid['success'] = array('success' => false, 'messages' => array());
ini_set('date.timezone', 'America/Caracas');
if ($_POST) {
	# code...

	$Name  = $_POST['Name'];
	$Lastname_Maternal  = $_POST['Lastname_Maternal'];
	$Lastname_Paternal  = $_POST['Lastname_Paternal'];
	$Phone_Cell  = $_POST['Phone_Cell'];
	$Phone_Hab  = $_POST['Phone_Hab'];
	$Management  = $_POST['Management'];
	$Appointment  = $_POST['Appointment'];
	$Time_Appointment  = $_POST['Time_Appointment'];
	$Email  = $_POST['Email'];
    $Medium = $_POST['Medium'];
	$Assistance = $_POST['Assistance'];
	$Status = "Convocado";
	$Recruiter = $_SESSION['Username'];	
    					
				$sql = "INSERT INTO db_human_talent (Name, Lastname_Maternal, Lastname_Paternal, Phone_Cell, Phone_Hab, Recruiter, Management, Appointment, Time_Appointment, Email, Medium, Assistance, Status)
				VALUES ('$Name', '$Lastname_Maternal', '$Lastname_Paternal', '$Phone_Cell', '$Phone_Hab', '$Recruiter', '$Management', '$Appointment', '$Time_Appointment', '$Email', '$Medium', '$Assistance', '$Status')";

				if($connect->query($sql) === true) {
					$valid['success'] = true;
					$valid['messages'] = "Creado exitosamente";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error no se ha podido guardar";
				}    
				
	$connect->close();

	echo json_encode($valid);
	header('Location: ../views/fronts/index.php');
 
} 
?>