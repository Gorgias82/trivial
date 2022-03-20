<?php

/**
 * Description 
 *
 * @author Jorge Vicente Ramiro
 * DAW2
 */

// clase que sera padre de jugador y administrador
abstract class Usuario {
    protected $nombre;
    protected $password;
       
    //funcion para comprobar si existe el usuario
    //en la base de datos
    static function existeUsuario($nombre) {
    $con = new mysqli('localhost', 'jorge', 'Nohay2sin3', 'trivial');
    //usamos una bandera para comprobar si la consulta devuelve algun
    //resultado, la iniciamos bajada, o sea a false
    $existeUsuario = false;
    //el metodo prepare devuelve un statement, se usan ? para los valores
    //que pueden cambiar, en este caso lo vamos a usar con el nombre
    //para que devuelva el password correspondiente
    $consulta_preparada = $con->prepare("select * from usuarios where login=?");
    //bind param se le pasa un parametro que es un string en el que
    //cada caracter indica el tipo de dato(por ejemplo s para string)
    //seguida de la variable nombre
    $consulta_preparada->bind_param("s", $nombre);
    //aqui se ejecuta la sentencia
    $consulta_preparada->execute();
    //guardamos el resultado de la consulta 
    $resultado = $consulta_preparada->get_result();
    //procesar el resultado, el metodo fetch_assoc devuelve un array
    //pero solo devuelve una fila, se puede hacer un bucle
    //se ira desplazando el puntero fila a fila
    while ($fila = $resultado->fetch_assoc()) {
        //levanta la bandera para indicar que si que existe el usuario
        $existeUsuario = true;
    }
    return $existeUsuario;
    //cerrar conexion
    $con->close();
}

//funcion para comprobar si es password corresponde al que hay en
//la base de datos
static function passwordCorrecto($nombre, $password) {
    //primero comprueba si existe el jugador
    if (SELF::existeUsuario($nombre)) {
        $con = new mysqli('localhost', 'jorge', 'Nohay2sin3', 'trivial');
        $isCorrecto = false;
        //el metodo prepare devuelve un statement, se usan ? para los valores
        //que pueden cambiar, en este caso lo vamos a usar con el nombre y el password
        //para que devuelva alguna fila en caso de que exista el usuario y el password sea correcto
        $consulta_preparada = $con->prepare("select * from usuarios where login=? and password=?");
        //bind param se le pasa un parametro que es un string en el que
        //cada caracter indica el tipo de dato(por ejemplo s para string)
        //seguida de lasvariables nombre y password
        $consulta_preparada->bind_param("ss", $nombre, $password);
        //aqui se ejecuta la sentencia
        $consulta_preparada->execute();
        //guardamos el resultado de la consulta 
        $resultado = $consulta_preparada->get_result();
        //procesar el resultado, el metodo fetch_assoc devuelve un array
        //pero solo devuelve una fila, se puede hacer un bucle
        //se ira desplazando el puntero fila a fila
        while ($fila = $resultado->fetch_assoc()) {
            //levanta la bandera para indicar que el password es correcto
            $isCorrecto = true;
        }
        return $isCorrecto;
        //cerrar conexion
        $con->close();
    } else {
        return false;
    }
}
    
}
