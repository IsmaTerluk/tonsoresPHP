<?php 

    class PDFModel extends Model {

        //Retorna los datos de un solo turno
        public function getTurnoSolicitado($id_turno){
            $connect = $this->database->connect();
            $query = "SELECT empleado.name, empleado.lastname, turnos_solicitados.* FROM empleado INNER JOIN turnos_solicitados ON empleado.id=turnos_solicitados.id_empleado WHERE turnos_solicitados.id =:id_turno";
            $sentencia = $connect->prepare($query);
            $sentencia->execute(array(':id_turno'=>$id_turno));
            $turno = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $turno;
        }

        //Retorna el los horarios de mañana o de tarde
        public function getAllHorarios($name_tabla){
            $connect = $this->database->connect();
            $sql = "SELECT * FROM $name_tabla";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute();
            $turnos = $sentencia->fetchALL(PDO::FETCH_ASSOC);
            return $turnos;
        }

        //Obtiene todos los servicios
        public function getAllServicios(){
            $connect = $this->database->connect();
            $sql = "SELECT * FROM servicios";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute();
            $servicios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $servicios;
        }

    }

?>