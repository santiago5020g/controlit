<?php 
require("solicitudes.php");

$obj_solicitudes = new Solicitudes();
if(isset($_REQUEST["sedes"]))
{
$cliente=$_REQUEST["clientesjx"];

$sedes = $obj_solicitudes->getSedes($cliente);
$Solicitudes=$obj_solicitudes->getSolicitudes_por_id($_GET["solicitud"]);
for($i=0;$i<sizeof($sedes);$i++)
{

?>

<option value="<?php echo $sedes[$i]["sede_id"]; ?>" <?php if($Solicitudes[0]["tareas_idsitio"]==$sedes[$i]["sede_id"]){echo "selected";} ?>><?php echo $sedes[$i]["sede_descripcion"]; ?></option>

<?php }}?>