<?php

/**
 * Description 
 *
 * @author Jorge Vicente Ramiro
 * DAW2
 */
include_once 'Tarjeta.php';
include_once 'Jugador.php';

class Trivial {

    private $tarjetas;
    private $jugador;

    //Constructor recibe nombre y password de un jugador y el numero de rondas
    //tambien puede recibir la categoria, si es asi crea
    //el array de tarjetas de esa categoria, si no es un 
    //array de tarjetas de categoria aleatoria
    function __construct($jugador, $rondas) {
        $this->jugador = $jugador;
        $this->tarjetas = array();
        for ($i = 0; $i < $rondas; $i++) {
            if (func_num_args() > 2) {
                $this->tarjetas[] = new Tarjeta(func_get_arg(2));
            } else {
                $this->tarjetas[] = new Tarjeta();
            }
        }
    }
    
    function addPuntuacion($suma){
        $this->jugador->addPuntuacion($suma);
        
    }

    function getTarjeta($indice) {
        return $this->tarjetas[$indice];
    }

    function getJugador() {
        return $this->jugador;
    }

    //se usa un destruct para guardar la puntuacion del jugador una vez acabe la partida
    function __destruct() {
        $con = new mysqli('localhost', 'jorge', 'Nohay2sin3', 'trivial');
        $consulta_preparada = $con->prepare("update usuarios set puntuacion = ? where login= ?");
        $puntuacion = $this->jugador->getPuntuacion();
        $nombre = $this->jugador->getNombre();
        $consulta_preparada->bind_param("ds", $puntuacion,$nombre);
        $consulta_preparada->execute();
        $con->close();
    }

}
