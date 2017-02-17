<?php 
// Copyright © McAnam.com 
// http://www.mcanam.com/articulos/PHP.php?id=15 



    $host_db = "localhost"; // Host de la BD
    $usuario_db = "root"; // Usuario de la BD
    $clave_db = ""; // Contraseña de la BD
    $nombre_db = "pruebas_controlit2"; // Nombre de la BD
    
    //conectamos y seleccionamos db
    mysql_connect($host_db, $usuario_db, $clave_db) or die("no se pudo conectar");
    mysql_select_db($nombre_db);

     
    function GuardaArchivosFormulario() 
    { 
         
        // Establecemos el directorio donde se guardan los ficheros 
       

        $tot = count($_FILES["archivo"]["name"]); 
         
        // Recorremos los Ficheros recibidos 
      for ($i = 0; $i < $tot; $i++){ 

            $archivo = $_FILES["archivo"]["tmp_name"][$i]; 
            $tamanio = $_FILES["archivo"]["size"][$i];
            $tipo    = $_FILES["archivo"]["type"][$i];
            $nombre  = $_FILES["archivo"]["name"][$i];


             if ( $archivo != "none" )
        {
            $dato = addslashes(file_get_contents($archivo));


            $sql=mysql_query("INSERT INTO img_solicitud(idsolicitud,file_name,binaryvalue,tipo) VALUES 
                    ('1010','$nombre','$dato','$tipo')");

            if($sql)
            {
              echo "datos agregados";
            }
            else
            {
              echo "error al insertar los datos";
            }

        }
         else
            print "No se ha podido subir el archivo al servidor";

     
    } 
}
         
   GuardaArchivosFormulario(); 