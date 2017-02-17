<?php require('mt.php'); 
$nombre = '';
$descripcion = '';
if (isset($_REQUEST["id"])) {
	$id = $_REQUEST["id"];
	$obj_conexion = new Conexion();
	$consultas = $obj_conexion->Consultas("select nombre,descripcion from tblproductos where id =".$id);
	$nombre = $consultas[0][0];
	$descripcion = $consultas[0][1];
}
?>

<html>
<head>
	<script type="text/javascript" src="jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="transaccion.js"></script>
	<title>
	</title>
</head>
<body>

<div>Nombre</div>
<div>
<input type="text" id="nombre" value="<?php if($nombre!='') echo $nombre; ?>">
</div>
<div>descripcion</div>
<div>
<input type="text" id="descripcion" value="<?php if($descripcion!='') echo $descripcion; ?>">
</div>

<div>
<input type = "button" value="Guardar" onclick="guardar()">
</div>

<div id="mensaje2"></div>

</body>
</html>