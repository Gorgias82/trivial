<?php

/**
 * Description 
 *
 * @author Jorge Vicente Ramiro
 * DAW2
 */
include_once 'Usuario.php';

class Jugador extends Usuario {

    private $puntuacion;

    //el constructor tiene que recibir el nombre y la contraseña
    function __construct($nombre, $password) {

        $con = new mysqli('localhost', 'jorge', 'Nohay2sin3', 'trivial');

        //la funcion real_scape_string evita ataques sql inyection
        //porque interpreta las comillas como un literal
        //y evita que se inyecte un codigo indeseado
        $this->nombre = $con->real_escape_string($nombre);
        $this->password = $con->real_escape_string($password);

        //Se comprueba si ya existe el jugador
        // en la base de datos
        // si es asi se vuelcan los datos en las variables
        // de la clase
        if (Usuario::existeUsuario($nombre)) {
            echo "existe el usuario";
            //Se genera una consulta preparada para buscar una fila
            // con un login concreto que sera el nombre recibido
            $consulta_preparada = $con->prepare("select * from usuarios where login= ?");
            //Se vincula el nombre a la consulta
            $consulta_preparada->bind_param("s", $nombre);
            //aqui se ejecuta la sentencia
            $consulta_preparada->execute();
            //vincular variables a la sentencia preparada
            $consulta_preparada->bind_result($login, $password, $puntuacion);
            while ($consulta_preparada->fetch()) {
                //se usan la variables para rellenar los campos de la clase
                //tarjeta
                $this->nombre = $login;
                $this->password = $password;
                $this->puntuacion = $puntuacion;
            }
        } else {
            //si el usuario no existe en la base de datos  se inserta en la misma
            $this->puntuacion = 0;
            $consulta = $con->query("insert into usuarios values('$nombre','$password',$this->puntuacion)");
            //devuelve true si se ha producido correctamente la insercion
            //y rellena los valores de la clase
            //con los parametros recibidos
            if ($consulta) {
                $this->nombre = $nombre;
                $this->password = $password;
                echo "insercion correcta";
            } else {
                echo "No se ha podido realizar la insercion";
            }
        }

        $con->close();
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPassword() {
        return $this->password;
    }

    function getPuntuacion() {
        if ($this->puntuacion > 0) {
            return $this->puntuacion;
        } else {
            return 0;
        }
    }

    function addPuntuacion($suma) {
        if ($suma > 0) {
            $this->puntuacion = $this->puntuacion + $suma;
            return true;
        } else {
            return false;
        }
    }

    
   
    
    
    
     
    

}
