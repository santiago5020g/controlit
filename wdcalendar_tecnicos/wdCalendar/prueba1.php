<?php 

$con=mysql_connect("localhost","root",""); /* nos conectamos a nuestra base de datos,  
poner su nombre de usario y contraeña( en mi caso no tengo, por eso el espacio en blanco) 
y si estan es un hosting los datos que les dio este 
*/ 
mysql_select_db("pruebas_controlit2");//aca seleccionamo el nombre de nuestra base de datos 


require_once("conexion/conexion.php"); 

//y hacemos la consulta 

$sql="select * from continentes order by nombre asc";  

$res=mysql_query($sql,$con); 

require_once("conexion/conexion.php"); 

$sql="select * from paises where pais=".$_GET["id"]; 

$res=mysql_query($sql,$con); 

?> 


<html>
<head>
	<script type="text/javascript" src="prueba1.js"></script>
</head>
</html>




<?php 

while ($reg=mysql_fetch_array($res)) 

{ 

?> 

<select name="continentes" onChange="from(document.form.continentes.value,'pais','prueba1.php')"> 

<option value="0">Seleccione el continente</option> 

<div id="paises"> 

Ciudad: 

<select name="paises"> 

<option value="0">Seleccione el pais</option> 

</select> 

</div> 

<div id="ciudad"> 

Ciudad: 

<select name="ciudad"> 

<option value="0">Seleccione la ciudad</option> 

</select> 

</div> 
