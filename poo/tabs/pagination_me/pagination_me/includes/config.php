<?php

define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'YOUR USERNAME');
define('DB_SERVER_PASSWORD', 'YOUR PASSWORD');
define('DB_DATABASE', 'YOUR DATA BASE');

$conexion = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);

mysql_select_db(DB_DATABASE, $conexion);

?>