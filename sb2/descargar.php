 <?php
 /* Script descargar_archivo.php */

  require("tran.php");


    $parametro=$_REQUEST["id"];
    $ts=$_REQUEST["ts"];
    $obj_archivos= new Archivos();
    if($ts==1)
    {
        $archivo=$obj_archivos->getArchivosSolcitiud($parametro);
    }
    else  
    {
       $archivo=$obj_archivos->getArchivosTareasFile($parametro);
    }
	$datos = $archivo[0]["binaryvalue"];
	$nombre =$archivo[0]["file_name"];
	$size = $archivo[0]["size"];
	$tipo = $archivo[0]["tipo"];


//echo '<img src = "data: image/jpeg;base64,'  . base64_encode ( $datos  )  .  '" /> ' ; 

 header("Content-Description: File Transfer");
    header("Content-transfer-encoding: binary");
    header("Content-Disposition: attachment; filename =".$nombre); 
    header("Content-Type:" .$tipo);
    header("Content-Length:" .$size);
    ob_clean();
    print $datos;
    exit();


 ?>
