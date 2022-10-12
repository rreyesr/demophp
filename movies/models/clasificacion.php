<?php
    require_once('mysqlconnection.php');

    class Clasificacion
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

        public function getAllClasificacion()
        {
            $opcion = 1;
            $idPelicula = 0;
            $titulo = 0;
            $anio = 0;
            $sinopsis = 0;
            $idClasificacion = 0;
            $idGenero = 0;
            $conexion = MySqlConnection::getConnection();            
            $query = 'call peliculasGestionSP (' . $opcion . ',' . $idPelicula . ',' . $titulo . ',' . $anio . ',' . $sinopsis . ',' . $idClasificacion . ',' . $idGenero . ')';
            //$routineSql = "CALL getSingleItemDetail(" . $itemId . ")";
            $command = $conexion->prepare($query);
            //$command->bind_param('issssss', 1,'1','1','1','1','1','1');
            $command->execute();
            
            $result = $command->get_result(); // get the mysqli result

            $items = $result->fetch_assoc(); // fetch data 

            echo "<pre>";
            print_r($items);
            //$conexion->query($query);
            /*if ($conexion->query($query) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $query . "<br>" . $conexion->error;
            } */
            
            $conexion->close();
        }
    }
?>