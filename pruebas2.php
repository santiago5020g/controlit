
<?php


$i4 = 0;
$i5 = 0;
$tiqueteras = array(241,242,250,244,245,289,300);
$tiqueteras_validadas = array();

	   for($i4; $i4<sizeof($tiqueteras);$i4++)
	   {

			 if($tiqueteras[$i4]<=240) 
			{
				$tiqueteras_validadas[$i5] = $tiqueteras[$i4];$i5++;
			}
	   }
	   
	   if(count($tiqueteras_validadas)==0)
		   {$tiqueteras_validadas[0] = min($tiqueteras);}

$tiqueteras = $tiqueteras_validadas;

print_r($tiqueteras);



















else if([estado3]==3)
{
	$Date = "now()";
	sc_exec_sql("update tblsolicitudes 
		set fecha_verificacion = $Date WHERE id={id}");

	if(({tiempo}=="" || {tiempo}==0) && {idproyecto}==1)
	{
		$link = "id_solicitud=".urlencode({id})."&correo_solicitud=".urlencode({correo});
//echo $link;

		echo "<style>
#my-div
		{
			width    : 10px;
			height   : 10px;
			overflow : hidden;

		}

#my-iframe
		{
			position : absolute;
			top      : 50%;
			left     : 0%;
			width    : 10%;
			height   : 10%;
		}
		</style> 
		<div id=my-div>
		<iframe id=my-iframe src =../mis_librerias/correos/cron.php?".$link."></iframe>
		</div>
		";
	}
	
	
if({idproyecto}>1)
{
sc_lookup(factura_proyecto, "select 1 from tblproyectos where fecha_factura='0000-00-00' and numero_factura='NA' and idpro = {idproyecto}");	



if({factura_proyecto}==false)
	{
		sc_exec_sql("update tblsolicitudes set idestado = 6 where id={id}");
	}
}
	
	if({idcontra}>1)
	{
		sc_lookup(factura_contrato,"select 1 from tblfecha_contratos fechac inner join tblsolicitudes so on so.idcontra = fechac.idcontra 
inner join tbltareas ta on ta.idso = so.id 
where fechac.fecha_factura2!='0000-00-00' and numero_factura2!='NA' and so.idcontra = {idcontra} and so.id = {id}
and so.idestado = 3 and date_format(ta.fecha_inicio,'%Y-%m') = date_format(fechac.fecha_mes,'%Y-%m')
group by 1");
	
		if({factura_contrato}!=false && {factura_contrato[0][0]}==1)
		{
			sc_exec_sql("update tblsolicitudes set idestado = 6 where id = {id}");
		}
		
	}
	

   if({idservicio}==2)
	{
	$i=0;
	$i2 = 0;
	$sw = 0;
	$i4 = 0;
	$i5 = 0;
	$tiqueteras_validadas = array();
	sc_lookup(tiqueteras,"select id,minutos from tbltiqueteras where idcliente =". 			     {Idcliente});
	   
	 for($i4; $i4<sizeof({tiqueteras});$i4++)
	   {
			sc_lookup(tiqueteras_suma,"select SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera =".{tiqueteras[$i4][0]});
			 if({tiqueteras_suma[0][0]}<=240) 
			{
				$tiqueteras_validadas[$i5] = {tiqueteras[$i4][0]};$i5++;
			}
	   } 
	   if(count($tiqueteras_validadas)==0)
		   {$tiqueteras_validadas[0] = min({tiqueteras});}
	   
	   sc_lookup(tareas,"select idtareas,tiempo_efectivo from tbltareas where idso =".{id});
	   
	   for($i;$i<sizeof($tiqueteras_validadas[$i]);$i++)
	   {
		   sc_lookup(tiqueteras_suma,"select SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera =".$tiqueteras_validadas[$i]);
		  $total = {tiqueteras_suma[0][0]};
		  for($i2;$i2<sizeof({tareas});$i2++) 
		  {
			 if($sw==1){sc_lookup(tiqueteras_suma,"select SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera =".$tiqueteras_validadas[$i]);
		  $total = {tiqueteras_suma[0][0]};
			$sw = 0;}
		  $tiempo_tarea = {tareas[$i2][1]};
		  $total = $total + $tiempo_tarea;

			if($total>240)
			{		
				if($i == sizeof({tiqueteras})-1)
				{	
	sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES(".$tiqueteras_validadas[$i].",".{tareas[$i2][0]}.",".$tiempo_tarea.",1)");
				}
				 
				else
				{
					//240 - 250 = -10; 60-10 = 50;
					$total = $total - 240;
					$tiempo_tarea = $tiempo_tarea - $total;	
					$sw = 1;
//aqui
sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado2) VALUES(".$tiqueteras_validadas[$i].",".{tareas[$i2][0]}.",".$tiempo_tarea.",1)");

if($total<=240)
{
	
	$i +=1 ;
	$tiempo_tarea = $total;
sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado2) VALUES(".$tiqueteras_validadas[$i].",".{tareas[$i2][0]}.",".$tiempo_tarea.",1)");
	
}

else
{	
$numero_clicos = Round($total/240,0);
	
	for($i3=0;$i3<$numero_clicos;$i3++)
    {
		$i += 1;
		if($i = sizeof({tiqueteras})-1)
		{
			$tiempo_tarea = $total;
			$i3 = $numero_clicos + 1;
		}
		else if($total>240){$total = $total - 240;$tiempo_tarea = 240;}
else{$tiempo_tarea = $total;}	

sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado2) VALUES(".$tiqueteras_validadas[$i].",".{tareas[$i2][0]}.",".$tiempo_tarea.",1)");
				
	}
}

		
	}// fin else despues de if($i == sizeof({tiqueteras})-1)	
	   }// fin if($total>240)
	
		else
{sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado2) VALUES(".$tiqueteras_validadas[$i].",".{tareas[$i2][0]}.",".$tiempo_tarea.",1)");} 
		 }
			  
		if($i2< sizeof({tareas})-1)
			{
				$i = sizeof($tiqueteras_validadas+1);
 			} 
		
    }//fin ciclo tareas
   }//fin ciclo tiqueteras
}// fin  if({idservicio}==2)
}
















if({idservicio}==2)
	{
		$i=0;
	$i2 = 0;
	$sw = 0;
	$i4 = 0;
	$i5 = 0;
	$tiqueteras_validadas = array();
	sc_lookup(tiqueteras,"select id,minutos from tbltiqueteras where idcliente =". 			     {Idcliente});
	   
	 for($i4; $i4<sizeof({tiqueteras});$i4++)
	   {
			sc_lookup(tiqueteras_suma,"select SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera =".{tiqueteras[$i4][0]});
			 if({tiqueteras_suma[0][0]}<=240) 
			{
				$tiqueteras_validadas[$i5] = {tiqueteras[$i4][0]};$i5++;
			}
	   } 
	   if(count($tiqueteras_validadas)==0)
		   {$tiqueteras_validadas[0] = min({tiqueteras});}
	
	   for($i;$i<sizeof($tiqueteras_validadas);$i++)
	   {
		   sc_lookup(tiqueteras_suma,"select SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera =".$tiqueteras_validadas[$i]);
		  $total = {tiqueteras_suma[0][0]};
		  for($i2;$i2<sizeof({tareas});$i2++) 
		  {
			 if($sw==1){sc_lookup(tiqueteras_suma,"select SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera =".$tiqueteras_validadas[$i]);
		  $total = {tiqueteras_suma[0][0]};
			$sw = 0;}
		  $tiempo_tarea = {tarea[$i2][1]};
		  $total = $total + $tiempo_tarea;

			if($total>240)
			{		
				if($i == sizeof({tiqueteras})-1)
				{	
				sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras_validadas[$i],".{tareas[$i2][0]}.",$tiempo_tarea,1)");
				}
				 
				else
				{
					//240 - 250 = -10; 60-10 = 50;
					$total = $total - 240;
					$tiempo_tarea = $tiempo_tarea - $total;	
					$sw = 1;
				sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras_validadas[$i],".{tareas[$i2][0]}.",$tiempo_tarea,1)");


if($total<=240)
{
	$i +=1 ;
	$tiempo_tarea = $total;
				sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras_validadas[$i],".{tareas[$i2][0]}.",$tiempo_tarea,1)");

}

else
{	
$numero_clicos = Round($total/240,0);
	
	for($i3=0;$i3<$numero_clicos;$i3++)
    {
		$i += 1;
		if($i = sizeof({tiqueteras})-1)
		{
			$tiempo_tarea = $total;
			$i3 = $numero_clicos + 1;
		}
		else if($total>240){$total = $total - 240;$tiempo_tarea = 240;}
else{$tiempo_tarea = $total;}	

				sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras_validadas[$i],".{tareas[$i2][0]}.",$tiempo_tarea,1)");
				
	}
}

		
	}// fin else despues de if($i == sizeof({tiqueteras})-1)	
	   }// fin if($total>240)
	
		else
		 {				
			sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras_validadas[$i],".{tareas[$i2][0]}.",$tiempo_tarea,1)");  
		 }
			  
		if($i2< sizeof(tarea)-1)
			{
				$i = sizeof({tiqueteras}+1);
 			} 
		
    }//fin ciclo tareas
   }//fin ciclo tiqueteras
}// fin  if({idservicio}==2)







tiqueteras
tareas

for(tiqueteras)
{

	for(tareas)
	{


			$total = $total + $tiempo_tarea;
			$sw = 0;

			if($total<=240)
			{
				sc_lookup("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras_validadas[$i]),{tareas[$i2][0]},$tiempo_tarea,1)");

			}

			else
			{
				$numero_clicos = round($total);
				for($i2;$i2<$numero_clicos;$i2++)
				{
					$total_temporal = $total;
					$total = $total - $tiempo_tarea;
					$tiempo_tarea = $tiempo_tarea - $total;
					$tiempo_tarea = $total;
					if($i = sizeof($tiqueteras) -1)
					{
						$tiempo_tarea = $total_temporal;
						sc_lookup("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras_validadas[$i]),{tareas[$i2][0]},$tiempo_tarea,1)");
						$numero_clicos = $numero_clicos +1;	
						$sw = 1;
					}

					else
					{
						sc_lookup("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras_validadas[$i]),{tareas[$i2][0]},$tiempo_tarea,1)");
						$i+=1;
					}

				}

					if($total > 0 && sw==0)
					{
						$tiempo_tarea = $total;
						sc_lookup("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras_validadas[$i]),{tareas[$i2][0]},$tiempo_tarea,1)");
					}
			}
	}
}






































 if({idservicio}==2)
	{
		$i=0;
	$i2 = 0;
	$sw = 0;
	$i4 = 0;
	$i5 = 0;
	$tiqueteras_validadas = array();
	sc_lookup(tiqueteras,"select id,minutos from tbltiqueteras where idcliente =". 			     {Idcliente});
	   
	 for($i4; $i4<sizeof({tiqueteras});$i4++)
	   {
			sc_lookup(tiqueteras_suma,"select SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera =".{tiqueteras[$i4][0]});
			 if({tiqueteras_suma[0][0]}<=240) 
			{
				$tiqueteras_validadas[$i5] = {tiqueteras[$i4][0]};$i5++;
			}
	   } 
	   if(count($tiqueteras_validadas)==0)
		   {$tiqueteras_validadas = min({tiqueteras});}
	   
	   sc_lookup(tareas,"select idtareas,tiempo_efectivo from tbltareas where idso =".{id});
	   
	   for($i;$i<sizeof($tiqueteras_validadas);$i++)
	   {
		   sc_lookup(tiqueteras_suma,"select SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera =".$tiqueteras_validadas[$i]);
		  $total = {tiqueteras_suma[0][0]};
		  for($i2;$i2<sizeof({tareas});$i2++) 
		  {
			  $id_tare = {tareas[$i2][0]};
			  $lista_tiqueteras = $tiqueteras_validadas[$i];
			 if($sw==1){sc_lookup(tiqueteras_suma,"select SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera =".$tiqueteras_validadas[$i]);
		  $total = {tiqueteras_suma[0][0]};
			$sw = 0;}
		  $tiempo_tarea = {tareas[$i2][1]};
		  $total = $total + $tiempo_tarea;

			if($total>240)
			{		
				if($i == sizeof($tiqueteras_validadas)-1)
				{	
	sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES('$lista_tiqueteras','$id_tare','$tiempo_tarea','1')");
				}
				 
				else
				{
					//240 - 250 = -10; 60-10 = 50;
					$total = $total - 240;
					$tiempo_tarea = $tiempo_tarea - $total;	
					$sw = 1;
	
	sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES('$lista_tiqueteras','$id_tare','$tiempo_tarea','1')");


if($total<=240)
{
	$i +=1 ;
	$tiempo_tarea = $total;
	sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES('$lista_tiqueteras','$id_tare','$tiempo_tarea','1')");
}

else
{	
$numero_clicos = Round($total/240,0);
	
	for($i3=0;$i3<$numero_clicos;$i3++)
    {
		$i += 1;
		$lista_tiqueteras = $tiqueteras_validadas[$i];
		if($i = sizeof($tiqueteras_validadas[$i])-1)
		{
			$tiempo_tarea = $total;
			$i3 = $numero_clicos + 1;
		}
		else if($total>240){$total = $total - 240;$tiempo_tarea = 240;}
else{$tiempo_tarea = $total;}	

	sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES('$lista_tiqueteras','$id_tare','$tiempo_tarea','1')");
	}
}

		
	}// fin else despues de if($i == sizeof({tiqueteras})-1)	
	   }// fin if($total>240)
	
		else
		 {				
	sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES('$lista_tiqueteras','$id_tare','$tiempo_tarea','1')");
		 }
			  
		if($i2< sizeof({tareas})-1)
			{
				$i = sizeof($tiqueteras_validadas[$i5])+1;
 			} 
		
    }//fin ciclo tareas
   }//fin ciclo tiqueteras
}/






































if({idservicio}==2)
	{
		 $i=0;
		 $i2=0;
		 $total = 0;
		 $tiempo_tarea=0;
		 sc_lookup(tiqueteras,"select id,minutos from tbltiqueteras where idcliente =". 			     {Idcliente});
		  sc_lookup(tareas,"select idtareas,tiempo_efectivo from tbltareas where idso =".{id});
		 
		 for($i;$i<sizeof({tiqueteras});$i++)
	{
			 $tiqueteras1 = {tiqueteras[$i][0]};

	for($i2;$i2<sizeof({tareas});$i2++)
	{
		
		$idtarea1 = {tareas[$i2][0]};
		$tiempo_tarea = {tareas[$i2][1]};
		$total = $total + $tiempo_tarea;
		$sw = 0;

			if($total<=240)
			{
				sc_exec_sql("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");

			}
		
			else
			{
				$numero_clicos = round($total);
				for($i2;$i2<$numero_clicos;$i2++)
				{
					$total_temporal = $total;
					$total = $total - $tiempo_tarea;
					$tiempo_tarea = $tiempo_tarea - $total;
					$tiempo_tarea = $total;
					if($i = sizeof($tiqueteras) -1)
					{
						$tiempo_tarea = $total_temporal;
				sc_exec_sql("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
						$numero_clicos = $numero_clicos +1;	
						$sw = 1;
					}

					else
					{
				sc_exec_sql("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
						$i+=1;
					}

				}

					if($total > 0 && sw==0)
					{
						$tiempo_tarea = $total;
				sc_exec_sql("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
					}
			}// fin else

		
	}// fin for tareas
		
}// fin for tiqueteras
	}// fin servicio










    ?>