<?php 

    class ABMServiciosModel extends Model{

        public function getAllServicios(){
            $connect = $this->database->connect();
            $query = "SELECT * FROM servicios";
            $sentencia = $connect->prepare($query);
            $sentencia->execute();
            $servicios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $servicios;
        }

        public function updateServicio($id, $servicio, $precio, $puntos, $description, $image){
            $connect = $this->database->connect();
            if(empty($image)){
            //No hay que actualizarla
                $query = "UPDATE `servicios` SET `servicio`=:servicio , `precio`=:precio, `puntos`=:puntos,  `descripcion`=:descripcion WHERE id=:id";
                $array = array(':id'=>$id, ':servicio'=>$servicio, ':precio'=>$precio, ':puntos'=>$puntos, ':descripcion'=>$description);
            }
            else{
            //Hay que actualizarla
                $query = "UPDATE `servicios` SET `servicio`=:servicio , `precio`=:precio, `puntos`=:puntos,  `descripcion`=:descripcion, `imagen`=:imagen WHERE id=:id";
                $array = array(':id'=>$id, ':servicio'=>$servicio, ':precio'=>$precio, ':puntos'=>$puntos, ':descripcion'=>$description, ':imagen'=>$image);    
            }
            $sentencia = $connect->prepare($query);
            $result = $sentencia->execute($array);
            return $result;
        }

        public function deleteServicio($id){
            $connect = $this->database->connect();
            $query = "DELETE FROM servicios WHERE id=:id";
            $sentencia = $connect->prepare($query);
            //Al eliminar un servicio tengo que reindexar los id
            if($sentencia->execute(array(':id'=>$id))){
                //Traigo el mayor id -> El ultimo indice 
                $query = "SELECT MAX(id) FROM servicios";
                $sentencia = $connect->prepare($query);
                $sentencia->execute();
                $lastId = $sentencia->fetch(PDO::FETCH_COLUMN);
                for($i=$id; $i<$lastId; $i++ ){
                   $query = "UPDATE `servicios` SET `id`=:new_id WHERE id=:id";
                   $sentencia = $connect->prepare($query);
                   $sentencia->execute(array( ':new_id'=>$i, ':id'=>$i+1));
                }
                 return true;
            }else{
                return false;
            }
        }

        public function insertServicio($servicio, $precio, $puntos, $description, $imagen){
            $connect = $this->database->connect();
            //Debemos previamente obtener el ultimo id para que los numeros sean secuenciales
            // y asi no tener problemas a la hora de mostar los servicios en los barberos
            $query = "SELECT MAX(id) FROM servicios";
            $sentencia = $connect->prepare($query);
            $sentencia->execute();
            $lastId = $sentencia->fetch(PDO::FETCH_COLUMN);
            $query = "INSERT INTO servicios (`id`, `servicio`, `precio`, `puntos`, `descripcion`, `imagen`) VALUES (:id, :servicio, :precio, :puntos, :descripcion, :imagen)";
            $sentencia = $connect->prepare($query);
            $result = $sentencia->execute(array(':id'=>$lastId+1,':servicio'=>$servicio, ':precio'=>$precio, ':puntos'=>$puntos, ":descripcion"=>$description, ':imagen'=>$imagen));
            return $result;
        }

    }



?>