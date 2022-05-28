<?php 

    class LoginModel extends Model {

// ---------   Metodo que evalua usuario y contraseña y devuelve los datos del usuario------------
        public function checkUser($user, $pass){
            //Conexion con base de datos
            $connect = $this->database->connect();
            //Prepara la sentencia
            $sql = "SELECT usuarios.id_usuario, usuarios.user, usuarios.password , roles.rol FROM usuarios INNER JOIN roles ON usuarios.rol_id = roles.id WHERE user=:user AND password=:password";
            $sentencia = $connect->prepare($sql);
            //Ejecuta la sentencia
            $sentencia->execute(array(':user'=> $user, ':password'=>$pass));

            //Count cuenta el numero de filas afectadas
            if($sentencia->rowCount()!=0){
                //Datos correctos
                $user = $sentencia->fetch(PDO::FETCH_ASSOC);
                //Mapeamos algunos datos
                $datos_user = $this->getAllDatos($connect,$user['id_usuario'], $user['rol']);
                //Combinamos arreglos asociativos 
                return array_merge($user,$datos_user);
            }else
                //Datos invalidos
                return array();
        }

//--------------- Retorna los datos del usuario ----------------------------------------
        public function getAllDatos($connect, $id, $name_tabla){
            //Connect es enviado por parametro
            $sql = "SELECT * FROM $name_tabla WHERE id=:id";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':id'=>$id ));
            $user = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $user;
        }


// ------------ Chequea el email para cambiar la contraseña -----------------------------
        public function checkEmail($email, $name_tabla){
            $connect = $this->database->connect();
            $sql = "SELECT id,name,lastname FROM $name_tabla WHERE email=:email";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':email'=> $email));
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        }

// --------- Cambia la contraseña --------------------------------------------------------
        public function recoverPass($password, $id){
            $connect = $this->database->connect();
            $sql ='UPDATE `usuarios` SET `password`=:password  WHERE id_usuario=:id';
            $sentencia = $connect->prepare($sql);
            $resultado = $sentencia->execute(array(':id' => $id, ':password' => $password));
            return $resultado; 
        }


//SECION PARA CONTROLAR LOS TURNOS DEL CLIENTE
//--------------Verifica si un cliente tiene un turno solicitado -------------------------
        public function getTurnoPendiente($id_cliente){
            $connect = $this->database->connect();
            //Inner join
            $sql = "SELECT empleado.name, empleado.lastname, turnos_solicitados.* FROM empleado INNER JOIN turnos_solicitados ON empleado.id = turnos_solicitados.id_empleado WHERE (id_cliente =:id_cliente  AND id_estado = :id_estado)";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':id_cliente'=>$id_cliente,':id_estado'=>1));
            $turnopendiente = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $turnopendiente;
            
        }

        public function getAllServicios(){
            $connect = $this->database->connect();
            $query = "SELECT * FROM servicios";
            $sentencia = $connect->prepare($query);
            $sentencia->execute();
            $servicios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $servicios;
        }

       //Retorna los horarios o de la tarde o de la mañana
       public function getAllTurnos($id_turno){
        $connect = $this->database->connect();
        if($id_turno == 1)
            $name_tabla = "turnos_mañana";
        else
            $name_tabla = "turnos_tarde";
        $sql = "SELECT * FROM $name_tabla";
        $sentencia = $connect->prepare($sql);
        $sentencia->execute();
        $turnos = $sentencia->fetchALL(PDO::FETCH_ASSOC);
        return $turnos;
    }


    }