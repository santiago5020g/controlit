<?php

require_once('../conexion/conexion.php');

class fecha_contratos
{


	public function setFecha_contratos()
	{
		
		$obj= new Conn();
		$sql="insert into tblfecha_contratos(fecha_mes,idcontra) select date_format(now(),'%Y-%m-%d'),idcontrato from tblcontratos contrato inner join tblclientes cli on cli.id_cli=contrato.cliente where idcontrato !=1 and estado_bloqueo=1 and idestado_contrato=1 and idcontrato not in (select idcontra from tblfecha_contratos where id>1
			group by idcontra
			 having max(Date_format(fecha_mes,'%Y-%m')) = Date_format(now(),'%Y-%m'))";
	if(!$obj->updateShot($sql)){return false;}
	else {return true;}

	}


	
	
}


/**
* 
*/



?>
