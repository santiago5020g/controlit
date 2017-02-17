<html>
<head>

	<title>
		Notificaciones a los clientes
	</title>
</head>

<body>

	<?php

	if(isset($_REQUEST["id_solicitud"]))
	{

		$c=0;
		$tecnicos="";
		$correos = "semidfg@gmail.com;luispolo@controlit.com.co;luzcorrea@controlit.com.co;catherinecastaneda@controlit.com.co";
		//$correos = "semidfg@gmail.com";
		$correos=explode(";", $correos);
		for($i2=0;$i2<sizeof($correos);$i2++)

		{

			if(!filter_var($correos[$i2], FILTER_VALIDATE_EMAIL)){$c=$c+1;}

		}



		if($c==0)
		{

			require('mailer/class.phpmailer.php');
			require('mailer/class.smtp.php');
			require('class_solicitudes.php');

			$mail = new PHPMailer();
			$obj_Solicitudes = new Solicitudes_consultas();
			$pc = $obj_Solicitudes->total_valor_hora_pc($_REQUEST["id_solicitud"]);
			$servidor = $obj_Solicitudes->total_valor_hora_servidor($_REQUEST["id_solicitud"]);
			$total = $obj_Solicitudes->total($_REQUEST["id_solicitud"]);


$body = "<b> Informe de facturacion del dia </b> ".date('d/m/Y')."<br>
<b> Cliente: </b>".$_REQUEST["cliente"]."<br>
<b> Total tiempo efectivo pc: </b>".round($pc[0][1],2)." horas <br>
<b> Valor hora pc: </b>".round($pc[0][2],0)."$ <br>
<b> Valor total pc: </b>".round($pc[0][0],0)."$ <br>
<b> Total tiempo efectivo servidor: </b>".round($servidor[0][1],2)." horas <br>
<b> Valor hora servidor: </b>".round($servidor[0][2],0)."$ <br>
<b> Valor total servidor: </b>".round($servidor[0][0],0)."$ <br>
<b> Total tiempo efectivo: </b>".round($total[0][1],0)." horas <br>
<b> Valor total: </b>".round($total[0][0],0)."$ <br>
<b> Numero de factura: </b>".$_REQUEST["numero_factura"]."<br>
<b> Fecha de facturacion: </b>".date('d/m/Y',strtotime(str_replace('/', '-', $_REQUEST["fecha_facturacion"])))."<br>
<b> Solicitudes: </b>".$_REQUEST["id_solicitud"];


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
	$mail->Subject = "Servicios ".$_REQUEST["cliente"];
	$mail->AltBody = "prueba";
	$mail->addAttachment( 'Informe_facturacion.pdf' );
	



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
	



	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Mensaje enviado!";
	}

}

else
	{echo "Formato de correo invalido ". $_REQUEST["correo_solicitud"];}

}


else
{
	echo "Faltan algunos parametros para el envio de correo";
}

//echo $body;

?>




</body>
</html>




