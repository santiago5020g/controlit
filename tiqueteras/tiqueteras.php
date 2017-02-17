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
$idso = $_REQUEST["idso"];
$i = 0;
$i3 = 0;
$i5 = 0;
$i_tareas = 0;
$tiempo_tarea =0;
$envio_de_correo = 0;
$c = 0;

$correo_solicitud = $obj_conexion->megaShot("select so.correo from tblsolicitudes so where so.id = '$idso'");
		 $tiqueteras = $obj_conexion->megaShot("select id,minutos from tbltiqueteras where idcliente = '$cliente'");
		 $tareas = $obj_conexion->megaShot("select ta.idtareas,ta.tiempo_efectivo,ca.tipo_servicio from tbltareas ta inner join tblcategoria ca on ca.categoriaid = ta.idcategoria where ta.idso = $idso group by ta.idtareas");

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

		for($i_tareas = 0;$i_tareas< sizeof($tareas);$i_tareas++)
		{
				$idtarea1 = $tareas[$i_tareas][0];
				if($tareas[$i_tareas][2] == 9)
				{$tiempo_tarea = $tareas[$i_tareas][1] * 1.6;}
			else if($tareas[$i_tareas][2] == 8)
			{
				{$tiempo_tarea =$tareas[$i_tareas][1];}
			}

			else
			{
				$tiempo_tarea = 0;
			}
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
						if($i == sizeof($tiqueteras_disponibles)-1)
						{
							$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
							$i = sizeof($tiqueteras_disponibles) +1;
						}// fin if($i == sizeof($tiqueteras)-1; $i++)
					}// fin else

				}//fin for($i=0;$i<sizeof($tiqueteras_disponibles);$i++)
				

		}// fin for ($i_tareas = 0;...)
		



		$suma_movimientos = $obj_conexion->megaShot("select SUM(mov.puntos_consumidos) from tblmovimientos mov inner join tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = ".$cliente);
		 if($suma_movimientos[0][0] >= (count($tiqueteras) * 0.80)*240)
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

	$body = "Apreciado cliente Control IT le informa que su consumo de tiqueteras excede al ochenta porciento";

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
		$mail->Subject = "Servicio al cliente controlit";
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



