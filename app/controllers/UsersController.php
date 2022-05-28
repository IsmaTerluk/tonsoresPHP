<?php 

    class UsersController extends Controller {

// ----- Metodo para crear un usuario -----------------
        public function create(){
            //Para restrignir el acceso
            $userSession = new UserSession();
            if(isset($_SESSION['user'])){ 
                $restringir_acceso = ' Para poder acceder a la URL solicitada debe cerrar sesion.';
                //Redirigir por roles
                $title = $_SESSION['user']['rol'] . ": " . $_SESSION['user']['name'];
                $page = "modules/" . $_SESSION['user']['rol'] . "/home";
                $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'restringir_acceso'=>$restringir_acceso]);
            }else{

                $title = 'Registrarse';

                if(!isset($_POST['submit'])){
                    $page = 'templates/create';
                    $this->view->renderHTML("template", ['page'=>$page, 'title'=>$title]);
                }else{
                    //Captura los datos
                    $name = $_POST['name'];
                    $lastname = $_POST['lastname'];
                    $email = $_POST['email'];
                    $cellphone = $_POST['cellphone'];
                    $user = $_POST['user'];
                    $pass = $_POST['pass'];
                    //Encripta contraseña
                    $password = hash('sha512', $pass);
                    $rol_id = $_POST['rol_id'];
                    $image_perfil = $_POST['img_perfil'];

                    //Carga el modelo correspondiente
                    $this->loadModel('UsersModel');

                    if($this->model->createUser($name, $lastname, $email, $cellphone, $user, $password, $rol_id, $image_perfil)){
                        //Incrementa el numero de usuarios, clientes, etc...
                        $this->model->incrementarCantidad($rol_id);
                        $mensaje = "Cuenta creada satisfactoriamente";
                        $color = "green";
                        $page = 'templates/create';
                        $title = 'Registrado';
                        $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'mensaje'=>$mensaje, 'color'=>$color ]);
                    }else{
                        $mensaje = "Tuvimos incovenientes para crear su cuenta. Por favor intente más tarde";
                        $color = "red";
                        $page = "templates/create";
                        $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'mensaje'=>$mensaje, 'color'=>$color ]);
                    }
                }
            }
        } 

//----- Metodo para actualizar el perfil ----------------
        public function configuracion(){

            $userSession = new UserSession();

            $page = 'templates/configuracion';
            $title = "Editar perfil";
            $this->loadModel('UsersModel');
            $id_usuario = $_SESSION['user']['id'];

            //Seccion editar perfil
            if(isset($_POST['editar_perfil'])){
               //Mapeo los datos
                $user = $_POST['user'];
                //Mapeamos los datos de la imagen
                $name_image = $_FILES['image_perfil']['name'];
                $type_image = $_FILES['image_perfil']['type'];

                //Carpeta temporal en la que se encuentra la imagen
                $file_temporal = $_FILES['image_perfil']['tmp_name'];

                //Directorio o carpeta de nuestro servidor donde queremos guardar la imagen
                $file_destino = $_SERVER['DOCUMENT_ROOT']."/tonsores/public/uploads/image/img_perfil";


                //Que solo haga el upload si viene una imagen
                if($type_image == 'image/png' || $type_image == 'image/jpeg' || $type_image == 'image/jpg'){
                    //Mueve la imagen de la carpeta temporal a la carpeta destino 
                    move_uploaded_file($file_temporal, $file_destino."/".$name_image);
                }

                if($this->model->updatePerfil($id_usuario, $user, $_SESSION['user']['rol'], $name_image)){
                    $mensaje = "Cambios actualizados";
                    $color = "success";
                    //Setea la sesion
                    $userSession->setUser($user);
                    if(!empty($name_image))
                        $userSession->setImagePerfil($name_image);
                    $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title,'edit_perfil'=>$mensaje, 'color'=>$color]);
                }else{
                    $mensaje = "Tenemos incovenientes para guardar tus cambios. Por favor intente mas tarde...";
                    $color = "danger";
                    $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title,'edit_pefil'=>$mensaje, 'color'=>$color]);
                }
            } 

            //Seccion cambiar password
            if(isset($_POST['cambiar_password'])){
                $pass_actual = $_POST['pass_actual'];
                $pass_new = $_POST['pass_new'];
                $pass_confirm = $_POST['pass_confirm'];

                //No ingreso la misma password
                if($pass_new != $pass_confirm){
                    $mensaje = "Las contraseñas a modificar no coinciden";
                    $color = "danger";
                    $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'cambiar_password'=>$mensaje, 'color'=>$color, 'pass_actual'=>$pass_actual]);
                }else{
                    //Verifica que las password actual sea igual a la ingresada
                    $password_actual = hash('sha512', $pass_actual);
                    if($password_actual!=$_SESSION['user']['password']){
                        $mensaje = "La contraseña actual no es correcta";
                        $color = "danger";
                        $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title,'cambiar_password'=>$mensaje, 'color'=>$color]);
                    }else{
                        //Encripta la nueva contraseña
                        $pass_new = hash('sha512', $pass_new);
                        //Actualiza la tabla de usuarios
                        if($this->model->updatePassword($id_usuario, $pass_new)){
                            //Setea la session
                            $userSession->setPassword($pass_new);
                            $mensaje = "Contraseña actualizada";
                            $color = "success";
                            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'cambiar_password'=>$mensaje, 'color'=>$color]);
                        }
                    }
                }
            }

            //Seccion cambiar datos_personales
            if(isset($_POST['datos_personales'])){
                $name = $_POST['name'];
                $lastname = $_POST['lastname'];
                $dni = $_POST['dni'];
                $email = $_POST['email'];
                $cellphone = $_POST['cellphone'];
                $fecha_nacimiento = $_POST['fecha_nacimiento'];
                if($this->model->updateDatosPersonales($id_usuario, $name, $lastname, $email, $cellphone, $_SESSION['user']['rol'], $dni, $fecha_nacimiento)){
                    $userSession->setDatosPersonales($name, $lastname, $email, $cellphone, $dni, $fecha_nacimiento);
                    $mensaje = "Cambios actualizados";
                    $color = "success";
                    $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title,'datos_personales'=>$mensaje, 'color'=>$color]);
                }else{
                    $mensaje = "Tenemos incovenientes para guardar tus cambios. Por favor intente mas tarde...";
                    $color = "danger";
                    $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title,'datos_personales'=>$mensaje, 'color'=>$color]);
                }
            }

            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title]);
                
        }


    }



    

?>