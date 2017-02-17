<html>
<head>
	<title></title>
</head>
<body>





<?php require("solicitudes.php"); 
$obj_solicitudes=new Solicitudes();
$selectedjx=0;



 if(isset($_REQUEST["serviciosjx"]))
 {
 	$servicios=$obj_solicitudes->getServicios($_REQUEST["serviciosjx"]);
 }

 else{$servicios=$obj_solicitudes->getServicios(-1);}


 if(isset($_REQUEST["selectedjx"]))
 {
 	$selectedjx=$obj_solicitudes->getIdso($_REQUEST["selectedjx"]);
 }


?>


     <?php for($i2=0;$i2<sizeof($servicios);$i2++)
                            { ?>
        <option value="<?php echo $servicios[$i2]["id"] ?>" required <?php if($selectedjx!=0){if($selectedjx[0][0]==$servicios[$i2]["id"]){echo "selected";}} ?> >solicitud--<?php echo $servicios[$i2]["id"];?>--<?php echo $servicios[$i2]["asunto"]; ?></option>
    <?php }?>


</body>
</html>

