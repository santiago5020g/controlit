<?php
require('solicitudes.php');
require("PDO_Pagination.php");
$obj_solicitudes=new Solicitudes();
$pagination = new PDO_Pagination();
$Solicitudes=$obj_solicitudes->getSolicitudes_por_id($_GET["id"]);
$clientes=$obj_solicitudes->getClientes();
$prioridad=$obj_solicitudes->getPrioridad();
$estado=$obj_solicitudes->getEstado();
$sedes=$obj_solicitudes->getSedes($Solicitudes[0]["solicitud_idcliente"]);
$propietario=$obj_solicitudes->getTecnicos();
$proyecto=$obj_solicitudes->getProyectos();
$tareas_paginacion=$obj_solicitudes->getTareas_paginacion($Solicitudes[0]["solicitud_id"]);
$categorias=$obj_solicitudes->getCategorias();
$disposicion=$obj_solicitudes->getDisposicion();




?>




<html>
<head>
	<meta http-equiv="Content-type" content="text/htal; charset=UTF-8">
	<title>prueba</title>
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script src="js/solicitudes_jx.js" type="text/javascript"></script>


<script type="text/javascript">
$(document).ready(function() {    
    $('.paginate').live('click', function(){

        $('#content').html('<div><img src="images/loading.gif" width="70px" height="70px"/></div>');

        var page = $(this).attr('data');        
        var dataString = 'page='+page;

        $.ajax({
            type: "GET",
            url: "includes/pagination.php",
            data: dataString,
            success: function(data) {
                $('#content').fadeIn(1000).html(data);
            }
        });
    });              
});    
</script>

	<link rel="stylesheet" type="text/css" href="css/style1.css">	
	<link rel="stylesheet" type="text/css" href="css/style3.css">
	<link rel="stylesheet" type="text/css" href="css/style2.css" media="screen" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>

<body>
	<form  name="frmclientes" >
		<div id="bloque_botones" style="height: 40px; margin-left: 40%; margin-top: 15px;">
			<?php if($Solicitudes[0]["solicitud_idestado"]==1 or $Solicitudes[0]["solicitud_idestado"]==2) { ?>
			<input type="button" name="actualizar" value="Nuevo">
			<input type="button" name="actualizar" value="Actualizar solicitud" onclick="Update_solicitudes();">
			<input type="button" name="actualizar" value="Borrar">
			<?php }?>
		</div>
	</form>

	<div id="mensaje"></div>

	<div id="demo">

		<section id="tabbed">
			<!-- First tab input and label -->
			<input id="t-1" name="tabbed-tabs" type="radio" checked="checked" />
			<label for="t-1" class="tabs shadow entypo-star">Solicitud</label>
			<!-- Second tab input and label -->
			<input id="t-2" name="tabbed-tabs" type="radio" />
			<label for="t-2" class="tabs shadow   entypo-pencil">Tareas</label>
			<!-- Third tab input and label -->
			<!-- Tabs wrapper -->
			<div class="wrapper shadow">

				<!-- Tab 1 content -->
				<div class="tab-1">
					<table>

						<tr>
							<td style="width: 200px;">
								<label>Id</label>
								<label id="solicitudd"><?php echo $Solicitudes[0]["solicitud_id"]; ?></label>
							</td>

							<td style="width: 200px;">
								<label>Cliente</label>
								<select name="clientes" id="clientes" style="width: 140px; height: 20px" >
									<?php for($i=0;$i<sizeof($clientes);$i++) { ?>
									<option value="<?php echo $clientes[$i]['id_cli']; ?>" <?php if ($clientes[$i]["id_cli"]==$Solicitudes[0]["solicitud_idcliente"]){echo "selected";} ?> > <?php echo $clientes[$i]["nombre_empresa"]; ?></option>
									<?php }?>
								</select>
							</td>
							<td style="width: 200px;">
								<label>Asunto</label>
								<input type="text" name="txtasunto" id="asunto" value="<?php echo $Solicitudes[0]["solicitud_asunto"]; ?>" >
							</td>

							<td style="width: 200px;">
								<label>Prioridad</label>
								<select name="prioridad" id="prioridad">
									<?php for($i=0;$i<sizeof($prioridad);$i++) { ?>
									<option value="<?php echo $prioridad[$i]['id']; ?>" <?php if ($prioridad[$i]["id"]==$Solicitudes[0]["solicitud_idprioridad"]){echo "selected";} ?> > <?php echo $prioridad[$i]["descripcion"]; ?></option>
									<?php }?>
								</select>
							</td>

							<td>
								<label> Fecha inicio creacion</label>
								<label><?php echo date('d/m/Y',strtotime($Solicitudes[0]["solicitud_fecha_inicio_creacion"])); ?></label>
							</td>
						</tr>		 	

						<tr>
							<td style="width: 200px;"><label>Contacto</label> <input type="text" name="txtcontacto" id="contacto" value="<?php echo $Solicitudes[0]["solicitud_contacto"]; ?>" ></td>
							<td style="width: 200px;"><label>Correo</label><input type="text" id="correo" value="<?php echo $Solicitudes[0]["solicitud_correo"]; ?>"></td>
							<td style="width: 200px;">
								<label>Sede</label>
								<select name="sedes" id="sede1" style="width: 190px; height: 20px">
									<?php for($i=0;$i<sizeof($sedes);$i++) {?>
									<option value="<?php echo $sedes[$i]["sede_id"]; ?>" <?php if($Solicitudes[0]["tareas_idsitio"]==$sedes[$i]["sede_id"]){echo "selected";} ?> > <?php echo $sedes[$i]["sede_descripcion"]; ?> </option>

									<?php }?>
								</select>

							</td>
							<td style="width: 200px;"><label>Estado</label>
								<select name="estado" id="estado1">
									<?php for($i=0;$i<sizeof($estado);$i++) { ?>
									<option value="<?php echo $estado[$i]["idestado"]; ?>" <?php if($estado[$i]["idestado"]==$Solicitudes[0]["solicitud_idestado"]){echo "selected";} ?> > <?php echo $estado[$i]["Descripcion"]; ?> </option>
									<?php }?>
								</select>
							</td>
						</tr>
					</table>
					<table>
						<tr>
							<td style= "padding-right : 70px;">
								<label>Descripcion</label>
								<textarea  id="descripcion" name="txtdescripcion" style="width:300px;height:80px;"><?php echo $Solicitudes[0]["solicitud_descripcion"]; ?></textarea>
							</td>
							<td>
								<label>Creado por</label>
								<label><?php echo $Solicitudes[0]["solicitud_creadopor"]; ?></label>
							</td>
						</tr>

					</table>	
					<table>
						<tr>
							<td style="width: 150px;">
								<label>Propietario</label>
								<select style="width : 130px; height: 20px;" id="propietario">
									<?php for($i=0;$i<sizeof($propietario);$i++) { ?>
									<option value="<?php echo $propietario[$i]["login"]; ?> " <?php if($propietario[$i]["login"]==$Solicitudes[0]["solicitud_propietario"]) echo "selected"; ?>><?php echo $propietario[$i]["name"]; ?></option>
									<?php } ?>
								</select>
							</td>
							<td style="width: 180px;">
								<label>Fecha inicio Programado</label>
								<input type="text" id="fecha_inicio_programado" name="fecha_inicio_programado" size="10" maxlength="10" onkeyup="dtval(this,event)" value="<?php echo date('d/m/Y',strtotime($Solicitudes[0]["solicitud_fecha_inicio_programado"])); ?>">
							</td>
							<td style="width:
							180px;">
							<label>Hora inicio Programado</label>
							<input type="text" id="hora_inicio_programado" value ="<?php echo date('H:i', strtotime($Solicitudes[0]["solicitud_hora_inicio_programado"])); ?>" name="hora_inicio_programado" size="10" maxlength="5" onkeyup="hour(this,event);" >
						</td>
						<td style="width: 180px;">
							<label>Fecha fin Programado</label>
							<input type="text" id="fecha_fin_programado" value ="<?php echo date('d/m/Y', strtotime($Solicitudes[0]["solicitud_fecha_fin_programado"])); ?>" name="fecha_fin_programado" size="10" maxlength="10" onkeyup="dtval(this,event);" >
						</td>
						<td style="width:
						180px;">
						<label>Hora fin Programado</label>
						<input type="text" id="hora_fin_programado" value ="<?php echo date('H:i', strtotime($Solicitudes[0]["solicitud_hora_fin_programado"])); ?>" name="hora_fin_programado" size="10" maxlength="5" onkeyup="hour(this,event);" >
					</td>
				</tr>
				<tr>
					<td style= "padding-right : 30px;">
						<label>Tiempo cotizado horas</label>
						<input type="text" id="tiempo_cotizado_horas" style="width: 130px;" value="<?php echo $Solicitudes[0]["solicitudes_tiempo"]; ?>" onKeyPress="return acceptNum(event)" />
					</td>
					<td style="margin-left: 100px">
						<label>valor cotizacion</label>
						<input type="text" id="valor_cotizacion" style="width: 130px;" value="<?php echo $Solicitudes[0]["solicitudes_tiempo"]; ?>" onKeyPress="return onlynum(event)" />
					</td>
					<td>
						<label>Proyecto</label>
						<select id="proyecto" style="width: 130px; height: 20px;" >
							<?php for($i=0;$i<sizeof($proyecto);$i++) {?>
							<option value= "<?php echo $proyecto[$i]["pro_idpro"]; ?>" <?php if($Solicitudes[0]["solicitud_idproyecto"]==$proyecto[$i]["pro_idpro"]) {echo "selected";} ?> > <?php echo $proyecto[$i]["proyecto_descripcion"]; ?></option>
							<?php }?>
						</select>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td style= "padding-right : 20px;">
						<label>Detalles verificacion</label>
						<textarea style="width:300px;height:80px;" id="verificacion"><?php echo $Solicitudes[0]["solicitud_verificacion"]; ?></textarea>
					</td>
					<td style= "padding-right : 20px;">
						<label>Causas</label>
						<textarea style="width:300px;height:80px;" id="causas"><?php echo $Solicitudes[0]["solicitud_causa"]; ?></textarea>
					</td>
					<td style= "padding-right : 20px;">
						<label>Solucion</label>
						<textarea style="width:300px;height:80px;" id="solucion"><?php echo $Solicitudes[0]["solicitud_solucion"]; ?></textarea>
					</td>
				</tr>
			</table>

		</div>



<?php  

	$tareas_num=$obj_solicitudes->getTareas_paginacion_num($Solicitudes[0]["solicitud_id"]);
	$pagination->rowCount($tareas_num);
	$pagination->config(10, 20);
	$pagina=$obj_solicitudes->getTareas_paginacion($pagination->start_row, $pagination->max_rows,$Solicitudes[0]["solicitud_id"]);

	$pagination->btn_first_page = 'Primera';
	$pagination->btn_last_page = 'Ultima';
	$pagination->btn_next_page = 'Siguiente';
	$pagination->btn_back_page = 'Atras';
	$pagination->btn_page = 'Pag.';
	$pagination->btn_active = 'active'; ?>


		<div class="tab-2">
			<table>
				<tr>
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
			</div>

			<!-- / Tabs wrapper -->
		</div>
	</section>

</div>
</body>
<html>

