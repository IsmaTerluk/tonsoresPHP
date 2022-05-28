<?php

    class HomeModel extends Model {

        //Par mostrar los horarios de atencion
        public function getAllHorariosAtencion(){
            $connect = $this->database->connect();
            $sql = "SELECT * FROM horarios_atencion";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute();
            $horarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $horarios;
        }

        //Obtiene las promociones
        public function getAllPromociones(){
            $connect = $this->database->connect();
            $sql = "SELECT * FROM descuentos";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute();
            $servicios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $servicios;
        }
        
    }


?>