<?php 

    class ABMEmpleadosModel extends Model {
        
        public function getAllEmpleados($name_tabla, $query=null){
            $connect = $this->database->connect();
            if($query==null){
                $query = "SELECT * FROM $name_tabla";
            }
            $sentencia = $connect->prepare($query);
            $sentencia->execute();
            $barberos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $barberos;
        }

        public function getEmpleado($id, $name_tabla){
            $connect = $this->database->connect();
            $query = "SELECT * FROM $name_tabla WHERE id=:id";
            $sentencia = $connect->prepare($query);
            $sentencia->execute(array(':id'=>$id));
            $barbero = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $barbero;
        }

        //------ Metodo que crea un registro en la tabla usuarios ------------------
        public function createUser($name, $lastname, $email, $cellphone, $dni, $fecha_nacimiento, $horas_trabajadas, $precio_hora, $rol_id, $servicios, $user, $password, $name_table, $image ){
            $connect = $this->database->connect();
            $sql = 'INSERT INTO usuarios (`id_usuario`, `user`, `password`, `rol_id`) VALUES (NULL, :user, :password, :rol_id)';
            $sentencia = $connect->prepare($sql);
            $result = $sentencia->execute(array(':user'=> $user, ':password'=>$password, ':rol_id'=> $rol_id));
            if($result){
                //Obtenemos el ultimo id insertado
                $id = $connect->lastInsertId();
                $result = $this->insertEmpleado($name_table, $id, $name, $lastname, $email, $cellphone,$dni, $fecha_nacimiento, $horas_trabajadas, $precio_hora, $servicios,$connect, $image);    
            }
            return $result;
        }

        //-------- Metodo que inserta los datos de un empleado de acuerdo al nombre de la tabl --------
        private function insertEmpleado($name_tabla, $id, $name, $lastname, $email, $cellphone, $dni, $fecha_nacimiento, $horas_trabajadas, $precio_hora, $servicios, $connect, $image){
            if(empty($servicios)){
                //Carga un secretario
                $query = "INSERT INTO $name_tabla (`id`, `name`, `lastname`, `email`, `cellphone`, `dni`, `fecha_nacimiento`,`imagen_perfil`, `horas_trabajadas`, `precio_x_hora`) VALUES (:id, :name, :lastname, :email, :cellphone, :dni, :fecha_nacimiento, :img_perfil,  :horas_trabajadas, :precio_hora)";
                $array = array(':id'=> $id, ':name'=>$name, ':lastname'=> $lastname, ':email'=> $email, ':cellphone'=> $cellphone, ':dni'=> $dni, ':fecha_nacimiento'=> $fecha_nacimiento,':horas_trabajadas'=> $horas_trabajadas, ':precio_hora'=> $precio_hora, ':img_perfil'=>$image);
            }else{
                //Carga un barbero
                $query = "INSERT INTO $name_tabla (`id`, `name`, `lastname`, `email`, `cellphone`, `dni`, `fecha_nacimiento`, `imagen_perfil`, `servicios`, `horas_trabajadas`, `precio_x_hora`) VALUES (:id, :name, :lastname, :email, :cellphone, :dni, :fecha_nacimiento, :img_perfil, :servicios, :horas_trabajadas, :precio_hora)";
                $array = array(':id'=> $id, ':name'=>$name, ':lastname'=> $lastname, ':email'=> $email, ':cellphone'=> $cellphone, ':dni'=> $dni, ':fecha_nacimiento'=> $fecha_nacimiento, ':servicios'=> $servicios, ':horas_trabajadas'=> $horas_trabajadas, ':precio_hora'=> $precio_hora, ':img_perfil'=>$image);
            }
            $sentencia = $connect->prepare($query);
            $result = $sentencia->execute($array);
            return $result;
        }

        //--------- Metodo que elimina un usuario ----------------------
        public function deleteEmpleado($id, $name_tabla){
            $connect = $this->database->connect();
            $query = "DELETE FROM $name_tabla WHERE id=:id";
            $sentencia = $connect->prepare($query);
            if($sentencia->execute(array(':id'=>$id))){
                //Eliminamos el usuario tambien
               if($this->deleteUser($id, $connect)){
                   //Y actualizamos la cantidad de roles
                   $result = $this->updateRol($name_tabla, $connect);
                   return $result;
               }else{
                   return false;
               }
            }else{
                return false;
            }

        }

        private function deleteUser($id, $connect){
            $query = "DELETE FROM usuarios WHERE id_usuario=:id";
            $sentencia = $connect->prepare($query);
            $result = $sentencia->execute(array(':id'=>$id));
            return $result;
        }

        private function updateRol($rol, $connect){
            $query = "UPDATE `roles` SET `cantidad`= cantidad-1 WHERE rol=:rol";
            $sentencia = $connect->prepare($query);
            $result = $sentencia->execute(array(':rol'=>$rol));
            return $result;
        }

        //---------- Metodo que actualiza los emppleados
        public function updateEmpleado($query, $array){
            $connect = $this->database->connect();
            $sentencia = $connect->prepare($query);
            $result = $sentencia->execute($array);
            return $result;
        }

        //---------- Metodo que retorna el barbero con mayor servicios -------
        public function getMaxBarbero(){
            $connect = $this->database->connect();
            $query = "SELECT * FROM empleado WHERE turnos_atendidos =(SELECT max(turnos_atendidos) FROM empleado)";
            $sentencia = $connect->prepare($query);
            $sentencia->execute();
            $barbero = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $barbero;

        }

    }



?>