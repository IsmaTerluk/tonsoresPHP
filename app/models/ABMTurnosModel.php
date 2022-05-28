<?php

use LDAP\Result;

    class ABMTurnosModel extends Model{

        public function createTurno($id_cliente, $id_empleado, $id_turno, $id_horario, $fecha, $id_estado, $servicios, $precio,$descuento,$saldoafavor, $total_pagar, $puntos){
            $connect = $this->database->connect();
            //Primero hay que corroborar que no tenga turno pendiente
            $sql = "SELECT id_cliente FROM turnos_solicitados WHERE (id_cliente =:id_cliente  AND id_estado = :id_estado)";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':id_cliente'=>$id_cliente,':id_estado'=>1));
            $turno = $sentencia->fetch(PDO::FETCH_COLUMN);
            //Si esta vacio se registra el turno
            if(empty($turno)){
                $sql = "INSERT INTO turnos_solicitados (`id_cliente`, `id_empleado`, `id_turno`, `id_horario`, `fecha`, `id_estado`,`servicios`, `precio`, `descuento_aplicado`,`saldoafavor`,`total_pagar`,`puntos`) VALUES (:id_cliente, :id_empleado, :id_turno, :id_horario, :fecha, :id_estado, :servicios, :precio, :descuento, :saldo, :total_pagar, :puntos)";
                $sentencia = $connect->prepare($sql);
                $resultado = $sentencia->execute(array(':id_cliente' => $id_cliente, ':id_empleado'=>$id_empleado,':id_turno'=>$id_turno, ':id_horario'=>$id_horario, ':fecha'=>$fecha, ':id_estado'=>$id_estado, ':servicios'=>$servicios, ':precio'=>$precio, ':descuento'=>$descuento, ':saldo'=>$saldoafavor, 'total_pagar'=>$total_pagar, ':puntos'=>$puntos));
                return $resultado;
            }else{
                return false;
            }
        }

        public function deleteTurno($id_turno, $id_estado, $id_cliente){
            $connect = $this->database->connect();
            $sql = "UPDATE turnos_solicitados SET id_estado=$id_estado WHERE id=:id_turno";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':id_turno'=>$id_turno));
            //Al ser cancelado por el cliente recupera el saldo a favor, caso contrario lo pierde
            if($id_estado == 3){
                //trae el saldo a favor
                $query = "SELECT saldoafavor FROM turnos_solicitados WHERE id=:id_turno";
                $sentencia = $connect->prepare($query);
                $sentencia->execute(array(':id_turno'=>$id_turno));
                $saldoafavor = $sentencia->fetch(PDO::FETCH_COLUMN);
                //Recupera su saldo a favor
                $query = "UPDATE cliente SET saldoafavor=saldoafavor+$saldoafavor WHERE id=:id_cliente";
                $sentencia = $connect->prepare($query);
                $sentencia->execute(array(':id_cliente'=>$id_cliente));
                return $saldoafavor;
            }
        }

    }