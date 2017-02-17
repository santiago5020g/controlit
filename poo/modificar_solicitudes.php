<?php
$id_solicitud = $_REQUEST["id"];
require('solicitudes.php');
$obj_solicitudes=new Solicitudes();
$Solicitudes=$obj_solicitudes->getSolicitudes_por_id($_REQUEST["id"]);
$clientes=$obj_solicitudes->getClientes();
$prioridad=$obj_solicitudes->getPrioridad();
$estado=$obj_solicitudes->getEstado();
$sedes=$obj_solicitudes->getSedes($Solicitudes[0]["solicitud_idcliente"]);
$propietario=$obj_solicitudes->getTecnicos();
$proyecto=$obj_solicitudes->getProyectos();
$categorias=$obj_solicitudes->getCategorias();
$disposicion=$obj_solicitudes->getDisposicion();
?>

<html>
<head>
	<meta http-equiv="Content-type" content="text/htal; charset=UTF-8">
	<title>prueba</title>
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script src="js/solicitudes_jx.js" type="text/javascript"></script>
	<script type="text/javascript">
	cargar_solicitud(<?php echo $id_solicitud; ?>);
	cargar_tarea(<?php echo $id_solicitud; ?>);
	</script>


<div id='resultado'></div>
	</script>

	<link rel="stylesheet" type="text/css" href="css/style1.css">	
	<link rel="stylesheet" type="text/css" href="css/style3.css">
	<link rel="stylesheet" type="text/css" href="css/style2.css" media="screen" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>

<body>
	
	<div id="mensaje"></div>

		<form  name="frmclientes" >
		<div id="bloque_botones" style="height: 40px; margin-left: 40%; margin-top: 15px;">
			<?php if($Solicitudes[0]["solicitud_idestado"]==1 or $Solicitudes[0]["solicitud_idestado"]==2) { ?>
			<input type="button" name="actualizar" value="Nuevo">
			<input type="button" name="actualizar" value="Actualizar solicitud" onclick="Update_solicitudes();">
			<input type="button" name="actualizar" value="Borrar">
			<?php }?>
		</div>
	</form>


	<div id="demo">

		<section id="tabbed">
			<!-- First tab input and label -->
			<input id="t-1" name="tabbed-tabs" type="radio" checked="checked" />
			<label for="t-1" class="tabs shadow entypo-star">Solicitud</label>
			<!-- Second tab input and label -->
			<input id="t-2" name="tabbed-tabs" type="radio" />
			<label for="t-2" class="tabs shadow   entypo-pencil">Tareas</label>
			<!-- Third tab input and label -->
			<!-- Tabs wrapper -->
			<div class="wrapper shadow">

				<!-- Tab 1 content -->
				<div id="solicitud" class="tab-1">
				</div>

				<div id="tareas" class="tab-2">	
				</div>

			<!-- / Tabs wrapper -->
		</div>
	</section>

</div>
</div>
</body>
<html>

