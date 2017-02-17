
<?php 
require_once("solicitudes.php");
$obj_solicitudes= new Solicitudes();
$usuarios=$obj_solicitudes->getSolicitudes();

?>


<select name='usuarios' style="width: 150px;" id='paises'>;
        <option value='0'>Usuario</option>
        <?php for($i2=0;$i2<sizeof($usuarios);$i2++)
                            { ?>
        <option ><?php echo $usuarios[$i2]["name"]; ?></option>
    <?php }?>
</select>