<?php 

    //Requiero las librerias
    require_once "../libs/Controller.php";
    require_once "../libs/View.php";
    require_once "../libs/Model.php";

    //Para manipulacion de la bd
    require_once "../config/config.php";
    require_once "../libs/DataBase.php";

    //Para el manejo de sessiones
    require_once "../class/UserSession.php";
    require_once "../class/TurnoSession.php";
    require_once "../class/PaginacionSession.php";
    require_once "../class/EmpleadoSession.php";

    //Para documentos pdf
    require_once "../libs/fpdf/fpdf.php";
    require_once "../class/FPDF.php";

    
    //Para usar PHPMailer
    require_once "../libs/PHPMailer/OAuthTokenProvider.php";
    require_once "../libs/PHPMailer/OAuth.php";
    require_once "../libs/PHPMailer/PHPMailer.php";
    require_once "../libs/PHPMailer/POP3.php";
    require_once "../libs/PHPMailer/SMTP.php";
    require_once "../libs/PHPMailer/Exception.php";

    require_once "../config/phpmailer.php";


    //Ruteo -> rutas amigables
    $routing = array(
        '/tonsores/'                                                   => ['controller' => 'HomeController',       'action' => 'home'],
        '/tonsores/servicios'                                          => ['controller' => 'HomeController',       'action' => 'servicios'],
        '/tonsores/contacto'                                           => ['controller' => 'HomeController',       'action' => 'contacto'],
        '/tonsores/ganapuntos'                                         => ['controller' => 'HomeController',       'action' => 'ganaPuntos'],                                    
        '/tonsores/producciones'                                       => ['controller' => 'HomeController',       'action' => 'producciones'], 
        '/tonsores/login'                                              => ['controller' => 'LoginController',      'action' => 'login'],
        '/tonsores/recover/password'                                   => ['controller' => 'LoginController',      'action' => 'recoverPass'],
        '/tonsores/create/user'                                        => ['controller' => 'UsersController',      'action' => 'create'],
        '/tonsores/solicitarturno/barbero'                             => ['controller' => 'ClientsController',    'action' => 'solicitarTurno'],
        '/tonsores/solicitarturno/barbero-servicio'                    => ['controller' => 'ClientsController',    'action' => 'solicitarTurno'],
        '/tonsores/solicitarturno/barbero-servicio-horario'            => ['controller' => 'ClientsController',    'action' => 'confirmarTurno'],
        '/tonsores/solicitarturno/barbero-servicio-horario-confirmar'  => ['controller' => 'ClientsController',    'action' => 'confirmarTurno'],
        '/tonsores/create/turno'                                       => ['controller' => 'ClientsController',    'action' => 'registrarTurno'],
        '/tonsores/delete/turno'                                       => ['controller' => 'ClientsController',    'action' => 'eliminarTurno'],
        '/tonsores/turnos/solicitados'                                 => ['controller' => 'ClientsController',    'action' => 'turnosSolicitados'],
        '/tonsores/configuracion'                                      => ['controller' => 'UsersController',      'action' => 'configuracion'],
        '/tonsores/secretario/ver-turnos'                              => ['controller' => 'SecretarioController', 'action' => 'verTurnosAlaFecha'],
        '/tonsores/descargar-comprobante'                              => ['controller' => 'PDFController',        'action' => 'generarPDF'],
        '/tonsores/seccion/empleados'                                  => ['controller' => 'JefeController',       'action' => 'seccionEmpleados'],
        '/tonsores/seccion/servicios'                                  => ['controller' => 'JefeController',       'action' => 'seccionServicios']
    );

    //Se obtiene la uri
    $url = $_SERVER["REQUEST_URI"];


    //Descompone por si viene con parametros
    $url = explode("?", $url);


    //Verifica si existe esa ruta
    if(isset($routing[$url[0]]))
        $controller_action = $routing[$url[0]];
    else
        //Error - Ruta invalida
        $controller_action = ['controller' => 'ErrorController', 'action' => 'error404'];


    //Se asigna controlller y action por separado
    $name_controller = $controller_action['controller'];
    $action = $controller_action['action'];

    
    //Variable que contiene un directorio
    $file = '../app/controllers/'. $name_controller .'.php';


    //Valida si existe
    if(file_exists($file)){
        require_once $file;
        $controller = new $name_controller;
        $controller->{$action}();
    }



    
?>