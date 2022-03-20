<!--Jorge Vicente Ramiro-->
<!--DAW2-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <meta name="viewport" content="width_device-width,initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php
        include_once 'filtrado.php';
        include_once 'Usuario.php';
        include_once 'Jugador.php';
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //se filtran los datos poniendolos en dos variables
            $nombre = filtrado($_POST['nombre']);
            $password = filtrado($_POST['password']);

            if (empty($_POST['nombre'])) {

                $errores[] = "Tiene que introducir un nombre";
            }
            if (empty($_POST['password'])) {

                $errores[] = "Debe introducir una contraseña";
            }
            if (empty($_POST['password2']) || ($_POST['password'] != $_POST['password2'])) {

                $errores[] = "Debe repetir la misma contraseña";
            }

            if (empty($errores)) {
                if (Usuario::existeUsuario($nombre)) {
                    $errores[] = "Ese nombre ya esta ocupado";
                }
            }
        }//proceso, se comprueba que este enviado y que no haya errores
        if (isset($_POST['enviar']) && empty($errores)) {
            session_start();
            $jugador = new Jugador($nombre, $password);
            $_SESSION['jugador'] = $jugador;
            header("Location: juego.php");
        } else {
            foreach ($errores as $error) {
                ?>
    <p><?php echo $error; ?></p>
    <?php
            }
            ?>



    <div class="container">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="<?php echo empty($errores) ? '' : $nombre; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12  col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12  col-md-6 col-lg-4">
                    <div class="mb-3">
                        <label for="password2" class="form-label">Repita la contraseña:</label>
                        <input type="password" id="password2" name="password2" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12  col-md-6 col-lg-4">
                    <button type="submit" id="enviar" name="enviar" value="enviar"
                        class="btn btn-primary">Enviar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12  col-md-6 col-lg-4">
                    <a href="index.php" class="breadcrumb-item"> Acceda como usuario registrado
                    </a>
                </div>
            </div>
        </form>
    </div>



    <?php
        }
        ?>
</body>

</html>