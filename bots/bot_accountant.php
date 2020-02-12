<?php

//include ('.../actions/action_db_connect.php');

    $sqlA= "SELECT * from db_human_talent where Status='Convocado'";
    $queryA = $connect->query($sqlA);
    $countConvocado = $queryA->num_rows;

    $sqlB= "SELECT * from db_human_talent where Status='Postulante'";
    $queryB = $connect->query($sqlB);
    $countPostulante = $queryB->num_rows;

    $sqlC= "SELECT * from db_human_talent where Status='Aspirante'";
    $queryC = $connect->query($sqlC);
    $countAspirante = $queryC->num_rows;

    $sqlD= "SELECT * from db_user_act where Personal_Type='Agente'";
    $queryD = $connect->query($sqlD);
    $countAsesor = $queryD->num_rows;

    $sqlE= "SELECT * from db_user_act where Personal_Type='PL'";
    $queryE = $connect->query($sqlE);
    $countPrimeralinea = $queryE->num_rows;

    $sqlF= "SELECT * from db_user_act where Personal_Type='Administrativo'";
    $queryF = $connect->query($sqlF);
    $countAdministrativo = $queryF->num_rows;

    $sqlG= "SELECT * from db_sales";
    $queryG = $connect->query($sqlG);
    $countSales = $queryG->num_rows;

    $sqlH= "SELECT * from db_sales where Status='Cargada'";
    $sqlH = $connect->query($sqlH);
    $countCarga = $sqlH->num_rows;

    $sqlI= "SELECT * from db_sales where Status='Verificada'";
    $sqlI = $connect->query($sqlI);
    $countVerificada = $sqlI->num_rows;

    $sqlJ= "SELECT * from db_sales where Status='Post-Fechada'";
    $sqlJ = $connect->query($sqlJ);
    $countPostFechada = $sqlJ->num_rows;

    $sqlK= "SELECT * from db_sales where Status='Validada'";
    $sqlK = $connect->query($sqlK);
    $countValidada = $sqlK->num_rows;

    $sqlL= "SELECT * from db_sales where Status='Enviada'";
    $sqlL = $connect->query($sqlL);
    $countEnviada = $sqlL->num_rows;

    $sqlM= "SELECT * from db_sales where Status='Alerta'";
    $sqlM = $connect->query($sqlM);
    $countAlerta = $sqlM->num_rows;

    $sqlN= "SELECT * from db_sales where Status='Entregada'";
    $sqlN = $connect->query($sqlN);
    $countEntregada = $sqlN->num_rows;

    $sqlO= "SELECT * from db_sales where Status='Pendiente_Reclamo_Pago'";
    $sqlO = $connect->query($sqlO);
    $countPendienteReclamoPago = $sqlO->num_rows;

    $sqlP= "SELECT * from db_sales where Status='Pago_Confirmado'";
    $sqlP = $connect->query($sqlP);
    $countPagoConfirmado = $sqlP->num_rows;

    $sqlQ= "SELECT * from db_sales where Status='Liquidada'";
    $sqlQ = $connect->query($sqlQ);
    $countLiquidada = $sqlQ->num_rows;

    $countSPH = $countSales/(($countAsesor*6.5)*21);
?>