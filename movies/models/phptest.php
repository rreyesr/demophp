<?php
    require_once('clasificacion.php');
    require_once('genero.php');
    require_once('mysqlconnection.php');
    require_once('pelicula.php');

    //$conn = new MySqlConnection;
    //$conn->getConnection();

    /*$var = new Clasificacion();
    $var->allJson();
    $var2 = new Genero();
    $var2->allJson();

    $peli = new Pelicula();
    $peli->setTitulo('test 1');
    $peli->setAnio('2022');
    $peli->setSinopsis('Esto es una prueba');
    $peli->setClasificacion(1);
    $peli->setGenero(1);
    $peli->agregar();

    $peli = new Pelicula();
    $peli->setId(3);
    $peli->setTitulo('Prueba de update');
    $peli->setAnio('2022');
    $peli->setSinopsis('Esto es una prueba');
    $peli->setClasificacion(1);
    $peli->setGenero(1);
    $peli->editar();

    $peli = new Pelicula();
    $peli->setId(4);
    $peli->eliminar();

    $peli = new Pelicula();
    $peli->allJson();*/

    /*$peli = new Pelicula();
    $peli->setTitulo('Prueba 2');
    $peli->setAnio('2022');
    $peli->setSinopsis('Esto es una prueba');
    $peli->setClasificacion(1);
    $peli->setGenero(1);
    $peli->agregar();*/

    $peli = new Pelicula('Prueba');

    echo json_encode(array(
        'status' => 0,//,
        'Peliculas' => $peli->toJson()
    ));

?>