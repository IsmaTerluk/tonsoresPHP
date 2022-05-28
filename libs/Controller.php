<?php 

    #Todo controller va heredar de este controller
    #Asi aseguramos que todos tengan asociado una vista y un modelo

    class Controller {
        protected $model;
        protected $view;

        function __construct(){
            $this->view = new View();  
        }

        public function loadModel($model){
            $file = '../app/models/'. $model .'.php';
            if(file_exists($file)){
                require_once $file;
                $this->model = new $model;
            } 
        }

    }