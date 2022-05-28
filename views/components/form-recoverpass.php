<div class="modal-dialog">
    <div class="modal-content">
        <div class="text-center p-2">
            <h5 class="modal-title mx-3" id="exampleModalLabel"> Reestablecer contraseña </h5>
            <hr>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <h6 class="text-center"> ¿No puedes iniciar sesion ? </h6>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p class="text-center text-secondary"> Ingresa tu correo y te enviaremos un mensaje para que puedas reestablecer tu contraseña. </h6>
            </div>
        </div>

        <div class="modal-body">

        <form action="/tonsores/recover/password" method="post">
            <div class="row mb-4">
                <div class="col-sm-12">
                    <input type="email" name="email" class="form-control" placeholder="Correo electronico" required >
                </div>
            <div>
            
            <div class="row mb-4 mt-4">
                <div class="col-sm-12">
                    <select class="form-select" name="name_tabla" required>
                        <option selected> ¿Qué eres?</option>
                        <optgroup label="Si no sabes tu opción, escoge cliente" required>
                            <option value="admin"> 1 - Admin </option>
                            <option value="jefe"> 2 - Jefe </option>
                            <option value="empleado"> 3 - Empleado </option>
                            <option value="cliente"> 4 - Cliente </option>
                            <option value="secretario"> 5 - Secretario </option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-sm-12 text-center ">
                    <input type="submit" name="submit" class="button btn btn-outline-secondary border rounded-pill" style="width: 25%;" value="Restablecer" > 
                </div>
            </div>
        </form>

        <div class="container">
            <div class="row">
                <div class="col-6">
                    <a href="/tonsores/login">Volver al inicio de sesion</a>
                </div>
                <div class="col-6">
                    <a href="/tonsores/create/user">Create una cuenta nueva</a>
                </div>
            </div>
        </div>

        </div> 
    </div>
</div>

<?php 

    if(isset($array['mensaje'])){
        echo '<strong><p class="text-center text-'. $array['color'] . '">' .  $array['mensaje'] .' </p></strong>';
    }


?>