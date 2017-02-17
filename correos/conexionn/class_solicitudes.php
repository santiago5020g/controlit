<?php

require('conexion.php');

class Solicitudes_consultas
{

	private $solicitudes_estado;
	private $Tareas_sin_categoria;
	private $sin_categoria_tecnico_dia;
	private $tiempo_tecnico;
	

	function __construct()
	{
		$this->solicitudes_estado=array();
		$this->Tareas_sin_categoria=array();
		$this->sin_categoria_tecnico_dia=array();
		$this->tiempo_tecnico=array();
	}

	public function getEstado_solicitudes()
	{
		
		$obj= new Conn();
		$sql="select count(1) as cantidad,es.descripcion as estado from tblsolicitudes so inner join estado es on es.idestado=so.idestado where so.idestado in(1,2,3,4,6,7) group by es.idestado";
		$this->solicitudes_estado=$obj->megaShot($sql);
		$obj="";
		return $this->solicitudes_estado;
	}


	public function getTareas_sin_categoria()
	{

		$obj= new Conn();
		$sql="select usuarios.name as tecnico,count(ta.idcategoria) as sin_categoria_ac FROM tbltareas ta inner join sec_users usuarios on usuarios.login=ta.propietario
		where ta.idcategoria=210
		group by ta.propietario";
		$this->Tareas_sin_categoria=$obj->megaShot($sql);
		$obj="";
		return $this->Tareas_sin_categoria;

	}

	public function getSin_categoria_tecnico_dia()
	{
		$obj=new Conn();
		$sql="select usuarios.name as tecnico,count(ta.idcategoria) as sin_categoria_dia FROM tbltareas ta inner join sec_users usuarios on usuarios.login=ta.propietario
				where ta.idcategoria=210 and ta.fecha_inicio=DATE_FORMAT(NOW(),'%Y-%m-%d')
				group by ta.propietario";
		$this->sin_categoria_tecnico_dia=$obj->megaShot($sql);
		$obj="";
		return $this->sin_categoria_tecnico_dia;
	}


	public function get_Tiempo_tecnico()
	{
		$obj=new Conn();
		$sql="select usuario.name as tecnico,sum(TIMESTAMPDIFF (MINUTE, Timestamp
				(tarea.fecha_inicio, tarea.hora_inicio ) ,
				Timestamp(tarea.fecha_inicio,tarea.hora_fin))) as tiempo_real,
				SUM( tarea.tiempo_efectivo ) as tiempo_efectivo
				FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
				inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
				inner join sec_users usuario on usuario.login=tarea.propietario
				WHERE tarea.fecha_inicio=DATE_FORMAT(NOW(),'%Y-%m-%d')
				group by tarea.propietario";
		$this->tiempo_tecnico=$obj->megaShot($sql);
		$obj="";
		return $this->tiempo_tecnico;
	}

	
}


/**
* 
*/



?>
