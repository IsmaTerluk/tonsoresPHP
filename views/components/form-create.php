<div class="d-flex justify-content-center align-item-center mt-5">
    <div class="col-8">
        <div class="row mt-2">
            <div class="col-12">
                <h3 class="text-center paragraph ">¡Creá tu cuenta!</h3><hr>
            </div>
        </div>  
        <div class="row mb-2">
            <div class="col-12">
                <h5 class="text-center" style="color: rgb(172, 172, 172); "> Registrate para poder solicitar turnos y obtener descuentos </h5>
            </div>
        </div>

        <form method="post" class="formulario" action="/tonsores/create/user" >  

            <div class="row mb-3">
                <div class="col-6">
                    <input type="text" class="form-control" placeholder="Nombre" name="name" required>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" placeholder="Apellido" name="lastname" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <input type="email" class="form-control" placeholder="Correo Electronico" name="email" required>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" placeholder="Cel: 264576276" name="cellphone" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <input type="text" class="form-control" placeholder="Usuario (con el que va iniciar sesion)" name="user" required>
                </div>
                <div class="col-6">
                    <input type="password" class="form-control" placeholder="Contraseña" name="pass" required>
                </div>
            </div>

            <input type="hidden" name="rol_id" value="4">   <!-- Oculto:  es para enviar el rol id-->
            <input type="hidden" name="img_perfil" value="usuario.png">

            <div class="text-center">
                <button type="submit" name="submit" class="button btn btn-outline-light border rounded-pill" style="width: 25%;">Registrarse</button>
            </div>
            
        </form>

        <div class="d-flex justify-content-center mb-2">
            <small class="mt-2">
                <?php if(isset($array['mensaje'])){?> 
                    <strong style="color:<?= $array['color']?>"> <?=$array['mensaje'];}?> </strong> 
            </small>
        </div>

        <div class="d-flex justify-content-center mb-2">
            <small>
                <p><strong>¿Ya tienes cuenta?</strong> <a href="/tonsores/login">Iniciá Sesión</a></p>
            </small>
        </div>
    </div>
</div>