<?php 
require('mt.php'); 
$obj_conexion = new Conexion();

?>

<html>
<head>
<script type="text/javascript" src="transaccion.js"></script>

	<title>Productos</title>
</head>
<body>

<div>
<input type = "button" name="crear" value="Crear producto" onclick="transaccion()">
</div>

<?php if(count($obj_conexion->Consultas("select * from tblproductos"))==0)

	{echo "No hay reegistros";}

	else
	{
		$productos = $obj_conexion->Consultas("select * from tblproductos"); 

		?>

		<table border="1">
				<tr>
					<td>
						id
					</td>
					<td>
						Descripcion
					</td>
					<td>
						Nombre
					</td>
				</tr>

		<?php for($i=0; $i < count($productos) ; $i++) { ?>
			
			

			

					<tr>
					<td>
						<input type="button" value="Editar" onclick="Pagina(<?php echo $productos[$i][0]; ?>);">
						<?php echo $productos[$i][0]; ?>
					</td>
					<td>
						<?php echo $productos[$i][1]; ?>
					</td>
					<td>
						<?php echo $productos[$i][2]; ?>
					</td>
				</tr>

		<?php } ?>

		</table>
	
<?php }  ?>

</body>
</html>