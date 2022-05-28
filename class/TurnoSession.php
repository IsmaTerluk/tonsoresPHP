<?php

    class TurnoSession {

        public static function setSession(){
            $_SESSION['turno'] = array();
        }

        public static function saveData($clave, $valor){
            $_SESSION['turno'][$clave] = $valor;
        }

        public function aplicarDescuento($total, $porcentaje){
            $descuento = intdiv($porcentaje*$total,100);
            $_SESSION['turno']['total_pagar'] = $_SESSION['turno']['precio'] - $descuento;
        }

        public static function getSession(){
            return $_SESSION['turno'];
        }

        public static function closeSession(){
            unset($_SESSION['turno']);

        }
    }

?>