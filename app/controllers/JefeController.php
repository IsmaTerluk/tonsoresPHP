<?php 

    class JefeController extends Controller{

        function __construct(){
            parent::__construct();
            //Para el manejo de sessiones
            $userSession = new UserSession();
        }

//Metodos para manejar la seccion de empleados------------------------------------------
        public function seccionEmpleados(){
            $page = "modules/jefe/seccion-empleados";
            $title = "Seccion empleados";

            //Para que independientemente de la accion que se ejecute siempre muestres los datos actualizados
            $this->loadModel('JefeModel');
            $all_servicios = $this->model->getAllServicios();
            $id_secretario = $this->model->getIDRol('secretario');
            $id_empleado = $this->model->getIDRol('empleado');
            $this->loadModel('ABMEmpleadosModel');
            $barberos = $this->model->getAllEmpleados('empleado');
            $secretarios = $this->model->getAllEmpleados('secretario');

            //Cuando confirma agregar/elimnar/actualizar un usuario
            if(isset($_POST['submit'])){
                $action = $_POST['action']."Empleado";
                //Invocamos al metodo correspodiente
                $this->{$action}($all_servicios, $id_empleado, $id_secretario, $page, $title);
            }

            //Cuando selecciona algun empleado para editar o eliminar
            if(isset($_GET['id'])){
                $id_table = explode("_", $_GET['id']);
                //Guarda los datos en una sesion
                $empleadoSession = new EmpleadoSession();
                $empleadoSession->saveData('id_empleado',$id_table[0]);
                $empleadoSession->saveData('name_table', $id_table[1]);

                $empleado = $this->model->getEmpleado($_SESSION['empleado']['id_empleado'], $_SESSION['empleado']['name_table']);
                $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'servicios'=>$all_servicios, 'id_empleado'=>$id_empleado, 'id_secretario'=>$id_secretario,'barberos'=>$barberos, 'secretarios'=>$secretarios, 'mensaje'=>'', 'color'=>'','empleado'=>$empleado, 'seccion-update-delete'=>true]);
            }


            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'servicios'=>$all_servicios, 'id_empleado'=>$id_empleado, 'id_secretario'=>$id_secretario, 'mensaje'=>'', 'color'=>'', 'barberos'=>$barberos, 'secretarios'=>$secretarios]);
        }

        private function agregarEmpleado($all_servicios, $id_empleado, $id_secretario, $page, $title){
            //Mapeo los datos
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $cellphone = $_POST['cellphone'];
            $dni = $_POST['dni'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $horas_trabajadas = $_POST['horas_trabajadas'];
            $precio_hora = $_POST['precio_hora'];
            $user = $_POST['user'];
            $rol_id = $_POST['rol_id'];
            //Mapeamos los datos de la imagen
            $name_image = $_FILES['image_empleado']['name'];
            $type_image = $_FILES['image_empleado']['type'];

            //Carpeta temporal en la que se encuentra la imagen
            $file_temporal = $_FILES['image_empleado']['tmp_name'];

            //Directorio o carpeta de nuestro servidor donde queremos guardar la imagen
            $file_destino = $_SERVER['DOCUMENT_ROOT']."/tonsores/public/uploads/image/empleados";


            //Que solo haga el upload si viene una imagen
            if($type_image == 'image/png' || $type_image == 'image/jpeg' || $type_image == 'image/jpg'){
                //Mueve la imagen de la carpeta temporal a la carpeta destino 
                move_uploaded_file($file_temporal, $file_destino."/".$name_image);
            }
            //Encripta la pasword
            $password = hash('sha512',$_POST['pass']);
            if($_POST['rol_id']==$id_empleado){
                //Mapeo los servicios
                $servicios = $_POST['servicios'];
                $servicios = $this->convertirString($servicios, '');
                $name_table = 'empleado';
            }else{
                $servicios='';
                $name_table = 'secretario';
            }
            //Carga nuevamente el model
            $this->loadModel('ABMEmpleadosModel');
            if($this->model->createUser($name, $lastname, $email, $cellphone, $dni, $fecha_nacimiento, $horas_trabajadas, $precio_hora, $rol_id, $servicios, $user, $password, $name_table, $name_image )){
                //Carga nuevamente el model
                $this->loadModel('JefeModel');    
                //Incrementa el numero de usuarios, clientes, etc...
                $this->model->incrementarCantidadRol($rol_id);
                $mensaje = "Empleado agregado satisfactoriamente";
                $color = "success";
            }else{
                $mensaje = "Tuvimos incovenientes al agregar un empleado. Por favor intente más tarde...";
                $color = "danger";
            }
            //Carga nuevamente el model para enviar los datos actualizados
            $this->loadModel('ABMEmpleadosModel');
            $barberos = $this->model->getAllEmpleados('empleado');
            $secretarios = $this->model->getAllEmpleados('secretario');
            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'mensaje'=>$mensaje, 'color'=>$color, 'servicios'=>$all_servicios ,'create_empleado'=>true, 'barberos'=>$barberos, 'secretarios'=>$secretarios]);
        }

        //Convierte el array de servicios en string para poder almacenarlo en la bd
        private function convertirString($servicios, $string){
            foreach($servicios as $servicio){
                $string = $string . $servicio . ",";
            }
            $string = trim($string,',');
            return $string;
        }

        private function eliminarEmpleado($all_servicios, $id_empleado, $id_secretario, $page, $title){
            //Mapeo los datos
            $id_empleado = $_SESSION['empleado']['id_empleado'];
            $name_table = $_SESSION['empleado']['name_table'];
            //Carga el modelo
            $this->loadModel('ABMEmpleadosModel');
            if($this->model->deleteEmpleado($id_empleado, $name_table)){
                $mensaje = "Empleado eliminado!";
                $color="success";
            }else{
                $mensaje = "Tuvimos inconvenientes para eliminar el empleado. Por favor intente mas tarde...";
                $color="danger";
            }
            //Carga nuevamente para enviar los datos actualizados
            $barberos = $this->model->getAllEmpleados('empleado');
            $secretarios = $this->model->getAllEmpleados('secretario');
            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'mensaje'=>$mensaje, 'color'=>$color, 'servicios'=>$all_servicios ,'seccion-update-delete'=>true,'barberos'=>$barberos, 'secretarios'=>$secretarios ]);
        }

        private function actualizarEmpleado($all_servicios, $id_empleado, $id_secretario, $page, $title){
            //Mapeo los datos
            $id_empleado = $_SESSION['empleado']['id_empleado'];
            $horas_trabajadas = $_POST['horas'];
            $precio_hora = $_POST['precio'];
            //Mapeamos los datos de la imagen
            $name_image = $_FILES['image_empleado']['name'];
            $type_image = $_FILES['image_empleado']['type'];

            //Carpeta temporal en la que se encuentra la imagen
            $file_temporal = $_FILES['image_empleado']['tmp_name'];

            //Directorio o carpeta de nuestro servidor donde queremos guardar la imagen
            $file_destino = $_SERVER['DOCUMENT_ROOT']."/tonsores/public/uploads/image/empleados";

            //Que solo haga el upload si viene una imagen
            if($type_image == 'image/png' || $type_image == 'image/jpeg' || $type_image == 'image/jpg'){
                //Mueve la imagen de la carpeta temporal a la carpeta destino 
                move_uploaded_file($file_temporal, $file_destino."/".$name_image);
            }

            if($_SESSION['empleado']['name_table']=='empleado'){
                $servicios = $this->convertirString($_POST['servicios'],'');
                //Preparamos la query
                if(empty($name_image)){
                    //No actualizamos la img
                    $query = "UPDATE `empleado` SET `horas_trabajadas`=:horas , `precio_x_hora`=:precio, `servicios`=:servicios WHERE id=:id";
                    $array = array(':id'=>$id_empleado, ':horas'=>$horas_trabajadas, ':precio'=>$precio_hora, ':servicios'=>$servicios);
                }else{
                    //Actualizamos la img
                    $query = "UPDATE `empleado` SET `horas_trabajadas`=:horas , `precio_x_hora`=:precio, `servicios`=:servicios, `imagen_perfil`=:img_perfil WHERE id=:id";
                    $array = array(':id'=>$id_empleado, ':horas'=>$horas_trabajadas, ':precio'=>$precio_hora, ':servicios'=>$servicios , 'img_perfil'=>$name_image);
                }
            }else{
                if(empty($name_image)){
                    $query = "UPDATE `secretario` SET `horas_trabajadas`=:horas , `precio_x_hora`=:precio  WHERE id=:id";
                    $array = array(':id'=>$id_empleado, ':horas'=>$horas_trabajadas, ':precio'=>$precio_hora);
                }else{
                    $query = "UPDATE `secretario` SET `horas_trabajadas`=:horas , `precio_x_hora`=:precio, `imagen_perfil`=:img_perfil WHERE id=:id";
                    $array = array(':id'=>$id_empleado, ':horas'=>$horas_trabajadas, ':precio'=>$precio_hora, 'img_perfil'=>$name_image);
                }
            }
            //Carga el modelo
            $this->loadModel('ABMEmpleadosModel');
            if($this->model->updateEmpleado($query, $array)){
                $mensaje = "Cambios guardados";
                $color="success";
            }else{
                $mensaje = "Tuvimos inconvenientes para eliminar el empleado. Por favor intente mas tarde...";
                $color="danger";
            }
            //Carga nuevamente para enviar los datos actualizados
            $barberos = $this->model->getAllEmpleados('empleado');
            $secretarios = $this->model->getAllEmpleados('secretario');
            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'mensaje'=>$mensaje, 'color'=>$color, 'servicios'=>$all_servicios ,'seccion-update-delete'=>true,'barberos'=>$barberos, 'secretarios'=>$secretarios ]);

        }
//---------------------------------------------------------------------------------------------------------------------------------------


//Metodos para manejar la seccion de servicios -----------------------------------------------------------------------------
        public function seccionServicios(){
            $page = 'modules/jefe/seccion-servicios';
            $title = 'Sección servicio';
            $mensaje = '';
            

            if(isset($_POST['submit'])){
                $action = $_POST['action']."Servicio";
                if(!$this->{$action}()){
                    $mensaje = "Tuvimos inconvenientes para realizar la opreción. Por favor intene mas tarde...";
                }
            }

            $this->loadModel('ABMServiciosModel');
            $servicios = $this->model->getAllServicios();
            $this->view->renderHTML('template', ['page'=>$page, 'title'=>$title, 'servicios'=>$servicios, 'mensaje'=>$mensaje]);
        }

        private function editarServicio(){
            $id_servicio = $_POST['id'];
            $servicio = $_POST['servicio'];
            $precio = $_POST['precio'];
            $puntos = $_POST['puntos'];
            $description = $_POST['description'];
            //Mapeamos los datos de la imagen
            $name_image = $_FILES['imagen_servicio']['name'];
            $type_image = $_FILES['imagen_servicio']['type'];

            //Carpeta temporal en la que se encuentra la imagen
            $file_temporal = $_FILES['imagen_servicio']['tmp_name'];

            //Directorio o carpeta de nuestro servidor donde queremos guardar la imagen
            $file_destino = $_SERVER['DOCUMENT_ROOT']."/tonsores/public/uploads/image/servicios";

            //Que solo haga el upload si viene una imagen
            if($type_image == 'image/png' || $type_image == 'image/jpeg' || $type_image == 'image/jpg'){
                //Mueve la imagen de la carpeta temporal a la carpeta destino 
                move_uploaded_file($file_temporal, $file_destino."/".$name_image);
            }

            $this->loadModel('ABMServiciosModel');
            if($this->model->updateServicio($id_servicio, $servicio, $precio, $puntos, $description, $name_image)){
                return true;
            }else{
                return false;
            }
             
        }

        private function eliminarServicio(){

            $id_servicio = $_POST['id'];
            $this->loadModel('ABMServiciosModel');
            if($this->model->deleteServicio($id_servicio)){
                //Al eliminar un servicio tengo que eliminar ese servicio de los barberos
                $this->loadModel('ABMEmpleadosModel');
                $query = "SELECT id, servicios FROM empleado";
                $barberos = $this->model->getAllEmpleados('', $query );
                foreach($barberos as $barbero){
                    $servicios = $barbero['servicios'];
                    //Descarta el servicio eliminado de los barberos para aquel que lo tenga
                    $newservicios = str_replace(",".strval($id_servicio),'', $servicios);
                    //update de los servicios de los empleados
                    $query = "UPDATE `empleado` SET `servicios`=:servicios WHERE id=:id";
                    $array = array(':id'=>$barbero['id'],  ':servicios'=>$newservicios);
                    $this->model->updateEmpleado($query, $array);
                }
                return true;
            }else{
                return false;
            }
        }

        private function agregarServicio(){
            $servicio = $_POST['servicio'];
            $precio = $_POST['precio'];
            $puntos = $_POST['puntos'];
            $description = $_POST['description'];
            //Mapeamos los datos de la imagen
            $name_image = $_FILES['imagen_servicio']['name'];
            $type_image = $_FILES['imagen_servicio']['type'];

            //Carpeta temporal en la que se encuentra la imagen
            $file_temporal = $_FILES['imagen_servicio']['tmp_name'];

            //Directorio o carpeta de nuestro servidor donde queremos guardar la imagen
            $file_destino = $_SERVER['DOCUMENT_ROOT']."/tonsores/public/uploads/image/servicios";


            //Que solo haga el upload si viene una imagen
            if($type_image == 'image/png' || $type_image == 'image/jpeg' || $type_image == 'image/jpg'){
                //Mueve la imagen de la carpeta temporal a la carpeta destino 
                move_uploaded_file($file_temporal, $file_destino."/".$name_image);
            }
            
            $this->loadModel('ABMServiciosModel');
            if($this->model->insertServicio($servicio, $precio, $puntos, $description, $name_image)){
                return true;
            }else{
                return false;
            } 
            
        }


//Metodos para manejar la seccion de descuentos -----------------------------------------------------------------------------



    }

?>