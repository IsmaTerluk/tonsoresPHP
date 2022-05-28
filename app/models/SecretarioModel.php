<?php

    class SecretarioModel extends Model{

        public function getAllBarberos($sql, $all=false){
            $connect = $this->database->connect();
            //Obtengo el nombre de los barberos primero
            $sentencia = $connect->prepare($sql);
            $sentencia->execute();
            if($all==true)
                $datos_barberos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            else
               $datos_barberos = $sentencia->fetch(PDO::FETCH_ASSOC);            
            return $datos_barberos;
        }

        public function getAllHorarios($name_table){
            $connect = $this->database->connect();
            $sql = "SELECT * FROM $name_table";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute();
            $datos_horarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $datos_horarios;
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

        public function buscarTurnosPorBarbero($id_turno, $fecha_actual, $id_barbero){
            $connect = $this->database->connect();
            $sql = "SELECT turnos_solicitados.id, turnos_solicitados.id_horario, turnos_solicitados.servicios, turnos_solicitados.total_pagar, cliente.name, cliente.lastname FROM turnos_solicitados INNER JOIN cliente ON turnos_solicitados.id_cliente=cliente.id WHERE (turnos_solicitados.id_empleado=:id_barbero AND turnos_solicitados.id_turno=:id_turno AND turnos_solicitados.fecha=:fecha AND turnos_solicitados.id_estado =:id_estado)";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':id_barbero'=>$id_barbero, ':id_turno'=>$id_turno, ':fecha'=>$fecha_actual, ':id_estado'=>1));
            $datos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        }

        public function buscarTurnoPorCellphoneCliente($cellphone, $fecha_actual, $id_turno){
            $connect = $this->database->connect();
            $sql = "SELECT cliente.name, cliente.lastname,turnos_solicitados.id, turnos_solicitados.id_empleado, turnos_solicitados.id_horario, turnos_solicitados.servicios, turnos_solicitados.total_pagar, turnos_solicitados.puntos FROM cliente INNER JOIN turnos_solicitados ON cliente.id = turnos_solicitados.id_cliente WHERE (cliente.cellphone=:cellphone AND turnos_solicitados.id_turno=:id_turno AND turnos_solicitados.fecha=:fecha AND turnos_solicitados.id_estado =:id_estado)";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':cellphone'=>$cellphone, ':id_turno'=>$id_turno,':fecha'=>$fecha_actual, ':id_estado'=>1));
            $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $datos;
        }
        
        public function confirmarTurno($id_turno){
            $connect = $this->database->connect();
            //Trae los datos
            $sql = "SELECT id_cliente, id_empleado,servicios, puntos FROM turnos_solicitados WHERE id=:id_turno ";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':id_turno'=>$id_turno));
            $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
            //Actualiza el estado del turno
            $sql = "UPDATE turnos_solicitados SET id_estado=2  WHERE id=:id_turno ";
            $sentencia = $connect->prepare($sql);
            $result = $sentencia->execute(array(':id_turno'=>$id_turno));
            if($result){
                return $datos;
            }
        }

        public function acumularPuntosCliente($id_cliente, $puntos){
            $connect = $this->database->connect();
            $sql = "UPDATE cliente SET puntos = puntos + $puntos , turnos_solicitados = turnos_solicitados +1 WHERE id=:id_cliente";
            $sentencia = $connect->prepare($sql);
            $result = $sentencia->execute(array(':id_cliente'=>$id_cliente));
            return $result;
        }

        public function incrementarCantidadBarbero($id_empleado){
            $connect = $this->database->connect();
            $sql = "UPDATE empleado SET turnos_atendidos=turnos_atendidos +1 WHERE id=:id_empleado";
            $sentencia = $connect->prepare($sql);
            $result = $sentencia->execute(array(':id_empleado'=>$id_empleado));
            return $result;
        }

        public function incrementarCantidadServicios($servicios){
            $connect = $this->database->connect();
            //Descompones los servicios
            $servicios = explode(',', $servicios);
            foreach($servicios as $id_servicio){
                $sql = "UPDATE servicios SET cantidad=cantidad +1 WHERE id=:id_servicio";
                $sentencia = $connect->prepare($sql);
                $result = $sentencia->execute(array(':id_servicio'=>$id_servicio));
            }
            return $result;
        }

        public function cancelarTurno($id_turno, $id_estado){
            $connect = $this->database->connect();
            $sql = "UPDATE turnos_solicitados SET id_estado=$id_estado WHERE id=:id_turno";
            $sentencia = $connect->prepare($sql);
            $result = $sentencia->execute(array(':id_turno'=>$id_turno));
            return $result;
        }
    }


?>