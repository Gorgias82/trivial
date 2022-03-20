/*
Jorge Vicente Ramiro
DAW2
*/

--Se crea un usuario con acceso desde localhost--
create user 'jorge'@'localhost' identified by 'Nohay2sin3';
--Se le conceden privilegios de seleccion para la tabla usuarios y tabla tarjetas--
--asi como permisos de insercion para la tabla usuarios--
GRANT
	SELECT, INSERT
	ON trivial.tarjetas
	TO 'jorge'@'localhost';
FLUSH PRIVILEGES;
GRANT 
INSERT, SELECT, UPDATE, DELETE
ON trivial.usuarios
TO 'jorge'@'localhost';
FLUSH PRIVILEGES;
