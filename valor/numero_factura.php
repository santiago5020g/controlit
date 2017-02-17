
<?php

$host_db = "192.168.200.17"; // Host de la BD
    $usuario_db = "administrador"; // Usuario de la BD
    $clave_db = "Gusano2012"; // Contraseña de la BD
    $nombre_db = "pruebas_controlit3"; // Nombre de la BD
    
    //conectamos y seleccionamos db
    mysql_connect($host_db, $usuario_db, $clave_db) or die("no se pudo conectar");
    mysql_select_db($nombre_db);



$numero_factura="";
$fecha_facturacion="";
$tiempof="";
$solicitudes="";

if(isset($_POST["numero_factura"])) 
{
$numero_factura= $_POST['numero_factura'];
}

if(isset($_POST["fecha_facturacion"])) 
{
$fecha_facturacion= $_POST['fecha_facturacion'];
}

if(isset($_POST["solicitudes"])) 
{
$solicitudes=$_POST['solicitudes'];
}


if(isset($_POST["actualizar"]) and $numero_factura!="" and $fecha_facturacion!="" and $solicitudes!="") 
	{
		

    $facturar_a_facturado=date('Y-m-d');

    $sql1=mysql_query("update tblsolicitudes set numero_factura='$numero_factura',fechafacturacion='$fecha_facturacion',facturar_a_facturado='$facturar_a_facturado',
      idestado=6 where id in($solicitudes) ")
     or die("Error al actualizar solicitudes");
	}

  
    else

    {
      
    echo "<script language=javascript>
    alert('no se puede actualizar porque el numero de factura o la fecha de facturacion no estan diligenciados');
      </script>";
    } 


?>


</script> 

<html>
  <head>
  	<title>n</title>
<script type="text/javascript" src="../mis_librerias/calendar/tcal.js"></script>
<link rel="stylesheet "type="text/css" href="../mis_librerias/calendar/tcal.css" />
  </head>
  <body>

<center>
           <form action= "numero_factura.php" name="frform" method="post">
				<table border=1 cellpadding=4 cellspacing=0 align=center>
			<tr>
						<td>Numero factura</td>
						<td> <input type="text" name="numero_factura" value = "<?php if($numero_factura!="") {echo $numero_factura;} ?>"></td>			
						
			</tr>

         <tr>
          <td>fecha facturacion</td>
          <td> <input type=text name="fecha_facturacion" class="tcal"  value="<?php if($fecha_facturacion!="") {echo $fecha_facturacion;} ?>"></td>
        </tr>
				
			 <tr>
					<td>id solicitudes seleccionadas</td>
					<td> <input type=text name="solicitudes" value="<?php if($solicitudes!="") {echo $solicitudes;}  ?>" readonly="readonly"></td>			
			 </tr>

				
				
				<input type="submit" name="actualizar" value="Actualizar">
				
			</form>

<form name="prueba888" method="post" action="../grid_solicitudes_pdf/grid_solicitudes_pdf.php" >
<input type="submit" name="refrescar" value="Refrescar" onclick="parent.location.reload();"></form>

</table> <br>

</center>;
  </body>
</html>


					