<?php
require("solicitudes.php");
require('../fpdf17/fpdf.php');



if(isset($_POST["solicitudespp"]))
{
$lista_solictudes=$_POST["solicitudespp"];
}
$obj_reportes= new Solicitudes();
$so = $obj_reportes->getSolicitudes_reporte($lista_solictudes);
$valor_y_tiempo_facturar=0;
$Subtotal=0;
$total=0;
$solicitudes2="";
$tipo_servicio="";

$cso=count($so);

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
    /*
   if($lastPage){
        $this->Cell(100,10,"Firma del cliente _________________________________",0,0,'C');
        $this->Cell(100,10,"Firma del tecnico  __________________________________",0,0,'C');


    }
    */
}  
}


$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);
$pdf->Image('../img/controlit.png',10,10,-200);


for($y=0;$y<$cso;$y++)
{
	
	$solicitudes2 .= $so[$y]["id"];
	if($y==$cso -1) 	{ $solicitudes2 .="."; }
	else {$solicitudes2 .=",";}
	

$Subtotal=0;
$pdf->SetXY(10,20);

$pdf->SetFont('Arial','b',9);
$pdf->Cell(20,10,"solicitud");
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,10,$so[$y]["id"]);

$pdf->SetFont('Arial','b',9);
$pdf->Cell(20,10,"Estado");
$pdf->SetFont('Arial','',9);
$pdf->Cell(40,10,$so[$y]["estado"]);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(15,10,"cliente");
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,10,utf8_decode($so[$y]["cliente"]));
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
$pdf->Cell(30,10,utf8_decode($so[$y]["tecnico_solicitud"]));
$pdf->ln();
$pdf->SetFont('Arial','b',9);
$pdf->Cell(25,10,"Solicitante");
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,10,utf8_decode($so[$y]["solicitante"]));
$pdf->SetFont('Arial','b',9);
$pdf->Cell(35,10,"fecha de la solicitud");
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,10,date('d/m/Y',strtotime($so[$y]["fecha_solicitud"])));
$pdf->ln();
$pdf->SetFont('Arial','b',9);
$pdf->Cell(25,10,"Asunto");
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,10,utf8_decode($so[$y]["asunto"]));
$pdf->ln();
$pdf->SetFont('Arial','b',9);
$pdf->Cell(25,5,"Descripcion");
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0,5,utf8_decode($so[$y]["descripcion"]));
$pdf->ln();

$pdf->SetX(75);
$pdf->SetFont('Arial','b',9);
$pdf->Cell(40,10,"Tareas realizadas");
$pdf->ln();
$pdf->ln();
$ta = $obj_reportes->getTareas_reporte($so[$y]["id"]);
for($x=0;$x<sizeof($ta);$x++)
{
		
		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(20,5,"Tarea");
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20,5,$ta[$x]["tarea"]);
		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(30,5,"tecnico");
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(50,5,utf8_decode($ta[$x]["tecnico_tarea"]));

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
		$pdf->Cell(20,5,utf8_decode($ta[$x]["sede"]));
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
		$pdf->Cell(30,5,utf8_decode($ta[$x]["categoria"]));
		$pdf->ln();
		$pdf->ln();
		$pdf->SetFont('Arial','b',9);
		$pdf->Cell(30,5,"Detalles");
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(0,5,utf8_decode($ta[$x]["detalles"]));
		$pdf->ln();
		$pdf->ln();

		//$valor_y_tiempo_facturar=(($ta[$x]["tarea_valor_facturar"]) * ($ta[$x]["tarea_tiempo_facturar"]))/60;
		//$Subtotal+=$valor_y_tiempo_facturar;
		//$total+=$valor_y_tiempo_facturar;
	
}
//$pdf->SetFont('Arial','b',9);
//$pdf->Cell(30,5,"Subtotal:");
//$pdf->SetFont('Arial','',9);
//$pdf->Cell(30,5,$Subtotal);


$pdf->AddPage();
//$pdf->Image('img/controlit.png',10,10,-200);
//$pdf->SetXY(10,271);
//$pdf->Cell(100,5,"Firma del cliente _________________________________");
//$pdf->Cell(30,5,"Firma del tecnico __________________________________");





}


$solicitudes2 = $obj_reportes->getTiposervicio($solicitudes2);
for($i=0;$i<sizeof($solicitudes2);$i++)
{
	$pdf->SetFont('Arial','b',9);
	$pdf->Cell(45,5,$solicitudes2[$i]["tipos_nombre"]);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(20,5,Round((($solicitudes2[$i]["suma_tarea_tiempo_efetivo"])/60),2)." Horas");
	$pdf->ln();
}


//$pdf->Cell(20,5,$solicitudes2);

/*
$pdf->SetFont('Arial','b',9);
$pdf->Cell(30,5,"Total:");
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,5,$total);
*/

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
