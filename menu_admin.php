<!--Jorge Vicente Ramiro-->
<!--DAW2-->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Menu administrador</title>
    </head>
    <body>
        <?php
        session_start();
        if (!isset($_SESSION['jugador'])) {
            header("Location: index.php");
        }
        include_once 'Administrador.php';
        include_once 'Categoria.php';
        $admin = new Administrador();
        if (isset($_POST['enviarOpcion'])) {

            switch ($_POST['opciones']) {
                case 0:
                    ?>
                    <form  method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div>
                            <label for="nombre">Introduzca el nombre de usuario</label>
                            <input type="text" id="nombre">
                        </div>
                        <div>
                            <input type="submit" id="enviarNombre" name="enviarNombre" value="Enviar_usuario">Enviar usuario
                        </div>            
                    </form>
                    <?php
                    break;
                case 1:
                    $admin->ranking();
                    break;
                case 2:
                    ?>
                    <div>
                        <form  method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <p>¿En que categoria desea insertar la pregunta?</p>
                            <div>
                                <label for='0'>Sistemas informaticos</label>
                                <input type="radio" id='0' name="categoria" value='<?php echo Categoria::SI; ?>'>
                            </div>
                            <div>
                                <label for='1'>Base de datos</label>
                                <input type="radio" id='1' name="categoria" value='<?php echo Categoria::BD; ?>'>
                            </div>
                            <div>
                                <label for='2'>PHP</label>
                                <input type="radio" id='2' name="categoria" value='<?php echo Categoria::PHP; ?>'>
                            </div>
                            <div>
                                <label for='3'>Interfaces web</label>
                                <input type="radio" id='3' name="categoria" value='<?php echo Categoria::DIW; ?>'>
                            </div>
                            <div>
                                <label for='4'>Javascript</label>
                                <input type="radio" id='4' name="categoria" value='<?php echo Categoria::JS; ?>'>
                            </div>
                            <div>
                                <label for='5'>Java</label>
                                <input type="radio" id='5' name="categoria" value='<?php echo Categoria::JA; ?>'>
                            </div>
                            <div>
                                <label for="pregunta">Diga la pregunta</label>
                                <input type="text" name="pregunta" id="pregunta">
                            </div>
                            <div>
                                <label for="respuesta1">Diga la respuesta acertada</label>
                                <input type="text" name="respuesta1" id="respuesta1">
                            </div>
                            <div>
                                <label for="respuesta2">Diga la primera respuesta incorrecta</label>
                                <input type="text" name="respuesta2" id="respuesta2">
                            </div>
                            <div>
                                <label for="respuesta3">Diga la segunda respuesta incorrecta</label>
                                <input type="text" name="respuesta3" id="respuesta3">
                            </div>
                            <div>
                                <label for="respuesta4">Diga la tercera respuesta incorrecta</label>
                                <input type="text" name="respuesta4" id="respuesta4">
                            </div>
                            <div>
                                <input type="submit" id="enviarCategoria" name="enviarPregunta" value="enviar" >Enviar pregunta 
                            </div>
                        </form>
                    </div>
                <?php
                break;
                default:
                    break;
            }
        } else if (isset($_POST['enviarPregunta'])) {
            $admin->insertarPregunta($_POST['categoria'], $_POST['pregunta'], $_POST['respuesta1'], $_POST['respuesta2'], $_POST['respuesta3'], $_POST['respuesta4']);
        } else if (isset($_POST['enviarNombre'])) {
            $admin->borrarUsuario($_POST['enviarNombre']);
        } else {
            ?>
            <div>
                <form  method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <p>¿Que quiere hacer?</p>
                    <div>
                        <label for='borrar'>Eliminar a un usuario:</label>
                        <input type="radio" id='borrar' name="opciones" value="0">
                    </div>
                    <div>
                        <label for='ranking'>Ver el ranking de jugadores</label>
                        <input type="radio" id='ranking' name="opciones" value="1">
                    </div>
                    <div>
                        <label for='pregunta'>Insertar una pregunta</label>
                        <input type="radio" id='pregunta' name="opciones" value="2">
                    </div>
                    <div>
                        <input type="submit" id="enviarOpcion" name="enviarOpcion" value="enviarOpcion" >Enviar opcion seleccionada
                    </div>
                </form>
            </div>

        <?php
        }
        ?>


    </body>
</html>
