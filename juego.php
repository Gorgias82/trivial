<!--Jorge Vicente Ramiro-->
<!--DAW2-->
<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Juego</title>
        <meta name="viewport" content="width_device-width,initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/estilos.css">
        <style>
            body {
                background-color: #FFFAFA;
            }


        </style>
    </head>

    <body>
        <?php
        include_once 'filtrado.php';
        include_once 'Categoria.php';
        include_once 'Jugador.php';
        include_once 'Tarjeta.php';
        include_once 'Trivial.php';
        session_start();
        if (!isset($_SESSION['jugador'])) {
            header("Location: index.php");
        } else {
            //Comprueba si ha seleccionado categoria o si ya esta jugando
            //y ha respondido a una pregunta
            if (isset($_POST['categoria']) || isset($_GET['enviarTarjeta'])) {
                //Esto comprueba que es la primera ronda dado
                //que ha seleccionado categoria y le ha dado a enviar
                if (isset($_POST['enviarCategoria']) && isset($_POST['categoria'])) {

                    //pasa a variables el numero de rondas
                    //y la categoria seleccionada por el jugador
                    $rondas = $_POST['rondas'];
                    $categoria = $_POST['categoria'];
                    //si la categoria es aleatoria
                    //crea un Trivial sin pasarle categoria
                    //si la ha recibido la usa para pasarsela
                    //al crear la clase Trivial
                    if ($categoria == 'aleatoria') {
                        $juego = new Trivial($_SESSION['jugador'], $rondas);
                    } else {
                        $juego = new Trivial($_SESSION['jugador'], $rondas, $categoria);
                    }
                    //IMPORTANTE! serializar para que pueda
                    //cargar los puntos en la base de datos
                    //al finalizar la partida
                    $_SESSION['juego'] = serialize($juego);
                    //Crea las variables de sesion para gestionar
                    //la partida, el numero de pregunta y las rondas
                    //para jugar las rondas solicitadas
                    //los aciertos para mostrarselos al jugador
                    $_SESSION['numeroPregunta'] = 1;
                    $_SESSION['aciertos'] = 0;
                    $_SESSION['rondas'] = $rondas;
                }

                //Este input viene del metodo Mostrar()
                //de Tarjeta
                if (isset($_GET['enviarTarjeta'])) {
                    //se usan numeros del 0 al 3 para comprobar
                    //que respuesta ha recibido, si no recibe
                    //nada la pone en -1 para darla como incorrecta
                    if (isset($_GET['respuestas'])) {
                        $respuesta = filtrado($_GET['respuestas']);
                    } else {
                        $respuesta = -1;
                    }
                    //se comprueba que la respuesta recibida
                    // corresponde con el indice de la respuesta
                    //correcta, si es asi se suman puntos
                    if ($_GET['indiceCorrecto'] == $respuesta) {
                        $_SESSION['aciertos'] = $_SESSION['aciertos'] + 1;
                        $juego = unserialize($_SESSION['juego']);
                        $juego->addPuntuacion(100);
                        $_SESSION['juego'] = serialize($juego);
                        echo "HA ACERTADO <br>";
                    } else {
                        echo "HA FALLADO <br>";
                    }
                }
                //Comprueba que no se ha sobrepasado el numero de rondas
                //seleccionadas
                if ($_SESSION['numeroPregunta'] <= $_SESSION['rondas']) {
                    //Se recoge el numero de pregunta para usarlo como
                    // indice en el array de tarjetas
                    // y la istancia de Trivial
                    $indice = $_SESSION['numeroPregunta'] - 1;
                    $juego = unserialize($_SESSION['juego']);
                    $juego->getTarjeta($indice)->mostrar();
                } else {
                    $juego = unserialize($_SESSION['juego']);
                    $aciertos = $_SESSION['aciertos'];
                    $puntuacion = $juego->getJugador()->getPuntuacion();
                    $_SESSION['jugador'] = $juego->getJugador();
                    echo "Ha acertado $aciertos preguntas, su puntuacion actual es $puntuacion";
                    ?>
                    <div>
                        <a href="juego.php"> Jugar otra partida</a>
                    </div>
                    <div>
                        <a href="index.php"> Cambiar de usuario</a>
                    </div>

                    <?php
                }
            } else {
                //Comprueba si le ha dado a enviar pero no ha seleccionado categoria
                if (isset($_POST['enviarCategoria']) && !isset($_POST['categoria'])) {
                    echo "Debe introducir alguna categoria <br>";
                }
                $puntuacion = $_SESSION['jugador']->getPuntuacion();
                $nombre = $_SESSION['jugador']->getNombre();

                $cdb = new mysqli('localhost', 'jorge', 'Nohay2sin3', 'trivial');
                $consulta = $cdb->query('select * from usuarios order by puntuacion desc');
                $posicion = 1;
                ?>
              


                <div class="container">
                    <form id="entrada" method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">

                        <div class="row">
                            <div class="col-auto">
                                <h3>Bienvenido <?php echo $nombre; ?> su puntuacion actual es de <?php echo $puntuacion; ?> puntos
                                </h3>
                                <h3>¿En que categoria prefiere jugar?</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label for='0' class="btn btn-danger">
                                        <input type="radio" id='0' name="categoria"
                                               value='<?php echo Categoria::SI; ?>'><?php echo Categoria::SI; ?>
                                    </label>
                                    <label for='1' class="btn btn-success">
                                        <input type="radio" id='1' name="categoria"
                                               value='<?php echo Categoria::BD; ?>'><?php echo Categoria::BD; ?>
                                    </label>
                                    <label for="2" class="btn btn-info">
                                        <input type="radio" id='2' name="categoria"
                                               value='<?php echo Categoria::PHP; ?>'><?php echo Categoria::PHP; ?>
                                    </label>
                                    <label for="3" class="btn btn-secondary">
                                        <input type="radio" id='3' name="categoria"
                                               value='<?php echo Categoria::DIW; ?>'><?php echo Categoria::DIW; ?>
                                    </label>
                                    <label for="4" class="btn btn-warning">
                                        <input type="radio" id='4' name="categoria"
                                               value='<?php echo Categoria::JS; ?>'><?php echo Categoria::JS; ?>
                                    </label>
                                    <label for="5" class="btn btn-light">
                                        <input type="radio" id='5' name="categoria"
                                               value='<?php echo Categoria::JA; ?>'><?php echo Categoria::JA; ?>
                                    </label>
                                    <label for="aleatorio" class="btn btn-dark">
                                        <input type="radio" id='aleatorio' name="categoria" value="aleatoria"> Aleatoria
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <h3>¿Cuantas rondas quiere jugar?</h3>
                                <label class="form-label" for="rondas">Rondas:</label>
                                <input class="form-control" type="number" id="rondas" name="rondas" min="1" value="1">
                            </div>
                        </div>

                        <div>
                            <button type="submit" id="enviarCategoria" name="enviarCategoria" value="enviarCategoria"
                                    class="btn btn-primary">Jugar!!
                            </button>
                        </div>
                    </form>
                </div>
          <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive mt-5 mb-5">
                                <table class="table table-striped table-hover table-sm table-bordered">
                                    <caption>Ranking de jugadores</caption>
                                    <tbody>
                                        <?php
                                        while ($fila = $consulta->fetch_assoc()) {
                                            if ($posicion <= 1) {
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
                        </div>
                    </div>
                </div>
            <footer>
        <div class="container-fluid">
            <div class="row justify-content-center align-middle mt-5 bg-success">
                <div class="col-auto">
                    <span class="h4 align-self-center">Mira el codigo aqui: </span>
                    <a href="https://github.com/Gorgias82/trivial"
                        class="d-inline-flex align-items-center justify-content-center">
                        <img src="./imagenes/github.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </footer>
                <?php
            }
        }
        ?>
    </body>

</html>