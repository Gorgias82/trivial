    /*
Jorge Vicente Ramiro
DAW2
*/
create database trivial;
use trivial;
--creacion tabla tarjetas--
--se crea un campo para el id, que sea un numero positivo y que se vaya incrementando automaticamente--
--La tabla tendra 6 campos mas la pregunta, la categoria, 1 respuesta correcta y 3 incorrectas--
--se asigna el campo id como primary key--
create table tarjetas(
id SMALLINT UNSIGNED not null AUTO_INCREMENT
,categoria VARCHAR(40) not null	
,pregunta VARCHAR(120) not null												
,respuestaCorrecta VARCHAR(80) not null
,respuestaFalsa1 VARCHAR(80) not null
,respuestaFalsa2 VARCHAR(80) not null
,respuestaFalsa3 VARCHAR(80) not null
,primary key (id)
)CHARACTER SET utf8 COLLATE utf8_general_ci;
--Creacion tabla usuarios--
--la primary key es el login, tambien tiene un campo contraseña--
--y un campo puntuacion donde se ira acumulando la puntucacion--
create table usuarios(
login VARCHAR(40) not null	
,password VARCHAR(40) not null
,puntuacion INT DEFAULT 0												
,primary key (login)
);
--Creacion de un usuario administrador--
insert INTO usuarios(login,password) VALUES('admin','Nohay2sin3');

