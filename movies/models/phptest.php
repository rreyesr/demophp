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
    $peli->agregar();
    
    $peli = new Pelicula();
    $peli->allJson();
    
   

    

    $peli = new Pelicula();
    $peli->setTitulo('Thor');
    $peli->setAnio('2022');
    $peli->setSinopsis('Es un hombre del espacio');
    $peli->setClasificacion(3);
    $peli->setGenero(4);
    $peli->agregar(); 

    //$g = new Genero(1);

    $gn = new Genero(2);
    $cl = new Clasificacion(3);
    $p = new Pelicula(6);
    $p->setTitulo('TestingG');
    $p->setAnio('2000');
    $p->setSinopsis('lo que sea');
    $p->setClasificacion($cl);
    $p->setGenero($gn);
    $p->editar();
    */

    $p = new Pelicula(6);

?>