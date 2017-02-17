<?php
require("mt.php");

$descripcion = $_REQUEST["descripcion"];
$nombre = $_REQUEST["nombre"];

$obj_conexion = new Conexion();

if($obj_conexion->Insertar("INSERT INTO tblproductos(nombre,descripcion) VALUES('$descripcion','$nombre')"))
{
	echo "Datos guardados";
}

else
{
	echo "Error al guardar";
}

?>