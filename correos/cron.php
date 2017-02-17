<html>
<head>

	<title>
		Notificaciones a los clientes
	</title>
</head>

<body>

	<?php

	if(isset($_REQUEST["id_solicitud"]) &&  isset($_REQUEST["correo_solicitud"]))
	{
		$estado_correcto = 0;
		$c=0;
		$tecnicos="";
		$tarea_nueva="";
		$solicitud_nueva="";
		if(isset($_REQUEST["tarea_nueva"]))
		{$tarea_nueva = $_REQUEST["tarea_nueva"];}
		if(isset($_REQUEST["solicitud_nueva"]))
		{$solicitud_nueva = $_REQUEST["solicitud_nueva"];}
		$correos=explode(";", $_REQUEST["correo_solicitud"]);
		for($i2=0;$i2<sizeof($correos);$i2++)

		{

			if(!filter_var($correos[$i2], FILTER_VALIDATE_EMAIL)){$c=$c+1;}

		}



		if($c==0)
		{

			require('includes/mailer/class.phpmailer.php');
			require('includes/mailer/class.smtp.php');
			require('clases/class_solicitudes.php');

			$mail = new PHPMailer();
			$obj_Solicitudes = new Solicitudes_consultas();
			$solicitud = $obj_Solicitudes->get_Solicitudes($_REQUEST["id_solicitud"]);
			$tareas = $obj_Solicitudes->get_tareas($_REQUEST["id_solicitud"]);


				if($solicitud[0]["so_idestado"]==2 && $tarea_nueva!=1)
				{
					for($i=0;$i<sizeof($tareas);$i++)
					{
						if($tareas[$i][1]!="admin" && $tareas[$i][1]!="na" && $tareas[$i][7]!=210 && strlen($tareas[$i][8])>=11)
						{
							$tecnicos .= "<b> Tarea: </b>".$tareas[$i][0]. "<br> <b>Tecnico: 
							</b> "
							.$tareas[$i][1]."<br> <b> Fecha de inicio: </b>".$tareas[$i][2].
							"<br> <b> Sede: 
							</b>"
							.$tareas[$i][6]."<br> <b> Categoria: </b>".$tareas[$i][7].
							"<br> <b> Detalles: </b>".$tareas[$i][8]."<br><br>";

							$estado_correcto += 1;
						}
					}

					if($estado_correcto>0)
					{
						$body     =  "Apreciado cliente, 
						Control IT le informa que la solicitud de servicio n&uacute;mero "
						.$solicitud[0]["so_id"].  
						" Se ha finalizado 
						<br><br> los detalles de la solicitud son:
						<br><br><b> Cliente:</b> ".$solicitud[0]["cli_nombre_empresa"].
						" <br><br><b> Contacto: </b> ".$solicitud[0]["so_contacto"].
						" <br><br> <b> Asunto: </b> ".$solicitud[0]["so_asunto"].
						" <br><br> <b> Descripci&oacute;n: </b> ".$solicitud[0]["so_descripcion"].
						"<br><br> y las tareas realizadas fuer&oacute;n: <br><br>".$tecnicos." 
						<br><br>
						Si tiene alguna inquietud, favor informar al tel 6041421 
						o al correo soporte@controlit.com.co  
						<br><br>  Atentamente: 
						<br><br>  Area de Soporte tecnico  ";
					}
				}



				else if($solicitud[0]["so_idestado"]==3 && $tarea_nueva!=1)
				{
					for($i=0;$i<sizeof($tareas);$i++)
					{
						if($tareas[$i][1]!="admin" && $tareas[$i][1]!="na" && $tareas[$i][7]!=210 && strlen($tareas[$i][8])>=11)
						{
							$tecnicos .= "<b> Tarea: </b>".$tareas[$i][0]. "<br> <b>Tecnico: 
							</b> "
							.$tareas[$i][1]."<br> <b> Fecha de inicio: </b>".$tareas[$i][2].
							"<br> <b> Hora inicio: </b>".$tareas[$i][3]."<br> <b> Hora fin: </b>"
							.$tareas[$i][4]."<br> <b>Tiempo efectivo: </b>".$tareas[$i][5].
							"<br> <b> Sede: 
							</b>"
							.$tareas[$i][6]."<br> <b> Categoria: </b>".$tareas[$i][7].
							"<br> <b> Detalles: </b>".$tareas[$i][8]."<br><br>";
							$estado_correcto += 1;
						}
					}

					if($estado_correcto>0)
					{
						$body     =  "Apreciado cliente, 
						Control IT le informa que la solicitud de servicio n&uacute;mero "
						.$solicitud[0]["so_id"].  
						" ha sido solucionada satisfactoriamente 
						<br><br> los detalles de la solicitud son:
						<br><br><b> Cliente:</b> ".$solicitud[0]["cli_nombre_empresa"].
						" <br><br><b> Contacto: </b> ".$solicitud[0]["so_contacto"].
						" <br><br> <b> Asunto: </b> ".$solicitud[0]["so_asunto"].
						" <br><br> <b> Descripci&oacute;n: </b> ".$solicitud[0]["so_descripcion"].
						"<br><br> y las tareas realizadas fuer&oacute;n: <br><br>".$tecnicos." 
						<br><br><br> En este momento su solicitud ser&aacute; 
						enviada al &aacute;rea de facturaci&oacute;n.
						Si tiene alguna inquietud, favor informar al tel 6041421 
						o al correo soporte@controlit.com.co  
						<br><br>  Atentamente: 
						<br><br>  Area de Soporte tecnico  ";
					}
				}


					else if($tarea_nueva==1)
				{
					for($i=0;$i<sizeof($tareas);$i++)
					{
						if($tareas[$i][1]!="admin" && $tareas[$i][1]!="na" && $tareas[$i][7]!=210 && strlen($tareas[$i][8])>=11)
						{
							$tecnicos .= "<b> Tarea: </b>".$tareas[$i][0]. "<br> <b>Tecnico: 
							</b> "
							.$tareas[$i][1]."<br> <b> Fecha de inicio: </b>".$tareas[$i][2].
							"<br> <b> Hora inicio: </b>".$tareas[$i][3]."<br> <b> Hora fin: </b>"
							.$tareas[$i][4]."<br> <b>Tiempo efectivo: </b>".$tareas[$i][5].
							"<br> <b> Sede: 
							</b>"
							.$tareas[$i][6]."<br> <b> Categoria: </b>".$tareas[$i][7].
							"<br> <b> Detalles: </b>".$tareas[$i][8]."<br><br>";
							$estado_correcto += 1;
						}
					}

					if($estado_correcto>0)
					{
						$body     =  "Apreciado cliente, 
						Control IT le informa que la solicitud de servicio n&uacute;mero "
						.$solicitud[0]["so_id"].  
						" Se le a realizado una tarea
						<br><br> los detalles de la solicitud son:
						<br><br><b> Cliente:</b> ".$solicitud[0]["cli_nombre_empresa"].
						" <br><br><b> Contacto: </b> ".$solicitud[0]["so_contacto"].
						" <br><br> <b> Asunto: </b> ".$solicitud[0]["so_asunto"].
						" <br><br> <b> Descripci&oacute;n: </b> ".$solicitud[0]["so_descripcion"].
						"<br><br> y las tareas hasta ahora son: <br><br>".$tecnicos." 
						<br><br>
						Si tiene alguna inquietud, favor informar al tel 6041421 
						o al correo soporte@controlit.com.co  
						<br><br>  Atentamente: 
						<br><br>  Area de Soporte tecnico  ";
					}
				}


								else if($solicitud_nueva==1)
				{
					
						$body     =  "Apreciado cliente, 
						Control IT le informa que se a registrado la solicitud de servicio n&uacute;mero "
						.$solicitud[0]["so_id"].  
						"<br><br> los detalles de la solicitud son:
						<br><br><b> Cliente:</b> ".$solicitud[0]["cli_nombre_empresa"].
						" <br><br><b> Contacto: </b> ".$solicitud[0]["so_contacto"].
						" <br><br> <b> Asunto: </b> ".$solicitud[0]["so_asunto"].
						" <br><br> <b> Descripci&oacute;n: </b> ".$solicitud[0]["so_descripcion"].
						"<br><br> <br>
						Si tiene alguna inquietud, favor informar al tel 6041421 
						o al correo soporte@controlit.com.co  
						<br><br>  Atentamente: 
						<br><br>  Area de Soporte tecnico  ";	
						$estado_correcto +=1;
				}


//echo $body;



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
	/* Sustituye  (CuentaDestino )  por la cuenta a la que deseas enviar por ejem. 
	admin@domitienda.com  */
	/*
	$mail->AddAddress("carlos@controlit.com.co");
	$mail->AddAddress("luispolo@controlit.com.co");
	$mail->AddAddress("yulianaarbelaez@controlit.com.co");
	$mail->AddAddress("juancasas@controlit.com.co");
	$mail->AddAddress("danielpolo@controlit.com.co");
	$mail->AddAddress("diegoorozco@controlit.com.co");
	$mail->AddAddress("jhonherrera@controlit.com.co");
	$mail->AddAddress("carlosforero@controlit.com.co");
	$mail->AddAddress("andresecheverri@controlit.com.co");
	$mail->AddAddress("luzcorrea@controlit.com.co");
	*/
	//$mail->AddAddress("semidfg@gmail.com");

	for($i=0;$i<sizeof($correos);$i++)
	{
		$mail->AddAddress($correos[$i]);
	}

	/*
	$mail->AddAddress("servicioalcliente@controlit.com.co");
    $mail->AddAddress("carlos@controlit.com.co");
	$mail->AddAddress("luzcorrea@controlit.com.co");
	//$mail->AddAddress("santinx@hotmail.com" , "santi");
*/

	//$mail->AddAddress("carlos@controlit.com.co", "carlos");
	//$mail->SMTPAuth = true;
	/* Sustituye (CuentaDeEnvio )  por la misma cuenta que usaste en la parte superior en 
	este caso  prueba@domitienda.com  y sustituye (ContraseñaDeEnvio)  por la contraseña 
	que tenga dicha cuenta */
	


if($estado_correcto > 0)
{
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Mensaje enviado!";
	}
}

}

else
	{echo "Formato de correo invalido ".$_REQUEST["correo_solicitud"];}

}


else
{
	echo "Faltan algunos parametros para el envio de correo";
}

//echo $body;

?>




</body>
</html>




