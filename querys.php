<?php 

numero y fecha de factura en los proyectos


ALTER TABLE  `tblproyectos` ADD  `numero_factura` VARCHAR( 100 ) NOT NULL DEFAULT  'NA',

ALTER TABLE  `tblcontratos` ADD  `horas_contratadas` VARCHAR( 8 ) NOT NULL DEFAULT  '0';







create table tblservicio
(
 id int(11) not null auto_increment primary key,
 descripcion varchar(30)
);

create table tbltiqueteras
(
	id int(11) not null auto_increment primary key,
	numero_factura varchar(30) not null,
	minutos int(11) not null,
	fecha_creacion date not null,
	idcliente bigint(20) not null
);

INSERT INTO tblservicio(descripcion) values('Sin nada asociado');
INSERT INTO tblservicio(descripcion) values('Tiquetera');

ALTER TABLE tbltiqueteras ADD FOREIGN KEY (idcliente) REFERENCES tblclientes(id_cli);
ALTER TABLE tblsolicitudes ADD idservicio int(11) NOT NULL DEFAULT 1;
ALTER TABLE tblsolicitudes ADD FOREIGN KEY(idservicio) REFERENCES tblservicio(id);
ALTER TABLE tbltiqueteras ADD cantidad int(11) NOT NULL;
ALTER TABLE tbltiqueteras ADD usuario varchar(32) NOT NULL;
ALTER TABLE tbltiqueteras ADD FOREIGN KEY(usuario) REFERENCES sec_users(login);




create table tblmovimientos
(
	id int(11) not null auto_increment primary key,
	numero_tiquetera int(11) not null,
	numero_tarea bigint(20) not null,
	puntos_consumidos int not null,
	estado_cruzado int not null DEFAULT 1
);


ALTER TABLE tblmovimientos  ADD FOREIGN KEY (numero_tiquetera)  REFERENCES tbltiqueteras(id);
ALTER TABLE tblmovimientos  ADD FOREIGN KEY (numero_tarea) REFERENCES tbltareas (idtareas);







?>



if({idservicio}==2)
	{
		sc_lookup(tiqueteras,"select id,minutos from tbltiqueteras where idcliente = 			  {Idcliente}");
	   
	   sc_lookup(tareas,"select idtareas,tiempo_efectivo from tbltareas where idso = {id}");
	   
	   for($i;$i<sizeof({tiqueteras});$i++)
	   {
		   sc_lookup(tiqueteras_suma,"select SUM(minutos) from tblmovimientos where numero_tiquetera =".{tiqueteras[$i][0]});
		  $total = {tiqueteras_suma[0][0]};
		  for($i2;$i2<sizeof({tareas});$i2++) 
		  {
			 if($sw==1){sc_lookup(tiqueteras_suma,"select SUM(minutos) from tblmovimientos where numero_tiquetera =".{tiqueteras[$i][0]});
		  $total = {tiqueteras_suma[0][0]};
			$sw = 0;}
		  $tiempo_tarea = {tarea[$i2][1]};
		  $total = $total + $tiempo_tarea;

			if($total>240)
			{		
				if($i == sizeof({tiqueteras})-1)
				{	
				sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES({tiquetera[$i][0]},{'tareas[$i2][0]}',$tiempo_tarea,2)");
				}
				 
				else
				{
					//240 - 250 = -10; 60-10 = 50;
					$total = $total - 240;
					$tiempo_tarea = $tiempo_tarea - $total;	
					$sw = 1;
sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado2) VALUES({tiquetera[$i][0]},{'tareas[$i2][0]}',$tiempo_tarea,2");


if($total<=240)
{
	$i +=1 ;
	$tiempo_tarea = $total;
	{sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos) VALUES({tiquetera[$i][0]},{'tareas[$i2][0]}',$tiempo_tarea");}

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

sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado2) VALUES({tiquetera[$i][0]},{'tareas[$i2][0]}',$tiempo_tarea,2");
				
	}
}

		
	}// fin else despues de if($i == sizeof({tiqueteras})-1)	
	   }// fin if($total>240)
	
		else
		 {sc_exec_sql("INSERT INTO tblmovimientos (numero_tiquetera,numero_tarea,puntos_consumidos) VALUES({tiquetera[$i][0]},{'tareas[$i2][0]}',$tiempo_tarea,2)");  
		 }
			  
		if($i2< sizeof(tarea)-1)
			{
				$i = sizeof({tiqueteras}+1);
 			} 
		
    }//fin ciclo tareas
   }//fin ciclo tiqueteras
}// fin  if({idservicio}==2)




























<?php

require('../conexion/conexion.php');

$servicio = 2;
$obj_conexion = new Conn();

//$cliente = $_REQUEST["cliente"];
//$idso = $_REQUEST["idso"];

$cliente = 900449925;
$idso = 5640;

		 $i=0;
		 $i2=0;
		 $i3=0;
		 $i4 = 0;
		 $i5 = 0;
		 $c = 0;
		 $total = 0;
		 $tiempo_tarea=0;
		 $tiqueteras_validadas = array();
		 $envio_de_correo = 0;
		 $correo_solicitud = $obj_conexion->megaShot("select so.correo from tblsolicitudes so where so.id = '$idso'");
		 $tiqueteras = $obj_conexion->megaShot("select id,minutos from tbltiqueteras where idcliente = '$cliente'");
		 $tareas = $obj_conexion->megaShot("select ta.idtareas,ta.tiempo_efectivo,ca.tipo_servicio from tbltareas ta inner join tblcategoria ca on ca.categoriaid = ta.idcategoria where ta.idso = $idso group by ta.idtareas");


		 $suma_movimientos = $obj_conexion->megaShot("select SUM(mov.puntos_consumidos) from tblmovimientos mov inner join tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = ".$cliente);
		 if($suma_movimientos >= (count($tiqueteras) * 0.80))
		 {
		 	$envio_de_correo = 1;
		 	$correos=explode(";", $correo_solicitud[0][0]);
			for($i2=0;$i2<sizeof($correos);$i2++)
				{

					if(!filter_var($correos[$i2], FILTER_VALIDATE_EMAIL)){$c=$c+1;}

				}

				$i2 = 0;
		 }

	



		 for($i4 = 0 ; $i4<sizeof($tiqueteras);$i4++)
		 {
		 	$suma2 = $obj_conexion->megaShot("SELECT SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera=".$tiqueteras[$i4][0]);
		 	if($suma2[0][0]<240){$tiqueteras_validadas[$i5][0] = $tiqueteras[$i4][0]; /*echo $tiqueteras_validadas[$i5][0]."<br>";*/ $i5++;}
		 }


		 if(count($tiqueteras_validadas)==0)
		 {
		 	$suma2 = $obj_conexion->megaShot("SELECT MAX(ti.id) from tblmovimientos mov inner join  tbltiqueteras ti on ti.id = mov.numero_tiquetera where ti.idcliente = '$cliente' and mov.estado_cruzado = 1");
		 	$tiqueteras_validadas[0][0] = $suma2[0][0];
		 }

		 $tiqueteras = $tiqueteras_validadas; 
		 for($i;$i<sizeof($tiqueteras);$i++)
	{
			 $tiqueteras1 = $tiqueteras[$i][0];
			 $suma3 = $obj_conexion->megaShot("SELECT SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera=".$tiqueteras[$i][0]);
			 $total = $suma3[0][0];

	for($i2;$i2<sizeof($tareas);$i2++)
	{

		$idtarea1 = $tareas[$i2][0];
		if($tareas[$i2][2]==9){$tiempo_tarea = $tareas[$i2][1]*1.6;}
		else{$tiempo_tarea = $tareas[$i2][1];}
		$total = $total + $tiempo_tarea;
		$tiempo_tarea_temporal = $tiempo_tarea;
		$sw = 0;
		$sw2=0;

			if($total<=240)
			{
				$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");

			}
		
			else
			{
				$numero_clicos = variant_int($total/240);

				//echo $numero_clicos. "-- total hasta ahora--".$total."<br>";
				for($i3;$i3<$numero_clicos;$i3++)
				{
					$total = $total - 240;
					$tiqueteras1 = $tiqueteras[$i][0];
					$suma = $obj_conexion->megaShot("SELECT SUM(puntos_consumidos) from tblmovimientos where numero_tiquetera=".$tiqueteras1);
					if($suma[0][0]<=240){$tiempo_tarea = 240 - $suma[0][0];}
					if($i == sizeof($tiqueteras) -1)
					{

						$tiempo_tarea = $tiempo_tarea_temporal;
				$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
						$i3 = $numero_clicos +1;	
						$sw = 1;
					}

					else
					{
					$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
						$i+=1;
					}

				}//fin for numero cliclos
				//echo $numero_clicos."<br>";
					$tiqueteras1 = $tiqueteras[$i][0];
					if($total > 0 && $sw==0)
					{
						$sw2=0;
						$tiempo_tarea = $total;
				$obj_conexion->updateShot("INSERT INTO tblmovimientos(numero_tiquetera,numero_tarea,puntos_consumidos,estado_cruzado) VALUES($tiqueteras1,$idtarea1,$tiempo_tarea,1)");
					}
					$i3 = 0;
			}// fin else

		if($i2==sizeof($tareas)-1)
			{$i = sizeof($tiqueteras) +1;}
	}// fin for tareas

}// fin for tiqueteras






if($envio_de_correo !=0 && $c!=0)
{
	require('../correos/includes/mailer/class.phpmailer.php');
	require('../correos/includes/mailer/class.smtp.php');
	require('../correos/clases/class_solicitudes.php');

	$mail = new PHPMailer();
	$obj_Solicitudes = new Solicitudes_consultas();


	$body = "Apreciado cliente Control IT le informa que su consumo de tiqueteras excede al ochenta porciento. Por favor solicite más tiqueteras";

	/*
	select ta.idtareas as ta_idtareas,us.name as us_tarea,us.email as us_email,ta.fecha_inicio as ta_fecha_inicio,ta.hora_inicio as ta_hora_inicio,ta.hora_fin as ta_hora_fin,ta.observaciones as ta_observaciones from tbltareas ta inner join sec_users us on us.login = ta.propietario
				where ta.idtareas= $idtareas
				*/




		$mail->IsSMTP();
			//$mail->CharSet = 'UTF-8';
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->SMTPSecure = "tls";
		$mail->Host     = "smtp.gmail.com";
		$mail->Username = "notificacionescontrolit@gmail.com";
		$mail->Password = "Gusano2014";
		$mail->Port        = 587;
		$mail->SetFrom( 'soporte@controlit.com.co', 'Soporte Controlit' ); //Especificamos remitente
		$mail->AddReplyTo( 'soporte@controlit.com.co' );
		$mail->Subject = "Servicio al cliente controlit";
		$mail->AltBody = "prueba";
		
		$mail->MsgHTML($body);
		/*
		$mail->AddAddress("carlos@controlit.com.co");
		$mail->AddAddress("luispolo@controlit.com.co");
		$mail->AddAddress("yulianaarbelaez@controlit.com.co");
		$mail->AddAddress("juancasas@controlit.com.co");
		$mail->AddAddress("danielpolo@controlit.com.co");
		$mail->AddAddress("diegoorozco@controlit.com.co");
		$mail->AddAddress("jhonherrera@controlit.com.co");
		$mail->AddAddress("carlosforero@controlit.com.co");
		$mail->AddAddress("andresecheverri@controlit.com.co");
		$mail->AddAddress("luzcorrea@controlit.com.co");
		*/
		//$mail->AddAddress("semidfg@gmail.com");

	for($i=0;$i<sizeof($correos);$i++)
		{
			$mail->AddAddress($correos[$i]);
		}

		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Mensaje enviado!";
		}

}


20/04/2015


create table tblestado_tiqueteras
(
	id int(11) not null auto_increment primary key,
	descripcion varchar(20) not null
);

INSERT INTO tblestado_tiqueteras(descripcion) VALUES('Abierto');
INSERT into tblestado_tiqueteras(descripcion) VALUES('Cerrado');

ALTER table tblmovimientos ADD FOREIGN key(estado_cruzado) REFERENCES tblestado_tiqueteras(id);




SELECT 
    mov.id as mov_id,
    mov.numero_tiquetera as mov_numero_tiquetera,
    mov.numero_tarea as mov_numero_tarea,
    mov.puntos_consumidos as mov_puntos_consumidos,
    mov.estado_cruzado as mov_estado_cruzado,
    ti.idcliente as ti_idcliente
FROM 
    tblmovimientos mov inner join tbltiqueteras ti on ti.id = mov.numero_tiquetera
where mov.numero_tiquetera = [tiquetera_global]
group by mov.id


SELECT cli.id_cli, cli.nombre_empresa 
FROM tblclientes cli inner join tbltiqueteras ti on ti.idcliente = cli.id_cli
inner join tblmovimientos mov on mov.numero_tiquetera = ti.id
group by cli.id_cli
ORDER BY cli.nombre_empresa

SELECT nombre_empresa 
FROM tblclientes 
WHERE id_cli = {ti_idcliente} 
ORDER BY nombre_empresa




28/04/2015 campo facturacion


/* Este consulta añade el campo fecha facturacion en las tareas*/
ALTER TABLE tbltareas ADD fecha_facturacion_t date;

/*Esta consulta actualiza la fecha de facturacion de las tareas con la facturacion del proyecto */
UPDATE tbltareas ta inner join tblsolicitudes so on so.id = ta.idso inner join tblproyectos pro on pro.idpro = so.idproyecto SET ta.fecha_facturacion_t = pro.fecha_factura where so.idproyecto >1 and so.idservicio=1 and so.idcontra=1;

/* Actualiza el valor_facturar de las tareas con el valor correspondiente al contrato o proyectos, este campo estaba en valor_real*/
UPDATE tbltareas ta inner join tblsolicitudes so on so.id=ta.idso
inner join tblproyectos pro on pro.idpro = so.idproyecto SET ta.valor_facturar = ta.valor_real
WHERE so.idproyecto > 1 or so.idcontra > 1;

/*Actualiza las tareas con la fecha de facturacion del mes facturado en los contratos*/
UPDATE tbltareas ta inner join tblsolicitudes so on so.id = ta.idso inner join tblcontratos contra on contra.idcontrato = so.idcontra inner join tblfecha_contratos fechac on fechac.idcontra = contra.idcontrato
SET ta.fecha_facturacion_t = fechac.fecha_mes
where date_format(ta.fecha_inicio,'%Y-%m') = date_format(fechac.fecha_mes,'%Y-%m') and so.idcontra > 1 and so.idproyecto = 1 and so.idservicio = 1;

/*Actualiza la fecha de facturacion de las tareas pertenecientes a las solicitudes sueltas, con la fecha de facturacion de solicitud suelta*/
UPDATE tbltareas ta inner join tblsolicitudes so on so.id=ta.idso SET ta.fecha_facturacion_t = so.fechafacturacion WHERE so.idproyecto=1 and so.idcontra=1 and so.idservicio = 1;

/*
ALTER TABLE tbltiqueteras ADD servicio int(11);
UPDATE tbltiqueteras SET servicio = 2;
INSERT INTO tbltiqueteras (numero_factura,minutos,fecha_creacion,idcliente,cantidad,usuario,estado,servicio)
VALUES ('NA',0,'2015-04-27','9999999999',0,'na',1,1);
ALTER TABLE tbltiqueteras ADD FOREIGN KEY(servicio) REFERENCES tblservicio(id);
*/

?>
