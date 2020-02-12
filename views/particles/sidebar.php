<?php

include ('../../bots/bot_accountant.php');

$menu='
    <ul class="nav">
        <li class="nav-item nav-category">Perfil activo:</li>
        <div>
        <img src="">
        </div>

        <li class="nav-item nav-profile">
        <a href="#" class="nav-link">           
        
            <div class="profile-image">
            <img class="img-xs rounded-circle" src="../../assets/images/faces/face8.jpg" alt="profile image">
            <div class="dot-indicator bg-success"></div>
            </div>
            <div class="text-wrapper">
            <p class="profile-name">'.$_SESSION['Name']." ".$_SESSION['Lastname_Paternal'].'</p>
            <p class="designation">'.$_SESSION['Role'].'</p>
            </div>
        </a>
        </li>
        <li class="nav-item nav-category">Menu principal</li>
        <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="menu-icon typcn typcn-document-text"></i>
            <span class="menu-title">Dashboard</span>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui_talent_human" aria-expanded="false" aria-controls="ui-basic">
            <i class="menu-icon typcn typcn-coffee"></i>
            <span class="menu-title">Tanlento Humano</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui_talent_human">               
            <ul>
                <li class="nav-item nav-category" title="Ciclo de reclutamiento"><h6>Reclutamiento</h6></li>
                <li class="nav-item">
                    <a class="nav-link" href="../forms/form_create_user_con.php">Crear nuevo postulante</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_users_1_con.php">('.$countConvocado.') Convocados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_users_2_pos.php">('.$countPostulante.') Postulantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_users_3_asp.php">('.$countAspirante.') Aspirantes</a>
                </li>
                <li class="nav-item nav-category" title="Personas no pertenecientes a la empresa"><h6>RRHH</h6></li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_users_act_ase.php">('.$countAsesor.') Activos - Agentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_users_act_pl.php">('.$countPrimeralinea.') Activos - Primera Linea</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_users_act_adm.php">('.$countAdministrativo.') Activos - Administrativos</a>
                </li>                
            </ul>
        </div>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui_operation" aria-expanded="false" aria-controls="ui-basic">
            <i class="menu-icon typcn typcn-coffee"></i>
            <span class="menu-title">Operaciones</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui_operation">               
            <ul>
                <li class="nav-item nav-category" title="Ordenes ingresadas al sistema"><h6>Ventas</h6></li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_order_pent_verif.php">('.$countCarga.') Cargadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_order_pent_valid.php">('.$countVerificada.') Verificadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_order_postf.php">('.$countPostFechada.') Post-Fechadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_order_pent_shipp.php">('.$countValidada.') Validadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_order_send.php">('.$countEnviada.') Enviadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_order_alert.php">('.$countAlerta.') Alerta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_order_deliv.php">('.$countEntregada.') Entregada</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_order_pent_rpaid.php">('.$countPendienteReclamoPago.') Pendiente de reclamo de pago</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_order_paid.php">('.$countPagoConfirmado.') Pago confirmado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../fronts/table_order_liquid.php">('.$countLiquidada.') Liquidada</a>
                </li>            
            </ul>
        </div>
        </li>      
    </ul>';

?>