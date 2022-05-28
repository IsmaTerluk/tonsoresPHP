<?php

    //El use se usa ya que PHPMailer tiene un namespace
    use PHPMailer\PHPMailer\PHPMailer;

    class LoginController extends Controller {

        public function __construct(){
            parent:: __construct();
        }
// ------ Metodo para logear a un usuario -------------------------
        public function login(){

            //Para manejar las sesiones
            $userSession = new UserSession();

            //Cuando cierra session
            if(isset($_GET['action'])){
                if($_GET['action']=="logout"){
                    $userSession->closeSession();
                    $page = 'templates/login';
                    $title = 'Iniciar sesion';
                    $this->view->renderHTML('template', ['page' => $page, 'title'=> $title]);
                }
            }

            //Si ya hay session, no es necesario volver a entrar
            if(isset($_SESSION['user'])){
                $page = "modules/" . $_SESSION['user']['rol'] . "/home";
                $title = ucfirst($_SESSION['user']['rol']) . ": " . $_SESSION['user']['name'];
                $active = 'sesion';
                if($_SESSION['user']['rol'] == 'cliente'){
                    //Puede que halla solicitado canjear los puntos
                    if(isset($_GET['action'])){
                        if($_GET['action']=='canjear'){
                            $puntos_saldo = $this->canjearPuntos();
                            if(empty($puntos_saldo)){
                                $mensaje_canje="Tuvimos inconvenientes para realizar la operación. Por favor intente más tarde";
                            }else{
                                //seteo la sesion
                                $userSession->setPuntos($puntos_saldo['puntos']);
                                $userSession->setSaldoFavor($puntos_saldo['saldoafavor']);
                                $mensaje_canje = '';
                            }
                        }
                    }else{
                        $mensaje_canje = '';
                    }
                    //Verifica si tiene turno solicitado
                    //Carga el modelo correspondiente
                    $this->loadModel('LoginModel');
                    $turnopendiente = $this->model->getTurnoPendiente($_SESSION['user']['id']);
                    if(!empty($turnopendiente)){
                        $servicios = $this->model->getAllServicios();
                        $horarios = $this->model->getAllTurnos($turnopendiente['id_turno']);
                        $this->view->renderHTML('template', ['page' => $page, 'title'=> $title, 'active'=>$active, 'turnopendiente'=>$turnopendiente, 'servicios'=>$servicios, 'horarios'=>$horarios, 'mensaje_canje'=>$mensaje_canje]);
                    }else{
                        $this->view->renderHTML('template', ['page' => $page, 'title'=> $title, 'active'=>$active, 'mensaje_canje'=>$mensaje_canje]);
                    }
                }else{
                    $this->view->renderHTML('template', ['page' => $page, 'title'=> $title, 'active'=>$active]);
                }
            }
            else{ 
                if(!isset($_POST['submit'])){
                    $page = 'templates/login';
                    $title = 'Iniciar sesion';
                    $this->view->renderHTML('template', ['page' => $page, 'title'=> $title]);
                }else{
                    
                    //Mapea los datos
                    $user = $_POST['user'];
                    $pass = $_POST['pass'];
                    //Encripta la contraseña
                    $password = hash('sha512', $pass);
                    
                    //Carga el modelo correspondiente
                    $this->loadModel('LoginModel');
    
                    //Chequea si los datos son correctos
                    $datos_user = $this->model->checkUser($user, $password);

                    if(!empty($datos_user)){
                        //Setea la session
                        $userSession->setSession($datos_user);
                        //Redirigir por roles
                        $page = "modules/" . $_SESSION['user']['rol'] . "/home";
                        $title = ucfirst($_SESSION['user']['rol']) . ": " . $_SESSION['user']['name'];
                        //Para el front
                        $active = 'sesion';
                        if($_SESSION['user']['rol'] == 'cliente'){
                            //Verifica si tiene turno solicitado
                            $turnopendiente = $this->model->getTurnoPendiente($_SESSION['user']['id']);
                            if(!empty($turnopendiente)){
                                $servicios = $this->model->getAllServicios();
                                $horarios = $this->model->getAllTurnos($turnopendiente['id_turno']);
                                $this->view->renderHTML('template', ['page' => $page, 'title'=> $title, 'active'=>$active, 'turnopendiente'=>$turnopendiente, 'servicios'=>$servicios, 'horarios'=>$horarios]);
                            }else{
                                $this->view->renderHTML('template', ['page' => $page, 'title'=> $title, 'active'=>$active]);
                            }
                        }else{
                            $this->view->renderHTML('template', ['page' => $page, 'title'=> $title, 'active'=>$active]);
                        }
                    }else{
                        $error = "Usuario y contraseña no coinciden. Ingrese nuevamente...";
                        $page = 'templates/login';
                        $title = 'Iniciar sesion';
                        $this->view->renderHTML('template', ['page'=> $page, 'title'=> $title, 'error'=>$error ]);
                    }
                }
            }
        } 

// ------ Metodo para reestablecer la contraseña -------------------
        public function recoverPass(){
            //Para manejar las sesiones y restringir accesos
            $userSession = new UserSession();

            //Restringir el acceso
            if(isset($_SESSION['user'])){
                $restringir_acceso = ' Para poder acceder a la URL solicitada debe cerrar sesion.';
                //Redirigir por roles
                $page = "modules/" . $_SESSION['user']['rol'] . "/home";
                $title = $_SESSION['user']['rol'] . ": " . $_SESSION['user']['name'];
                $this->view->renderHTML('template', ['page'=> $page, 'title'=>$title, 'restringir_acceso'=>$restringir_acceso]);
            }else{

                $title = "Restablecer contraseña";

                if(!isset($_POST['submit'])){
                    $page = 'templates/recover-pass';
                    $this->view->renderHTML("template", ['page'=>$page, 'title' => $title]);
                }else{
                    //Mapeo los datos
                    $email = $_POST['email'];
                    $name_tabla = $_POST['name_tabla'];

                    //Carga el modelo correspondiente
                    $this->loadModel('LoginModel');
                    $datos_user = $this->model->checkEmail($email, $name_tabla);
                    
                    if(!empty($datos_user)){
                        //Generamos una clave aleatoria 
                        $clave = rand(0,10000);
                        //Encriptamos clave para almacenarla en la bd
                        $password = hash('sha512', $clave);
                        //Reestablecemos contraseña
                        if($this->model->recoverPass($password, $datos_user['id'])){
                            //Se reestablecio correctamente
                            //Debemos enviar el email
                            //Creamos el objeto para manejar el mail
                            $mail = new PHPMailer();
                            $mail->isSMTP();
                            $mail->SMTPAuth = true;

                            //Configuracion del servidor
                            $mail->Host = constant('EMAIL_HOST');
                            $mail->Username = constant('EMAIL_USERNAME');
                            $mail->Password = constant('EMAIL_PASS');
                            $mail->SMTPSecure = constant('EMAIL_SMTPSECURE');
                            $mail->Port = constant('EMAIL_PORT');

                            // Indicamos el origen del correo
                            $mail->setFrom("tonsores_barberia@gmail.com");  

                            // Añadimos el destinatario (ahora mismo solo irá a mailtrap)
                            $mail->addAddress($email);

                            // Indicamos el asunto
                            $mail->Subject  = "Recupero de contraseña";

                            //Para que muestre caracteres especiales
                            $mail->CharSet = "UTF-8";

                            // Indicamos que puede contener codigo html
                            $mail->isHTML(true);
                            
                            // Mensaje del email
                            $body = "<h3> TONSORES </h3> 
                                     <p> ENCUENTRA TU ESTILO</p>
                                     <p> Hola ". $datos_user['name'] ." " . $datos_user['lastname'] .". Solicitaste recuperar tu contraseña </p>
                                     <p> Hemos creado una clave temporal para que puedas inciar sesión. Clave: $clave</p>
                                     <p> Por cuestiones de seguridad te pedimos que cambies rápidamente tu contraseña.</p>
                                     <p> Atte. Tonsores Barbería.</p>";
                            $mail->Body = $body;


                            //Enviamos el mail
                            if($mail->send('')){
                                $mensaje = "Hemos enviado un mensaje a $email. Por favor verifique su casilla de mensajes.";
                                $color = "success";
                            }else{
                                $mensaje = $mensaje = "La password se modifico, pero no ha sido enviado el email"; 
                                $color = "danger";
                            }
                            $page = 'templates/recover-pass'; 
                            $this->view->renderHTML("template", ['page'=>$page, 'title' => $title, 'mensaje' => $mensaje,  'color'=> $color]);
                        }else{
                            $mensaje = "Tenemos inconvenientes para reestablecer la contraseña. Por favor intente mas tarde"; 
                            $color = 'secondary';
                            $page = 'templates/recover-pass';
                            $this->view->renderHTML("template", ['page'=>$page, 'title' => $title, 'mensaje' => $mensaje,  'color'=> $color]);
                        }
                    }else{
                        $mensaje = "El correo ingresado no es válido";
                        $color = 'danger';
                        $page = 'templates/recover-pass';
                        $this->view->renderHTML("template", ['page'=>$page, 'title' => $title, 'mensaje' => $mensaje,  'color'=> $color]);
                    }    
                }
            }  
        }

// ------ Metodo para cuando el cliente realiza una acción sobre el mismo login... 
        private function canjearPuntos(){
            $puntos_canje = $_POST['puntos_canje'];
            $id_cliente = $_SESSION['user']['id'];
            //Canjeo de puntos es:  Divide los puntos en 4 y ese es el saldo a favor
            $saldo_favor = intval($puntos_canje/4);
            $this->loadModel('ClientsModel');
            $puntos_saldo = $this->model->canjearPuntos($puntos_canje, $saldo_favor, $id_cliente);
            return $puntos_saldo;
        }


    }
