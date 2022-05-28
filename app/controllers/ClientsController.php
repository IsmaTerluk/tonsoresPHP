<?php

    class ClientsController extends Controller {

        public function __construct() {
            parent::__construct();
            //Para el manejo de sessiones
            $userSession = new UserSession();
        }

        public function solicitarTurno(){

            $title = 'Solicitar turno';
            $page = 'modules/cliente/solicitar-turno';
            //Carga el modelo correspondiente
            $this->loadModel('ClientsModel');
            //Para manejar la paginacion
            $paginacion = new PaginacionSession();
            if(isset($_GET['pag'])){
                $paginacion->setSession(4);
                $paginacion->calcularPaginas('empleado');
            }
            //Obtiene todos los empleados -> paginado
            $empleados = $this->model->getAllEmpleados($_SESSION['paginacion']['indice'], $_SESSION['paginacion']['resultados_por_pagina']);
            //Obtiene los servicios
            $servicios = $this->model->getAllServicios();

          
            if(isset($_POST['barbero'])){
                $id_empleado = $_POST['id_empleado'];
                $empleado = $this->model->getEmpleado($id_empleado);
                //Obtenemos todos los horarios
                $promociones = $this->model->getAllPromociones();
                //Va guardando los datos del turno en una sesion
                $turnoSession = new TurnoSession();
                $turnoSession->setSession();
                $turnoSession->saveData('id_empleado', $empleado['id']);
                $turnoSession->saveData('name_empleado', $empleado['name']);
                $turnoSession->saveData('lastname_empleado', $empleado['lastname']);
                $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'empleado'=>$empleado, 'promociones'=>$promociones, 'empleados'=>$empleados, 'servicios'=>$servicios, 'seccion-servicio'=>True, 'id_empleado'=>$_SESSION['turno']['id_empleado'], 'class'=>'text-muted', 'disabled'=>'disabled']);
            }

            //Redirige a la vista
            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'empleados'=>$empleados, 'servicios'=>$servicios, 'id_empleado'=>0, 'class'=>'', 'disabled'=>'']);
        }

        public function confirmarTurno(){
            $turnoSession = new TurnoSession();
            $this->loadModel('ClientsModel');
            //Obtiene todos los servicios
            $servicios = $this->model->getAllServicios();

            if(!isset($_POST['confirmar'])){
                $precio = 0;
                $total_puntos = 0;

                //Viene de la pagina de servicios
                if(isset($_POST['submit'])){
                    //Mapeo los datos
                    if(!empty($_POST['servicios'])){
                        $servicios_solcitados = $_POST['servicios'];
                        //Para obtener el descuento aplicado
                        $descuento_aplicado = $this->model->getDescuento(count($servicios_solcitados));
                        foreach($_POST['servicios'] as $servicio){
                            $precio = $precio +  intval($servicios[$servicio-1]['precio']);
                            $total_puntos = $total_puntos + intval($servicios[$servicio-1]['puntos']);
                        }
                    }

                    if(isset($_POST['name_tabla'])){
                        $turno = explode("-", $_POST['name_tabla']);
                        $id_turno = $turno[0];
                        $name_table = $turno[1];
                    }

                    //Resguarda los datos en la sesion
                    $turnoSession->saveData('servicios', $servicios_solcitados);
                    $turnoSession->saveData('precio' , $precio);
                    $turnoSession->saveData('descuento', $descuento_aplicado);
                    $turnoSession->aplicarDescuento($precio, $descuento_aplicado);
                    $turnoSession->saveData('puntos' , $total_puntos);
                    $turnoSession->saveData('id_turno', $id_turno);
                    $turnoSession->saveData('name_table', $name_table);
                }

                //Maneja las fechas
                date_default_timezone_set('America/Argentina/San_Juan'); 
                if(isset($_GET['fecha']))
                    $turnoSession->saveData('fecha_value', $_GET['fecha']);
                else
                    $turnoSession->saveData('fecha_value', date('Y-m-d'));
                $turnoSession->saveData('fecha_fin', '2022-12-31');

                $class='';
                $disabled = '';
                $band = False;
                if(isset($_POST['modificar_id_horario'])){
                    $turnoSession->saveData('id_horario', 0);
                }

            }else{
                $id_horario = explode("_",$_POST['horario']);
                //Almacena los datos en las sesiones
                $turnoSession->saveData('id_horario', $id_horario[0]);
                $turnoSession->saveData('horario', $id_horario[1]);
                $turnoSession->saveData('fecha', $_POST['fecha']);

                $class='text-muted';
                $disabled='disabled';
                $band = True;
            }

            $turnos = $this->model->getAllTurnos($_SESSION['turno']['name_table']);
            //Averigua los horarios ocupados
            $horarios_ocupados =  $this->model->getTurnosOcupados($_SESSION['turno']['fecha_value'], $_SESSION['turno']['id_empleado'],$_SESSION['turno']['id_turno']);
            
            $title = 'Solicitar turno';
            $page = 'modules/cliente/confirmar-turno';
            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'turnos'=>$turnos, 'name_table'=>$_SESSION['turno']['name_table'], 'fecha_actual'=>$_SESSION['turno']['fecha_value'], 'fecha_fin'=>$_SESSION['turno']['fecha_fin'], 'horarios_ocupados'=>$horarios_ocupados, 'class'=>$class, 'disabled'=>$disabled, 'seccion-confirmar'=>$band, 'servicios'=>$servicios]);

        }

        public function registrarTurno(){
            //Mapeo los datos
            if(isset($_POST['saldo_favor'])){
                if($_POST['saldo_favor']=='si'){
                    //Utilizo el saldo a favor
                    $total_pagar = $_SESSION['turno']['total_pagar'] - $_SESSION['user']['saldoafavor'];
                    $saldoafavor = $_SESSION['user']['saldoafavor'];
                    //Resguardo por si ya tiene un turno asignado
                    $aux_saldo_a_favor = $_SESSION['user']['saldoafavor'];
                    //Setea la sesion
                    $_SESSION['user']['saldoafavor']=0;
                    //Update del saldo a favor del cliente
                    $this->loadModel('ClientsModel');
                    $this->model->updateSaldoFavor($_SESSION['user']['id_usuario'], 0);
                }else{
                    $total_pagar = $_SESSION['turno']['total_pagar'];
                    $saldoafavor = 0;
                    $aux_saldo_a_favor = $_SESSION['user']['saldoafavor'];
                }
            }else{
                $total_pagar = $_SESSION['turno']['total_pagar'];
                $saldoafavor = 0;
                $aux_saldo_a_favor = $_SESSION['user']['saldoafavor'];
            }
            $id_cliente = $_SESSION['user']['id_usuario'];
            $id_empleado = $_SESSION['turno']['id_empleado'];
            $servicios = $this->convertirString($_SESSION['turno']['servicios'], '');
            $id_turno = $_SESSION['turno']['id_turno'];
            $id_horario = $_SESSION['turno']['id_horario'];
            $fecha = $_SESSION['turno']['fecha'];
            $id_estado = 1;
            $precio = $_SESSION['turno']['precio'];
            $descuento = $_SESSION['turno']['descuento'];
            $puntos = $_SESSION['turno']['puntos'];

            $this->loadModel('ABMTurnosModel');
            if($this->model->createTurno($id_cliente, $id_empleado, $id_turno, $id_horario, $fecha, $id_estado, $servicios, $precio, $descuento, $saldoafavor, $total_pagar, $puntos)){
                $mensaje = "Su turno ha sido confirmado. Lo esperamos!!";
                $color = 'success';
            }else{
                $mensaje = "Ya tiene un turno pendiente. Por favor verifique pagina de inicio!";
                $color = 'danger';
                //Volver a setear la sesion porque no se registra el turno
                $_SESSION['user']['saldoafavor']=$aux_saldo_a_favor;
            }
            $title = 'Solicitar turno';
            $page = 'modules/cliente/mensaje';
            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'mensaje'=>$mensaje,'color'=>$color]);
        }

        //Convierte el array de servicios en string para poder almacenarlo en la bd
        private function convertirString($servicios, $string){
            foreach($servicios as $servicio){
                $string = $string . $servicio . ",";
            }
            $string = trim($string,',');
            return $string;
        }

        //Muestra un listado de los turnos que ha solicitado el usuario
        public function turnosSolicitados(){
            $title = 'Turnos Solicitados';
            $page = 'modules/cliente/turnos-solicitados';
            $this->loadModel('ClientsModel');
            $listado_turnos = $this->model->getAllTurnosSolicitados($_SESSION['user']['id_usuario']);
            $horarios_mañana = $this->model->getAllTurnos('turnos_mañana');
            $horarios_tarde = $this->model->getAllTurnos('turnos_tarde');
            $servicios = $this->model->getAllServicios();
            $this->view->renderHTML('template', ['page'=>$page, 'title'=> $title, 'listado_turnos'=>$listado_turnos, 'horarios_mañana'=>$horarios_mañana, 'horarios_tarde'=>$horarios_tarde, 'servicios'=>$servicios]);
        }

        //Cancela el turno
        public function eliminarTurno(){
            //Mapeo los datos
            $id_turno = $_POST['id_turno'];
            $this->loadModel('ABMTurnosModel');
            $saldoafavor = $this->model->deleteTurno($id_turno, 3, $_SESSION['user']['id']);
            if($saldoafavor>=0){
                $color = "success";
                if($saldoafavor == 0){
                    $mensaje = "Turno eliminado";
                }else{
                    $mensaje = "Turno eliminado y saldo recuperado";
                    //Seteamos la sesion
                    $_SESSION['user']['saldoafavor'] = $saldoafavor;
                }
            }else{
                $color = "danger";
                $mensaje = "Tuvimos incoveniente para cancelar el turno. Por favor intente mas tarde...";                
            }

            $page = "modules/cliente/home";
            $title = ucfirst($_SESSION['user']['rol']) . ": " . $_SESSION['user']['name'];
            $active = 'sesion';
            $this->view->renderHTML('template', ['page' => $page, 'title'=> $title, 'active'=>$active, 'mensaje_delete_turno'=>$mensaje, 'color'=>$color]);
        }

    }
?>

