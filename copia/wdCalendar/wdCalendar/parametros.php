<?php 

$fecha1='2014-01-01';
$fecha2='2014-08-15';


   $usuarios=$_REQUEST["usuarios"];

		$array_tecnicos = array($usuarios);
   		//$variable="'".implode("','",$a1)."'";
		$usuarios2="'".implode("''",$array_tecnicos)."'";


$sql2 = "select * from tbltareas inner join sec_users on propietario=login where propietario in($usuarios2) and fecha_inicio between '"
      .$fecha1."' and '". $fecha2."'order by hora_inicio asc";
echo $sql2;

?>