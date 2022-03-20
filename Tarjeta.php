<?php
/**
 * Description 
 *
 * @author Jorge Vicente Ramiro
 * DAW2
 */
include_once 'Categoria.php';

class Tarjeta {

    private $categoria;
    private $pregunta;
    private $respuestaCorrecta;
    private $respuestasFalsas = array();

    //Crea una tarjeta extrayendo una fila  de la base
    //de datos y dando los valores de los campos a las propiedades
    //correspondientes de la clase Tarjeta
    //si recibe un parametro interpreta que ha recibido una categoria
    // y creara una tarjeta aleatoria de esa categoria
    // si no recibe nada creara una tarjeta aleatoria de cualquier categoria
    function __construct() {

        //se crea una variable id y un array para guardar todos los ids
        $id;
        $ids = array();
        $con = new mysqli('localhost', 'jorge', 'Nohay2sin3', 'trivial');
        //se comprueba si se ha recibido un parametro
        if (func_num_args() > 0) {
            //se guarda el parametro recibido que sera la categoria
            $categoria = func_get_args()[0];
            //se genera una consulta preparada para buscar todos los id
            // de la categoria recibida
            $consulta_preparada = $con->prepare('select id from tarjetas where categoria= ?');
            //Se vincula el valor del numero aleatorio a la consulta
            //de tal modo que se extraiga una fila aleatoria de la tabla
            $consulta_preparada->bind_param("s", $categoria);
        } else {
            //En caso de no recibir parametro se generara una tarjeta
            //aleatoria entre toda la tabla
            //se genera una consulta para generar todos los ids de la tabla
            $consulta_preparada = $con->prepare('select id from tarjetas');
        }
        //aqui se ejecuta la sentencia
        $consulta_preparada->execute();
        //se vincula el resultado a la variable $id
        $consulta_preparada->bind_result($id);
        while ($fila = $consulta_preparada->fetch()) {
            //se va cargando el array $ids con las ids correspondientes
            $ids[] = $id;
        }
        //extrae un valor aleatorio
        //usando la funcion array_rand para
        //extraer la key de un valor aleatorio
        $aleatorio = $ids[array_rand($ids)];
        //Se genera una consulta preparada para buscar una fila
        // con un id concreto
        $consulta_preparada = $con->prepare("select * from tarjetas where id= ?");
        //Se vincula el valor del numero aleatorio a la consulta
        //de tal modo que se extraiga una fila aleatoria de la tabla
        //si se ha pasado un parametro sera una fila de la categoria recibida
        // si no sera una fila cualquiera
        $consulta_preparada->bind_param("d", $aleatorio);
        //aqui se ejecuta la sentencia
        $consulta_preparada->execute();
        //vincular variables a la sentencia preparada
        $consulta_preparada->bind_result($id, $categoria, $pregunta, $respuestaCorrecta, $respuestaFalsa1, $respuestaFalsa2, $respuestaFalsa3);
        while ($consulta_preparada->fetch()) {
            //se usan la variables para rellenar los campos de la clase
            //tarjeta
            $this->categoria = $categoria;
            $this->pregunta = $pregunta;
            $this->respuestaCorrecta = $respuestaCorrecta;
            $this->respuestasFalsas[] = $respuestaFalsa1;
            $this->respuestasFalsas[] = $respuestaFalsa2;
            $this->respuestasFalsas[] = $respuestaFalsa3;
        }
        $con->close();
    }

    function mostrar() {
        //se crea un array de respuestas y se añade la respuesta correcta
        $respuestas = [$this->respuestaCorrecta];
        //al array se le añaden el resto de respuestas
        $respuestas = array_merge($respuestas, $this->respuestasFalsas);
        //se aplica shuffle para que que se muestren en un orden aleatorio
        shuffle($respuestas);
        //se extrae el indice de la respuesta correcta
        $indiceCorrecto = array_search($this->respuestaCorrecta, $respuestas);
        ?>

        <div style="background-color: <?php echo Categoria::COLORES[$this->categoria]; ?>" class="container">
            <form method='GET' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="row">
                    <div class="col-auto">
                        <h2>Pregunta: <?php echo $_SESSION['numeroPregunta']; ?></h2>
                        <h2><img src="<?php echo Categoria::ICONOS[$this->categoria]; ?>" height="70"
                                 width="70"><?php echo $this->categoria; ?> </h2>
                        <h4><?php echo $this->pregunta; ?> </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <?php
                            for ($i = 0; $i < count($respuestas); $i++) {
                                ?>
                                <label for="<?php echo $i ?>" class="btn btn-outline-light">
                                    <input type="radio" id='<?php echo $i ?>' name="respuestas"
                                           value='<?php echo $i; ?>'><?php echo $respuestas[$i]; ?>
                                </label>
                                <?php
                            }
                            ?>           
                        </div>
                    </div>
                </div>
                    <?php
                    //aumenta  la variable de sesion para controlar el numero de rondas
                    $_SESSION['numeroPregunta'] = $_SESSION['numeroPregunta'] + 1;
                    //refresca la pagina cada 10 segundos mandando el indiceCorrecto y el input de enviar
                    //para poner un limite de tiempo y que responda automaticamente
                    $page = $_SERVER['PHP_SELF'] . "?indiceCorrecto=" . $indiceCorrecto . "&enviarTarjeta=enviarTarjeta";
                    $sec = "15";
                    header("Refresh: $sec; url=$page");
                    ?>
                <div class="row">
                    <div class="col-auto">
                        <input type="number" name="indiceCorrecto" hidden value=<?php echo $indiceCorrecto; ?>>
                            <div>
                                <input class="btn btn-primary" type="submit" id="enviarTarjeta" name="enviarTarjeta"
                                       value="Responder">
                            </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row justify-content-between">
            <div class="col-auto">
                <span class="h1" id="reloj"></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-stopwatch"
                     viewBox="0 0 16 16">
                    <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z" />
                    <path
                        d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z" />
                </svg>
            </div>
        </div>

        </div>
        <!-- Se usa un script solo para mostrar visualmente la cuenta atras -->
        <script src="cronometro.js"></script>
        <?php
    }

}
