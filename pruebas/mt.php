<?php

/**
* 
*/
class Conexion 
{
	private $localhost;
	private $user;
	private $pass;
	private $db;
	private $conexion; 
	private $open;
	public function __construct()
	{
		require('config.php');

		$this->localhost = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->db = $db;
		$this->conexion = null;
		$this->open = false;
	}


	public function Conectar()
	{
		if($this->open) return;
		$this->conexion =  mysqli_connect($this->localhost,$this->user,$this->pass);
		mysqli_select_db($this->conexion,$this->db);
		$this->open = true;
	}


	public function Consultas($sql)
	{

		$this->Conectar();
		$query = mysqli_query($this->conexion,$sql);
		if(!$query)
		{
			throw new Exception("Error Processing Request", mysqli_error($this->conexion,$sql));
		}
		$result = array();
		while ($row = mysqli_fetch_array($query)) {
			$result[] = $row;
		}
		//print_r($result);
		return $result;
	}

	public function Insertar($sql)
	{
		$this->Conectar();
		if(!mysqli_query($this->conexion,$sql))
		{
			throw new Exception("Error Processing Request", mysqli_error($this->conexion,$sql));
			return false;
		}

		else
		return true;
	}



}

?>