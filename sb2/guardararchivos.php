<?php 
// Copyright © McAnam.com 
// http://www.mcanam.com/articulos/PHP.php?id=15 


require("tran.php");

     
    function GuardaArchivosFormulario() 
    { 
         
      $parametro=$_REQUEST["parametro"]; 
      $confirmacion=$_REQUEST["confirmacion"];
        $obj_tran= new Archivos();

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

if($confirmacion!=2)
{
            if(!$obj_tran->setArchivos($nombre,$dato,$tipo,$tamanio,$parametro))
            {
                echo "error al insertar en la base de datos";
            }

            else
            {
                echo "Datos agregados";
            }
}

else
{
         if(!$obj_tran->setArchivosTareas($nombre,$dato,$tipo,$tamanio,$parametro))
            {
                echo "error al insertar en la base de datos";
            }

            else
            {
                echo "Datos agregados";
            }
}
/*
            if(mysql_affected_rows($conn) > 0)
               print "Se ha guardado el archivo en la base de datos.";
            else
               print "NO se ha podido guardar el archivo en la base de datos.";
*/
        }
         else
            print "No se ha podido subir el archivo al servidor";

     
    } 

if($confirmacion!=2)
{
       echo "<br> <a href=documentacion.php?parametro=$parametro>volver</a>";
}

else
{
   echo "<br> <a href=documentacion_tareas.php?parametro=$parametro>volver</a>";
}

}
 

   GuardaArchivosFormulario(); 


/*
//Preguntamos si nuetro arreglo 'archivos' fue definido 
if (isset ($_FILES["archivos"])) { 
//de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo 
//obtenemos la cantidad de elementos que tiene el arreglo archivos 
$tot = count($_FILES["archivos"]["name"]); 
//este for recorre el arreglo 
for ($i = 0; $i < $tot; $i++){ 
//con el indice $i, poemos obtener la propiedad que desemos de cada archivo 
//para trabajar con este 
$tmp_name = $_FILES["archivos"]["tmp_name"][$i]; 
$name = $_FILES["archivos"]["name"][$i]; 

} 
} 
*/


?>



