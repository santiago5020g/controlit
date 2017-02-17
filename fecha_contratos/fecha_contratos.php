<?php
require_once('class_solicitudes.php');
$obj_fecha_contratos = new fecha_contratos();

if(!$obj_fecha_contratos->setFecha_contratos()){echo "Error";}
else{echo "Hecho";}

?>