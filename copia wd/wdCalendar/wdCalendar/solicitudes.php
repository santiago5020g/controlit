<?php

require("conexion.php");


class Solicitudes 
{
	private $solicitudes;
	private $categorias;
	private $sedes;
	private $clientes;
	private $servicios;
	private $disposicion;
	private $liberacion;
	private $idso;
	private $idsede;
    private $espacios;
    private $usuarios;

	public function solicitudes()
	{
		$this->solicitudes=array();
		$this->categorias=array();
		$this->sedes=array();
		$this->clientes=array();
		$this->servicios=array();
		$this->disposicion=array();
		$this->liberacion=array();
		$this->idso=array();
		$this->idsede=array();
		$this->espacios=array();
		$this->usuarios=array();;
	}




	public function getSolicitudes()//usuarios
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		$sql="select login,name from sec_users where active='Y' order by name";
		$this->solicitudes=$obj->megaShot($sql);
		$obj="";
		return $this->solicitudes;
	}

		public function getClientes()
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		$sql="select id_cli,nombre_empresa from tblclientes order by nombre_empresa";
		$this->clientes=$obj->megaShot($sql);
		$obj="";
		return $this->clientes;
	}

		public function getCategorias()
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		$sql="select categoriaid,descripcion from vista_categorias order by descripcion";
		$this->categorias=$obj->megaShot($sql);
		$obj="";
		return $this->categorias;
	}

		public function getSedes($cliente)
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		if($cliente==-1){$where="where empresa=0";}
		else{$where="where empresa=$cliente";}
		$sql="select id,Sede from tblsede $where order by Sede";
		$this->sedes=$obj->megaShot($sql);
		$obj="";
		return $this->sedes;
	}


		public function getServicios($cliente)
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		if($cliente==-1){$where="and Idcliente=0";}
		else{$where="and Idcliente=$cliente";}
		$sql="SELECT id,asunto
			FROM tblsolicitudes 
			where idestado in(1,2,7) $where ";
		$this->servicios=$obj->megaShot($sql);
		$obj="";
		return $this->servicios;
	}

		public function getDisposicion()
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT Descripcion
			FROM disposicion";
		$this->disposicion=$obj->megaShot($sql);
		$obj="";
		return $this->disposicion;
	}


		public function getLiberacion()
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT idliberacion,descripcion_liberacion
			FROM tblliberacion order by idliberacion desc";
		$this->liberacion=$obj->megaShot($sql);
		$obj="";
		return $this->liberacion;
	}


	public function getIdso($idso)
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT id
			FROM tblsolicitudes where id=$idso ";
		$this->idso=$obj->megaShot($sql);
		$obj="";
		return $this->idso;
	}


public function getIdsede($idsede)
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT id
			FROM tblsede where id=$idsede ";
		$this->idsede=$obj->megaShot($sql);
		$obj="";
		return $this->idsede;
	}



	public function set_disponibilidad($tecnico)
	{
		$this->solicitudes();
		$obj= new Conn();
		$sql="select fecha_inicio,hora_inicio,hora_fin from tbltareas where fecha_inicio = Date_format(now(),'%Y-%m-%d') and propietario = '$tecnico'
				order by hora_inicio asc";
		$this->espacios=$obj->megaShot($sql);
		$obj="";
		return $this->espacios;
	}

	public function getUsuarios()
	{
		$this->solicitudes();
		$obj= new Conn();
		$sql = "select usuarios.login,usuarios.name from sec_users usuarios inner join sec_users_groups grupos on usuarios.login=grupos.login where grupos.group_id in(2,4) and usuarios.active='Y' and usuarios.login not in('prueba3','claudiamejia','na','omar') or usuarios.login='yuliana' order by name";
		$this->usuarios=$obj->megaShot($sql);
		$obj="";
		return $this->usuarios;
	}


		
}








?>
