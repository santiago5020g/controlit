if([propietario]==1)
{
$propietario={propietario};
$idso={id};
$fecha_inicio={fecha_inicio_programado};
$hora_inicio={hora_inicio_programado};
$hora_fin={hora_fin_programado};

$sql="INSERT INTO tbltareas(idso,propietario,fecha_inicio,hora_inicio,hora_fin) 
VALUES ($idso,'$propietario','$fecha_inicio','$hora_inicio','$hora_fin');";
sc_exec_sql($sql);
}

if([estado3]==2)
{
$Date = "now()";	
sc_exec_sql("UPDATE tblsolicitudes set abierto_a_verificar = $Date
WHERE id={id}");

if({idcontra}==1 && ({tiempo}=="" || {tiempo}==0) && {idproyecto}==1)
{

$link = "id_solicitud=".urlencode({id})."&correo_solicitud=".urlencode({correo});
//echo $link;

echo "<style>
#my-div
{
width    : 100px;
height   : 100px;
overflow : hidden;

}

#my-iframe
{
position : absolute;
top      : 50%;
left     : 0%;
width    : 100%;
height   : 100%;
}
</style> 
<div id=my-div>
<iframe id=my-iframe src =../mis_librerias/correos/cron.php?".$link."></iframe>
</div>
";
}
}

else if([estado3]==3)
{
$Date = "now()";
sc_exec_sql("update tblsolicitudes 
set fecha_verificacion = $Date WHERE id={id}");

if({idcontra}==1 && ({tiempo}=="" || {tiempo}==0) && {idproyecto}==1)
{
$link = "id_solicitud=".urlencode({id})."&correo_solicitud=".urlencode({correo});
//echo $link;

echo "<style>
#my-div
{
width    : 100px;
height   : 100px;
overflow : hidden;

}

#my-iframe
{
position : absolute;
top      : 50%;
left     : 0%;
width    : 100%;
height   : 100%;
}
</style> 
<div id=my-div>
<iframe id=my-iframe src =../mis_librerias/correos/cron.php?".$link."></iframe>
</div>
";
}

if({idcontra}>1)
{
sc_lookup(dataset,"SELECT so.id as so_id,SUM( tarea.tiempo_efectivo ) as 
suma_tiempo_efectivo,contra.valor as contrato_valor
FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
inner join tblcontratos contra on contra.idcontrato=so.idcontra
where so.idcontra={contrato_idcontrato} and so.idestado in(1) 
and 
so.fechafacturacion !='' 
and so.fechafacturacion IS NOT NULL and so.numero_factura !='' 
and so.numero_factura IS NOT NULL");

if({dataset[0][0]}!=0)
{
$valor_contrato={dataset[0][2]};
$suma_tiempo_efectivo2={dataset[0][1]};
$solicitudd={dataset[0][0]};
$valor_a_distribuir=$valor_contrato/($suma_tiempo_efectivo2/60);


sc_exec_sql("update tbltareas tarea inner join tblsolicitudes so 
on so.id=tarea.idso 
set tarea.valor_facturar=$valor_a_distribuir,so.idestado=6 
where tarea.idso='$solicitudd' and tarea.idcategoria!=22 ");
}

}






}




sc_alert("Modificado");

/*
if(is_numeric({valor_cotizacion}) && is_numeric({tiempo}))
{
sc_lookup(dataset_su,"SELECT SUM( tarea.tiempo_facturar ),
sum(TIMESTAMPDIFF (MINUTE, Timestamp
(tarea.fecha_inicio, tarea.hora_inicio ) ,
Timestamp(tarea.fecha_inicio,tarea.hora_fin)))
FROM tblsolicitudes so INNER JOIN tbltareas tarea ON so.id = tarea.idso
inner join tblcategoria ca on ca.categoriaid=tarea.idcategoria
WHERE tarea.idso ={id} and ca.categoriaid!=22");

$suma_tiempo_facturar={dataset_su[0][0]};
$suma_tiempo_real={dataset_su[0][1]};
$valor_cotizado_hora_efectivo=
({valor_cotizacion}/$suma_tiempo_facturar)*60;
$valor_cotizado_hora_real=
({valor_cotizacion}/$suma_tiempo_real)*60;

{causas}=$valor_cotizado_hora_efectivo;
{solucion}=$valor_cotizado_hora_real;

sc_exec_sql("update tbltareas set valor_facturar=
$valor_cotizado_hora_efectivo,
valor_real=$valor_cotizado_hora_real where idso={id}");
}
*/






/*
$mail_smtp_server = 'smtp.gmail.com';        // SMTP server name or IP address
$mail_smtp_user   = 'notificacionescontrolit@gmail.com';                   // SMTP user name
$mail_smtp_pass   = 'Gusano2014';                // SMTP password
$mail_from        =  'soportetecnico@controlit.com.co';          // From email
$mail_to          =  $mail_contacto_solicitud;       // To email
$mail_subject     =  'Servicio al cliente controlit';            // Message subject
$mail_message     =  "Apreciado cliente, 
Control IT le informa que la solicitud de servicio número " . {id} .  
" ha sido solucionado satisfactoriamente 
<br/><br/> los detalles de la solicitud son:
<br/><br/> <b> Cliente:  </b> ".$cliente.
" <br/><br/><b> Contacto: </b> ".{contacto}.
" <br/><br/> <b> Asunto: </b> ".{asunto}.
" <br/><br/> <b> Descripcion: </b> ". {descripcion} .
"<br/><br/> <b> fecha de finalizacion:  </b>".  {abierto_a_verificar}  . 
"<br/><br/> y las tareas realizadas fueron: <br><br>".$tecnicos.
"<br/> <b> Total tiempo efectivo: </b> ".$tiempo_efe.


"<br><br><br> En este momento su solicitud será enviada al área de facturación.
Si tiene alguna inquietud, favor informar al tel 6041421 
o al correo soportetecnico@controlit.com.co  
<br/><br/>  Atentamente: 
<br/><br/>  Area de Soporte tecnico  ";
// Message body
$mail_format      = 'H';                       // Message format: (T)ext or (H)tml

// Send email";
sc_mail_send($mail_smtp_server,
$mail_smtp_user,
$mail_smtp_pass,
$mail_from,
$mail_to,
$mail_subject,
$mail_message,
$mail_format);


if(preg_match($Sintaxis,$cliente_correo)) 
{
sc_mail_send($mail_smtp_server,
$mail_smtp_user,
$mail_smtp_pass,
$mail_from,
$cliente_correo,//mail to
$mail_subject,
$mail_message,
$mail_format);  
}


}//fin if(preg_match($Sintaxis,$mail_cliente))


}//fin else if([estado3]==3)

*/



