<?php require("solicitudes.php"); 
$obj_solicitudes=new Solicitudes();
$selectedjx=0;

$combo=$_REQUEST["combo"];

 if(isset($_REQUEST["serviciosjx"]))
 {
 	$servicios=$obj_solicitudes->getSedes($_REQUEST["serviciosjx"]);
 }

 else{$servicios=$obj_solicitudes->getSedes(-1);}


 if(isset($_REQUEST["selectedjx"]))
 {
 	$selectedjx=$obj_solicitudes->getIdsede($_REQUEST["selectedjx"]);
 }




?>

<span>Sede</span>
<select name='sedes' id='sedes'>;
        <?php for($i2=0;$i2<sizeof($servicios);$i2++)
                            { ?>
        <option value="<?php echo $servicios[$i2]["id"] ?>" <?php if($selectedjx!=0){if($selectedjx[0][0]==$servicios[$i2]["id"]){echo "selected";}} ?> >sede--<?php echo $servicios[$i2]["id"];?>--<?php echo $servicios[$i2]["Sede"]; ?></option>
    <?php }?>
</select>



