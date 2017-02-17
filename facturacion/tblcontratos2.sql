create table tblcontratos
	(
		idcontrato int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		descripcion MEDIUMTEXT NULL, 
		usuario VARCHAR(32) not null,
		cliente BIGINT(20) NOT NULL,
		fecha_inicio DATE NOT NULL,
		fecha_fin date NULL,
		valor INT(11) NOT NULL,
		idestado_contrato int(11) not null default 1

	)ENGINE INNODB;

insert into tblcontratos(descripcion,usuario,cliente,fecha_inicio,fecha_fin,valor) values('Sin contrato','na',9999999999,'2014-09-03','',0);
ALTER TABLE  `tblsolicitudes` ADD  `idcontra` INT NOT NULL DEFAULT  '1';
alter table tblcontratos add foreign key (usuario) references sec_users(login);
alter table tblcontratos add foreign key (cliente) references tblclientes(id_cli);
ALTER TABLE  tblsolicitudes ADD FOREIGN KEY (idcontra) REFERENCES  tblcontratos (idcontrato);


create table tblestado_contrato
(
 id  INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 descripcion VARCHAR(20) NOT NULL
)ENGINE INNODB;
INSERT INTO tblestado_contrato(descripcion) values('Activo');
INSERT INTO tblestado_contrato(descripcion) values('Inactivo');

--tabla estados
insert into estado(Descripcion) values('No facturados');


--evento of after insert
$fecha_creacion=date("Y-m-d");
$hora_creacion=date("H:i");
$month = date('m');
$year = date('Y');
$day = date("d", mktime(0,0,0, $month+1, 0, $year));
$fin_mes=date('Y-m-d', mktime(0,0,0, $month, $day, $year));
sc_lookup(dataset1,"select MAX(idcontrato) from tblcontratos");
$ultimo_contrato={dataset1[0][0]};
	
	
sc_exec_sql("insert into tblsolicitudes 
(Idcliente,asunto,descripcion,idprioridad,propietario,fecha_inicio_creacion,
hora_creacion,fecha_inicio_programado,hora_inicio_programado,fecha_fin_programado,
hora_fin_programado,idestado,creadopor,idcontra) values('{cliente}','{descripcion}','{descripcion}',
1,
'{usuario}','$fecha_creacion','$hora_creacion','{fecha_inicio}','$hora_creacion',
'$fin_mes','23:00:00',1,'[login]','$ultimo_contrato')");

sc_lookup(dataset2,"select MAX(id) from tblsolicitudes");
$idso={dataset2[0][0]};
$sql="INSERT INTO tbltareas(idso,propietario,fecha_inicio,hora_inicio,hora_fin,idEstado) 
VALUES ($idso,'{usuario}','$fecha_creacion','$hora_creacion','23:59:59',2);";
sc_exec_sql($sql);


--borrar clave foranea es constrain
show create table tblsolicitudes;--informacion de la tabla para bsaer que clave borrar
ALTER TABLE tblsolicitudes DROP FOREIGN KEY 
tblsolicitudes_ibfk_1; 



--select grid

SELECT 
    contrato.idcontrato as contrato_idcontrato,
    contrato.descripcion as contrato_descripcion,
    contrato.usuario as contrato_usuario,
    contrato.cliente as contrato_cliente,
    contrato.fecha_inicio as contrato_fecha_inicio,
    contrato.fecha_fin as contrato_fecha_fin,
    contrato.valor as contrato_valor,
    contrato.idestado_contrato as contrato_idestado
FROM 
    tblcontratos contrato
where  contrato.idcontrato>1


--grid boton runn
$fecha_creacion=date("Y-m-d");
$hora_creacion=date("H:i");
$month = date('m');
$year = date('Y');
$day = date("d", mktime(0,0,0, $month+1, 0, $year));
$fin_mes=date('Y-m-d', mktime(0,0,0, $month, $day, $year));
sc_lookup(dataset1,"select MAX(idcontrato) from tblcontratos");
$ultimo_contrato={dataset1[0][0]};

sc_exec_sql("insert into tblsolicitudes 
(Idcliente,asunto,descripcion,idprioridad,propietario,fecha_inicio_creacion,
hora_creacion,fecha_inicio_programado,hora_inicio_programado,fecha_fin_programado,
hora_fin_programado,idestado,creadopor,idcontra) values('{contrato_cliente}','{contrato_descripcion}','{contrato_descripcion}',
1,
'{contrato_usuario}','$fecha_creacion','$hora_creacion','$fecha_creacion','$hora_creacion',
'$fin_mes','23:00:00',1,'[login]','{contrato_idcontrato}')");


sc_lookup(dataset2,"select MAX(id) from tblsolicitudes");
$idso={dataset2[0][0]};
$sql="INSERT INTO tbltareas(idso,propietario,fecha_inicio,hora_inicio,hora_fin,idEstado) 
VALUES ($idso,'{contrato_usuario}','$fecha_creacion','$hora_creacion','23:59:59',2);";
sc_exec_sql($sql);







---------------
create table tblfecha_contratos
( 
 id int(11) not null auto_increment primary key ,
 idcontra int(11) not null,
 numero_factura2 varchar(20) null,
 fecha_factura2 date null
);

insert into tblfecha_contratos(idcontra) values(1);
alter table tblfecha_contratos add foreign key(idcontra) references tblcontratos(idcontrato);








create table tblencuestas
(
  id int(11) not null auto_increment primary key,
  idsolicitud bigint(20),
  puntos int(11) not null default 1,
  comentarios varchar(200) not null default 'na'
);
alter table tblencuestas add foreign key(idsolicitud) references tblsolicitudes(id);







