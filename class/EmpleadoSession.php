<?php

    //Va guardando los datos de los empleados a agregar/eliminar/o actualizar

    class EmpleadoSession {

        public static function setSession(){
            $_SESSION['empleado'] = array();
        }

        public static function saveData($clave, $valor){
            $_SESSION['empleado'][$clave] = $valor;
        }

        public static function getSession(){
            return $_SESSION['empleado'];
        }

        public static function closeSession(){
            unset($_SESSION['empleado']);

        }
    }

?>