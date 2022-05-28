<?php

    #La vista tiene solo un metodo que redirige a un template

    class View {

        public function renderHTML($view, $array = []){
            $file = '../views/' . $view . '.php';
            if(file_exists($file))
                require_once $file;
        }

    }