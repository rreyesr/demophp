<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/movies/models/pelicula.php');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
    //header('Access-Control-Allow-Headers: user, token');
    $headers = getallheaders();

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        if(isset($_GET['idPelicula']))
        {
            try
            {
                $p = new Pelicula($_GET['idPelicula']);            
                echo json_encode(array(
                    'status' => 200,
                    'peliculas' => json_decode($p->toJson())
                ));
            }
            catch(RecordNotFoundException $ex)
            {
                echo json_encode(array(
                    'estatus' => 404,
                    'message' => 'No se encontro pelicula'
                ));

            }            
        }
        else
        {
            echo Pelicula::allJson();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") 
    {
        
        //$_POST = json_decode(file_get_contents('php://input'),true);
        //echo json_encode($_POST);
        //$_POST = $_REQUEST;
        //var_dump($_POST);
        //var_dump($_REQUEST);
        //echo $_POST;
        //var_dump($_FILES['image']['name']);
        if(isset($_POST['titulo']) && 
            isset($_POST['anio']) && 
            isset($_POST['sinopsis']) && 
            isset($_POST['idClasificacion']) && 
            isset($_POST['idGenero']) //&&
            //isset($_FILES['image'])
            )
        {
            $error = false;

            try
            {
                $gn = new Genero($_POST['idGenero']);
                
                try
                {
                    $cl = new Clasificacion($_POST['idClasificacion']);
                }
                catch(RecordNotFoundException $ex)
                {
                    echo json_encode(array(
                        'status' => 404,
                        'No se encontro clasificacion'
                    ));
                    $error = true;
                }
            }
            catch (RecordNotFoundException $ex)
            {
                echo json_encode(array(
                    'status' => 404,
                    'message' => 'No se encontro genero'
                ));

                $error = true;
            }

            if(!$error)
            {
                $p = new Pelicula();
                $p->setTitulo($_POST['titulo']);
                $p->setAnio($_POST['anio']);
                $p->setSinopsis($_POST['sinopsis']);
                $p->setClasificacion($_POST['idClasificacion']);
                $p->setGenero($_POST['idGenero']);
                $p->setImage($_FILES['image']['name']);

                $ruta = $p->getRuta().$_FILES['image']['name'];
                $file = $_FILES['image']['tmp_name'];
                

                if(file_exists($ruta))
                {
                    echo json_encode(array(
                        'status' => 500,
                        'errorMessage' => 'El nombre del archivo ya existe!'
                    ));                    
                }
                else
                {
                    if($p->agregar())
                    {
                        move_uploaded_file($file, $ruta);
                        echo json_encode(array(
                            'status' => 200,
                            'message' => 'Pelicula agregada con exito'
                        ));
                    }
                    else
                    {
                        echo json_encode(array(
                            'status' => 500,
                            'message' => 'Se tuvo un error al intentar guardar'
                        ));
                    }
                }
            }          
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'PUT')
    {
        $_PUT = json_decode(file_get_contents('php://input'),true);

        if(isset($_PUT['idPelicula']) &&
            isset($_PUT['titulo']) &&
            isset($_PUT['anio']) &&
            isset($_PUT['sinopsis']) &&
            isset($_PUT['idClasificacion']) &&
            isset($_PUT['idGenero'])          
        )
        {
            $error = false;
            try
            {
                $gn = new Genero($_PUT['idGenero']);

                try
                {
                    $cl = new Clasificacion($_PUT['idClasificacion']);
                }
                catch(RecordNotFoundException $ex)
                {
                    echo json_encode(array(
                        'estatus' => 404,
                        'message' => 'No se encontro clasificacion',
                    ));
                    $error = true;
                }
            }
            catch(RecordNotFoundException $ex)
            {
                echo json_encode(array(
                    'estatus' => 404,
                    'message' => 'No se encontro genero'
                ));
                $error = true;
            }

            if(!$error)
            {
                try
                {
                    $p = new Pelicula($_PUT['idPelicula']);
                    $p->setTitulo($_PUT['titulo']);
                    $p->setAnio($_PUT['anio']);
                    $p->setSinopsis($_PUT['sinopsis']);
                    $p->setClasificacion($cl->getId());
                    $p->setGenero($gn->getId());
                    if($p->editar())
                    {
                        echo json_encode(array(
                            'estatus' => 200,
                            'message' => 'Pelicula editada exitosamente'
                        ));
                    }
                    else
                    {
                        echo json_encode(array(
                            'estatus' => 404,
                            'message' => 'Fallo al intentar modificar registros'
                        ));
                    }
                }
                catch(RecordNotFoundException $ex)
                {
                    echo json_encode(array(
                        'estatus' => 404,
                        'message' => 'Pelicula no encontrada'
                    ));
                }
                

            }
        }
        else
        {
            echo json_encode(array(
                'estatus' => 404,
                'message' => 'Faltan parametros'
            ));
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'DELETE') 
    {
        //$_DETELE = json_decode(file_get_contents('php://input'), true);
        if(isset($_GET['idPelicula']))
        {
            try
            {
                $p = new Pelicula($_GET['idPelicula']);
                if($p->eliminar())
                {
                    echo json_encode(array(
                        'estatus' => 200,
                        'message' => 'Se elimino registro exitosamente!'
                    ));
                }
                else
                {
                    echo json_encode(array(
                        'estatus' => 500,
                        'message' => 'Ocurrio un error cuando se intento eliminar'
                    ));
                }
            }
            catch(RecordNotFoundException $ex)
            {
                echo json_encode(array(
                    'estatus' => 404,
                    'message' => 'No se encontro pelicula'
                ));
            }

        }
        else
        {
            echo json_encode(array(
                'estatus' => 404,
                'message' => 'faltan parametros'
            ));
        }
    }
?>