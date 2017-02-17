<?php

  
require('includes/mailer/class.phpmailer.php');
require('includes/mailer/class.smtp.php');
require('clases/class_solicitudes.php');



$fecha=date('d/m/Y');
$solicitudes_estado1="";
$tareas_sin_categoria1="";
$sin_categoria_tecnico_dia1="";
$tiempo_tecnico1="";

	$mail = new PHPMailer();
	$obj_Solicitudes = new Solicitudes_consultas();
	$solicitudes_estado = $obj_Solicitudes->getEstado_solicitudes();
	$tareas_sin_categoria=$obj_Solicitudes->getTareas_sin_categoria();
	$sin_categoria_tecnico_dia=$obj_Solicitudes->getSin_categoria_tecnico_dia();
	$tiempo_tecnico=$obj_Solicitudes->get_Tiempo_tecnico();

for($i=0;$i<sizeof($solicitudes_estado);$i++){ 


$solicitudes_estado1 .= "Cantidad de: ".$solicitudes_estado[$i]["estado"]." " .$solicitudes_estado[$i]["cantidad"] ."<br><br>";

if($i == (sizeof($solicitudes_estado)-1)){

$solicitudes_estado1 .= ".";

}else{

$solicitudes_estado1 .= ",";

}

}


for($i=0;$i<sizeof($tiempo_tecnico);$i++){ 


$tiempo_tecnico1 .= "Usuario ".$tiempo_tecnico[$i]["tecnico"]. " Tiempo efectivo en minutos: ".$tiempo_tecnico[$i]["tiempo_efectivo"]." Tiempo real en minutos " .$tiempo_tecnico[$i]["tiempo_real"] ."<br><br>";

if($i == (sizeof($tiempo_tecnico)-1)){

$tiempo_tecnico1 .= ".";

}else{

$tiempo_tecnico1 .= ",";

}

}


for($i=0;$i<sizeof($sin_categoria_tecnico_dia);$i++){ 


$sin_categoria_tecnico_dia1 .= "Usuario ".$sin_categoria_tecnico_dia[$i]["tecnico"]." Sin categoria " .$sin_categoria_tecnico_dia[$i]["sin_categoria_dia"] ."<br><br>";

if($i == (sizeof($sin_categoria_tecnico_dia)-1)){

$sin_categoria_tecnico_dia1 .= ".";

}else{

$sin_categoria_tecnico_dia1 .= ",";

}

}


for($i=0;$i<sizeof($tareas_sin_categoria);$i++){ 


$tareas_sin_categoria1 .= "Usuario ".$tareas_sin_categoria[$i]["tecnico"]." Sin categoria " .$tareas_sin_categoria[$i]["sin_categoria_ac"] ."<br><br>";

if($i == (sizeof($tareas_sin_categoria)-1)){

$tareas_sin_categoria1 .= ".";

}else{

$tareas_sin_categoria1 .= ",";

}

}


//echo $tareas_sin_categoria1."</br>";
//echo $tiempo_tecnico1."</br>";
//echo $solicitudes_estado1."</br>";
//echo $sin_categoria_tecnico_dia1."</br>";



$body = " tiempo por Usuario </br></br> ".$tiempo_tecnico1. " </br></br> Resumen del estado de todas las solicitudes de servicio del dia  " . $fecha . " <br><br> ".$solicitudes_estado1.  "</br></br> total tareas sin categoria por tecnico del dia ".$fecha."</br>".$sin_categoria_tecnico_dia1. "</br></br> Total de tareas sin categoria acumuladas por tecnico <br>".$tareas_sin_categoria1 ;

//echo $body;


	$mail->IsSMTP();
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->SMTPSecure = "tls";
	$mail->Host     = "smtp.gmail.com";
	$mail->Username = "semidfg@gmail.com";
	$mail->Password = "Gusano2014";
	$mail->Port        = 587;
	$mail->From = "soporte@controlit.com.co"; 
	$mail->FromName = "Solicitudes";
	$mail->Subject = "Tiempo efectivo por tecnico y estado de solicitudes de servicio";
	$mail->AltBody = "prueba";
	



	$mail->MsgHTML($body);
	/* Sustituye  (CuentaDestino )  por la cuenta a la que deseas enviar por ejem. 
	admin@domitienda.com  */
	
	$mail->AddAddress("carlos@controlit.com.co");
	$mail->AddAddress("luispolo@controlit.com");
	$mail->AddAddress("yulianaarbelaez@controlit.com");
	$mail->AddAddress("juancasas@controlit.com.co");
	$mail->AddAddress("danielpolo@controlit.com.co");
	$mail->AddAddress("diegoorozco@controlit.com.co");
	$mail->AddAddress("jhonherrera@controlit.com.co");
	$mail->AddAddress("carlosforero@controlit.com.co");
	$mail->AddAddress("andresecheverri@controlit.com.co");
	$mail->AddAddress("semidfg@gmail.com");


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

//echo $body;

?>




