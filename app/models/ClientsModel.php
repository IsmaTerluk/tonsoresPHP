<?php 

    class ClientsModel extends Model {

        //Todos los empleados-->paginados
        public function getAllEmpleados($pos, $hasta){
            $connect = $this->database->connect();
            //Consulta paginada
            $sql = "SELECT id, name, lastname, email, cellphone, imagen_perfil, servicios FROM empleado LIMIT :pos, :hasta ";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':pos'=>$pos, ':hasta'=>$hasta));
            $empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $empleados;
        }

        //Obtiene unicamente un empleado --> Es para mostrar los servicios 
        public function getEmpleado($id_empleado){
            $connect = $this->database->connect();
            $sql = "SELECT id, name, lastname,cellphone,servicios FROM empleado  WHERE id=:id_empleado";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':id_empleado'=>$id_empleado));
            $empleado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $empleado;
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

        //Obtiene las promociones
        public function getAllPromociones(){
            $connect = $this->database->connect();
            $sql = "SELECT * FROM descuentos";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute();
            $servicios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $servicios;
        }

        //Retorna los horarios o de la tarde o de la mañana
        public function getAllTurnos($name_tabla){
            $connect = $this->database->connect();
            $sql = "SELECT * FROM $name_tabla";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute();
            $turnos = $sentencia->fetchALL(PDO::FETCH_ASSOC);
            return $turnos;
        }

        //Retorna el descuento aplicado al turno solicitado
        public function getDescuento($cant_servicios){
            $connect= $this->database->connect();
            $query = "SELECT descuento FROM descuentos WHERE cant_servicios = :cant_servicios";
            $sentencia = $connect->prepare($query);
            $sentencia->execute(array(':cant_servicios'=>$cant_servicios));
            $descuento = $sentencia->fetch(PDO:: FETCH_COLUMN);
            if(empty($descuento))
                return 0;
            else    
                return $descuento;
        }

        //Para mostrar los que tiene ocupado
        public function getTurnosOcupados($fecha, $id_empleado, $id_turno){
            $connect = $this->database->connect();
            $sql = "SELECT id_horario FROM turnos_solicitados WHERE id_empleado=:id_empleado AND id_turno=:id_turno AND fecha=:fecha AND (id_estado=1 OR id_estado=2)";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':id_empleado'=>$id_empleado, ':id_turno'=>$id_turno, 'fecha'=>$fecha));
            return $sentencia->fetchAll(PDO::FETCH_COLUMN);
        }

        //Obtiene todos los turnos solicitados para listarlos
        public function getAllTurnosSolicitados($id_cliente){
            $connect = $this->database->connect();
            $query = "SELECT empleado.name, empleado.lastname, turnos_solicitados.* FROM empleado INNER JOIN turnos_solicitados ON empleado.id=turnos_solicitados.id_empleado WHERE (turnos_solicitados.id_cliente=:id_cliente AND (turnos_solicitados.id_estado=2 OR turnos_solicitados.id_estado=4))";
            $sentencia = $connect->prepare($query);
            $sentencia->execute(array(':id_cliente'=>$id_cliente));
            $listado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $listado;
        }

        //Canjea los puntos solicitados
        public function canjearPuntos($puntos, $saldo, $id_cliente){
            $connect = $this->database->connect();
            $query = "UPDATE cliente SET puntos=puntos-$puntos, saldoafavor=saldoafavor+$saldo WHERE id=:id_cliente";
            $sentencia = $connect->prepare($query);
            if($sentencia->execute(array(':id_cliente'=>$id_cliente))){
                //Nesecito traeme los datos, para actualizar la sesión
                $query="SELECT puntos,saldoafavor FROM cliente WHERE id=:id_cliente";
                $sentencia = $connect->prepare($query);
                $sentencia->execute(array(':id_cliente'=>$id_cliente));
                $puntos_saldo = $sentencia->fetch(PDO::FETCH_ASSOC);
                return $puntos_saldo;
            }else{
                return array();
            }
            
        }
        
        //Actualiza el saldo a favor del cliente 
        public function updateSaldoFavor($id_cliente, $saldo){
            $connect = $this->database->connect();
            $query = "UPDATE cliente SET saldoafavor=$saldo WHERE id=:id_cliente";
            $sentencia = $connect->prepare($query);
            $result = $sentencia->execute(array(':id_cliente'=>$id_cliente));
            return $result;
        }

    }