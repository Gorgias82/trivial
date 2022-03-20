<?php
/**
 * Description 
 *
 * @author Jorge Vicente Ramiro
 * DAW2
 */
include_once 'Tarjeta.php';
include_once 'Usuario.php';

//clase administrador para un usuario unico
//que permitira realizar varias gestiones
class Administrador extends Usuario {

    function __construct() {
        $this->nombre = 'admin';
        $this->password = null;
    }

    //Funcion que recibe los datos de una tarjeta y la introduce en la base de datos
    function insertarPregunta($categoria, $pregunta, $respuestaCorrecta, $respuestaFalsa1, $respuestaFalsa2, $respuestaFalsa3) {
        //insercion con consulta preparada
        $con = new mysqli('localhost', 'jorge', 'Nohay2sin3', 'trivial');
        $consulta_preparada = $con->prepare("insert into tarjetas(categoria,pregunta,respuestaCorrecta,respuestaFalsa1,respuestaFalsa2,respuestaFalsa3) values(?,?,?,?,?,?)");
        $consulta_preparada->bind_param("ssssss", $categoria, $pregunta, $respuestaCorrecta, $respuestaFalsa1, $respuestaFalsa2, $respuestaFalsa3);
        $consulta_preparada->execute();
        //devuelve true si se ha producido correctamente la insercion
        if ($consulta_preparada) {
            echo "insercion correcta <br>";
        } else {
            echo "No se ha podido realizar la insercion";
        }
         ?>
        <div>
            <a href="menu_admin.php"> Hacer otra gestion de administrador</a>
        </div>
        <div>
            <a href="index.php"> Cambiar de usuario</a>
        </div>
        <?php

        $con->close();
    }

    //funcion que recibe un nombre de usuario y lo elimina de la base de datos
    function borrarUsuario($login) {
        $con = new mysqli('localhost', 'jorge', 'Nohay2sin3', 'trivial');
        $consulta_preparada = $con->prepare("delete from usuarios where login = ?");
        $consulta_preparada->bind_param("s", $login);
        $consulta_preparada->execute();
        //devuelve true si se ha borrado la fila correctamente
        if ($consulta_preparada) {
            echo "Borrado correcto <br>";
        } else {
            echo "No se ha podido realizar el borrado";
        }
        ?>
        <div>
            <a href="menu_admin.php"> Hacer otra gestion de administrador</a>
        </div>
        <div>
            <a href="index.php"> Cambiar de usuario</a>
        </div>
        <?php
        $con->close();
    }

    //funcion que muestra todos los usuarios ordenados por puntuacion
    function ranking() {
        $con = new mysqli('localhost', 'jorge', 'Nohay2sin3', 'trivial');
        $consulta = $con->query('select * from usuarios order by puntuacion desc');
       $posicion = 1;
                ?>
 <div class="table-responsive mt-5 mb-5">
        <table class="table table-striped table-hover table-sm table-bordered" id="respuesta" hidden="hidden">
            <caption>Lista de movimientos</caption>
            <tbody>
                <?php
                
        while ($fila = $consulta->fetch_assoc()) {
            if($posicion <= 1){
                ?>
                <tr>
                <th>Posicion</th>
                <th>Nombre</th>
                <th>Puntuación</th>
                </tr>
                <?php
            }     
            //se comprueba que el nombre no sea admin
            //para que no muestre al usuario administrador
            //y solo muestre a los jugadores
            if ($fila['login'] != 'admin') {
                ?>
                 <tr>
                    <td> <?php echo $posicion; ?>  </td>
                    <td> <?php echo $fila['login']; ?>  </td>
                    <td> <?php echo $fila['puntuacion']; ?>  </td>
                </tr>
                <?php
                $posicion++;
            }
        }
         ?>

               
            </tbody>
        </table>
    </div>
        <div>
            <a href="menu_admin.php"> Hacer otra gestion de administrador</a>
        </div>
        <div>
            <a href="index.php"> Cambiar de usuario</a>
        </div>
        <?php
    }

}
