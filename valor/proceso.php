<?php  
require("../conexion/config.php");
    mysql_connect($dbHost, $dbUser, $dbPass) or die("no se pudo conectar");
    mysql_select_db($dataBase);

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



		$fecha_facturacion = date('Y-m-d',strtotime(str_replace('/', '-', $_REQUEST["fecha_facturacion"])));
	    $numero_factura = $_REQUEST["numero_factura"];
	    $solicitudes =$_REQUEST["solicitudes"];

if($_REQUEST["actualiza"]==1)
{

	    $valor_hora_pc = $_REQUEST["valor_hora_pc"];
	    $valor_hora_servidor = $_REQUEST["valor_hora_servidor"];
	    $codigo_error = 0;

		if($fecha_facturacion==""){echo "falta diligenciar la fecha de facturacion </br>";$codigo_error=1;}
		if($numero_factura==""){echo "falta diligenciar numero de factura </br>";$codigo_error=1;}
		if($solicitudes==""){echo "Error sin solicitudes seleccionadas </br>";$codigo_error=1;}


	if($codigo_error!=1)
	{
		$sql=mysql_query("update tblsolicitudes set numero_factura='$numero_factura',fechafacturacion='$fecha_facturacion',idestado=6 where id in($solicitudes)");
		$sql2=mysql_query("update tbltareas set fecha_facturacion_t = '$fecha_facturacion' where idso in($solicitudes)");
		if(!$sql){echo "Error al actualizar";}
		else 
		{

			$message=1;
			
		}
		//echo "<script type = text/javascript>window.close();</script>";

	}



	if($solicitudes!="")
	{$sql1=mysql_query("update tbltareas tarea inner join tblsolicitudes so on so.id=tarea.idso 
		inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
	set tarea.valor_facturar=$valor_hora_pc 
	WHERE tarea.idso in($solicitudes) and ca.categoriaid!=22 and ca.tipo_servicio = 8 and ca.tipo_servicio != 3 ")
	or die("Error al actualizar tareas");
	$sql2=mysql_query("update tbltareas tarea inner join tblsolicitudes so on so.id=tarea.idso 
		inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
	set tarea.valor_facturar=$valor_hora_servidor 
	WHERE tarea.idso in($solicitudes) and ca.categoriaid!=22 and ca.tipo_servicio = 9 and ca.tipo_servicio != 3")
	or die("Error al actualizar tareas");
	$sql3=mysql_query("update tbltareas set valor_facturar=0,valor_real=0,tiempo_facturar=0 where idso in($solicitudes) and idcategoria=22")
	or die("Error al actualizar transporte");
		if($sql1!=false && $sql2!=false && $sql3!=false)
		{
			$message=2;
		}
	//echo "<script type = text/javascript>window.close();</script>";
	}

		if($message==1 || $message==2)
		{
			echo "<script type=text/javascript>alert('Modificado');</script>";
		}

}


else if($_REQUEST["actualiza"]==0 && $_REQUEST["pc"]==1)
{

	$codigo_error = 0;
	$valor_hora_pc = $_REQUEST["valor_hora_pc"];
	$total_valor_hora_pc = megaShot("SELECT SUM( $valor_hora_pc * tarea.tiempo_efectivo ) /60, 
	SUM( tarea.tiempo_efectivo )/60,tarea.valor_facturar
	FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
	inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
	WHERE tarea.idso in($solicitudes) and ca.categoriaid!=22 and ca.tipo_servicio = 8 and ca.tipo_servicio != 3");

	echo round($total_valor_hora_pc[0][0],0);

}

else if($_REQUEST["actualiza"]==0 && $_REQUEST["servidor"]==1)
{

	$codigo_error = 0;
	$valor_hora_servidor = $_REQUEST["valor_hora_servidor"];
	$total_valor_hora_servidor = megaShot("SELECT SUM( $valor_hora_servidor * tarea.tiempo_efectivo ) /60, 
	SUM( tarea.tiempo_efectivo )/60,tarea.valor_facturar
	FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
	inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
	WHERE tarea.idso in($solicitudes) and ca.categoriaid!=22 and ca.tipo_servicio = 9 and ca.tipo_servicio != 3");

	echo round($total_valor_hora_servidor[0][0],0);
}


/*
echo $fecha_facturacion."</br>";
echo $numero_factura."</br>";
echo $solicitudes."</br>";
*/

?>




