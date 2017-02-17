<?php

require('../conexion/conexion.php');

$obj_conexion = new Conn();
$i = 0;
$i2 = 0;
$tiqueteras_excedidas = array();
$tiqueteras = array();
$tiqueteras_disponibles = array();
$suma = array();
//$cliente = 811039981;
$cliente = $_REQUEST["cliente"];
$i = 0;
$i3 = 0;
$i5 = 0;
$i_tareas_excedidas = 0;

$tiqueteras_excedidas = $obj_conexion->megaShot("SELECT mov.numero_tiquetera,SUM(mov.puntos_consumidos) from tblmovimientos mov inner join tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = '$cliente' GROUP by mov.numero_tiquetera having SUM(mov.puntos_consumidos)>240");
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



if(count($tiqueteras_excedidas) > 0)
{

	for($i3=0;$i3<sizeof($tiqueteras_excedidas);$i3++)
	{

		$tareas_excedidas = $obj_conexion->megaShot("SELECT mov.numero_tarea,mov.puntos_consumidos,mov.id from tblmovimientos mov where mov.numero_tiquetera =".$tiqueteras_excedidas[$i3][0]);
		$suma_tarea_excedida = $obj_conexion->megaShot("SELECT SUM(mov.puntos_consumidos) from tblmovimientos mov where mov.numero_tiquetera =".$tiqueteras_excedidas[$i3][0]);
		$quitar_puntos = $suma_tarea_excedida[0][0] - 240;//1380-240=1140

		for($i_tareas_excedidas = 0;$i_tareas_excedidas< sizeof($tareas_excedidas);$i_tareas_excedidas++)
		{
			if($quitar_puntos >= $tareas_excedidas[$i_tareas_excedidas][1])//si 280 > 400
			{
				$quitar_puntos = $quitar_puntos - $tareas_excedidas[0][1];//
				$tiempo_tarea = $tareas_excedidas[0][1];//300
				$obj_conexion->updateShot("DELETE FROM tblmovimientos WHERE id = ".$tareas_excedidas[$i_tareas_excedidas][2]);//
			}//fin if($quitar_puntos >= $tareas_excedidas...)
			else
			{
				$tiempo_tarea = $quitar_puntos;//280
				$quitar_puntos = $tareas_excedidas[$i_tareas_excedidas][1] - $quitar_puntos;//400 - 280 = 120
				$obj_conexion->updateShot("UPDATE tblmovimientos SET puntos_consumidos = $quitar_puntos WHERE id =".$tareas_excedidas[$i_tareas_excedidas][2]); //actualice 288 a 120
			}//fin else
				$idtarea1 = $tareas_excedidas[$i_tareas_excedidas][0];
				for($i = 0;$i<sizeof($tiqueteras);$i++)
				{
				 	$suma = $obj_conexion->megaShot("SELECT SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera=".$tiqueteras[$i][0]);
				 	if($suma[0][0]<240){$tiqueteras_disponibles[$i2][0] = $tiqueteras[$i][0]; /*echo $tiqueteras_validadas[$i2][0]."<br>";*/ $i2++;}
				}

				if(count($tiqueteras_disponibles)==0)
				{
					 	$tiquetera_maxima = $obj_conexion->megaShot("SELECT MAX(ti.id) from tblmovimientos mov inner join  tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = '$cliente' and mov.estado_cruzado = 1");
					 	$tiqueteras_disponibles[0][0] = $tiquetera_maxima[0][0];
				}// fin if(count($tiqueteras_disponibles)==0)


				

		}// fin for ($i_tareas_excedidas = 0;...)
		
	}// fin for($i3=0;$i3<sizeof($tiqueteras_excedidas);$i3++)

}// fin if(count($tiqueteras_excedidas)>0)


/*
for($i=0;$i<sizeof($tiqueteras_disponibles);$i++)
				{
					$suma3 = $obj_conexion->megaShot("SELECT SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera=".$tiqueteras_disponibles[$i][0]);
					$total = $suma3[0][0];
					$tiqueteras1 = $tiqueteras_disponibles[$i][0];
					if($total<240)
					{
						if($i == sizeof($tiqueteras_disponibles)-1)
						{
							$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
							$i = sizeof($tiqueteras_disponibles) +1;
						}// fin if($i == sizeof($tiqueteras)-1; $i++)

						else if($tiempo_tarea+$total <=240)
						{
							$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
							$i = sizeof($tiqueteras_disponibles) +1;
						}//fin else if($tiempo_tarea+$total <=240)


						else
						{
							$tiempo_tarea_insertar = 240 - $total;
							$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea_insertar,1)");
							$tiempo_tarea = $tiempo_tarea - $tiempo_tarea_insertar;
						}//fin else
				
					}//fin if($total<240)

					else
					{
						if($i < sizeof($tiqueteras_disponibles)-1)
						{
							$i+= 1;
							$tiqueteras1 = $tiqueteras_disponibles[$i][0];
						}// fin if($i < sizeof($tiqueteras)-1)

						else
						{
							$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
							$i = sizeof($tiqueteras_disponibles) +1;
						}//fin else
					}// fin else

				}//fin for($i=0;$i<sizeof($tiqueteras_disponibles);$i++)

*/


?>



