<?php 
require('solicitudes.php');
require("PDO_Pagination.php");
$obj_solicitudes=new Solicitudes();
$pagination = new PDO_Pagination();
$URL = "'tarea_modificacion.php'";
$variables = "'id-".$_REQUEST["id"]."'";
$contenido = "'tareas'";


$tareas_num=$obj_solicitudes->getTareas_paginacion_num($_REQUEST["id"]);
$pagination->rowCount($tareas_num[0][0],$URL,$variables,$contenido);
$pagination->config(10, 5);
$tareas_paginacion=$obj_solicitudes->getTareas_paginacion($pagination->start_row, $pagination->max_rows,$_REQUEST["id"]);
$pagination->btn_first_page = 'Primera';
$pagination->btn_last_page = 'Ultima';
$pagination->btn_next_page = 'Siguiente';
$pagination->btn_back_page = 'Atras';
$pagination->btn_page = 'Pag.';
$pagination->btn_active = 'active';


$sedes=$obj_solicitudes->getSedes($tareas_paginacion[0]["so_idcliente"]);
$clientes=$obj_solicitudes->getClientes();
$prioridad=$obj_solicitudes->getPrioridad();
$estado=$obj_solicitudes->getEstado();
$propietario=$obj_solicitudes->getTecnicos();
$proyecto=$obj_solicitudes->getProyectos();
$categorias=$obj_solicitudes->getCategorias();
$disposicion=$obj_solicitudes->getDisposicion();
?>


<table>

	<input type="button" onclick="" value="Nuevo">
	<input type="button" onclick="" value="Actualizar">
	<input type="button" onclick="" value="Borrar">

				<tr>
					<td style= "padding-right : 20px;">
						<label></label>
					</td>
					<td style= "padding-right : 20px;">
						<label>Idtareas</label>
					</td>
					<td style= "padding-right : 20px;">
						<label>Idso</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Fecha inicio</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Hora inicio</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Hora fin</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Tiempo real</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Tiempo efectivo</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Categoria</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Disposicion</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Sede</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Detalles</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Pendientes</label>

					</td>
					<td style= "padding-right : 20px;">
						<label>Gastos transporte</label>

					</td>
				</tr>
				<?php for($i=0;$i<sizeof($tareas_paginacion);$i++) {?>
				<tr>
					<td><input type="checkbox" name="checktarea[]" onclick="" value=""></td>
					<td>
						<label id="idtareas1" ><?php  echo $tareas_paginacion[$i]["tareas_idtareas"];?></label>
					</td>
					<td>
						<label><?php  echo $tareas_paginacion[$i]["tareas_iso"];?></label>
					</td>
					<td style= "padding-right : 20px;">
						<input type="text" id="fecha_inicio" name="fecha_inicio" size="10" maxlength="10" onkeyup="dtval(this,event)" value="<?php echo date('d/m/Y',strtotime($tareas_paginacion[0]["tareas_fecha_inicio"])); ?>">

					</td>
					<td style= "padding-right : 20px;">
						<input type="text" id="hora_inicio" value ="<?php echo date('H:i', strtotime($tareas_paginacion[$i]["tareas_hora_inicio"])); ?>" name="hora_inicio" size="10" maxlength="5" onkeyup="hour(this,event);" >

					</td>
					<td style= "padding-right : 20px;">
						<input type="text" id="hora_fin" value ="<?php echo date('H:i', strtotime($tareas_paginacion[$i]["tareas_hora_fin"])); ?>" name="tareas_hora_fin" size="10" maxlength="5" onkeyup="hour(this,event);" >

					</td>
					<td style= "padding-right : 20px;">
						<?php
						$hora_inicio = substr($tareas_paginacion[$i]["tareas_hora_inicio"],0,2);
						$minutosi=substr($tareas_paginacion[$i]["tareas_hora_inicio"],3,2);

						$hora_fin = substr($tareas_paginacion[$i]["tareas_hora_fin"],0,2);
						$minutosf=substr($tareas_paginacion[$i]["tareas_hora_fin"],3,2);
						$total=$minutosf-$minutosi;


						$totalh=($hora_fin-$hora_inicio)*60;
						$totalm=$minutosf-$minutosi;
						$total=$totalh+$totalm;
						echo $total;
						?>

					</td>
					<td style= "padding-right : 20px;">
						<label id="tiempo_efectivo"> <?php echo $tareas_paginacion[$i]["tareas_tiempo_efectivo"];?></label>

					</td>
					<td style= "padding-right : 20px;">
						<select style="width: 120px;">
							<?php for($i2=0;$i2<sizeof($categorias);$i2++){ ?>
							<option value="<?php echo $categorias[$i2]["categoria_categoriaid"];?>" <?php if($tareas_paginacion[$i]["tareas_idcategoria"]==$categorias[$i2]["categoria_categoriaid"]) echo "selected"; ?>  ><?php echo $categorias[$i2]["categoria_descripcion"]; ?></option>
							<?php }?>
						</select>

					</td>
					<td style= "padding-right : 20px;">
						<?php for($i2=0;$i2<sizeof($disposicion);$i2++) { ?>
						<input type="radio" name="disposicion" id="disposicion" value="<?php echo $disposicion[$i2]["Descripcion"] ?>" <?php if($tareas_paginacion[$i]["tareas_disposicion"]==$disposicion[$i2]["Descripcion"]) {echo "checked";}?> /> <?php echo $disposicion[$i2]["Descripcion"];?>
						<?php } ?>

					</td>
					<td style= "padding-right : 20px;">
						<select name="sedes2" id="sede2" style="width: 190px; height: 20px">
							<?php for($i2=0;$i2<sizeof($sedes);$i2++) {?>
							<option value="<?php echo $sedes[$i2]["sede_id"]; ?>" <?php if($tareas_paginacion[$i]["tareas_idsitio"]==$sedes[$i2]["sede_id"]){echo "selected";} ?> > <?php echo $sedes[$i2]["sede_descripcion"]; ?> </option>

							<?php }?>

						</td>

						<td style= "padding-right : 20px;">
							<textarea style="width:300px;height:80px;" id="detalles"><?php echo $tareas_paginacion[$i]["tareas_observaciones"]; ?></textarea>
						</td>
						<td style= "padding-right : 20px;">
							<textarea style="width:300px;height:80px;" id="pendietes"><?php echo $tareas_paginacion[$i]["tareas_pendientes"]; ?></textarea>
						</td>


						<td style= "padding-right : 20px;">
							<input type="text" id="gastos_transporte" style="width: 130px;" value="<?php echo $tareas_paginacion[$i]["tareas_gatos_transporte"]; ?>" onKeyPress="return onlynum(event)" />
						</td>
					</tr>
					<?php }?>
				</table>

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

