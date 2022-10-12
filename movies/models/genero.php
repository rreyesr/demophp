<?php
    require_once('mysqlconnection.php');

    class Genero
    {
        private $id;
        private $descripcion;

        public function setId($value) { $this->id = $value;}
        public function getId() { return $this->id;}
        public function setDescripcion($value) { $this->id = $value;}
        public function getDescripcion() { return $this->descripcion;}

        public function __construct()
        {
            if(func_num_args() == 0)
            {
                $this->id = 0;
                $this->descripcion = '';
            }

            if(func_num_args()==2)
            {
                $arguments = func_get_args();
                $this->id = $arguments[0];
                $this->descripcion = $arguments[1];
            }
        }

        public static function getAllClasificacion()
        {
            $list = array();
            $opcion = 2;
            $idPelicula = 'NULL';
            $titulo = 'NULL';
            $anio = 'NULL';
            $sinopsis = 'NULL';
            $idClasificacion = 'NULL';
            $idGenero = 'NULL';      
            $conexion = MySqlConnection::getConnection();            
            $command = $conexion->prepare('call peliculasGestionSP (' . $opcion . ',' . $idPelicula . ',' . $titulo . ',' . $anio . ',' . $sinopsis . ',' . $idClasificacion . ',' . $idGenero . ')');
            $command->execute();
            $command->bind_result($id,$descripcion);
            while ($command->fetch()) {
				array_push($list, new Genero($id, $descripcion));
			}
            mysqli_stmt_close($command);
            $conexion->close();
            return $list;            
        }

        public function toJson()
        {
            return json_encode(array(
                'id' => $this->id,
                'descripcion' => $this->descripcion
            ));
        }

        public static function allJson()
        {
            $list = array();
            foreach(self::getAllClasificacion() as $item)
            {
                array_push($list, json_decode($item->toJson()));
            }
            echo json_encode(array(
                'clasificaciones' => $list
            ));
        }
    }
?>