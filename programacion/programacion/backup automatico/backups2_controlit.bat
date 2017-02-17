set FECHA=%date:~6,4%-%date:~3,2%-%date:~0,2%
set FILE=C:\xampp\htdocs\base_datos\Backup_helpdesk_%FECHA%.sql
C:\xampp\mysql\bin\mysqldump.exe -h 127.0.0.1 -ucybercup_root -pObjetivo2 --routines --triggers -r %FILE% cybercup_cupones


SET username=admin
SET password=Gusano2013
net use "\\192.168.200.50\backup-controlit\prueba" %password% /user:CONTROLIT\%username%

xcopy %FILE%  "\\192.168.200.50\backup-controlit\Backups_helpdesk_controlit\backups_bases_de_datos"

