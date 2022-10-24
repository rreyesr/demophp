<?php
    require_once('mysqlconnection.php');
    require_once('clasificacion.php');
    require_once('genero.php');

    class Pelicula
    {
        private $idPelicula;
        private $titulo;
        private $anio;
        private $sinopsis;
        private $clasificacion;
        private $genero;

        public function setId($value){ $this->idPelicula = $value; }
        public function getId(){ return $this->idPelicula; }
        public function setTitulo($value){ $this->titulo = $value; }
        public function getTitulo(){ return $this->titulo; }
        public function setAnio($value){ $this->anio = $value; }
        public function getAnio(){ return $this->anio; }
        public function setSinopsis($value){ $this->sinopsis = $value; }
        public function getSinopsis(){ return $this->sinopsis; }
        public function setClasificacion($value){ $this->clasificacion = $value; }
        public function getClasificacion(){ return $this->clasificacion; }
        public function setGenero($value){ $this->genero = $value; }
        public function getGenero(){return $this->genero; }

        public function __construct()
        {
            if(func_num_args() == 0)
            {
                $this->idPelicula = 0;
                $this->titulo = '';
                $this->anio = '';
                $this->sinopsis = '';
                $this->clasificacion = new Clasificacion();
                $this->genero = new Genero();

            }
            
            if(func_num_args() == 1)
            {
                $opcion = 8;
                $list = array();
                $tituloP = func_get_arg(0);
                $conexion = MySqlConnection::getConnection();
                $command = $conexion->prepare('call peliculasGestionSP('. $opcion .',NULL,?,NULL,NULL,NULL,NULL)');
                echo $tituloP . '<br>';
                $command->bind_param('s', $tituloP);
                $command->execute();
                $command->bind_result($idPelicula, $titulo, $anio, $sinopsis, $idClasificacion, $cDescripcion, $idGenero, $gDescripcion);
                $found = $command->fetch();
                if($found)
                {
                    while($command->fetch())
                    {
                        $this->idPelicula = $idPelicula;
                        $this->titulo = $titulo; 
                        $this->anio = $anio;
                        $this->sinopsis = $sinopsis;
                        $this->clasificacion = new Clasificacion($idClasificacion, $cDescripcion);
                        $this->genero = New Genero($idGenero, $gDescripcion);
                    }
                    //echo $list;
                }
                else
                {
                    echo 'No se encontraron resultados';
                }
                mysqli_stmt_close($command);
                $conexion->close();                
            }

            if(func_num_args() == 6)
            {
                $parametros = func_get_args();            
                $this->idPelicula = $parametros[0];
                $this->titulo = $parametros[1];
                $this->anio = $parametros[2];
                $this->sinopsis = $parametros[3];
                $this->clasificacion = $parametros[4];
                $this->genero = $parametros[5];
            }
        }

        public function agregar()
        {
            $opcion = 5;
            $conexion = MySqlConnection::getConnection();
            $command = $conexion->prepare('call peliculasGestionSP('. $opcion .',NULL,?,?,?,?,?)');
            $command->bind_param('sssii',$this->titulo, $this->anio, $this->sinopsis, $this->clasificacion,$this->genero);
            $resultado = $command->execute();
            mysqli_stmt_close($command);
            $conexion->close();
            echo $resultado;
        }

        public function editar()
        {
            $opcion = 6;
            $conexion = MySqlConnection::getConnection();
            $command = $conexion->prepare('call peliculasGestionSP('. $opcion .',?,?,?,?,?,?)');
            $command->bind_param('isssii',$this->idPelicula, $this->titulo, $this->anio, $this->sinopsis, $this->clasificacion,$this->genero);
            $resultado = $command->execute();
            mysqli_stmt_close($command);
            $conexion->close();
            echo $resultado;

        }

        public function eliminar()
        {
            $opcion = 7;
            $conexion = MySqlConnection::getConnection();
            $command = $conexion->prepare('call peliculasGestionSP('. $opcion .','.$this->idPelicula.',NULL,NULL,NULL,NULL,NULL)');
            $resultado = $command->execute();
            mysqli_stmt_close($command);
            $conexion->close();
            echo $resultado;
        }

        public function getAll()
        {
            $list = array();
            $opcion=8;
            $conexion = MySqlConnection::getConnection();
            $command = $conexion->prepare('call peliculasGestionSP('. $opcion .',NULL,NULL,NULL,NULL,NULL,NULL)');
            $command->execute();
            $command->bind_result($idPelicula, $titulo, $anio, $sinopsis, $idClasificacion, $cDescripcion, $idGenero, $gDescripcion);
            while($command->fetch())
            {
                $clasificacion = new Clasificacion($idClasificacion, $cDescripcion);
                $genero = new Genero($idGenero, $gDescripcion);
                array_push($list, new Pelicula($idPelicula, $titulo, $anio, $sinopsis, $clasificacion, $genero));
            }            
            mysqli_stmt_close($command);
            $conexion->close();
            return $list;
        }

        public function toJson()
        {
            echo json_encode(
                array(
                    'id' => $this->idPelicula,
                    'titulo' => $this->titulo,
                    'anio' => $this->anio,
                    'sinopsis' => $this->sinopsis,
                    'clasificacion' => json_decode($this->clasificacion->toJson()),
                    'genero' => json_decode($this->genero->toJson())
                )
            );
        }

        public function allJson()
        {
            $list = array();
            foreach(self::getAll() as $item)
            {
                array_push($list, json_decode($item->toJson()));
            }
            echo json_encode(
                array(
                    'peliculas' => $list
                ));
        }

    }
?>