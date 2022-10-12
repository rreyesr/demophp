<?php
    require_once('clasificacion.php');
    require_once('mysqlconnection.php');

    //$conn = new MySqlConnection;
    //$conn->getConnection();

    $var = new Clasificacion();
    $var->getAllClasificacion();
?>