<?php $parametro=$_REQUEST["parametro"]; 

$p="0";
if(isset($_REQUEST["p"]))
{
    $p=$_REQUEST["p"];
}

?>

<html> 
    <head> 
        <script type="text/javascript" language="javascript" src="js/dina.js"></script>
        <script type="text/javascript" language="javascript" src="prueba.js"></script>

        <title>Rellene el formulario</title> 
    </head> 
    <body> 
        <form name='formulario' id='formulario' method='post' action='guardararchivos.php' enctype="multipart/form-data"> 
            <div id="adjuntos"> 
                 <input type="text" style="border:none"; name="carpeta" value="Documentacion" readonly="readonly">
                 <input type="text"  style="border:none"; name="parametro" value="<?php echo $parametro; ?>" readonly="readonly">
                  <input type="hidden"   name="confirmacion" value="2">
                <dt><a href="#" onClick="addCampo()">Agregar archivo</a></dt> 
            <p><input type='file' name='archivo[]'></p> 
             
            <p align='center'> 
            </div>
                <input type='submit' value='Enviar'> 
               
            </p> 
        </form> 

<table>

        <?php

    require("tran.php");

        $obj_archivos= new Archivos();
        $listado=$obj_archivos->getArchivosTareasParametro($parametro);

        for($i=0;$i<sizeof($listado);$i++)
        {

        ?>



    <tr>
       <td> <a href="descargar.php?id=<?php echo $listado[$i]["idfile"];?>&ts=2" ><?php echo $listado[$i]["file_name"];?></a></td> <td><a href="javascript:confirmation(<?php echo $listado[$i]["idfile"];?>,<?php echo $parametro?>,2);">Eliminar</a> </td>
    </tr>


        <?php } ?>
</table>

    </body> 
</html>

