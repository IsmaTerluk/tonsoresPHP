<link rel="stylesheet" href="public/css/login.css">

<div class="container border border-1 rounded p-3 mt-5" style="width: 45%;">
    <div class=" text-center">
        <h6 class="paragraph">Iniciar Sesión</h6>
    </div>

    <hr class="border border-2">

    <div class="body">
        <form action="/tonsores/login" method="post">
            <div class="container">
                <div class="mb-2">
                    <input type="text" class="form-control" placeholder="Usuario"  name="user"  required>
                </div>
                <div class="mb-2">
                    <input type="password" class="form-control" placeholder="Contraseña"  name="pass" id="password" required>
                </div>
                <div>
                    <input type="checkbox" onclick="mostrarPassword()" > Mostrar contraseña
                </div>
            </div>

            <!-- Mensaje de error -->

            <div class="d-flex justify-content-center mb-2">
                <small>
                    <strong style="color: red;"> <?php if(isset($array['error'])){
                            echo $array['error'];}?>
                    </strong>
                </small>
            </div> 
            
            <div class="d-flex justify-content-center mb-3">
                <small>
                    <strong>¿Eres nuevo?</strong> <a href="/tonsores/create/user">Create una cuenta</a>
                </small>
            </div>

            <hr class="border border-1">

            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <small>
                        <a href="/tonsores/recover/password"> ¿Olvidaste tu contraseña? </a>
                    </small>
                </div>
                <div class="d-flex align-items-center">
                    <input type="submit" name ="submit" value="Iniciar Sesion" class="button btn btn-outline-light rounded-pill ">
                </div>
            </div>

        </form>
    </div>
</div>


<?php 
    //require_once '../views/components/form-login.php';

?>

<!-- script para mostrar contraseña -->

<script>

    function mostrarPassword(){

        //Mapeo la contraseña
        var pass = document.getElementById("password");
        if(pass.type == "password"){
            pass.type = "text";
        }else{
            pass.type = "password";
        }

    }

</script>
