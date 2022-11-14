<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/movies/models/genero.php');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: user, token');
    $headers = getallheaders();

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        echo Genero::allJson();
    }
?>