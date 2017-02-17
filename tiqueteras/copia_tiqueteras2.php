<?php

require('../conexion/conexion.php');

$servicio = 2;
$obj_conexion = new Conn();

$cliente = $_REQUEST["cliente"];
$idso = $_REQUEST["idso"];

//$cliente = 900449925;
//$idso = 5640;

		 $i=0;
		 $i2=0;
		 $i3=0;
		 $i4 = 0;
		 $i5 = 0;
		 $c = 0;
		 $total = 0;
		 $tiempo_tarea=0;
		 $tiqueteras_validadas = array();
		 $envio_de_correo = 0;
		 $correo_solicitud = $obj_conexion->megaShot("select so.correo from tblsolicitudes so where so.id = '$idso'");
		 $tiqueteras = $obj_conexion->megaShot("select id,minutos from tbltiqueteras where idcliente = '$cliente'");
		 $tareas = $obj_conexion->megaShot("select ta.idtareas,ta.tiempo_efectivo,ca.tipo_servicio from tbltareas ta inner join tblcategoria ca on ca.categoriaid = ta.idcategoria where ta.idso = $idso group by ta.idtareas");


		 $suma_movimientos = $obj_conexion->megaShot("select SUM(mov.puntos_consumidos) from tblmovimientos mov inner join tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = ".$cliente);
		 if($suma_movimientos >= (count($tiqueteras) * 0.80))
		 {
		 	$envio_de_correo = 1;
		 	$correos=explode(";", $correo_solicitud[0][0]);
			for($i2=0;$i2<sizeof($correos);$i2++)
				{

					if(!filter_var($correos[$i2], FILTER_VALIDATE_EMAIL)){$c=$c+1;}

				}

				$i2 = 0;
		 }

	



		 for($i4 = 0 ; $i4<sizeof($tiqueteras);$i4++)
		 {
		 	$suma2 = $obj_conexion->megaShot("SELECT SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera=".$tiqueteras[$i4][0]);
		 	if($suma2[0][0]<240){$tiqueteras_validadas[$i5][0] = $tiqueteras[$i4][0]; /*echo $tiqueteras_validadas[$i5][0]."<br>";*/ $i5++;}
		 }


		 if(count($tiqueteras_validadas)==0)
		 {
		 	$suma2 = $obj_conexion->megaShot("SELECT MAX(ti.id) from tblmovimientos mov inner join  tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = '$cliente' and mov.estado_cruzado = 1");
		 	$tiqueteras_validadas[0][0] = $suma2[0][0];
		 }

		 $tiqueteras = $tiqueteras_validadas; 
		 for($i;$i<sizeof($tiqueteras);$i++)
	{
			 $tiqueteras1 = $tiqueteras[$i][0];

/*
			for($a=0;$a<sizeof($tiqueteras);$a++)
			{
				echo $tiqueteras[$a][0]."<br>";
			}
*/

	for($i2=0;$i2<sizeof($tareas);$i2++)
	{
		$suma3 = $obj_conexion->megaShot("SELECT SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera=".$tiqueteras[$i][0]);
		$total = $suma3[0][0];
		$idtarea1 = $tareas[$i2][0];
		if($tareas[$i2][2]==9){$tiempo_tarea = $tareas[$i2][1]*1.6;}
		else{$tiempo_tarea = $tareas[$i2][1];}
		$tiempo_tarea_temporal = $tiempo_tarea;
		$sw = 0;
		$sw2=0;

			if($total<240)
			{
				if($i == sizeof($tiqueteras)-1)
				{
					$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
				}// fin if($i == sizeof($tiqueteras)-1; $i++)

				else if($tiempo_tarea+$total <=240)
				{
					$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
				}//fin else if($tiempo_tarea+$total <=240)
				

				else
				{
					$tiempo_tarea_insertar = 240 - $total;
					$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea_insertar,1)");
					$tiempo_tarea = $tiempo_tarea - $tiempo_tarea_insertar;

					$i+=1;
					$tiqueteras1 = $tiqueteras[$i][0];

					if($i == sizeof($tiqueteras)-1)
					{
						$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
					}

					else
					{
						if($tiempo_tarea <= 240)
						{
							$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");	
							echo "if $tiempo_tarea <= 240";
						}// fin if

						else
						{

							$numero_clicos = variant_int($tiempo_tarea / 240);
							for($i3 = 0;$i3<$numero_clicos;$i3++)
							{
									$suma3 = $obj_conexion->megaShot("SELECT SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera=".$tiqueteras[$i][0]);
									$total = $suma3[0][0];
										if($i == sizeof($tiqueteras)-1)
										{
											$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
											$tiempo_tarea = 0;
											$i3 = $numero_clicos +1;
										}// fin if($i == sizeof($tiqueteras)-1; $i++)
										else if($tiempo_tarea+$total <=240)
										{
											echo $tiempo_tarea."---chimbo  q pasa";
											$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
										}//fin else if($tiempo_tarea+$total <=240)

										else
										{
											$tiempo_tarea_insertar = 240 - $total;
											$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea_insertar,1)");
											$tiempo_tarea = $tiempo_tarea - $tiempo_tarea_insertar;
											if($i < sizeof($tiqueteras) -1)
											{
												$i+=1;
												$tiqueteras1 = $tiqueteras[$i][0];
											}// fin if($i < sizeof($tiqueteras) -1)
											
										}//fin else
							}//fin 	for($i3 = 0;$i3<$numero_clicos -1 ;$i3++)

							if($tiempo_tarea>0)
							{
								$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
							}

						}//fin else
						

					}//fin else
						
				}// fin else
			}// fin if($total<240)
		
			else
			{
				if($i < sizeof($tiqueteras)-1)
				{
					$i+= 1;
					$tiqueteras1 = $tiqueteras[$i][0];
				}

				else
				{
					$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
				}

			}// fin else

		if($i2==sizeof($tareas)-1)
			{$i = sizeof($tiqueteras) +1;}
	}// fin for tareas

}// fin for tiqueteras





/*
if($envio_de_correo !=0 && $c==0)
{
	require('../correos/includes/mailer/class.phpmailer.php');
	require('../correos/includes/mailer/class.smtp.php');
	$mail = new PHPMailer();

	$body = "Apreciado cliente Control IT le informa que su consumo de tiqueteras excede al ochenta porciento. Por favor solicite más";





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

*/

?>