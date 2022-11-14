<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/movies/models/clasificacion.php');
    //access control
	//allow access from outside the server
    header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	//allow headers
	header('Access-Control-Allow-Headers: user, token');
	//get headers
	$headers = getallheaders();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        echo Clasificacion::allJson();
    }

?>