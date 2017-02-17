<?php

$fecha_uno = '2015-02-19';
$hora_uno = '10:51';

$fecha = $fecha_uno." ".$hora_uno;

//$fecha = explode(' ', $fecha);

echo date('d/m/Y',strtotime($fecha));
echo date('H:i',strtotime($fecha));

?>