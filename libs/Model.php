<?php

    #El model tiene la conexion con la base de datos

    class Model{
            protected $database;

            function __construct(){
                $this->database = new DataBase();
            }
        }