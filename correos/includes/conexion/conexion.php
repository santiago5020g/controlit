 <?php
    $host_db = "192.168.200.17"; // Host de la BD
    $usuario_db = "administrador"; // Usuario de la BD
    $clave_db = "Gusano2012"; // Contraseña de la BD
    $nombre_db = "controlit"; // Nombre de la BD
    
    //conectamos y seleccionamos db
    mysql_connect($host_db, $usuario_db, $clave_db) or die("no se pudo conectar");
    mysql_select_db($nombre_db);
?> 