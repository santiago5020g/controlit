<?php
require("conexion/conexion.php");

class Solicitudes 
{
	private $solicitudes;
	private $tecnicos;
	private $clientes;
	private $tareas;
	private $total_solicitudes;
	private $estado;

	public function solicitudes()
	{
		$this->clientes=array();
		$this->estado=array();
	}

		public function getClientes()
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT id_cli,nombre_empresa from tblclientes order by nombre_empresa";
		$this->clientes=$obj->megaShot($sql);
		$obj="";
		return $this->clientes;
	}

		public function getTecnicos()
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT login,name from sec_users order by name";
		$this->tecnicos=$obj->megaShot($sql);
		$obj="";
		return $this->tecnicos;
	}


		public function getEstados()
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT idestado,Descripcion from estado order by idestado";
		$this->estado=$obj->megaShot($sql);
		$obj="";
		return $this->estado;
	}


}
?>
