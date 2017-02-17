set FECHA=%date%
set FECHA=%FECHA:/=%
set FECHA=%FECHA: =%
set FECHA=%FECHA::=%
set FECHA=%FECHA:,=%
set FILE=C:\\Backups\\Backup_helpdesk_%FECHA%.sql
C:\wamp\bin\mysql\mysql5.5.8\bin\mysqldump.exe -h localhost -uroot -pGusano2013 --routines --triggers -r %FILE% pruebas_controlit