<?php 
require("combobox.php");
$obj_solicitudes=new solicitudes();
$clientes=$obj_solicitudes->getClientes();
$tecnicos=$obj_solicitudes->getTecnicos();
$estado=$obj_solicitudes->getEstados();

?>

<html> 
<head> 
	<?php $URL = "'index.php',";
	$variables = "'clientes,tecnico,fecha_inicio_programado,fecha_inicio2_programado,fecha_fin_programado,fecha_fin2_programado,chkestado[]',";
	$contenido = "'contenido'"; ?>
		<meta http-equiv="Content-type" content="text/htal; charset=UTF-8">
 			<title>prueba</title>
 	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/Limpiar.js"></script>
 	<script type="text/javascript" language="javascript" src="js/Clientes.js"></script>
 	<script src="js/solicitudes_jx.js" type="text/javascript"></script>
 	<script type="text/javascript" language="javascript" src="js/Tr.js"></script>
 	<script type="text/javascript" language="javascript" src="js/tareas.js"></script>
 	<script type="text/javascript" language="javascript" src="js/datetimepicker.js"></script>
 	<link rel="stylesheet" href="css/tablas1.css" type="text/css" media="screen">

 

</head> 

<body onLoad="Paginaa('index.php','NA','contenido',0,0,10)"> 


<form name="ll" id="fr">

<?php for($i=0;$i<sizeof($estado);$i++)
{ $parametros = "'index.php','chkestado[],clientes,tecnico,fecha_inicio_programado,fecha_inicio2_programado,fecha_fin_programado,fecha_fin2_programado','contenido',0,0,10"; ?>



<?php echo $estado[$i]["Descripcion"]; ?><input type="checkbox" name="chkestado[]" value="<?php echo $estado[$i]["idestado"]; ?>" onChange="Paginaa(<?php echo $parametros ;?>)" >

<?php } ?>



<select name='clientes' style="width: 150px;" id='clientes' onChange="Paginaa(<?php echo $parametros ;?>)" >;
	<option value='0'>Cliente</option>
<?php for($i=0;$i<sizeof($clientes);$i++)
 				{ ?>
		<option value='<?php echo $clientes[$i]["id_cli"]; ?>'><?php echo $clientes[$i]["nombre_empresa"]; ?></option>
 <?php }?>
</select>



<select name='cmbtecnico' style="width: 150px;" id='tecnico' onChange="Paginaa(<?php echo $parametros ;?>)" >;
	<option value='0'>Usuario</option>
<?php for($i=0;$i<sizeof($tecnicos);$i++)
 				{ ?>
		<option value='<?php echo $tecnicos[$i]["login"]; ?>'><?php echo $tecnicos[$i]["name"]; ?></option>
 <?php }?>
</select>



</br>
Fecha inicio programado 
<select name="filtro_fecha" id="filtro_fecha" onchange="filtro_date()">
<option value="1">Exactamente igual</option>
<option value="2">Entre</option>
</select>

<div id="fecha1" style="display: inline-block">
<input type="Text" id="fecha_inicio_programado" maxlength="25" size="25" onclick="javascript:NewCal('fecha_inicio_programado','ddmmyyyy',false,24)" readonly="readonly" style="cursor: pointer" onChange="Pagina() ">
</div>

<div id="fecha2" style="display: inline-block">
<input type="Text" id="fecha_inicio2_programado" style="display: none; " maxlength="25" size="25" onclick="javascript:NewCal('fecha_inicio2_programado','ddmmyyyy',false,24)" readonly="readonly" style="cursor: pointer" onChange="Pagina() ">
</div>

Fecha fin programado 
<select name="filtro_fecha2" id="filtro_fecha2" onchange="filtro_date()">
<option value="1">Exactamente igual</option>
<option value="2">Entre</option>
</select>

<div id="fecha11" style="display: inline-block">
<input type="Text" id="fecha_fin_programado" maxlength="25" size="25" onclick="javascript:NewCal('fecha_fin_programado','ddmmyyyy',false,24)" readonly="readonly" style="cursor: pointer" onChange="Pagina() ">
</div>

<div id="fecha22" style="display: inline-block">
<input type="Text" id="fecha_fin2_programado" style="display: none; " maxlength="25" size="25" onclick="javascript:NewCal('fecha_fin2_programado','ddmmyyyy',false,24)" readonly="readonly" style="cursor: pointer" onChange="Pagina() ">
</div>

</br></br>


<input type="button" name="buscar" value="Busqueda" onClick="Paginaa(<?php echo $parametros ;?>)">
<input type="button" name="limpiar" value="Limpiar" onClick="this.form.reset() ">

</form>

<div id="contenido">
</div>



</fieldset>
</form> 
</body> 
</html> 



