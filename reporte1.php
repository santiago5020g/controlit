<?php

 include('includes/conexion/conexion.php');
require('fpdf17/fpdf.php');




if(isset($_POST["solicitudespp"]) && isset($_POST["tareaspp"]))
{
$lista_solictudes=$_POST["solicitudespp"];
$lista_tareas=$_POST["tareaspp"];
}




//$nombre = $_POST["santiago"];
//$telefono = $_POST["3813553"];



$solicitudes_noasignadas=mysql_query("select count(id) from tblsolicitudes where propietario='na'") or die("Error en la consulta solicitudes_noasignadas");//sin asignar
$solicitudes_a=mysql_query("select count(id) from tblsolicitudes where idestado=1") or die("Error en la consulta solicitudes_a");//abiertas
$solicitudes_pv=mysql_query("select count(id) from tblsolicitudes where idestado=2") or die("Error en la consulta solicitudes_pv");//pendientes por verificar
$solicitudes_pf=mysql_query("select count(id) from tblsolicitudes where idestado=3") or die("Error en la consulta solicitudes_pf");//pendientes por facturar
$solicitudes_f=mysql_query("select count(id) from tblsolicitudes where idestado=4") or die("Error en la consulta solicitudes_f");//facturar
$solicitudes_fd=mysql_query("select count(id) from tblsolicitudes where idestado=6") or die("Error en la consulta solicitudes_fd");//facturado

$solicitudes=mysql_query("select distinct so.id as id,so.fecha_inicio_creacion as fecha_solicitud,so.contacto as solicitante,so.fecha_inicio_programado as fecha_inicio_programado,so.hora_inicio_programado as hora_inicio_programado,
	so.fecha_fin_programado as fecha_fin_programado,so.hora_fin_programado as hora_fin_programado,
	so.descripcion as descripcion,usuarios.name as tecnico_solicitud,cli.nombre_empresa as cliente,est.Descripcion as estado,
	so.asunto as asunto from tblsolicitudes so inner join tblclientes cli on cli.id_cli=so.Idcliente 
	inner join sec_users usuarios  on usuarios.login=so.propietario
	inner join estado est on so.idestado=est.idestado where so.id in($lista_solictudes)")or die("Error en solicitudes");
$tareas=mysql_query("select ta.idso as idso,ta.idtareas as tarea,usuarios.name as tecnico_tarea,ta.tiempo_efectivo as tiempo_efectivo,TIMESTAMPDIFF (MINUTE, Timestamp
(ta.fecha_inicio, ta.hora_inicio ) ,Timestamp(ta.fecha_inicio,ta.hora_fin)) as tiempo_real,ca.descripcion as categoria,se.Sede as sede,ta.fecha_inicio as fecha_inicio,ta.hora_inicio as hora_inicio,ta.hora_fin as hora_fin,ta.observaciones as detalles from tbltareas ta inner join tblcategoria ca on ta.idcategoria=ca.categoriaid
	inner join sec_users usuarios  on usuarios.login=ta.propietario
inner join tblsede se on se.id=ta.idsitio where ta.idtareas in($lista_tareas)")or die("Error en tareas");

$tiempo_tecnico=mysql_query("select usuario.name as tecnico,sum(TIMESTAMPDIFF (MINUTE, Timestamp
(tarea.fecha_inicio, tarea.hora_inicio ) ,
Timestamp(tarea.fecha_inicio,tarea.hora_fin))) tiempo_real,
SUM( tarea.tiempo_efectivo ) as tiempo_efectivo
FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
inner join sec_users usuario on usuario.login=tarea.propietario
WHERE tarea.fecha_inicio=DATE_FORMAT(NOW(),'%Y-%m-%d')
group by tarea.propietario") or die("Error en la consulta tiempos");



$ret = array();
			while ($list = mysql_fetch_array($tiempo_tecnico)){
				$ret[sizeof($ret)] = $list;
			}


$so = array();
			while ($list2 = mysql_fetch_array($solicitudes)){
				$so[sizeof($so)] = $list2;
			}

$ta = array();
			while ($list3 = mysql_fetch_array($tareas)){
				$ta[sizeof($ta)] = $list3;
			}


$cso=count($so);
$cta=count($ta);


$tot = count($ret);
$contacts ="";
for($x=0;$x<$tot;$x++){ 
$contacts .= "Tecnico: &nbsp ".$ret[$x]["tecnico"]." &nbsp Tiempo_real: &nbsp".$ret[$x]["tiempo_real"]. " &nbsp Tiempo_efectivo: &nbsp" .$ret[$x]["tiempo_efectivo"]. "<br><br>";

if($x == ($tot-1)){

$contacts .= ".";

}else{

$contacts .= ",";

}

}

/*
echo $contacts;
*/


$na=mysql_fetch_array($solicitudes_noasignadas);
$ab=mysql_fetch_array($solicitudes_a); 
$pv=mysql_fetch_array($solicitudes_pv);  
$pf=mysql_fetch_array($solicitudes_pf);  
$f=mysql_fetch_array($solicitudes_f);  
$fd=mysql_fetch_array($solicitudes_fd);
$fecha=date('d/m/Y H:i');




$body = "Resumen del estado de todas las solicitudes de servicio del dia  " . $fecha . " <br><br> Solicitudes sin asignar:  ".  $na[0]  ."<br/><br/> Solicitudes abiertas:  ".  $ab[0]  .
	"<br/><br/>   solicitudes pendientes por verificar:  ".$pv[0].
	"<br/><br/>  Solicitudes pendientes por facturar:  ".$pf[0]." <br/><br/> Facturar: ".$f[0].
	"<br/><br/> solicitudes facturadas: ".$fd[0].
	"<br><br> Tiempo por tecnico <br><br>".$contacts;

class PDF extends FPDF
{

function Footer($lastPage = true)
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
   // if (!$lastPage){
       // $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
   // }
   if($lastPage){
        $this->Cell(100,10,"Firma del cliente _________________________________",0,0,'C');
        $this->Cell(100,10,"Firma del tecnico  __________________________________",0,0,'C');


    }
}  
}


$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);
$pdf->Image('img/controlit.png',10,10,-200);


for($y=0;$y<$cso;$y++)
{
$pdf->SetXY(10,20);

$pdf->SetFont('Arial','b',9);
$pdf->Cell(20,10,"solicitud");
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,10,$so[$y]["id"]);

$pdf->SetFont('Arial','b',9);
$pdf->Cell(20,10,"Estado");
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,10,$so[$y]["estado"]);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(15,10,"cliente");
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,10,$so[$y]["cliente"]);
$pdf->ln();

$pdf->SetFont('Arial','b',9);
$pdf->Cell(40,10,"Fecha inicio programado");
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,10,date('d/m/Y',strtotime($so[$y]["fecha_inicio_programado"])));
$pdf->SetFont('Arial','b',9);
$pdf->Cell(40,10,"Hora inicio programado");
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,10,$so[$y]["hora_inicio_programado"]);
$pdf->ln();
$pdf->SetFont('Arial','b',9);
$pdf->Cell(35,10,"Fecha fin programado");
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,10,date('d/m/Y',strtotime($so[$y]["fecha_fin_programado"])));
$pdf->SetFont('Arial','b',9);
$pdf->Cell(35,10,"Hora fin programado");
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,10,$so[$y]["hora_fin_programado"]);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(28,10,"Tecnico solicitud");
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,10,$so[$y]["tecnico_solicitud"]);
$pdf->ln();
$pdf->SetFont('Arial','b',9);
$pdf->Cell(25,10,"Solicitante");
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,10,$so[$y]["solicitante"]);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(35,10,"fecha de la solicitud");
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,10,date('d/m/Y',strtotime($so[$y]["fecha_solicitud"])));
$pdf->ln();
$pdf->SetFont('Arial','b',9);
$pdf->Cell(25,10,"Asunto");
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,10,$so[$y]["asunto"]);
$pdf->ln();
$pdf->SetFont('Arial','b',9);
$pdf->Cell(25,5,"Descripcion");
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0,5,$so[$y]["descripcion"]);
$pdf->ln();

$pdf->SetX(75);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(40,10,"Tareas realizadas");
$pdf->ln();
$pdf->ln();
for($x=0;$x<$cta;$x++)
{
	$r=0;
	if($so[$y][0]==$ta[$x][0])
	{
		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(20,5,"Tarea");
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20,5,$ta[$x]["tarea"]);
		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(30,5,"tecnico");
		$pdf->Cell(50,5,$ta[$x]["tecnico_tarea"]);

		$pdf->ln();
		$pdf->ln();
		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(30,5,"fecha inicio");
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(30,5,date('d/m/Y',strtotime($ta[$x]["fecha_inicio"])));
		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(20,5,"hora inicio");
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20,5,$ta[$x]["hora_inicio"]);
		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(20,5,"hora fin");
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20,5,$ta[$x]["hora_fin"]);

		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(10,5,"Sede");
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20,5,$ta[$x]["sede"]);
		$pdf->ln();
		$pdf->ln();


		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(27,5,"Tiempo efectivo");
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20,5,$ta[$x]["tiempo_efectivo"]);


		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(20,5,"Tiempo real");
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20,5,$ta[$x]["tiempo_real"]);

		$pdf->ln();
		$pdf->ln();

		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(30,5,"Categoria");
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(30,5,$ta[$x]["categoria"]);
		$pdf->ln();
		$pdf->ln();
		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(30,5,"Detalles");
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(0,5,$ta[$x]["detalles"]);
		$pdf->ln();
		$pdf->ln();
		



	}
}


//$pdf->AddPage();
//$pdf->Image('img/controlit.png',10,10,-200);
//$pdf->SetXY(10,271);
//$pdf->Cell(100,5,"Firma del cliente _________________________________");
//$pdf->Cell(30,5,"Firma del tecnico __________________________________");





}
$pdf->Output();


/*
$pdf->SetXY(10,20);
$pdf->Cell(40,10,$hola1);

$pdf->MultiCell(0,4,$texto,0);
$pdf->ln();
$pdf->Cell(40,10,$categoria);


$pdf->Output();
*/


?>
