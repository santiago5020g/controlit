<?php

require_once('../conexion/conexion.php');

class Espacios
{

	private $espacios;

	function __construct()
	{
		$espacios=array();
		$usuarios=array();
	}


	public function set_disponibilidad($tecnico)
	{
		
		$obj= new Conn();
		$sql="select fecha_inicio,hora_inicio,hora_fin from tbltareas where fecha_inicio = Date_format(now(),'%Y-%m-%d') and propietario = '$tecnico'
				order by hora_inicio asc";
		$this->espacios=$obj->megaShot($sql);
		$obj="";
		return $this->espacios;
	}

	public function getUsuarios()
	{
		$obj= new Conn();
		$sql = "select usuarios.login,usuarios.name from sec_users usuarios inner join sec_users_groups grupos on usuarios.login=grupos.login where grupos.group_id in(2,4) and usuarios.active='Y' and usuarios.login not in('prueba3','claudiamejia','na') or usuarios.login='yuliana' order by name";
		$this->usuarios=$obj->megaShot($sql);
		$obj="";
		return $this->usuarios;
	}


	
	
}


/**
* 
*/



?>
