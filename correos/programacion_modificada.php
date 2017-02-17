
<html>
<head>

	<title>
		Notificaciones a los clientes
	</title>
</head>

<body>

	<?php
/*
	if(isset($_REQUEST["idtarea"]))
	{


			require('includes/mailer/class.phpmailer.php');
			require('includes/mailer/class.smtp.php');
			require('clases/class_solicitudes.php');

			$mail = new PHPMailer();
			$obj_Solicitudes = new Solicitudes_consultas();


$tarea = $obj_Solicitudes->get_tarea($_REQUEST["idtarea"]);
$solicitud = $obj_Solicitudes->get_solicitud($tarea[0][8]);

if($tarea[0][7]==1)
{

$body = $_REQUEST["usuario"]." ha modificado la programacion de la tarea ".$_REQUEST["idtarea"]." <br> antes: ".$_REQUEST["fecha_primera"]." ".$_REQUEST["hora_primera"]." <br> Ahora ".$_REQUEST["fecha_inicio2"]." ".$_REQUEST["hora_inicio2"]."<br>
<br><br> <b> Solicitud: </b>" .$solicitud[0][0]."<br> <b> Cliente: </b> ".$solicitud[0][4]. "<br> <b> Asunto: </b> ".$solicitud[0][1]. "<br> <b> Descripcion: </b>".$solicitud[0][2]."<br> <b> Creado por: </b>".$solicitud[0][3].
"<br><br> <b> Detalles de la tarea : </b> <br> <b> Tarea: </b>".$tarea[0][0]. "<br> <b> Usuario: </b>".$tarea[0][1]."<br> <b> fecha inicio: </b>".date('d/m/Y',strtotime(($tarea[0][3])))."<br> <b> Hora inicio: </b>".$tarea[0][4]."<br> <b>Hora fin: </b>".$tarea[0][5]."<br> <b> Detalles: </b>".$tarea[0][6];






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
	$mail->Subject = "programacion modificada de ".$solicitud[0][4];
	$mail->AltBody = "prueba";
	
	$mail->MsgHTML($body);
	
		$mail->AddAddress('santiago5021828182881288182812881282220g@hotmail.com');
		//$mail->AddAddress("carlos@controlit.com.co");
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Mensaje enviado!";
	}

}

}





else
{
	echo "Faltan algunos parametros para el envio de correo";
}

//echo $body;

*/
//Aqui termina comentario

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


?>

</body>
</html>




