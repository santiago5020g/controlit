<?php

require("conexion/conexion.php");

class Solicitudes 
{
	private $solicitudes;
	private $clientes;
	private $tareas;
	private $total_solicitudes;
	private $prioridad;
	private $estado;
	private $sedes;
	private $proyectos;
	private $proyecto_por_id;
	private $tareas_paginacion;
	private $categoria;
	private $disposicion;
	private $liberacion;

	public function solicitudes()
	{
		$this->solicitudes=array();
		$this->clientes=array();
		$this->tareas=array();
		$this->total_solicitudes=0;
		$this->prioridad=array();
		$this->estado=array();
		$this->sedes=array();
		$this->proyectos=array();
		$this->proyecto_por_id=array();
		$this->tareas_paginacion=array();
		$this->categoria=array();
		$this->liberacion=array();
		$this->disposicion=array();
	}




	public function getSolicitudes($sql_solicitudes)
	{ 
		
		if($sql_solicitudes!="") {$where="where $sql_solicitudes";} else {$where="";}
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT 
	    solicitudes.id as solicitud_id
		FROM 
	 	tblsolicitudes solicitudes left join tbltareas tareas on solicitudes.id=tareas.idso inner join tblclientes clientes on solicitudes.Idcliente=clientes.id_cli 
		inner join sec_users users on users.login=solicitudes.propietario
		inner join sec_users users2 on users2.login=solicitudes.creadopor
		inner join estado est on est.idestado=solicitudes.idestado
		inner join  tblprioridad prioridad on solicitudes.idprioridad = prioridad.id
		$where
		group by solicitudes.id
		order by solicitudes.fecha_fin_programado asc,  solicitudes.hora_fin_programado asc,solicitudes.hora_inicio_programado asc";
		$this->solicitudes=$obj->megaShot($sql);
		$obj="";
		return $this->solicitudes;
	}

		public function Paginacion($start_row,$max_rows,$sql_solicitudes)
	{ 
		if($sql_solicitudes!="") {$where="where $sql_solicitudes";} else {$where="";}
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT 
	    solicitudes.id as solicitud_id,     
	    clientes.nombre_empresa as solicitud_nombre_empresa,solicitudes.asunto as solicitud_asunto,solicitudes.descripcion as solicitud_descripcion,
	    solicitudes.idprioridad as solicitud_idprioridad,prioridad.descripcion as prioridad_descripcion,
	    solicitudes.propietario as solicitud_propietario,users.name as users_name,
	    solicitudes.fecha_inicio_creacion as solicitud_fecha_inicio_creacion,solicitudes.hora_creacion as solicitud_hora_creacion,
	    solicitudes.fecha_inicio_programado as solicitud_fecha_inicio_programado,solicitudes.hora_inicio_programado as solicitud_hora_inicio_programado,
	    solicitudes.fecha_fin_programado as solicitud_fecha_fin_programado,solicitudes.hora_fin_programado as solicitud_hora_fin_programado,
	    solicitudes.idestado as solicitud_idestado,solicitudes.idproyecto as solicitud_idproyecto,
	    est.Descripcion as est_Descripcion,solicitudes.creadopor as solicitud_creadopor,
	    users2.name as users2_name, solicitudes.contacto as solicitud_contacto,
	    solucion,solicitudes.tiempo as solicitudes_tiempo,
	    fechafacturacion,tareas.propietario as tareas_propietario,tareas.fecha_inicio as tareas_fecha_inicio
		FROM 
	 	tblsolicitudes solicitudes left join tbltareas tareas on solicitudes.id=tareas.idso inner join tblclientes clientes on solicitudes.Idcliente=clientes.id_cli 
		inner join sec_users users on users.login=solicitudes.propietario
		inner join sec_users users2 on users2.login=solicitudes.creadopor
		inner join estado est on est.idestado=solicitudes.idestado
		inner join  tblprioridad prioridad on solicitudes.idprioridad = prioridad.id	
		$where
		group by solicitudes.id
		order by solicitudes.fecha_fin_programado asc,  solicitudes.hora_fin_programado asc,solicitudes.hora_inicio_programado asc LIMIT $start_row,$max_rows";
		$this->total_solicitudes=$obj->megaShot($sql);
		$obj="";
		return $this->total_solicitudes;
	}


		public function getTareas($idsolicitud)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT 
		    tareas.idtareas as tareas_idtareas,tareas.idso as tareas_iso,
		    tareas.propietario as tareas_propietario,users.name as users_name,
		    tareas.fecha_inicio as tareas_fecha_inicio,tareas.hora_inicio as tareas_hora_inicio,
		    tareas.hora_fin as tareas_hora_fin,tareas.tiempo_efectivo as tareas_tiempo_efectivo,
		    tareas.gastos_transporte as tareas_gatos_transporte,tareas.pendientes as tareas_pendientes,
		    tareas.idcategoria as tareas_idcategoria,categoria.descripcion as categoria_descripcion,
		    tareas.disposicion as tareas_disposicion,
		    sede.Sede as sede_Sede,
		    tareas.observaciones as tareas_observaciones,tareas.Garantia as tareas_Garantia,
		    tareas.id_tarea_garantia as tareas_id_tarea_garantia
			FROM 
			    tbltareas tareas inner join sec_users users on tareas.propietario=users.login
			inner join tblcategoria categoria on categoria.categoriaid=tareas.idcategoria
			inner join tblsede sede on sede.id=tareas.idsitio
			inner join tblsolicitudes so on so.id=tareas.idso
			inner join tblclientes cli on cli.id_cli=so.Idcliente
			WHERE tareas.idso=$idsolicitud
			order by tareas.fecha_inicio desc,tareas.hora_inicio desc";
			$this->tareas=$obj->megaShot($sql);
			$obj="";
			return $this->tareas;
	}



	public function getSolicitudes_por_id($id)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT 
	    solicitudes.id as solicitud_id,     
	    clientes.nombre_empresa as solicitud_nombre_empresa,solicitudes.asunto as solicitud_asunto,solicitudes.descripcion as solicitud_descripcion,
	    solicitudes.idprioridad as solicitud_idprioridad,prioridad.descripcion as prioridad_descripcion,
	    solicitudes.propietario as solicitud_propietario,users.name as users_name,solicitudes.Idcliente as solicitud_idcliente,
	    solicitudes.fecha_inicio_creacion as solicitud_fecha_inicio_creacion,solicitudes.hora_creacion as solicitud_hora_creacion,
	    solicitudes.fecha_inicio_programado as solicitud_fecha_inicio_programado,solicitudes.hora_inicio_programado as solicitud_hora_inicio_programado,solicitudes.valor_cotizacion as solicitud_valor_cotizacion,solicitudes.verificacion as solicitud_verificacion,solicitudes.causas as solicitud_causa, solicitudes.solucion as solicitud_solucion,
	    solicitudes.fecha_fin_programado as solicitud_fecha_fin_programado,solicitudes.hora_fin_programado as solicitud_hora_fin_programado,
	    solicitudes.idestado as solicitud_idestado,solicitudes.idproyecto as solicitud_idproyecto,
	    est.Descripcion as est_Descripcion,solicitudes.creadopor as solicitud_creadopor,
	    users2.name as users2_name, solicitudes.contacto as solicitud_contacto,solicitudes.correo as solicitud_correo,
	    solucion,solicitudes.tiempo as solicitudes_tiempo,
	    fechafacturacion,tareas.propietario as tareas_propietario,tareas.fecha_inicio as tareas_fecha_inicio,tareas.idsitio as tareas_idsitio
		FROM 
	 	tblsolicitudes solicitudes left join tbltareas tareas on solicitudes.id=tareas.idso inner join tblclientes clientes on solicitudes.Idcliente=clientes.id_cli 
		inner join sec_users users on users.login=solicitudes.propietario
		inner join sec_users users2 on users2.login=solicitudes.creadopor
		inner join estado est on est.idestado=solicitudes.idestado
		inner join  tblprioridad prioridad on solicitudes.idprioridad = prioridad.id where solicitudes.id=$id";
		$this->solicitudes=$obj->megaShot($sql);
		$obj="";
		return $this->solicitudes;
	}

	public function getClientes()
	{
		$this->Solicitudes();
		$obj=new Conn();
		$sql="select id_cli,nombre_empresa from tblclientes order by nombre_empresa";
		$this->clientes=$obj->megaShot($sql);
		$obj="";
		return $this->clientes;

	}

	public function getPrioridad()
	{
		$this->Solicitudes();
		$obj=new Conn();
		$sql="select id,descripcion from tblprioridad";
		$this->prioridad=$obj->megaShot($sql);
		$obj="";
		return $this->prioridad;
	}

	public function getEstado()
	{
		$this->Solicitudes();
		$obj=new Conn();
		$sql="select idestado,Descripcion from estado";
		$this->estado=$obj->megaShot($sql);
		$obj="";
		return $this->estado;

	}

	public function getSedes($cliente)
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		$sql="select sede.id as sede_id,concat(sede.Sede ,'--', cli.telefono, '--', cli.nombre_empresa) as sede_descripcion from tblsede sede inner join tblclientes cli on cli.id_cli=sede.empresa where empresa=$cliente order by Sede";
		$this->sedes=$obj->megaShot($sql);
		$obj="";
		return $this->sedes;
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

	public function getProyectos()
	{
		$this->solicitudes();
		$obj=new Conn();
		$sql = "SELECT pro.idpro as pro_idpro, concat(pro.nombre,'--', cli.nombre_empresa) as proyecto_descripcion FROM tblproyectos pro inner join tblclientes cli on cli.id_cli=pro.idcliente order by  pro.nombre asc";
		$this->proyectos = $obj->megaShot($sql);
		$obj="";
		return $this->proyectos;
	}

	public function getproyecto_por_id($idproyecto,$idcliente)
	{
		$this->solicitudes();
		$obj=new Conn();
		$sql="select 1 from tblproyectos where idpro = $idproyecto and idcliente=$idcliente ";
		$this->proyecto_por_id=$obj->megaShot($sql);
		$obj="";
		return $this->proyecto_por_id;
	}


	public function Actualizar_solicitud($idsolicitud,$Idcliente,$asunto,$idprioridad,$contacto,$correo,$sedes,$idestado,$descripcion,$propietario,$fecha_inicio_programado,$hora_inicio_programado,$fecha_fin_programado,$hora_fin_programado,$tiempo,$valor_cotizacion,$idproyecto,$verificacion,$causas,$solucion)
	{
		$obj= new Conn();
		$sql = "update tblsolicitudes set Idcliente='$Idcliente',asunto='$asunto',idprioridad='$idprioridad',contacto='$contacto',correo='$correo',sedes='$sedes',idestado='$idestado',descripcion='$descripcion',propietario='$propietario',fecha_inicio_programado='$fecha_inicio_programado',hora_inicio_programado='$hora_inicio_programado',fecha_fin_programado='$fecha_fin_programado',hora_fin_programado='$hora_fin_programado',tiempo='$tiempo',valor_cotizacion='$valor_cotizacion',idproyecto='$idproyecto',verificacion='$verificacion',causas='$causas',solucion='$solucion' where id = '$idsolicitud'";
		return $obj->updateShot($sql);
	}



		public function getTareas_paginacion($idsolicitud)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT 
		    tareas.idtareas as tareas_idtareas,tareas.idso as tareas_iso,
		    tareas.propietario as tareas_propietario,users.name as users_name,
		    tareas.fecha_inicio as tareas_fecha_inicio,tareas.hora_inicio as tareas_hora_inicio,
		    tareas.hora_fin as tareas_hora_fin,tareas.tiempo_efectivo as tareas_tiempo_efectivo,
		    tareas.gastos_transporte as tareas_gatos_transporte,tareas.pendientes as tareas_pendientes,
		    tareas.idcategoria as tareas_idcategoria,categoria.descripcion as categoria_descripcion,
		    tareas.disposicion as tareas_disposicion,tareas.idsitio as tareas_idsitio,
		    sede.Sede as sede_Sede,
		    tareas.observaciones as tareas_observaciones,tareas.Garantia as tareas_Garantia,
		    tareas.id_tarea_garantia as tareas_id_tarea_garantia
			FROM 
			    tbltareas tareas inner join sec_users users on tareas.propietario=users.login
			inner join tblcategoria categoria on categoria.categoriaid=tareas.idcategoria
			inner join tblsede sede on sede.id=tareas.idsitio
			inner join tblsolicitudes so on so.id=tareas.idso
			inner join tblclientes cli on cli.id_cli=so.Idcliente
			WHERE tareas.idso=$idsolicitud
			order by tareas.fecha_inicio desc,tareas.hora_inicio desc";
			$this->tareas_paginacion=$obj->megaShot($sql);
			$obj="";
			return $this->tareas_paginacion;
	}

	public function getCategorias()
	{
		$this->Solicitudes();
		$obj=new Conn();
		$sql="select ca.categoriaid as categoria_categoriaid,ca.descripcion as categoria_descripcion from vista_categorias ca order by ca.descripcion";
		$this->categoria=$obj->megaShot($sql);
		$this->obj="";
		return $this->categoria;
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


/*
	public function agregar_clientes($nit,$nombre,$telefono,$email)
	{
		$sql="insert into tblclientes (nit,nombre,telefono,email) values($nit,'$nombre','$telefono','$email')";
		$obj=new Conn();
		$obj->updateShot($sql);
		
		echo '<script type="text/javascript">
		alert("Datos ingresados correctamente");
		window.location="index.php";
		</script>';
		
	}
*/

}
?>
