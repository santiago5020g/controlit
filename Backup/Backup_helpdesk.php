<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'Gusano2013';
$dbname = 'Backup_helpdesk_'.date('d_m_y H_i_s');

//echo $dbname;

$ruta = 'C:\Users\administrador.CONTROLIT\Desktop\Backups_helpdesk_controlit\backups_bases_de_datos\$dbname.sql';

/*
set FILE=C:\Users\administrador.CONTROLIT\Desktop\Backups_helpdesk_controlit\backups_bases_de_datos\Backup_helpdesk_%FECHA%_%TIME%.sql
C:\wamp\bin\mysql\mysql5.5.8\bin\mysqldump.exe -h localhost -uroot -pGusano2013 --routines --triggers -r %FILE% controlit
*/



$command = "C:\wamp\bin\mysql\mysql5.5.8\bin\mysqldump.exe -h $dbhost -u $dbuser -p $dbpass --routines --triggers -r $ruta controlit";
system($command);

?>