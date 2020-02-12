<?php 
require_once 'action_core.php';

session_start();
// remove all session variables
session_unset();
//Destruye sesion
session_destroy();

header("Location: ../login.php")

?>