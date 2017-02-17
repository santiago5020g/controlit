<div id="cuerpo">
	<?php

	require("solicitudes.php");
	require "PDO_Pagination.php";
	$sql_solicitudes = "";


	if(isset($_REQUEST["chkestadojx"]))
	{
		$chkestadojx=$_REQUEST["chkestadojx"];

		if($chkestadojx!="")
		{
			if ($sql_solicitudes != "") 
			{
				$sql_solicitudes .= " AND ";
			}
			$sql_solicitudes .= "solicitudes.idestado in($chkestadojx)";
		}
	}



	if(isset($_REQUEST["fecha_inicio_programadojx"]) && isset($_REQUEST["fecha_inicio2_programadojx"]))
	{

		$fecha_inicio_programadojx=$_REQUEST["fecha_inicio_programadojx"];
		$fecha_inicio2_programadojx=$_REQUEST["fecha_inicio2_programadojx"];
		if($fecha_inicio_programadojx!="" && $fecha_inicio2_programadojx!="")
		{

			$fecha_inicio_programadojx=str_replace('/','-',$_REQUEST["fecha_inicio_programadojx"]);
			$fecha_inicio2_programadojx=str_replace('/','-',$_REQUEST["fecha_inicio2_programadojx"]);
			$fecha_inicio_programadojx=date('Y-m-d',strtotime($fecha_inicio_programadojx));
			$fecha_inicio2_programadojx=date('Y-m-d',strtotime($fecha_inicio2_programadojx));
			if ($sql_solicitudes != "") 
			{
				$sql_solicitudes .= " AND ";
			}
			$sql_solicitudes .= "solicitudes.fecha_inicio_programado between '$fecha_inicio_programadojx' and '$fecha_inicio2_programadojx'";
		}

	}


	else if(isset($_REQUEST["fecha_inicio_programadojx"]))
		{
			$fecha_inicio_programadojx=$_REQUEST["fecha_inicio_programadojx"];
			$fecha_inicio_programadojx=str_replace('/','-',$_REQUEST["fecha_inicio_programadojx"]);
			$fecha_inicio_programadojx=date('Y-m-d',strtotime($fecha_inicio_programadojx));
			if ($sql_solicitudes != "") 
			{
				$sql_solicitudes .= " AND ";
			}
			$sql_solicitudes .= "solicitudes.fecha_inicio_programado='$fecha_inicio_programadojx'";
		}


	if(isset($_REQUEST["fecha_fin_programadojx"]) && isset($_REQUEST["fecha_fin2_programadojx"]))
	{

		$fecha_fin_programadojx=$_REQUEST["fecha_fin_programadojx"];
		$fecha_fin2_programadojx=$_REQUEST["fecha_fin2_programadojx"];
		if($fecha_fin_programadojx!="" && $fecha_fin2_programadojx!="")
		{

			$fecha_fin_programadojx=str_replace('/','-',$_REQUEST["fecha_fin_programadojx"]);
			$fecha_fin2_programadojx=str_replace('/','-',$_REQUEST["fecha_fin2_programadojx"]);
			$fecha_fin_programadojx=date('Y-m-d',strtotime($fecha_fin_programadojx));
			$fecha_fin2_programadojx=date('Y-m-d',strtotime($fecha_fin2_programadojx));
			if ($sql_solicitudes != "") 
			{
				$sql_solicitudes .= " AND ";
			}
			$sql_solicitudes .= "solicitudes.fecha_fin_programado between '$fecha_fin_programadojx' and '$fecha_fin2_programadojx'";
		}


	}

	
		else if(isset($_REQUEST["fecha_fin2_programadojx"]))
		{
			$fecha_fin_programadojx=$_REQUEST["fecha_fin_programadojx"];
			$fecha_fin_programadojx=str_replace('/','-',$_REQUEST["fecha_fin_programadojx"]);
			$fecha_fin_programadojx=date('Y-m-d',strtotime($fecha_fin_programadojx));
			if ($sql_solicitudes != "") 
			{
				$sql_solicitudes .= " AND ";
			}
			$sql_solicitudes .= "solicitudes.fecha_fin_programado='$fecha_fin_programadojx'";
		}




	if(isset($_REQUEST["clientesjx"]))
	{
		$idclientejx=$_REQUEST["clientesjx"];
		if($idclientejx!=0)
		{
			if ($sql_solicitudes != "") 
			{
				$sql_solicitudes .= " AND ";
			}
			$sql_solicitudes .= "solicitudes.Idcliente=$idclientejx ";
		}
	}

	if(isset($_REQUEST["tecnicojx"]))
	{
		$tecnicojx=$_REQUEST["tecnicojx"];
		if($tecnicojx!='0')
		{
			if ($sql_solicitudes != "") 
			{
				$sql_solicitudes .= " AND ";
			}
			$sql_solicitudes .= "solicitudes.propietario='$tecnicojx' ";
		}
	}


	echo $sql_solicitudes;

	$pagination = new PDO_Pagination();
	$obj_solicitudes=new solicitudes();
	$URL = "'index.php'";
	$variables = "'clientes,tecnico,fecha_inicio_programado,fecha_inicio2_programado,fecha_fin_programado,fecha_fin2_programado,chkestado[]'";
	$contenido = "'contenido'";

	$solicitudes_num=$obj_solicitudes->getSolicitudes($sql_solicitudes);
	$pagination->rowCount($solicitudes_num[0][0],$URL,$variables,$contenido);
	//echo $solicitudes_num[0][0];
	$pagination->config(10, 20);
	$pagina=$obj_solicitudes->Paginacion($pagination->start_row, $pagination->max_rows,$sql_solicitudes);

	$pagination->btn_first_page = 'Primera';
	$pagination->btn_last_page = 'Ultima';
	$pagination->btn_next_page = 'Siguiente';
	$pagination->btn_back_page = 'Atras';
	$pagination->btn_page = 'Pag.';
	$pagination->btn_active = 'active';

	?>


	<html>
	<head>
		<meta http-equiv="Content-type" content="text/htal; charset=UTF-8">
		<title>prueba</title>



	</head>

	<body >



		<table >
			<tr>
				<th>Opciones</th>
				<th>Id</th>
				<th>Cliente</th>
				<th>Tecnico</th>
				<th>Estado</th>
				<th>Asunto</th>
				<th>Descripcion</th>
				<th>Fecha inicio programado</th>
				<th>hora inicio programado</th>
				<th>Fecha fin programado</th>
				<th>hora fin programado</th>

			</tr>


			<?php for($i=0;$i<sizeof($pagina);$i++) { ?>
			<tr id="<?php echo "r1_$i"; ?>"> 

				<td>
					<span class="editar" onclick="nueva_ventana('modificar_solicitudes.php?id=<?php echo $pagina[$i]["solicitud_id"]; ?>');" title="Editar 

						registro">Editar</span></a> 
					</td>

					<td id="<?php echo "r2_$i"; ?>"  style="cursor: pointer" onclick="swap('<?php echo "r2_$i"; ?>')"><?php echo $pagina[$i]["solicitud_id"]; ?></td>
					<td><?php echo $pagina[$i]["solicitud_nombre_empresa"]; ?></td>
					<td><?php echo $pagina[$i]["users_name"]; ?></td>
					<td><?php echo $pagina[$i]["est_Descripcion"]; ?></td>
					<td><?php echo $pagina[$i]["solicitud_asunto"]; ?></td>
					<td><?php echo $pagina[$i]["solicitud_descripcion"]; ?></td>
					<td><?php echo date('d/m/Y',strtotime($pagina[$i]["solicitud_fecha_inicio_programado"])); ?></td>
					<td><?php echo $pagina[$i]["solicitud_hora_inicio_programado"]; ?></td>
					<td><?php echo date('d/m/Y',strtotime($pagina[$i]["solicitud_fecha_fin_programado"])); ?></td>
					<td><?php echo $pagina[$i]["solicitud_hora_fin_programado"]; ?></td>

				</tr>




				<?php $tareas=$obj_solicitudes->getTareas($pagina[$i]["solicitud_id"]); 
				$contador2=0;
				for($i2=0;$i2<sizeof($tareas);$i2++)
				{

					$contador2++;
					?>

					<tr class="<?php echo "r2_$i"; ?>" style="display: none">
						<th></th>
						<th></th>
						<th><b>Tarea</b></th>
						<th><b>idsolicitud</b></th>
						<th><b>Tecnico</b></td>
							<th><b>Fecha inicio</b></th>
							<th><b>hora inicio</b></th>
							<th><b>hora fin</b></th>
							<th><b>Tiempo efectivo</b></th>
							<th><b>Categoria</b></th>
							<th><b>Detalles</b></th>
							<th><b>Pendientes</b></th>
						</tr>


						<?php $contador2++?>

						<tr class="<?php echo "r2_$i"; ?>" style="display: none">
							<td></td>
							<td></td>
							<td><?php echo $tareas[$i2]["tareas_idtareas"] ?></td>
							<td><?php echo $tareas[$i2]["tareas_iso"] ?></td>
							<td><?php echo $tareas[$i2]["users_name"] ?></td>
							<td><?php echo $tareas[$i2]["tareas_fecha_inicio"] ?></td>
							<td><?php echo $tareas[$i2]["tareas_hora_inicio"] ?></td>
							<td><?php echo $tareas[$i2]["tareas_hora_fin"] ?></td>
							<td><?php echo $tareas[$i2]["tareas_tiempo_efectivo"] ?></td>
							<td><?php echo $tareas[$i2]["categoria_descripcion"] ?></td>
							<td><?php echo $tareas[$i2]["tareas_observaciones"] ?></td>
							<td><?php echo $tareas[$i2]["tareas_pendientes"] ?></td>
						</tr>


						<?php } ?>

						<?php } ?>

					</table> <br>


					<br>
					<br>
					<style>
					/* CSS */
					.btn
					{
						text-decoration: none;
						color: #FFFFFF;
						padding-left: 10px;
						padding-right: 10px;
						margin-left: 1px;
						margin-right: 1px;
						border-radius: 3px;
						background: #7F83AD;
					}

					.btn:hover
					{
						background: #474C80;
					}
					.active
					{
						background: #E7814A;
					}
					/* CSS */
					</style>






					<?php
					$pagination->pages("btn");
					?>

				</body>
				</html>

			</div>

