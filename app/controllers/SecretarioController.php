<?php 

    class SecretarioController extends Controller{
        
        public function __construct() {
            parent::__construct();
            //Para el manejo de sessiones
            $userSession = new UserSession();
        }

        //Metodo para el secretario, para poder confirmar los turnos a la fecha de hoy
        public function verTurnosAlaFecha(){
            //Cargamos el modelo correspondiente
            $this->loadModel('SecretarioModel');
            //Mapeamos los datos
            $info_turno = false;
            if(isset($_POST['cancelar-confirmar'])){
                //Invoca al metodo de acuerdo si se cancelo o se confirmo
                $action = $_POST['action']."Turno";
                $id_turno = $_POST['id_turno'];
                $info_turno = $this->{$action}($id_turno);
            }
            //Mapeamos la fecha de hoy
            date_default_timezone_set('America/Argentina/San_Juan'); 
            $fecha_actual = date('Y-m-d');
            //Comparamos la hora para saber con tabla trabajar
            $hora_actual = date('H:i:s', time());
            $hora_de_referencia = date("H:i:s", strtotime('15:00:00'));
            if($hora_actual < $hora_de_referencia){
                $name_table = 'turnos_mañana';
                $id_turno = 1;
                $title_horario = 'Turnos por la mañana';
            }else{
                $name_table = 'turnos_tarde';
                $id_turno = 2;
                $title_horario = 'Turnos por la tarde';
            }
            //Obtenemos todos los barberos
            $sql = "SELECT id, name, lastname FROM empleado";
            $barberos = $this->model->getAllBarberos($sql,true);
            $title = 'Ver turnos';
            $page = 'modules/secretario/ver-turnos';

            if(!isset($_POST['submit'])){
                $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'barberos'=>$barberos,'title_horario'=>$title_horario, 'info_turno'=>$info_turno]);
            }else{
                //Obtenemos los horarios de acuerdo a la hora
                $horarios = $this->model->getAllHorarios($name_table);
                //Obtenemos los servicios
                $servicios = $this->model->getAllServicios();

                if(isset($_POST['id_empleado'])){
                    //Se busco por barbero
                    if(empty($_POST['cellphone_cliente'])){
                        $id_empleado = $_POST['id_empleado'];
                        //Obtenemos un barbero
                        $sql = "SELECT id, name, lastname FROM empleado WHERE id=$id_empleado";
                        $barbero = $this->model->getAllBarberos($sql);
                        $turnos_barbero = $this->model->buscarTurnosPorBarbero($id_turno, $fecha_actual, $barbero['id']);
                        $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'barberos'=>$barberos, 'horarios'=>$horarios, 'barbero'=>$barbero, 'lista_turnos'=>$turnos_barbero, 'seccion-por-barbero'=>true, 'title_horario'=>$title_horario, 'servicios'=>$servicios]);
                    }else{
                        //Se busco por el cellphone del cliente
                        $cellphone_cliente = $_POST['cellphone_cliente'];
                        $datos_cliente = $this->model->buscarTurnoPorCellphoneCliente($cellphone_cliente, $fecha_actual, $id_turno);
                        if(empty($datos_cliente)){
                            $mensaje_error= "Número equivocado o no tiene ningún turno asignado...";
                            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'barberos'=>$barberos,'error'=>$mensaje_error, 'cellphone'=>$cellphone_cliente, 'title_horario'=>$title_horario, 'servicios'=>$servicios]);
                        }else{
                            //Busco un barbero
                            $id_empleado = $datos_cliente['id_empleado'];
                            $sql = "SELECT name, lastname FROM empleado WHERE id=$id_empleado";
                            $barbero = $this->model->getAllBarberos($sql);
                            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'barberos'=>$barberos, 'horarios'=>$horarios, 'barbero'=>$barbero,  'datos_cliente'=> $datos_cliente, 'cellphone'=>$cellphone_cliente, 'seccion-por-cellphone'=>true, 'title_horario'=>$title_horario, 'servicios'=>$servicios]);
                        }
                        
                        
                    }
                }
                
                
                }
                      
        }

        //Confirma el turno
        public function confirmarTurno($id_turno){
            $datos_turno = $this->model->confirmarTurno($id_turno);
           //Aumentar la cantidad de turnos solicitados y acumular puntos del cliente
           if($this->model->acumularPuntosCliente($datos_turno['id_cliente'], $datos_turno['puntos'])){
               //Incrementamos la cantidad de servicios realizados por el empleado
               if($this->model->incrementarCantidadBarbero($datos_turno['id_empleado'])){
                   if($this->model->incrementarCantidadServicios($datos_turno['servicios'])){
                        $color ="success";
                        $mensaje = "Turno confirmado!";
                    }else{
                        $color ="danger";
                        $mensaje = "Tuvimos incoveniente para confirmar el turno. Por favor intente mas tarde...";
                    }
                }else{
                    $color ="danger";
                    $mensaje = "Tuvimos incoveniente para confirmar el turno. Por favor intente mas tarde...";
                }
            }else{
                $color ="danger";
                $mensaje = "Tuvimos incoveniente para confirmar el turno. Por favor intente mas tarde...";
            }

           return ['color'=>$color, 'mensaje'=>$mensaje];
        }

        //Cancela el turno
        public function cancelarTurno($id_turno){
            if($this->model->cancelarTurno($id_turno, 4)){
                $color = "success";
                $mensaje = "Turno cancelado!";
            }else{
                $color = "success";
                $mensaje = "Tuvimos incoveniente para cancelar el turno. Por favor intente mas tarde...";
            }

            return ['color'=>$color, 'mensaje'=>$mensaje];
        }


    }

?>