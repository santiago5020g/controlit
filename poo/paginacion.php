<?php



class paginador
{
private $_datos;
private $_paginacion;

public function __construct()
{
	$this->_datos=array();
	$this->_paginacion = array();
}


public function paginar($query, $pagina = false, $limite = false)

{
	if($limite && is_numeric($limite))
	{
		$limite = $limite;
	}
	else
	{
		$limite = 10;
	}

	if($pagina && is_numeric($pagina))
	{
		$pagina = $pagina;
		$inicio = ($pagina -1) * $limite;
	}
	else
	{
		$pagina=1;
		$inicio = 0;
	}


		$obj=new Conn();
		//$sql="select nit,nombre,telefono,email from tblclientes order by id desc ";
		$consulta=$query;
		$registros = count($consulta);
		$total = ceil($registros / $limite);
		$query = $query . 'LIMIT $inicio, $limite';
		$consulta = megaShot($query);

		 for($regs=0; $regs<count($consulta); $regs++) 
		{
		 	$this->_datos[] = $consulta[$regs ];
		}

		 	$paginacion = array();
		 	$paginacion['actual'] = $pagina;
		 	$paginacion['total']=$total;

		 	if($pagina > 1)
		 	{
		 		$paginacion['primero'] = 1;
		 		$paginacion['anterior'] = $pagina -1;
		 	}

		 	else
		 	{
		 		$paginacion['primero'] = '';
		 		$paginacion['anterior'] =  '';
		 	}

		 	if($pagina < $total)
		 	{
		 		$paginacion['ultimo'] = $total;
		 		$paginacion['siguiente'] = $pagina + 1;
		 	}

		 	else
		 	{
		 		$paginacion['ultimo'] = '';
		 		$paginacion['siguiente'] = '';
		 	}

		 	$this->_paginacion = $paginacion;
		 	return $this->_datos;
		}

		public function getPaginacion()
		{
			if($this->paginacion)
				return $this->_paginacion;
			else return false;
		}


}

?>
