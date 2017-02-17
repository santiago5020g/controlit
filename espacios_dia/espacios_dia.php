
<link rel="stylesheet" type="text/css" href="css/style1.css">
<script type="text/javascript" src="js/script1.js"></script>

<div id="logo" style="height : 14%;">
<img src="img/logo_controlit.jpg">
</div>



<a href="javascript:nueva_ventana()" >Programacion</a>

<div id="informe" style="padding-left: 15%; padding-top: 2%; background: url(img/fondo.bmp) no-repeat fixed center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    min-height: 80%;">





<h3>


<?php
require("class_solicitudes.php");


$obj_espacios= new Espacios();

$usuarios =  $obj_espacios->getUsuarios();

for($i=0;$i<sizeof($usuarios);$i++)
{
	$espacios = $obj_espacios->set_disponibilidad($usuarios[$i][0]);
	echo $usuarios[$i][1];
	if(count($espacios)!=0)	
	{
		$sw=0;
		$sw2=0;
		$c=0;
		for($i2=0;$i2<sizeof($espacios);$i2++)
		{

			if(Minutos(date('H:i:s'),$espacios[$i2]["hora_inicio"])>30  && $sw2==0)
			{
				echo "---Disponibilidad--- de-".date('H:i')."-- a- ".$espacios[$i2]["hora_inicio"];
				$c+=1;
				
			}

			$sw2=1;

	
			if($sw==0)
			{
				$hora_fin_sw=$espacios[$i2]["hora_fin"];
				$sw=1;
			}


			else if(Minutos($hora_fin_sw,$espacios[$i2]["hora_inicio"])>29 && Minutos(date('H:i:s'),$espacios[$i2]["hora_inicio"])>29)
			{

				
					echo "---Disponibilidad--- de-".date('H:i')."-- a- ".$espacios[$i2]["hora_inicio"];
					$c+=1;
					$hora_fin_sw=$espacios[$i2]["hora_fin"];

			}


			else {$hora_fin_sw=$espacios[$i2]["hora_fin"];}
				$hora_final_del_ciclo=$espacios[$i2]["hora_fin"];
			

		}


		if(Minutos($hora_final_del_ciclo,"17:30:00")>29)
		{

			if(Minutos($hora_final_del_ciclo,date('H:i'))>1 && Minutos(date('H:i'),"17:30"))
			{
				echo "---Disponibilidad--- de-".date('H:i')."-- a- 17:30 ";
			}

			else 
			{
				echo "---Disponibilidad--- de-".$hora_final_del_ciclo."-- a- 17:30  ";
			}

			
		}

		else if($c==0){echo "---Sin disponibilidad ";}
	}

	else
	{
		echo "---Sin programacion ";
	}





	echo "</br>";
}




function Minutos($hora_inicio1,$hora_fin1)
{
	$hora_inicio = substr($hora_inicio1,0,2);
	$minutosi=substr($hora_inicio1,3,2);
	$hora_fin = substr($hora_fin1,0,2);
	$minutosf=substr($hora_fin1,3,2);
	$total=$minutosf-$minutosi;
	$totalh=($hora_fin-$hora_inicio)*60;
	$totalm=$minutosf-$minutosi;
	$total=$totalh+$totalm;

	return $total;
}




?>

</h3>

</div>

