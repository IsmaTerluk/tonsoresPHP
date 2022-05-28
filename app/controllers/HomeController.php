<?php   

    //El use se usa ya que PHPMailer tiene un namespace
    use PHPMailer\PHPMailer\PHPMailer;

    class HomeController extends Controller {

        function __construct() {
            parent::__construct();
            //Para el manejo de sessiones
            $userSession = new UserSession();
        }

//----- Metodo que nos redirige a la pagina Home -----
        public function home(){
            if(isset($_SESSION['user'])){
                $page = "modules/" . $_SESSION['user']['rol'] . "/home";
                $title = $_SESSION['user']['rol'] . ": " . $_SESSION['user']['name'];
                $active = 'sesion';
                $this->view->renderHTML('template', ['page'=>$page, 'title'=> $title, 'active'=>$active]);
            }else{
                $page = 'templates/home';
                $title = 'Inicio';
                //el parametro active, es para el front
                $this->view->renderHTML('template', ['page' => $page, 'title'=>$title, 'active'=>$title]);
            }
        }

//----- Metodo que nos redirige a la pagina de servicios -----
        public function servicios(){
            $page = 'templates/servicios';
            $title = 'Servicios';
            $this->loadModel('ABMServiciosModel');
            $servicios = $this->model->getAllServicios();
            //el parametro active, es para el front
            $this->view->renderHTML('template', ['page' => $page, 'title'=>$title,'active'=>$title, 'servicios'=>$servicios]);
        }

//----- Metodo que nos redirige a la pagina de contacto -----
        public function contacto(){

            $page = 'templates/contacto';
            $title = 'Contacto';
            $this->loadModel('HomeModel');
            $horarios = $this->model->getAllHorariosAtencion();

            if(isset($_POST['submit'])){
                $name = $_POST['name'];
                $correo = $_POST['correo'];
                $mensaje = $_POST['mensaje'];
                $title_mensaje = "¡Hola! Mi nombre es " . $name . ".";
                //El asunto siempre sera el mismo
                $asunto = "Consulta cliente - Sitio web";

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
                $mail->setFrom($correo);  

                // Añadimos el destinatario (ahora mismo solo irá a mailtrap)
                $mail->addAddress("tonsores_barberia@gmail.com");

                //Para que muestre caracteres especiales
                $mail->CharSet = "UTF-8";

                // Indicamos el asunto
                $mail->Subject  = $asunto;

                // Indicamos que puede contener codigo html
                $mail->isHTML(true);
                
                // Mensaje del email
                $mail->Body = $title_mensaje . $mensaje;

                //Enviamos el mail
                if($mail->send()){
                    $respuesta = "¡Tu mensaje ha sido enviado! Pronto nos comunicaremos contigo";
                    $color = "success";
                }else{
                    $respuesta = "Tenemos incovenientes para enviar el mensaje. Intente nuevamente...";
                    $color = "danger";
                }
                $this->view->renderHTML('template', ['page' => $page, 'title'=>$title, 'active'=>$title, 'horarios'=>$horarios, 'respuesta'=>$respuesta, 'color'=>$color]);
            }else{
                //el parametro active, es para el front
                $this->view->renderHTML('template', ['page' => $page, 'title'=>$title, 'active'=>$title, 'horarios'=>$horarios]);
            }          
        }

//----- Metodo que nos redirige a la pagina de ganá puntos -----
        public function ganaPuntos(){
            $page = 'templates/gana-puntos';
            $title = 'Gana Puntos';
            $this->loadModel('HomeModel');
            $promociones = $this->model->getAllPromociones();
            //el parametro active, es para el front
            $this->view->renderHTML('template', ['page' => $page, 'title'=>$title,'active'=>$title, 'promociones'=>$promociones]);
            
        }

//----- Metodo que nos redirige a la pagina de contacto -----
        public function producciones(){
            $page = 'templates/producciones';
            $title = 'Producciones';
            //el parametro active, es para el front
            $this->view->renderHTML('template', ['page' => $page, 'title'=>$title, 'active'=>$title]);
            
        }
    
}
