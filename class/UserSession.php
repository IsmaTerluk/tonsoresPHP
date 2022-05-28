<?php

    class UserSession {

        public function __construct(){
            session_start();
        }
        
        public function setSession($user){
            //$user es un array asociativo con todos los datos del usuario
            $_SESSION['user'] = $user ;
        }

        public function setDatosPersonales($name, $lastname, $email, $cellphone, $dni=null, $fecha_nacimiento=null){
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['lastname'] = $lastname;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['cellphone'] = $cellphone;
            $_SESSION['user']['dni'] = $dni;
            $_SESSION['user']['fecha_nacimiento']=$fecha_nacimiento;
        }

        public function setUser($user){
            $_SESSION['user']['user'] = $user ;
        }

        public function setImagePerfil($imagen_perfil){
            $_SESSION['user']['imagen_perfil']=$imagen_perfil;
        }

        public function setPassword($password){
            $_SESSION['user']['password'] = $password ;
        }

        public function setPuntos($puntos){
            $_SESSION['user']['puntos'] = $puntos ;
        }

        public function setSaldoFavor($saldo){
            $_SESSION['user']['saldoafavor'] = $saldo ;
        }

        public function getSession(){
            return $_SESSION['user'];
        }

        public function closeSession(){
            session_unset();
            session_destroy();
        }
    }