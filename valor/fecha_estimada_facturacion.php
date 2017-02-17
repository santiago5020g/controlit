<?php
//echo "<link rel=stylesheet type=text/css href=../mis_librerias/calendar/tcal.css />";
//echo "<script type='text/javascript' src=../mis_librerias/calendar/tcal.js></script> ";
require("config.php");
    mysql_connect($dbHost, $dbUser, $dbPass) or die("no se pudo conectar");
    mysql_select_db($dataBase);

$fecha_estimada="";
$solicitudes="";
if(isset($_REQUEST["fecha_estimada"])) 
{
$fecha_estimada= $_REQUEST["fecha_estimada"];
}

if(isset($_REQUEST["solicitudes"])) 
{
$solicitudes=$_REQUEST["solicitudes"];
}


if(isset($_REQUEST["actualizar"])) 
	{

		if($fecha_estimada!="")
		{

		     $sql=mysql_query("update tblsolicitudes set fecha_estimada_facturacion='$fecha_estimada' where id in($solicitudes)")
		     or die("Error al actualizar solicitudes");

		     if($sql){ ?> <script type="text/javascript"> window.close();</script> <? }
		}		


		else

		{
			
		echo "<script language=javascript>
		alert('fecha estimada de facturacion no valida');
			</script>";
		}	

	}


?>

<script type='text/javascript' src='../calendar/tcal.js'></script>
<link rel=stylesheet type=text/css href='../calendar/tcal.css' />
<script language='javascript'> 
function redireccionar(){ 
window.location = "../grid_solicitudes_analisis_factura" 
}

function limpiar()
{
if (document.frform.valorh.value =!"")
document.frform.valorh.value = "";
}
</script> 
<center>
           <form action= "fecha_estimada_facturacion.php" name="frform" method="post">
				<table border="1" cellpadding="4" cellspacing="0" align="center">
			 	<tr>
			 		<td>fecha estimada de facturacion</td>
			 		<td> <input type="text" name="fecha_estimada" class="tcal" value="<?php if($fecha_estimada!="") {echo $fecha_estimada;}  ?>" /> </td>
			 	</tr>	

			 <tr>
					<td>id solicitudes seleccionadas</td>
					<td> <input type=text name="solicitudes" value=<?php if($solicitudes!="") {echo $solicitudes;}  ?> readonly="readonly"></td>			
			 </tr>

				<input type="submit" name="actualizar" value="Actualizar">
			</form>
				<input type="submit" name="recalcular" value="Recalcular" onclick="limpiar()">
			<form name="prueba888" method="post" action="../grid_solicitudes_analisis_factura/grid_solicitudes_analisis_factura.php" >
			<input type="submit" name="refrescar" value="Refrescar" onclick="parent.location.reload();"></form>
			</table> <br>
</center>;
