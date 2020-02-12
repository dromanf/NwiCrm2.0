<?php
if ($_SESSION['Username'] == true) {

} else {
  
  header('Location: ./login.php');
exit;
}?>