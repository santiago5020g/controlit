<?php

	class Conn{
		private $isOpen = false;
		private $connection = null;
		
		private function conectar(){
			if ($this->isOpen) return;

			require("../conexion/conexion.php");
			$this->connection = mysql_connect($dbHost, $dbUser, $dbPass)or die(exit("Error conectando a la base de datos"));
			mysql_select_db($dataBase, $this->connection)or die(exit("Error seleccionando la base de datos"));
			//mysql_query("SET NAMES 'utf8'");
			$this->isOpen = true;
		}
		
		public function close(){
			if (!$this->isOpen) return;
			
			mysql_close($this->connection);
			$this->connection = null;
			$this->isOpen = false;
		}


		   	public function megaShot($sql){
			$this->conectar();
			
			$result = mysql_query($sql, $this->connection);
			if (!$result){
				throw new Exception(mysql_error($this->connection));
			}
			
			$ret = array();
			while ($list = mysql_fetch_array($result)){
				$ret[sizeof($ret)] = $list;
			}
			
			return $ret;
		}


		public function updateShot($sql){
			$this->conectar();
			
			$result = mysql_query($sql, $this->connection);
			if (!$result){
				throw new Exception(mysql_error($this->connection));
				return false;
			}

			else {return true;}
		}
	
	}
?>