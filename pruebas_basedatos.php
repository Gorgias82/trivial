<!--Jorge Vicente Ramiro-->
<!--DAW2-->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $con = new mysqli('localhost', 'jorge', 'Nohay2sin3', 'trivial');
        $consulta_preparada = $con->prepare("update usuarios set puntuacion = ? where login= ?");
        $puntuacion = 700;
        $nombre = 'juan';
        $consulta_preparada->bind_param("ds", $puntuacion,$nombre);
        $consulta_preparada->execute();
        echo "puntuacion: " . $puntuacion. "<br>";
        echo "nombre: " . $nombre . "<br>";
        echo "filas afectadas : " . $consulta_preparada->affected_rows . "<br>";
        $con->close();
        ?>
    </body>
</html>
