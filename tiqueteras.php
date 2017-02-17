
<?php

require('conexion/conexion.php');


if({idservicio}==2)
	{
		 $i=0;
		 $i2=0;
		 $total = 0;
		 $tiempo_tarea=0;
		 sc_lookup(tiqueteras,"select id,minutos from tbltiqueteras where idcliente =". 			     {Idcliente});
		  sc_lookup(tareas,"select idtareas,tiempo_efectivo from tbltareas where idso =".{id});
		 
		 for($i;$i<sizeof({tiqueteras});$i++)
	{
			 $tiqueteras1 = {tiqueteras[$i][0]};

	for($i2;$i2<sizeof({tareas});$i2++)
	{
		
		$idtarea1 = {tareas[$i2][0]};
		$tiempo_tarea = {tareas[$i2][1]};
		$total = $total + $tiempo_tarea;
		$sw = 0;

			if($total<=240)
			{
				sc_exec_sql("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");

			}
		
			else
			{
				$numero_clicos = round($total/240,0);
				for($i2;$i2<$numero_clicos;$i2++)
				{
					$total_temporal = $total;
					$total = $total - 240;
					$tiempo_tarea = $tiempo_tarea - $total;
					$tiqueteras1 =  $tiqueteras1 = {tiqueteras[$i][0]};
					if($i = sizeof($tiqueteras) -1)
					{
						$tiempo_tarea = $total_temporal;
				sc_exec_sql("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
						$numero_clicos = $numero_clicos +1;	
						$sw = 1;
					}

					else
					{
				sc_exec_sql("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
						$i+=1;
					}

				}

					if($total > 0 && $sw==0)
					{
						$tiempo_tarea = $total;
						$total = 0;
				sc_exec_sql("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
					}
			}// fin else

		
	}// fin for tareas
		
}// fin for tiqueteras
	}// fin servicio

?>