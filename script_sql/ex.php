<?php
script sql

ALTER TABLE  `tbltareas` ADD  `idpendiente` INT NOT NULL DEFAULT  '1';

create table tblpendientes_tarea
(
id int(11) not null primary key auto_increment,
descripcion varchar(15) not null
);


insert into tblpendientes_tarea(descripcion) values('No pendiente');
insert into tblpendientes_tarea(descripcion) values('Pendiente');

alter table tbltareas add foreign key(idpendiente) references tblpendientes_tarea(id);


A111F111M113CE7Y


?>