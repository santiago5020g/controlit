<?php 
require("tran.php");

  $parametro=$_REQUEST["id"];
   $tres=$_REQUEST["tres"];
  $p=$_REQUEST["p"];  
  $obj_tran= new Archivos();


if($tres==1)
{

      if(!$obj_tran->setEliminar($parametro))
      {
                echo "error al eliminar en la base de datos";
      }

      else
      {
      	echo "Datos eliminados";
      }

      echo "<br> <a href=documentacion.php?parametro=$p>volver</a>";
  }

else
  {

      if(!$obj_tran->setEliminarTareas($parametro))
      {
                echo "error al eliminar en la base de datos";
      }

      else
      {
        echo "Datos eliminados";
      }

      echo "<br> <a href=documentacion_tareas.php?parametro=$p>volver</a>";
  }



?>