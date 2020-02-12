<?php
require_once('setup.php');

	if(isset($_POST['btnguardar'])){
	$fecha=$_POST['fecha'];
	$venta=$_POST['venta'];

		//$sql2=$dbcon->query("insert into operacion(Ope_Fecha, Ope_Venta) values('$fecha','$venta')");

		$sales = ORM::for_table('operacion')->create();
		$sales->set('Ope_Fecha', $fecha );
 		$sales->set('Ope_Venta', $venta);
		$sales->save();
		
		if($sales){
			$ok= "Registrado correctamente";
		}else{
			$ok2= "Hubo un error al procesar recurso";
		}
	
}
	
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Crear gráficos dinámicos con jQuery y xCharts - BaulPHP</title>
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/css/sticky-footer-navbar.css" rel="stylesheet">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<style type="text/css">
.ui-state-hover,
.ui-widget-content .ui-state-hover,
.ui-widget-header .ui-state-hover,
.ui-state-focus,
.ui-widget-content .ui-state-focus,
.ui-widget-header .ui-state-focus {
	border: 1px solid #999999/*{borderColorHover}*/;
	background: #5893D3;
	font-weight: normal/*{fwDefault}*/;
	color: #fff/*{fcHover}*/;
}
</style>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
 dayNamesShort: ['Dom','Lun','Mar','Mie','Juv','Vie','Sab'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
 weekHeader: 'Sm',
 dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: '-100:+2',
reverseYearRange: false,
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
$("#text_uno").datepicker();
});
</script>
  </head>

  <body>

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">BaulPHP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Ver grafico <span class="sr-only">(current)</span></a>
            </li>  
            <li class="nav-item active">
              <a class="nav-link" href="registro.php">Registrar</a>
            </li>  
                  
          </ul>
          <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Buscar" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Busqueda</button>
          </form>
        </div>
      </nav>
    </header>

    <!-- Begin page content -->

<div class="container">
 <h1 class="mt-5">Registrar ventas </h1>
 <hr>

<?php
if(isset($ok)){?>
 <div class="alert alert-success" role="alert">
  <strong>Hecho!</strong> El registro ha sido guardado con exito.
</div>
<?php }?>

<?php if(isset($ok2)){?>
<div class="alert alert-danger" role="alert">
  <strong>Oh!</strong> Hubo un error al procesar el recurso.
</div>		
	<?php }?>
<div class="row">
  <div class="col-12 col-md-6">

   <!-- Contenido --> 

<form id="frmLogin" action="" method="post">
  <fieldset>
        <div class="form-group">
    <label for="fecha">Fecha:</label>
    <input required type="text" class="form-control" name="fecha" id="text_uno" placeholder="Ingrese fecha" value="">
 	   </div>
        <div class="form-group">
    <label for="venta">Valor de venta:</label>
    <input required class="form-control" type="number" name="venta"  placeholder="Ingrese valor" value="">
 	   </div>
    <input type="hidden" name="btnguardar" value="v">
<input class="btn btn-primary" type="submit" value="Registrar Venta">
             
  </fieldset>

</form>

 <!-- Fin Contenido --> 
</div>
</div><!-- Fin row -->


</div><!-- Fin container -->
    <footer class="footer">
      <div class="container">
        <span class="text-muted"><p>Códigos <a href="https://www.baulphp.com/" target="_blank">BaulPHP</a></p></span>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>