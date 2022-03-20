<?php

/**
 * Description 
 *
 * @author Jorge Vicente Ramiro
 * DAW2
 */
abstract class Categoria {
    const SI = 'Sistemas informaticos';
    const BD = 'Base de datos';
    const PHP = 'PHP';
    const DIW = 'Interfaces web';
    const JS = 'Javascript';
    const JA = 'Java';
    const ICONOS = [Categoria::SI => 'imagenes/linux.png', Categoria::BD => 'imagenes/mysql.png',
        Categoria::PHP => 'imagenes/php.png', Categoria::DIW => 'imagenes/css.png', Categoria::JS => 
            'imagenes/js-file.png', Categoria::JA => 'imagenes/java.png'];
    const COLORES = [Categoria::SI => '#DC143C', Categoria::BD => '#32CD32',
        Categoria::PHP => '#7B68EE', Categoria::DIW => '#F4A460', Categoria::JS => 
            '#DAA520', Categoria::JA => '#008080'];
}
