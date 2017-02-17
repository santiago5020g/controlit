<?php
if(isset($_POST['valor'])){
	echo "valor-> ".$_POST['valor'];
}//LE ESTAMOS INDICANDO QUE SI LA VARIABLE POST DE NOMBRE valor contiene datos, la imprimimos con un echo
?>





solicitudes_fecha_inicio_programado_dia    SC_solicitudes_fecha_inicio_programado_dia


solicitudes_fecha_inicio_programado_input_2_dia  SC_solicitudes_fecha_inicio_programado_input_2_dia



$sql="";

if({solicitudes.Idcliente}!="")
{
  if($sql!="")
	{
	   $sql .=" and so.Idcliente=".{solicitudes.Idcliente};
	}
   else
	{
	   $sql .="so.Idcliente=".{solicitudes.Idcliente};
	}
}

if({solicitudes.fecha_inicio_programado}!="")
{
  if($sql!="")
	{
	   $sql .=" and so.fecha_inicio_programado=".{solicitudes.fecha_inicio_programado};
	}
   else
	{
	   $sql .="so.fecha_inicio_programado=".{solicitudes.fecha_inicio_programado};
	}
}

if({solicitudes.propietario}!="")
{
  if($sql!="")
	{
	   $sql .=" and so.propietario=".{solicitudes.propietario};
	}
   else
	{
	   $sql .="so.propietario=".{solicitudes.propietario};
	}
}

if({tareas_propietario}!="")
{
  if($sql!="")
	{
	   $sql .=" and ta.propietario=".{tareas_propietario};
	}
   else
	{
	   $sql .="ta.propietario=".{tareas_propietario};
	}
}

if({tarea_idest}!="")
{
  if($sql!="")
	{
	   $sql .=" and ta.idEstado=".{tarea_idest};
	}
   else
	{
	   $sql .="ta.idEstado=".{tarea_idest};
	}
}

[sql_global]=$sql;
