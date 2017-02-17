<?php

require('../conexion/conexion.php');

class Solicitudes_consultas
{

	private $solicitudes;
	private $tareas;


	function __construct()
	{
		$this->solicitudes=array();
		$this->tareas=array();
	}

	

	public function get_Solicitudes($idsolicitud)
	{
		$obj=new Conn();
		$sql="SELECT so.id as so_id,cli.nombre_empresa as cli_nombre_empresa,so.idestado as so_idestado,so.contacto as so_contacto,so.asunto as so_asunto,so.descripcion as so_descripcion from tblsolicitudes so inner join tblclientes cli on cli.id_cli=so.Idcliente where so.id=$idsolicitud";
		$this->solicitudes=$obj->megaShot($sql);
		$obj="";
		return $this->solicitudes;
	}


	public function get_tareas($idso)
	{
		$obj=new Conn();
		$sql="select ta.idtareas as ta_idtareas,usuarios.name as us_name,ta.fecha_inicio as ta_fecha_inicio,
		ta.hora_inicio as ta_hora_inicio,ta.hora_fin as ta_hora_fin,ta.tiempo_efectivo as ta_tiempo_efectivo,se.Sede as se_Sede,ca.descripcion ca_descripcion,
		ta.observaciones as ta_observaciones
		from tbltareas ta inner join sec_users usuarios on 
		usuarios.login=ta.propietario 
		inner join tblsede se on se.id = ta.idsitio 
		inner join tblcategoria ca on ca.categoriaid=ta.idcategoria
		where idso=$idso
		and ta.idcategoria!=22 ";
		$this->tareas=$obj->megaShot($sql);
		$obj="";
		return $this->tareas;

	}



	public function get_solicitud($id)
	{
			$obj=new Conn();
		$sql="select so.id as so_id,so.asunto as so_asunto,so.descripcion as so_descripcion,so.creadopor as so_creadopor,cli.nombre_empresa as cli_cliente from tblsolicitudes so inner join tblclientes cli on cli.id_cli = so.Idcliente where so.id = $id ";
		$this->solicitudes=$obj->megaShot($sql);
		$obj="";
		return $this->solicitudes;

	}
	


	public function get_tarea($idtareas)
	{
		$obj=new Conn();
		$sql="select ta.idtareas as ta_idtareas,us.name as us_tarea,us.email as us_email,ta.fecha_inicio as ta_fecha_inicio,ta.hora_inicio as ta_hora_inicio,ta.hora_fin as ta_hora_fin,ta.observaciones as ta_observaciones,ta.idEstado as ta_liberacion,ta.idso as ta_idso from tbltareas ta inner join sec_users us on us.login = ta.propietario
			where ta.idtareas= $idtareas";
		$this->tareas=$obj->megaShot($sql);
		$obj="";
		return $this->tareas;

	}
}


/**
* 
*/



?>
