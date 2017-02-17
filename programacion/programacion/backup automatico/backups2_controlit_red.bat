SET username=admin
SET password=Gusano2013
net use "\\192.168.200.50\backup-controlit\prueba" %password% /user:CONTROLIT\%username%

xcopy "C:\Users\administrador.CONTROLIT\Desktop\Backups_helpdesk_controlit\backups_bases_de_datos\Backup_helpdesk_16_12_2014_22_55_00.sql" "\\192.168.200.50\backup-controlit\Backups_helpdesk_controlit\backups_bases_de_datos"

pause

