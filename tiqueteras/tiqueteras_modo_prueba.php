<?php

require('../conexion/conexion.php');

$servicio = 2;
$obj_conexion = new Conn();

$cliente = $_REQUEST["cliente"];
$idso = $_REQUEST["idso"];

//$cliente = 811039981;//union medical
//$idso = 5701;
$i5 = 0;

		 $c = 0;
		 $tiqueteras_disponibles = array();
		 $envio_de_correo = 0;
		 $cliente_nombre = $obj_conexion->megaShot("select nombre_empresa from tblclientes where id_cli = ".$cliente);
		 $correo_solicitud = $obj_conexion->megaShot("select so.correo from tblsolicitudes so where so.id = '$idso'");
		 $tiqueteras = $obj_conexion->megaShot("select id,minutos from tbltiqueteras where idcliente = '$cliente'");
		 $tareas = $obj_conexion->megaShot("select ta.idtareas,ta.tiempo_efectivo,ca.tipo_servicio from tbltareas ta inner join tblcategoria ca on ca.categoriaid = ta.idcategoria where ta.idso = $idso group by ta.idtareas");

		 for($i4 = 0 ; $i4<sizeof($tiqueteras);$i4++)
		 {
		 	$suma2 = $obj_conexion->megaShot("SELECT SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera=".$tiqueteras[$i4][0]);
		 	if($suma2[0][0]<240){$tiqueteras_disponibles[$i5][0] = $tiqueteras[$i4][0]; /*echo $tiqueteras_disponibles[$i5][0]."<br>";*/ $i5++;}
		 }


		 if(count($tiqueteras_disponibles)==0)
		 {
		 	$suma2 = $obj_conexion->megaShot("SELECT MAX(ti.id) from tblmovimientos mov inner join  tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = '$cliente' and mov.estado_cruzado = 1");
		 	$tiqueteras_disponibles[0][0] = $suma2[0][0];
		 }

		 $tiqueteras = $tiqueteras_disponibles; 
		

	for($i=0;$i<sizeof($tareas);$i++)
		{
			$numero_tarea = $tareas[$i][0];
			if($tareas[$i][2]==9){$puntos_consumidos = $tareas[$i][1]*1.6;}
			else{$puntos_consumidos = $tareas[$i][1];}

			$puntos_consumidos = $puntos_consumidos / count($tiqueteras_disponibles);
			for($i2 = 0;$i2<sizeof($tiqueteras_disponibles);$i2++)
			{
				$numero_tiquetera = $tiqueteras_disponibles[$i2][0];
				$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($numero_tiquetera,$numero_tarea,$puntos_consumidos,1)");
			}

		}// fin for tareas


		 $suma_movimientos = $obj_conexion->megaShot("select SUM(mov.puntos_consumidos) from tblmovimientos mov inner join tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = ".$cliente);

		 echo $suma_movimientos[0][0];
		 
		 if($suma_movimientos[0][0] >= (count($tiqueteras) * 240) * 0.80)
		 {
		 	$envio_de_correo = 1;
		 	$correos=explode(";", $correo_solicitud[0][0]);
			for($i2=0;$i2<sizeof($correos);$i2++)
				{

					if(!filter_var($correos[$i2], FILTER_VALIDATE_EMAIL)){$c=$c+1;}

				}

				$i2 = 0;
		 }



if($envio_de_correo ==1 && $c==0)
{
	require('../correos/includes/mailer/class.phpmailer.php');
	require('../correos/includes/mailer/class.smtp.php');
	$mail = new PHPMailer();

	$body = "Apreciado cliente Control IT le informa que su consumo de tiqueteras excede al ochenta porciento.";





		$mail->IsSMTP();
			//$mail->CharSet = 'UTF-8';
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->SMTPSecure = "tls";
		$mail->Host     = "smtp.gmail.com";
		$mail->Username = "notificacionescontrolit@gmail.com";
		$mail->Password = "Gusano2014";
		$mail->Port        = 587;
		$mail->SetFrom( 'soporte@controlit.com.co', 'Soporte Controlit' ); //Especificamos remitente
		$mail->AddReplyTo( 'soporte@controlit.com.co' );
		$mail->Subject = "Servicio al cliente controlit ".$cliente_nombre[0][0];
		$mail->AltBody = "prueba";
		
		$mail->MsgHTML($body);


	for($i=0;$i<sizeof($correos);$i++)
		{
			$mail->AddAddress($correos[$i]);
		}

		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Mensaje enviado!";
		}

}



?>