<html>
<head>
<meta http-equiv="expires" content="0">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" CONTENT="no-cache">
<script type="text/javascript" src="jquery-1.11.1.min.js?v=1.000"> </script>
<script type="text/javascript" src="puente.js?v=1.005"></script>
<link rel="stylesheet" type="text/css" href="css/style1.css">
	<title>Informe de facturacion</title>
</head>
<body>

<?php
require("../conexion/config.php");
    mysql_connect($dbHost, $dbUser, $dbPass) or die("no se pudo conectar");
    mysql_select_db($dataBase);

$valor="";
$valorh="";
$tiempof="";
$valor_calculado_hora="";
$fecha_estimada="";
$solicitudes="";
$totalT=0;

$numero_factura="";
$fecha_facturacion="";

if(isset($_REQUEST["valor"])) 
{
$valor= $_REQUEST["valor"];
}

if(isset($_REQUEST["fecha_estimada"])) 
{
$fecha_estimada= $_REQUEST["fecha_estimada"];
}



if(isset($_REQUEST["tiempof"])) 
{
$tiempof=$_REQUEST["tiempof"];
}


if(isset($_REQUEST["solicitudes"])) 
{
$solicitudes=$_REQUEST["solicitudes"];
}


if(isset($_REQUEST["numero_factura"])) 
{
$numero_factura= $_REQUEST['numero_factura'];
}

if(isset($_REQUEST["fecha_facturacion"])) 
{
$fecha_facturacion= $_REQUEST['fecha_facturacion'];
}


	   	function megaShot($sql){			
			$result = mysql_query($sql);
			if (!$result){
				throw new Exception(mysql_error());
			}
			
			$ret = array();
			while ($list = mysql_fetch_array($result)){
				$ret[sizeof($ret)] = $list;
			}
			
			return $ret;
		}


$totalT = megaShot("SELECT SUM( tarea.valor_facturar * tarea.tiempo_efectivo ) /60, 
SUM( tarea.tiempo_efectivo )/60
FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
WHERE tarea.idso in($solicitudes) and ca.tipo_servicio != 3");

$tiempo_efectivo_pc = megaShot("SELECT SUM( tarea.tiempo_efectivo )/60
FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
WHERE tarea.idso in($solicitudes) and ca.categoriaid!=22 and ca.tipo_servicio = 8"); 

$total_valor_hora_pc = megaShot("SELECT SUM( tarea.valor_facturar * tarea.tiempo_efectivo ) /60, 
SUM( tarea.tiempo_efectivo )/60,MAX(tarea.valor_facturar)
FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
WHERE tarea.idso in($solicitudes) and ca.categoriaid!=22 and ca.tipo_servicio = 8 and ca.tipo_servicio != 3");


$tiempo_efectivo_servidor = megaShot("SELECT SUM( tarea.tiempo_efectivo )/60
FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
WHERE  tarea.idso in($solicitudes) and ca.categoriaid!=22 and ca.tipo_servicio = 9");

$total_valor_hora_servidor = megaShot("SELECT SUM( tarea.valor_facturar * tarea.tiempo_efectivo ) /60, 
SUM( tarea.tiempo_efectivo )/60,MAX(tarea.valor_facturar)
FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
WHERE tarea.idso in($solicitudes) and ca.categoriaid!=22 and ca.tipo_servicio = 9 and ca.tipo_servicio != 3");

$cliente = megaShot("SELECT cli.nombre_empresa from tblclientes cli inner join tblsolicitudes so on so.Idcliente = cli.id_cli where so.id in ($solicitudes)");

/*
and
(so.valor_cotizacion is null or so.valor_cotizacion=0 or so.valor_cotizacion='') and (so.tiempo is null or so.tiempo=0 or  so.tiempo='')


*/

if(isset($_REQUEST["actualizar"])) 
	{


/*
			if($valorh!="" && $solicitudes!="")
			 {$sql1=mysql_query("update tbltareas tarea inner join tblsolicitudes so on so.id=tarea.idso 
			 set tarea.valor_facturar=$valorh where tarea.idso in($solicitudes) and tarea.idcategoria!=22 ")
			 or die("Error al actualizar tareas");

		     $sql2=mysql_query("update tbltareas set valor_facturar=0,valor_real=0,tiempo_facturar=0 where idso in($solicitudes) and idcategoria=22")
		     or die("Error al actualizar transporte");}


		     if($fecha_facturacion!="" && $numero_factura!="")
		     {
			     $sql=mysql_query("update tblsolicitudes set numero_factura='$numero_factura',fechafacturacion='$fecha_facturacion' idestado=6 where id in($solicitudes)")
			     or die("Error al actualizar solicitudes");
		     }

		     ?>

		     <script type="text/javascript">
		     window.close();
		     </script>

		     <?php
	*/

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
           <form action= "valor.php" name="frform" method="post">
				<table border=1 cellpadding=4 cellspacing=0 align=center>
				<tr>
					<td>Cliente</td>
					<td> <input type="text" name="cliente" id="cliente" value= "<?php  echo $cliente[0][0]; ?>" readonly="readonly"></td>		
			    </tr>
				<tr>
					<td>Total tiempo efectivo pc</td>
					<td> <input type="text" name="tiempo_efectivo_pc" id="tiempo_efectivo_pc" value= "<?php  echo round($tiempo_efectivo_pc[0][0],2); ?>" readonly="readonly"></td>		
			    </tr>

			    <tr>
					<td>valor hora pc</td>
					<td> <input type="text" name="valor_hora_pc" id="valor_hora_pc" onkeypress="recalculo_pc();" onkeyup="recalculo_pc();" value= "<?php  echo round($total_valor_hora_pc[0][2],2); ?>" ></td>		
			    </tr>

			    <tr>
					<td>valor total pc</td>
					<td> <input id="valor_total_pc" type="text" name="valor_total_pc" value= "<?php  echo round($total_valor_hora_pc[0][0],0); ?>" readonly="readonly"></td>		
			    </tr>

				<tr>
					<td>Total tiempo efectivo servidor</td>
					<td> <input type=text name="tiempo_efectivo_servidor" value= "<?php echo round($tiempo_efectivo_servidor[0][0],2); ?>" readonly="readonly"></td>		
			    </tr>

			     <tr>
					<td>valor hora servidor</td>
					<td> <input type="text" onkeypress="recalculo_servidor();" onkeyup="recalculo_servidor();" name="valor_hora_servidor" id="valor_hora_servidor" value= "<?php  echo round($total_valor_hora_servidor[0][2],2); ?>" ></td>		
			    </tr>

			     <tr>
					<td>valor total servidor</td>
					<td> <input type=text name="valor_total_servidor" id="valor_total_servidor" value= "<?php  echo round($total_valor_hora_servidor[0][0],0); ?>" readonly="readonly"></td>		
			    </tr>
				
				<tr>
					<td>Total tiempo efectivo</td>
					<td> <input type=text name="tiempof" id="tiempof" value= "<?php echo round($totalT[0][1],2); ?>" readonly="readonly"></td>		
			    </tr>

			      <tr>
					<td>Valor total</td>
					<td> <input type=text name="valorT" id="valorT" value= "<?php if($totalT!=0) {echo round(ceil($totalT[0][0]),0);}?>" readonly="readonly"></td>		
			    </tr>


			 <tr>
				<td>Numero factura</td>
				<td> <input type="text" id="numero_factura" name="numero_factura" value = "<?php if($numero_factura!="") {echo $numero_factura;} ?>"></td>			
			</tr>

		        <tr>
		          <td>fecha facturacion</td>
		          <td> <input type="text" id="fecha_facturacion" name="fecha_facturacion" readonly="readonly"  class="tcal"  value="<?php if($fecha_facturacion!="") {echo $fecha_facturacion;} ?>"></td>
		        </tr>

			 <tr>
					<td>id solicitudes seleccionadas</td>
					<td> <input type=text id="solicitudes" name="solicitudes" value=<?php if($solicitudes!="") {echo $solicitudes;}  ?> readonly="readonly"></td>	
			 </tr>


				<input type="button" name="actualizar" value="Actualizar" onclick="facturar()">
				
			</form>

<form name="prueba888" method="post" action="../../grid_solicitudes_analisis_factura/" >
<input type="submit" name="refrescar" value="Refrescar" onclick="window.opener.document.location.reload();self.close()"></form>

</table> <br>

</center>

 <div id="mensaje"></div>
  <div id="mensaje2"></div>

</body>
</html>

