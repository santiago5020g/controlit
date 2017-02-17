<?php

require('../conexion/conexion.php');

$obj_conexion = new Conn();
$i = 0;
$i2 = 0;
$tareas_excedidas = array();
$tiqueteras = array();
$tiqueteras_disponibles = array();
$suma = array();
//$cliente = 900449925;
$cliente = $_REQUEST["cliente"];
$i = 0;
$i3 = 0;
$i5 = 0;

$tareas_excedidas = $obj_conexion->megaShot("SELECT mov.numero_tarea,SUM(mov.puntos_consumidos) from tblmovimientos mov inner join tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = '$cliente' GROUP by mov.numero_tarea having SUM(mov.puntos_consumidos)>240");
$tiqueteras = $obj_conexion->megaShot("SELECT id from tbltiqueteras where idcliente = '$cliente'");



for($i = 0 ; $i<sizeof($tiqueteras);$i++)
		{
			 	$suma = $obj_conexion->megaShot("SELECT SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera=".$tiqueteras[$i][0]);
			 	if($suma[0][0]<240){$tiqueteras_disponibles[$i2][0] = $tiqueteras[$i][0]; /*echo $tiqueteras_validadas[$i2][0]."<br>";*/ $i2++;}
		}

		if(count($tiqueteras_disponibles)==0)
		{
			 	$tiquetera_maxima = $obj_conexion->megaShot("SELECT MAX(ti.id) from tblmovimientos mov inner join  tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = '$cliente' and mov.estado_cruzado = 1");
			 	$tiqueteras_disponibles[0][0] = $tiquetera_maxima[0][0];
		}	



if(count($tareas_excedidas) > 0)
{

	for($i3=0;$i3<sizeof($tareas_excedidas);$i3++)
	{
		$numero_tarea = $tareas_excedidas[$i3][0];
		$puntos_consumidos = ($tareas_excedidas[$i3][1] - 240) / count($tiqueteras_disponibles);


		$cantidad_actualizar = $obj_conexion->megaShot("SELECT count(1) FROM tblmovimientos WHERE numero_tarea = '$numero_tarea'");
		$puntos_actualizar = 240 / $cantidad_actualizar[0][0];
		$obj_conexion->updateShot("UPDATE tblmovimientos SET puntos_consumidos = $puntos_actualizar WHERE numero_tarea = '$numero_tarea'");


		for($i15 = 0 ; $i15 < sizeof($tiqueteras_disponibles);$i15++)
		{	
			$numero_tiquetera = $tiqueteras_disponibles[$i15][0];
			$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($numero_tiquetera,$numero_tarea,$puntos_consumidos,1)");
		}
		
	}// fin for($i3=0;$i3<sizeof($tareas_excedidas);$i3++)

}



?>



