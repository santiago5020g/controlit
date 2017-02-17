<?php 

$month = date('m');
$year = date('Y');
$day = date("d", mktime(0,0,0, $month+1, 0, $year));
$fin_mes=date('Y-m-d', mktime(0,0,0, $month, $day, $year));

if($fin_mes=='2014-09-30')
{
	require_once("solicitudes.php");


	$obj_solicitudes=new Solicitudes();
	$solicitudes_contrato=$obj_solicitudes->getSolicitudes();
	$total_registros=count($solicitudes_contrato);

	if($total_registros!=0)

	{

		for($i=0;$i<sizeof($solicitudes_contrato);$i++)
		{

			$tarea=$obj_solicitudes->getValidacion($solicitudes_contrato[$i]["so_id"]);
			$cuenta_tarea=count($tarea);
			if($cuenta_tarea!=1)
			{
				$valor=$solicitudes_contrato[$i]["contrato_valor"];
				$tiempof=$solicitudes_contrato[$i]["suma_tiempo_efectivo"];
			    $valor_calculado_hora=$valor/($tiempof/60);
			    $idso=$solicitudes_contrato[$i]["so_id"];
			    $obj_solicitudes->updateValor_factura_tareas($valor_calculado_hora,$idso);
			    echo  "id=".$solicitudes_contrato[$i]["so_id"]. "valor_contrato= ".$valor. " tiempo_efectivo= ".$tiempof." Valor a distribuir=".$valor_calculado_hora;
			    echo "<br>";
			}
			else {echo "la solicitud " .$solicitudes_contrato[$i]["so_id"]." tiene algunas tareas sin diligenciar "; echo "<br>"; }
		
		}

 	}

 	
 		$solicitudes_no_facturadas=$obj_solicitudes->getsolicitudes_no_facturadas();
 		$total_registros=count($solicitudes_no_facturadas);
 		if($total_registros!=0)
 		{
	 		$obj_solicitudes->update_solicitudes_no_facturadas();
	 		echo "no se facturaron: </br>";
	 		for($i=0;$i<sizeof($solicitudes_no_facturadas);$i++)
	 		{
	 			echo "<br> solicitud " .$solicitudes_no_facturadas[$i]["so_id"]." fecha inicio programado ".$solicitudes_no_facturadas[$i]["so_fecha_inicio_programado"]. " fecha fin programado ".$solicitudes_no_facturadas[$i]["so_fecha_fin_programado"]."</br>";
	 		}
 	    }

 	    else {echo "no hay registros que actualizar";}
 	

}




else 
{
	echo "no es fin de mes";
}

?>

