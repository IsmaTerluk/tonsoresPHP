<?php

    //CRUD de los usuarios

    class UsersModel extends Model{

//------ Metodo que crea un registro en la tabla usuarios ------------------
        public function createUser($name, $lastname, $email, $cellphone, $user, $pass, $rol_id, $image_perfil){
                #Retorna la conexion a base de datos con PDO
                $connect = $this->database->connect();
                //Prepara la sentencia
                $sql = 'INSERT INTO usuarios (`id_usuario`, `user`, `password`, `rol_id`) VALUES (NULL, :user, :password, :rol_id)';
                $sentencia = $connect->prepare($sql);
                //Ejecuta la sentencia
                $result = $sentencia->execute(array(':user'=> $user, ':password'=>$pass, ':rol_id'=> $rol_id));
                if($result){
                    //Obtenemos el ultimo id insertado
                    $id = $connect->lastInsertId();
                    //Segun el rol_id es la tabla a la que va a parar
                    $name_tabla = $this->getNameTable($rol_id);
                    $result = $this->insert($name_tabla, $id, $name, $lastname, $email, $cellphone, $image_perfil,$connect);    
                }
                return $result;
        }

//-------- Metodo que inserta los datos de la persona que se registra de acuerdo al nombre de la tabla --------
        private function insert($name_tabla, $id, $name, $lastname, $email, $cellphone, $image_perfil, $connect){
            //Prepara la sentencia
            $sql = "INSERT INTO $name_tabla (`id`, `name`, `lastname`, `email`, `cellphone`, `imagen_perfil`) VALUES (:id, :name, :lastname, :email, :cellphone, :img)";
            $sentencia = $connect->prepare($sql);
            //Ejecuta la sentencia
            $result = $sentencia->execute(array(':id'=> $id, ':name'=>$name, ':lastname'=> $lastname, ':email'=> $email, ':cellphone'=> $cellphone, ':img'=>$image_perfil));
            return $result;
        }

// ----- Metodo que incrementa la cantidad de acuedo al rol ---------------------
        public function incrementarCantidad($rol_id){
            $connect = $this->database->connect();
            $sql = "UPDATE roles SET cantidad = cantidad + 1 WHERE id=:rol_id";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute(array(':rol_id'=> $rol_id));
        }

//-------- Metodo que retorna el nombre de tabla de acuerdo al rol_id ...............
        public function getNameTable($id){
            switch($id){
                case 1: $name_tabla = 'admin';
                    break;
                case 2: $name_tabla = 'jefe';
                    break;
                case 3: $name_tabla = 'empleado';
                    break;
                case 4: $name_tabla = 'cliente';
                    break;
                case 5: $name_tabla = 'secretario';
                    break;
                default: $name_tabla = 'Error';
                    break;
            }
            return $name_tabla;
        }

//-------- Metodo para actualizar la tabla de usuarios ---------------------------
        public function updatePerfil($id_usuario, $user, $name_tabla, $image_perfil){
            $connect = $this->database->connect();
            $query = "UPDATE `usuarios` SET `user`=:user WHERE id_usuario = :id_usuario"; 
            $sentencia = $connect->prepare($query);
            $result = $sentencia->execute(array('id_usuario'=>$id_usuario, ':user'=>$user));
            if($result){
                //Actualiza en caso que venga la imagen
                if(!empty($image_perfil)){
                    $query = "UPDATE $name_tabla SET `imagen_perfil`=:imagen_perfil WHERE id=:id_usuario"; 
                    $sentencia = $connect->prepare($query);
                    $result = $sentencia->execute(array('id_usuario'=>$id_usuario, ':imagen_perfil'=>$image_perfil)); 
                }
            }
            return $result;
        }

//-------- Metodo para actualizar la password
        public function updatePassword($id_usuario, $new_pass){
            $connect = $this->database->connect();
            $query = "UPDATE `usuarios` SET `password`=:password WHERE id_usuario = :id_usuario"; 
            $sentencia = $connect->prepare($query);
            $result = $sentencia->execute(array('id_usuario'=>$id_usuario, ':password'=>$new_pass));
            return $result;
        }
        

//-------- Metodo para actualizar los datos dependiendo el rol del usuario ----------------s
        public function updateDatosPersonales($id_usuario, $name, $lastname, $email, $cellphone, $name_tabla, $dni=null, $fecha_nacimiento=null){
            $connect = $this->database->connect();
            $query = "UPDATE $name_tabla SET `name`=:name, `lastname`=:lastname,`email`=:email, `cellphone`=:cellphone, `fecha_nacimiento`=:fecha_nacimiento, `dni`=:dni WHERE id=:id";
            $sentencia = $connect->prepare($query);
            $result = $sentencia->execute(array(':id'=>$id_usuario, ':name'=>$name, ':lastname'=>$lastname, ':email'=>$email, 'cellphone'=>$cellphone, 'fecha_nacimiento'=>$fecha_nacimiento, 'dni'=>$dni));
            return $result;
        }


    }