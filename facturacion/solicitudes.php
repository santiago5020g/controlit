<?php

require("../conexion/conexion.php");


/*
SELECT so.id as so_id,so.idestado as so_idestado,SUM( tarea.tiempo_efectivo ) as 
				suma_tiempo_efectivo,contra.idcontrato,contra.valor as contrato_valor
				FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
				inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
				inner join tblcontratos contra on contra.idcontrato=so.idcontra
				where so.fechafacturacion!="" and so.fechafacturacion IS NOT NULL and so.numero_factura!="" and so.numero_factura IS NOT NULL and tarea.idcategoria!=22 and 
				so.idcontra!=1 AND so.idestado=1
				group by so.id
*/
class Solicitudes 
{
	private $solicitudes;
	private $valida;
	private $solicitudes_no_facturadas;
	private $solicitudes_reporte;
	private $tareas_reporte;
	private $tipo_servicio;


	public function solicitudes()
	{
		$this->solicitudes=array();
		$this->valida=array();
		$this->solicitudes_no_facturadas=array();
		$this->solicitudes_reporte=array();
		$this->tareas_reporte=array();
		$this->tipo_servicio=array();
	}



	public function getSolicitudes()//usuarios
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT so.id as so_id,so.idestado as so_idestado,SUM( tarea.tiempo_efectivo ) as 
				suma_tiempo_efectivo,contra.idcontrato,contra.valor as contrato_valor
				FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
				inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
				inner join tblcontratos contra on contra.idcontrato=so.idcontra
				where so.fechafacturacion!='' and so.fechafacturacion IS NOT NULL and so.numero_factura!='' and so.numero_factura IS NOT NULL and tarea.idcategoria!=22 and  
				so.idcontra!=1 AND so.idestado=1 and contra.idestado_contrato=1
				group by so.id";
		$this->solicitudes=$obj->megaShot($sql);
		$obj="";
		return $this->solicitudes;
	}


public function getSolicitudes2($idso)//usuarios
	{ 
		
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT so.id as so_id,SUM( tarea.tiempo_efectivo ) as 
				suma_tiempo_efectivo
				FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
				where so.id in($idso)
				group by so.id";
		$this->solicitudes=$obj->megaShot($sql);
		$obj="";
		return $this->solicitudes;
	}

	public function getValidacion($idso2)
	{
		$this->solicitudes();
		$obj= new Conn();
		$sql="select 1 FROM  tbltareas 
		WHERE (idcategoria =210 or idsitio=160 or 
		propietario in('admin','na') or CHARACTER_LENGTH(observaciones )<11
		OR observaciones = '' OR observaciones IS NULL) 
		and idso=$idso2";
		$this->valida=$obj->megaShot($sql);
		$obj="";
		return $this->valida;
	}

public function updateValor_factura_tareas($valor_facturar,$idsolicitud)
{
	$obj=new Conn();
	$sql="update tbltareas tarea inner join tblsolicitudes so on so.id=tarea.idso 
			 set tarea.valor_facturar=$valor_facturar,so.idestado=6 where tarea.idso=$idsolicitud and tarea.idcategoria!=22 ";

      $obj->updateShot($sql);
      $obj="";
}


public function update_solicitudes_no_facturadas()
{
	$obj=new Conn();
	$sql="update tblsolicitudes so set so.idestado=8 where so.idcontra!=1 AND so.idestado=1  and (so.fechafacturacion='' or so.fechafacturacion IS NULL or so.numero_factura='' or so.numero_factura IS NULL) and Date_format(now(),'%Y-%m')>= Date_format(so.fecha_fin_programado,'%Y-%m') ";
	$obj->updateShot($sql);
	$obj="";
}


public function getsolicitudes_no_facturadas()
{
	$this->Solicitudes();
	$obj=new Conn();
	$sql="select so.id as so_id,so.fecha_inicio_programado as so_fecha_inicio_programado,so.fecha_fin_programado as so_fecha_fin_programado from tblsolicitudes so where so.idcontra!=1 AND so.idestado=1  and (so.fechafacturacion='' or so.fechafacturacion IS NULL or so.numero_factura='' or so.numero_factura IS NULL) and Date_format(now(),'%Y-%m')>= Date_format(so.fecha_fin_programado,'%Y-%m') ";
	$this->solicitudes_no_facturadas=$obj->megaShot($sql);
	$obj="";
	return $this->solicitudes_no_facturadas;
}


public function getSolicitudes_reporte($lista_solictudes)
{
	$this->Solicitudes();
	$obj=new Conn();
	$sql="select so.id as id,so.fecha_inicio_creacion as fecha_solicitud,so.contacto as solicitante,so.fecha_inicio_programado as fecha_inicio_programado,so.hora_inicio_programado as hora_inicio_programado,
	so.fecha_fin_programado as fecha_fin_programado,so.hora_fin_programado as hora_fin_programado,
	so.descripcion as descripcion,usuarios.name as tecnico_solicitud,cli.nombre_empresa as cliente,est.Descripcion as estado,
	so.asunto as asunto from tblsolicitudes so inner join tblclientes cli on cli.id_cli=so.Idcliente 
	inner join sec_users usuarios  on usuarios.login=so.propietario
	inner join estado est on so.idestado=est.idestado where so.id in($lista_solictudes)
	group by so.id";
	$this->solicitudes_reporte=$obj->megaShot($sql);
	$obj="";
	return $this->solicitudes_reporte;
}


public function getSolicitudes_reporte_control_interno($lista_solictudes)
{
	$this->Solicitudes();
	$obj=new Conn();
	$sql="select so.id as id,so.fecha_inicio_creacion as fecha_solicitud,so.contacto as solicitante,so.fecha_inicio_programado as fecha_inicio_programado,so.hora_inicio_programado as hora_inicio_programado,
	so.fecha_fin_programado as fecha_fin_programado,so.hora_fin_programado as hora_fin_programado,
	so.descripcion as descripcion,usuarios.name as tecnico_solicitud,cli.nombre_empresa as cliente,est.Descripcion as estado,
	so.asunto as asunto from tblsolicitudes so inner join tblclientes cli on cli.id_cli=so.Idcliente 
	inner join sec_users usuarios  on usuarios.login=so.propietario
	inner join estado est on so.idestado=est.idestado where so.id in($lista_solictudes)
	group by so.id";
	$this->solicitudes_reporte=$obj->megaShot($sql);
	$obj="";
	return $this->solicitudes_reporte;
}




public function getTareas_reporte($lista_solictudes)
{
	$this->Solicitudes();
	$obj=new Conn();
	$sql="select ta.idso as idso,ta.idtareas as tarea,usuarios.name as tecnico_tarea,ta.tiempo_efectivo as tiempo_efectivo,ta.valor_facturar as tarea_valor_facturar, ta.tiempo_facturar as tarea_tiempo_facturar,TIMESTAMPDIFF (MINUTE, Timestamp
	(ta.fecha_inicio, ta.hora_inicio ) ,Timestamp(ta.fecha_inicio,ta.hora_fin)) as tiempo_real,ca.descripcion as categoria,se.Sede as sede,ta.fecha_inicio as fecha_inicio,ta.hora_inicio as hora_inicio,ta.hora_fin as hora_fin,ta.observaciones as detalles from tbltareas ta inner join tblcategoria ca on ta.idcategoria=ca.categoriaid
	inner join sec_users usuarios  on usuarios.login=ta.propietario
	inner join tbltipo_servicio tipos on tipos.id = ca.tipo_servicio
     inner join tblsede se on se.id=ta.idsitio where ta.idso in($lista_solictudes) and tipos.valor!=0";
     $this->tareas_reporte=$obj->megaShot($sql);
     $obj="";
     return $this->tareas_reporte;
}


public function getTiposervicio($lista_solictudes)
{
	$this->Solicitudes();
	$obj=new Conn();
	$sql="SELECT SUM( tarea.tiempo_efectivo ) AS suma_tarea_tiempo_efetivo, tipos.nombre AS tipos_nombre
FROM tbltipo_servicio tipos
INNER JOIN tblcategoria ca ON ca.tipo_servicio = tipos.id
INNER JOIN tbltareas tarea ON tarea.idcategoria = ca.categoriaid
INNER JOIN tblsolicitudes so ON so.id = tarea.idso
WHERE so.id
IN ($lista_solictudes) and tipos.id !=3 and tipos.id!=10 and tipos.valor!=0
GROUP BY tipos.nombre";

     $this->tipo_servicio=$obj->megaShot($sql);
     $obj="";
     return $this->tipo_servicio;
}









public function getSolicitudes_reporte2($idcontratos,$fecha_mes_contratos)
{
	$this->Solicitudes();
	$obj=new Conn();
	$sql="select so.id as id,so.idcontra as so_idcontra,so.fecha_inicio_creacion as fecha_solicitud,so.contacto as solicitante,so.fecha_inicio_programado as fecha_inicio_programado,so.hora_inicio_programado as hora_inicio_programado,
	so.fecha_fin_programado as fecha_fin_programado,so.hora_fin_programado as hora_fin_programado,
	so.descripcion as descripcion,usuarios.name as tecnico_solicitud,cli.nombre_empresa as cliente,est.Descripcion as estado,
	so.asunto as asunto,fechac.fecha_mes as fechac_fecha_mes from tblsolicitudes so inner join tblclientes cli on cli.id_cli=so.Idcliente 
	inner join sec_users usuarios  on usuarios.login=so.propietario
	inner join tblfecha_contratos fechac on fechac.idcontra = so.idcontra
	inner join estado est on so.idestado=est.idestado 
	inner join tbltareas ta on ta.idso = so.id
	where so.idcontra in($idcontratos) and date_format(ta .fecha_inicio,'%Y-%m') in (date_format('$fecha_mes_contratos','%Y-%m'))
	group by so.id";
	$this->solicitudes_reporte=$obj->megaShot($sql);
	$obj="";
	return $this->solicitudes_reporte;
}


	//where so.idcontra in($idcontratos) and date_format(ta .fecha_inicio,'%Y-%m') in (date_format('2014-11-24','%Y-%m'))
public function getTareas_reporte2($lista_solictudes,$fecha_mes_contratos)
{
	$this->Solicitudes();
	$obj=new Conn();
	$sql="select ta.idso as idso,ta.idtareas as tarea,usuarios.name as tecnico_tarea,ta.tiempo_efectivo as tiempo_efectivo,ta.valor_facturar as tarea_valor_facturar, ta.tiempo_facturar as tarea_tiempo_facturar,TIMESTAMPDIFF (MINUTE, Timestamp
		(ta.fecha_inicio, ta.hora_inicio ) ,Timestamp(ta.fecha_inicio,ta.hora_fin)) as tiempo_real,ca.descripcion as categoria,se.Sede as sede,ta.fecha_inicio as fecha_inicio,ta.hora_inicio as hora_inicio,ta.hora_fin as hora_fin,ta.observaciones as detalles from tbltareas ta inner join tblcategoria ca on ta.idcategoria=ca.categoriaid
	inner join sec_users usuarios  on usuarios.login=ta.propietario
	inner join tblsolicitudes so on so.id = ta.idso
	inner join tblfecha_contratos fechac on fechac.idcontra = so.idcontra
	inner join tblsede se on se.id=ta.idsitio 
	inner join tbltipo_servicio tipos on tipos.id = ca.tipo_servicio
	where ta.idso in($lista_solictudes)  and date_format(ta.fecha_inicio,'%Y-%m') = date_format('$fecha_mes_contratos','%Y-%m') and tipos.valor!=0
	group by ta.idtareas";
	$this->tareas_reporte=$obj->megaShot($sql);
	$obj="";
	return $this->tareas_reporte;
}



public function get_proyectos($proyectos)
{
	$this->Solicitudes();
	$obj=new Conn();
	$sql="select pro.idpro,pro.nombre,pro.descripcion,cli.nombre_empresa,pro.nombre from tblproyectos pro inner join tblclientes cli on cli.id_cli = pro.idcliente where pro.idpro in($proyectos) group by pro.idpro";
	$this->tareas_reporte=$obj->megaShot($sql);
	$obj="";
	return $this->tareas_reporte;
}



public function getSolicitudes_reporte_proyecto($proyecto)
{
	$this->Solicitudes();
	$obj=new Conn();
	$sql="select so.id as id,so.fecha_inicio_creacion as fecha_solicitud,so.contacto as solicitante,so.fecha_inicio_programado as fecha_inicio_programado,so.hora_inicio_programado as hora_inicio_programado,
	so.fecha_fin_programado as fecha_fin_programado,so.hora_fin_programado as hora_fin_programado,
	so.descripcion as descripcion,usuarios.name as tecnico_solicitud,cli.nombre_empresa as cliente,est.Descripcion as estado,
	so.asunto as asunto from tblsolicitudes so inner join tblclientes cli on cli.id_cli=so.Idcliente 
	inner join sec_users usuarios  on usuarios.login=so.propietario
	inner join estado est on so.idestado=est.idestado where so.idproyecto iN ($proyecto)
	group by so.id";
	$this->solicitudes_reporte=$obj->megaShot($sql);
	$obj="";
	return $this->solicitudes_reporte;
}



}

?>
