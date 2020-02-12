<?php
include ('../actions/action_db_connect.php');
  $sqlG= "SELECT * from sales WHERE Status='Enviada'";
  $queryG = $connect->query($sqlG);
  $countSalesEnv = $queryG->num_rows;

  $sqlH= "SELECT * from sales WHERE Status='Entregada'";
  $queryH = $connect->query($sqlH);
  $countSalesEnt = $queryH->num_rows;

  $sqlI= "SELECT * from sales WHERE Status='Pendiente_Reclamo_Pago'";
  $queryI = $connect->query($sqlI);
  $countSalesPRP = $queryI->num_rows;

  $sqlJ= "SELECT * from sales WHERE Status='Pago_Confirmado'";
  $queryJ = $connect->query($sqlJ);
  $countSalesPC = $queryJ->num_rows;

  $sqlK= "SELECT * from sales WHERE Status='Liquidada'";
  $queryK = $connect->query($sqlK);
  $countSalesLiq = $queryK->num_rows;


  $VentEnv = $countSalesEnv + $countSalesEnt + $countSalesPRP + $countSalesPC + $countSalesLiq;
  $VentCob =  $countSalesPC + $countSalesLiq;
  var_dump($VentEnv);
  var_dump($VentCob);
?>