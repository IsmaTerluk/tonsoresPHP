<?php

    class JefeModel extends Model{
        
        public function getAllServicios(){
            $connect = $this->database->connect();
            $query = "SELECT * FROM servicios ";
            $sentencia = $connect->prepare($query);
            $sentencia->execute();
            $servicios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $servicios;
        }

        //Obtiene todos los roles
        public function getAllRoles(){
            $connect = $this->database->connect();
            $sql = "SELECT * FROM roles";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute();
            $servicios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $servicios;
        }

        //Obtien el id de acuerdo al rol
        public function getIdRol($rol){
            $connect = $this->database->connect();
            $query= "SELECT id FROM roles WHERE rol=:rol";
            $sentencia = $connect->prepare($query);
            $sentencia->execute(array(':rol'=>$rol));
            $id_rol = $sentencia->fetch(PDO::FETCH_COLUMN);
            return $id_rol;
        }

        // ----- Metodo que incrementa la cantidad de acuedo al rol ---------------------
        public function incrementarCantidadRol($rol_id){
            $connect = $this->database->connect();
            $sql = "UPDATE roles SET cantidad = cantidad + 1 WHERE id=:rol_id";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':rol_id'=> $rol_id));
        }

    }

?>