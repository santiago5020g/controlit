<?php
require("conexion/conexion.php");

class Archivos 
{
	private $archivos;


	public function solicitudes()
	{
		$this->archivos=array();
	}


		public function getArchivos($parametro)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT idfile,file_name,binaryvalue,tipo,size,idparametro FROM archivos_solicitud WHERE idparametro=$parametro";
		$this->archivos=$obj->megaShot($sql);
		$obj="";
		return $this->archivos;
	}

		public function getArchivosSolcitiud($parametro)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT idfile,file_name,binaryvalue,tipo,size,idparametro FROM archivos_solicitud WHERE idfile=$parametro";
		$this->archivos=$obj->megaShot($sql);
		$obj="";
		return $this->archivos;
	}


	public function setEliminar($parametro)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="delete from archivos_solicitud where idfile=$parametro";
		if(!$obj->updateShot($sql))
		{
			
			$obj="";
			return false;
		}

		else
		{
		$obj="";
		return true;
		}
	}


	public function setArchivos($file_name,$contenido,$tipo,$tamanio,$parametro)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="INSERT INTO archivos_solicitud(idparametro,file_name,binaryvalue,tipo,size) VALUES 
                    ('$parametro','$file_name','$contenido','$tipo','$tamanio')";
		if(!$obj->updateShot($sql))
		{
			
			$obj="";
			return false;
		}

		else
		{
		$obj="";
		return true;
		}
	}







		public function getArchivosTareasParametro($parametro)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT idfile,file_name,binaryvalue,tipo,size,tarea FROM  archivos_solicitud WHERE tarea=$parametro";
		$this->archivos=$obj->megaShot($sql);
		$obj="";
		return $this->archivos;
	}

		public function getArchivosTareasFile($parametro)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="SELECT idfile,file_name,binaryvalue,tipo,size,tarea FROM  archivos_solicitud WHERE idfile=$parametro";
		$this->archivos=$obj->megaShot($sql);
		$obj="";
		return $this->archivos;
	}


	public function setEliminarTareas($parametro)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="delete from  archivos_solicitud where idfile=$parametro";
		if(!$obj->updateShot($sql))
		{
			
			$obj="";
			return false;
		}

		else
		{
		$obj="";
		return true;
		}
	}


	public function setArchivosTareas($file_name,$contenido,$tipo,$tamanio,$parametro)
	{ 
		$this->solicitudes();
		$obj=new Conn();
		$sql="INSERT INTO  archivos_solicitud(tarea,file_name,binaryvalue,tipo,size) VALUES 
                    ('$parametro','$file_name','$contenido','$tipo','$tamanio')";
		if(!$obj->updateShot($sql))
		{
			
			$obj="";
			return false;
		}

		else
		{
		$obj="";
		return true;
		}
	}


}

?>
