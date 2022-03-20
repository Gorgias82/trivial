
<?php

/**
 * Jorge Vicente Ramiro
 * DAW2
 */

function filtrado($texto) {
    $texto = trim($texto);
    $texto = htmlspecialchars($texto);
    $texto = stripcslashes($texto);
    return $texto;
}

?>
