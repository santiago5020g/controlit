set FECHA=%DATE:~0,2%_%DATE:~3,2%_%DATE:~6,4%
set FILE=C:\Users\administrador.CONTROLIT\Desktop\Backups_helpdesk_controlit\backups_bases_de_datos\Backup_helpdesk_%FECHA%.sql
C:\wamp\bin\mysql\mysql5.5.8\bin\mysqldump.exe -h localhost -uroot -pGusano2013 --routines --triggers -r %FILE% controlit