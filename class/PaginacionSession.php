<?php 

    class PaginacionSession extends Model{


        public static function setSession($resultados_por_pagina){
            $_SESSION['paginacion'] = array(
                'resultados_por_pagina'=>$resultados_por_pagina,
                'indice' => 1,
                'pagina_actual'=>1,
                'error'=> false);
        }

        public static function saveData($clave, $valor){
            $_SESSION['paginacion'][$clave] = $valor;
        }

        public static function getSession(){
            return $_SESSION['paginacion'];
        }

        public static function closeSession(){
            unset($_SESSION['paginacion']);

        }

        public function calcularPaginas($name_table){
            $connect = $this->database->connect();
            //COUNT cuenta todos los resultados obtenidos de la clase empleado
            $sql = "SELECT COUNT(*) AS `total`  FROM $name_table";
            $sentencia = $connect->prepare($sql);
            $sentencia->execute();
            $resultados = $sentencia->fetch(PDO::FETCH_OBJ)->total;
            //cantidad de resultas par
            if($resultados % $_SESSION['paginacion']['resultados_por_pagina'] == 0){
                $total_paginas = intval($resultados / $_SESSION['paginacion']['resultados_por_pagina']);
            }else{
                #Cantidad de usuarios numero impar
                $total_paginas = intval($resultados / $_SESSION['paginacion']['resultados_por_pagina']) +1;
            }
            $this->saveData('total_resultados', $resultados);
            $this->saveData('total_paginas', $total_paginas);


            if(isset($_GET['pag'])){
                //Validar que sea un numero 
                if(is_numeric($_GET['pag'])){
                    //Valida que sea positivo y que <= total_de_paginas
                    if($_GET['pag'] >= 1 && $_GET['pag']<= $_SESSION['paginacion']['total_paginas']){
                        $this->saveData('pagina_actual',$_GET['pag']);
                        $this->saveData ('indice', ($_SESSION['paginacion']['pagina_actual']-1) * ($_SESSION['paginacion']['resultados_por_pagina']));
                    }else{
                        $this->saveData('mensaje_error', 'No existe esa pagina');
                        $this->saveData('error',true);
                    }
                }else{
                    $this->saveData('mensaje_error', 'La pagina tiene que ser valor numerico');
                    $this->saveData('error', true);
                }
            }
        }
  
    }
