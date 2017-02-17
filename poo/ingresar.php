<?php

	require('solicitudes.php');
	function validateDate($date, $format = 'd/m/Y')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
	function validateHour($date, $format = 'H:i')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}

	function Actualizar_solicitudd()
	{
		$obj_solicitudes = new Solicitudes();
		$Error="0";
		$idsolicitud=trim($_REQUEST["idsolicitud"]);
		$Idcliente=trim($_REQUEST["cliente"]);
		$asunto=trim($_REQUEST["asunto"]);
		$idprioridad=trim($_REQUEST["prioridad"]);
		$contacto=trim($_REQUEST["contacto"]);
		$correo=trim($_REQUEST["correo"]);
		$sedes=trim($_REQUEST["sede1"]);
		$idestado=trim($_REQUEST["estado1"]);
		$descripcion=trim($_REQUEST["descripcion"]);
		$propietario=trim($_REQUEST["propietario"]);
		$fecha_inicio_programado=trim($_REQUEST["fecha_inicio_programado"]);
		$fecha_inicio_programado2=trim(date('Y-m-d',strtotime(str_replace('/', '-', $fecha_inicio_programado))));
		$hora_inicio_programado=trim($_REQUEST["hora_inicio_programado"]);
		$fecha_fin_programado=trim($_REQUEST["fecha_fin_programado"]);
		$fecha_fin_programado2=trim(date('Y-m-d',strtotime(str_replace('/', '-', $fecha_fin_programado))));
		$hora_fin_programado=trim($_REQUEST["hora_fin_programado"]);
		$tiempo=trim($_REQUEST["tiempo_cotizado_horas"]);
		$valor_cotizacion=trim($_REQUEST["valor_cotizacion"]);
		$idproyecto=trim($_REQUEST["proyecto"]);
		$verificacion=trim($_REQUEST["verificacion"]);
		$causas=trim($_REQUEST["causas"]);
		$solucion=trim($_REQUEST["solucion"]);

	
		if(!is_numeric($idsolicitud)){echo "Error fatal en la solicitud"; return false;}
		else if(!trim($asunto)){echo "Error, asunto datos requeridos"; return false;}
		else if(!trim($descripcion)){echo "Error, Descripcion datos requeridos"; return false;}
		else if(!validateDate($fecha_inicio_programado)){echo "fecha inicio programado invalida"; return false;}
		else if(!validateHour($hora_inicio_programado)){echo "hora inicio programado invalida"; return false;}
		else if(!validateDate($fecha_fin_programado)){echo "fecha fin programado invalida"; return false;}
		else if(!validateHour($hora_fin_programado)){echo "hora fin programado invalida"; return false;}
		else if(!is_numeric($tiempo)){echo "Error en el campo tiempo cotizado en horas";return false;}
		else if(!is_numeric($valor_cotizacion)){echo "Error en el campo valor_cotizacion"; return false;}
		else if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){echo "Error correo invalido"; return false;}
		else if($idproyecto!=1){$proyecto2=$obj_solicitudes->getproyecto_por_id($idproyecto,$Idcliente); if(count($proyecto2)!=1){echo "el cliente de la solicitud es diferente al cliente del proyecto"; return false;} else if(!$obj_solicitudes->Actualizar_solicitud($idsolicitud,$Idcliente,$asunto,$idprioridad,$contacto,$correo,$sedes,$idestado,$descripcion,$propietario,$fecha_inicio_programado2,$hora_inicio_programado,$fecha_fin_programado2,$hora_fin_programado,$tiempo,$valor_cotizacion,$idproyecto,$verificacion,$causas,$solucion)) {echo "Error al actualizar"; return false;} else {echo "Datos modificados"; return true;}}
		else if(!$obj_solicitudes->Actualizar_solicitud($idsolicitud,$Idcliente,$asunto,$idprioridad,$contacto,$correo,$sedes,$idestado,$descripcion,$propietario,$fecha_inicio_programado2,$hora_inicio_programado,$fecha_fin_programado2,$hora_fin_programado,$tiempo,$valor_cotizacion,$idproyecto,$verificacion,$causas,$solucion)) {echo "Error al actualizar"; return false;}
		else {echo "Datos modificados"; echo $fecha_inicio_programado2;return true;}
	}

	
Actualizar_solicitudd();


?>