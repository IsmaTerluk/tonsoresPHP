<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Iniciar Sesión</h5>
        </div>

        <div class="modal-body">
            <form action="/tonsores/login" method="post">
                
                <div class="row">
                    <div class="col-12 mb-2">
                        <input type="text" class="form-control" placeholder="Usuario" name="user"  required>
                    </div>

                    <div class="col-12 mb-2">
                        <input type="password" class="form-control" placeholder="Contraseña" name="pass" id="password" required>
                    </div>

                    <div class="col-12 mb-2">
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

                <hr>

                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <small>
                            <a href="/tonsores/recover/password"> ¿Olvidaste tu contraseña? </a>
                        </small>
                    </div>
                    <div class="d-flex align-items-center">
                        <input type="submit" name ="submit" value="Iniciar Sesion" class="btn mt-2" style="background-color: #aa3506; color:white">
                    </div>
                </div>

            </form>


        </div> 
    </div>
</div>


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

