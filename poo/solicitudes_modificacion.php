<?php 
require('solicitudes.php');
$obj_solicitudes=new Solicitudes();
$Solicitudes=$obj_solicitudes->getSolicitudes_por_id($_REQUEST["id"]);
$clientes=$obj_solicitudes->getClientes();
$prioridad=$obj_solicitudes->getPrioridad();
$estado=$obj_solicitudes->getEstado();
$sedes=$obj_solicitudes->getSedes($Solicitudes[0]["solicitud_idcliente"]);
$propietario=$obj_solicitudes->getTecnicos();
$proyecto=$obj_solicitudes->getProyectos();
$categorias=$obj_solicitudes->getCategorias();
$disposicion=$obj_solicitudes->getDisposicion();
?>


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
