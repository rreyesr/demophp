<?php
    require_once('mysqlconnection.php');
    require_once('clasificacion.php');
    require_once('genero.php');
    require_once('exeption/recordnotfoundexception.php');

    class Pelicula
    {
        private $idPelicula;
        private $titulo;
        private $anio;
        private $sinopsis;
        private $clasificacion;
        private $genero;
        private $image;

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
        public function getGenero(){ return $this->genero; }
        public function setImage($value){ $this->image = $value; }
        public function getImage(){ return $this->image; }
        public function getRuta(){ return $_SERVER['DOCUMENT_ROOT'].'/movies/client/images/'; }

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
                $this->image = '';

            }
            
            if(func_num_args() == 1)
            {
                $opcion = 8;
                $idPeliculaP = func_get_arg(0);
                $conexion = MySqlConnection::getConnection();
                $command = $conexion->prepare('call peliculasGestionSP('. $opcion .',?,NULL,NULL,NULL,NULL,NULL,NULL)');
                $command->bind_param('i', $idPeliculaP);
                $command->execute();
                $command->bind_result($idPelicula, $titulo, $anio, $sinopsis, $idClasificacion, $cDescripcion, $idGenero, $gDescripcion, $image);
                $found = $command->fetch();
                mysqli_stmt_close($command);
                $conexion->close();
                if($found)
                {
                    $this->idPelicula = $idPelicula;
                    $this->titulo = $titulo; 
                    $this->anio = $anio;
                    $this->sinopsis = $sinopsis;
                    $this->clasificacion = new Clasificacion($idClasificacion, $cDescripcion);
                    $this->genero = New Genero($idGenero, $gDescripcion);
                    $this->image = $image;
                }
                else
                {
                    throw new RecordNotFoundException();
                   // echo 'No se encontraron resultados';
                }
            }

            if(func_num_args() == 7)
            {
                $parametros = func_get_args();            
                $this->idPelicula = $parametros[0];
                $this->titulo = $parametros[1];
                $this->anio = $parametros[2];
                $this->sinopsis = $parametros[3];
                $this->clasificacion = $parametros[4];
                $this->genero = $parametros[5];
                $this->image = $parametros[6];
            }
        }

        public function agregar()
        {
            $opcion = 5;
            $conexion = MySqlConnection::getConnection();
            $command = $conexion->prepare('call peliculasGestionSP('. $opcion .',NULL,?,?,?,?,?,?)');
            $command->bind_param('sssiis',$this->titulo, $this->anio, $this->sinopsis, $this->clasificacion,$this->genero, $this->image);
            $resultado = $command->execute();
            mysqli_stmt_close($command);
            $conexion->close();
            return $resultado;
        }

        public function editar()
        {
            $opcion = 6;
            $conexion = MySqlConnection::getConnection();
            $command = $conexion->prepare('call peliculasGestionSP('. $opcion .',?,?,?,?,?,?,?)');
            $command->bind_param('isssiis',$this->idPelicula, $this->titulo, $this->anio, $this->sinopsis, $this->clasificacion,$this->genero, $this->image);
            $resultado = $command->execute();
            mysqli_stmt_close($command);
            $conexion->close();
            return $resultado;
        }

        public function eliminar()
        {
            $opcion = 7;
            $conexion = MySqlConnection::getConnection();
            $command = $conexion->prepare('call peliculasGestionSP('. $opcion .','.$this->idPelicula.',NULL,NULL,NULL,NULL,NULL,NULL)');
            $resultado = $command->execute();
            mysqli_stmt_close($command);
            $conexion->close();
            return $resultado;
        }

        public static function getAll()
        {
            $list = array();
            $opcion=4;
            $conexion = MySqlConnection::getConnection();
            $command = $conexion->prepare('call peliculasGestionSP('. $opcion .',NULL,NULL,NULL,NULL,NULL,NULL,NULL)');
            $command->execute();
            $command->bind_result($idPelicula, $titulo, $anio, $sinopsis, $idClasificacion, $cDescripcion, $idGenero, $gDescripcion, $image);
            while($command->fetch())
            {
                $clasificacion = new Clasificacion($idClasificacion, $cDescripcion);
                $genero = new Genero($idGenero, $gDescripcion);
                array_push($list, new Pelicula($idPelicula, $titulo, $anio, $sinopsis, $clasificacion, $genero, $image));
            }            
            mysqli_stmt_close($command);
            $conexion->close();
            return $list;
        }

        public function toJson()
        {
            return json_encode(array(
                    'idPelicula' => $this->idPelicula,
                    'titulo' => $this->titulo,
                    'anio' => $this->anio,
                    'sinopsis' => $this->sinopsis,
                    'clasificacion' => json_decode($this->clasificacion->toJson()),
                    'genero' => json_decode($this->genero->toJson()),
                    'image' => $this->image
                ));
        }

        public static function allJson()
        {
            $list = array();
            foreach(self::getAll() as $item)
            {
                array_push($list, json_decode($item->toJson()));
            }
            return json_encode(
                array(
                    'peliculas' => $list
                ));
        }

    }
?>