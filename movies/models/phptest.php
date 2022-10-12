<?php
    require_once('clasificacion.php');
    require_once('genero.php');
    require_once('mysqlconnection.php');

    //$conn = new MySqlConnection;
    //$conn->getConnection();

    $var = new Clasificacion();
    $var->allJson();
    $var2 = new Genero();
    $var2->allJson();
?>