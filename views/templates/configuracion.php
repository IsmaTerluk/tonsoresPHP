<link rel="stylesheet" href="public/css/configuracion.css">

<p class="text-center mt-3 subtitle"> Configuración </p><hr>

<!-- Seccion de editar usuario -->
<?php 
    if(!isset($array['edit_perfil']))
        $display = 'none';
    else
        $display = 'block';

?>
<p class="mx-4 h6 "> 
    <i class="bi bi-pen-fill px-2 icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
        </svg>
    </i>
    Editar perfil
    <span class="mx-2" onclick="editarPerfil()" id="flecha_editar" style="cursor:pointer;"> ⇲ </span>
</p>
<div style="display:<?=$display?>; " id="editar_perfil" class="container ">
    <form action="/tonsores/configuracion" method="POST" class=" d-flex flex-column" enctype="multipart/form-data">
        <div class=" d-flex justify-content-around">
            <div class="mb-3 col-5">
                <label for="user" class="form-label">Usuario</label>
                <input type="text" class="form-control" name="user" id="user" value="<?= $_SESSION['user']['user'];?>" placeholder="Ingrese su usuario" required>
            </div>

            <div class="mb-3 d-flex justify-content-center">
                <div class="container d-flex flex-column">
                    <label for="image" class="form-label"> Imágen de perfil </label>
                    <img src="http://localhost/tonsores/public/uploads/image/img_perfil/<?=$_SESSION['user']['imagen_perfil']?>" class="borber rounded-circle mt-1 mb-3 " alt="" width="100" height="95">
                    <div class="edit">
                        <input type="file" class="form-control" name="image_perfil" id="image">
                    </div>
                    
                </div>
            </div>
        </div>
        <?php 
            if(isset($array['edit_perfil'])){?>
                <div class="text-center">
                    <p class="h6 text-<?=$array['color']?>"> <?= $array['edit_perfil']?> </p>
                </div>
            <?php
            }
        ?>
        <div class="text-center">
            <input type="submit" value="Guardar" name="editar_perfil" class="button btn btn-outline-light  border rounded-pill">
        </div>           
    </form>
</div>
<hr>

<!-- Seccion de cambiar la contraseña -->
<?php 
    if(!isset($array['cambiar_password']))
        $display = 'none';
    else
        $display = 'block';
?>
<p class="mx-4 h6 mb-4">
    <i class="bi bi-lock-fill mx-2 icon ">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
        </svg>
    </i>
    Cambiar contraseña 
    <span class="mx-2" onclick="cambiarContraseña()" id="flecha_password" style="cursor:pointer;"> ⇲ </span> 
</p>
<div style="display:<?=$display?>; " id="cambiar_contraseña" class="container ">
    <form action="/tonsores/configuracion" method="POST" >
            <div class="container d-flex justyfi-content-around ">

                <div class="container text-end " style="width:30%">
                    <p class="mb-4">Contraseña actual</p>
                    <p class="mb-4">Nueva contraseña</p>
                    <p>Confirma contraseña</p>
                </div>

                <div class="container" style="width: 80%;">
                    
                    <div class="mb-2">
                        <input type="password" class="form-control pass" placeholder="Ingrese contraseña actual" name="pass_actual" 
                            <?php if(isset($array['pass_actual'])){?>
                                value="<?= $array['pass_actual']?>"
                            <?php
                            }?> required 
                        >
                    </div>
                    
                    <div class="mb-2">
                      <input type="password" class="form-control pass" placeholder="Ingrese nueva contraseña" name="pass_new" required>
                    </div>

                    <div>
                        <input type="password" class="form-control pass" placeholder="Ingrese nuevamente la contraseña" name="pass_confirm" required>
                    </div>
                </div>

            </div>  

            <?php 
                if(isset($array['cambiar_password'])){?>
                    <div class="text-center mt-2">
                        <p class="h6 text-<?=$array['color']?>"> <?= $array['cambiar_password']?> </p>
                    </div>
                <?php
                }
            ?>     
            
            <div class="text-center mt-3">
                <input type="submit" value="Guardar" name="cambiar_password" class=" button btn btn-outline-light  border rounded-pill">
            </div>         
    </form>
</div>
<hr>

<!-- Seccion de cambiar los datos personales -->
<?php 
    if(!isset($array['datos_personales']))
        $display = 'none';
    else
        $display = 'block';

?>
<p class="mx-4 h6">
    <i class="bi bi-person-video2 mx-2 icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-video2" viewBox="0 0 16 16">
            <path d="M10 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
            <path d="M2 1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2ZM1 3a1 1 0 0 1 1-1h2v2H1V3Zm4 10V2h9a1 1 0 0 1 1 1v9c0 .285-.12.543-.31.725C14.15 11.494 12.822 10 10 10c-3.037 0-4.345 1.73-4.798 3H5Zm-4-2h3v2H2a1 1 0 0 1-1-1v-1Zm3-1H1V8h3v2Zm0-3H1V5h3v2Z"/>
        </svg>
    </i>
    Datos personales 
    <span class="mx-2" onclick="datosPersonales()" id="flecha_datos" style="cursor:pointer;"> ⇲ </span> 
</p>
<div style="display:<?=$display?>; " id="datos_personales" class="container mt-2 mb-3">
    <form action="/tonsores/configuracion" method="POST">
        <div class="container d-flex flex-row">
            <div class="container">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="name" value="<?= $_SESSION['user']['name'];?>" placeholder="Ingrese su nombre" required>
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">Apellido</label>
                    <input type="text" class="form-control" name="lastname" value="<?= $_SESSION['user']['lastname'];?>" placeholder="Ingrese su apellido" required>
                </div>

                <div class="mb-4">
                    <label for="dni" class="form-label"> DNI </label>
                    <input type="text" class="form-control"  name="dni" id="date" value="<?= $_SESSION['user']['dni'];?>" placeholder="Ingrese su dni (sin puntos)">
                </div>
            </div>

            <div class="container">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="user" value="<?= $_SESSION['user']['email'];?>" placeholder="Ingrese su email" required>
                </div>
            

                <div class="mb-3">
                    <label for="cellphone" class="form-label">Celular</label>
                    <input type="text" class="form-control" name="cellphone" id="user" value="<?= $_SESSION['user']['cellphone'];?>" placeholder="Ingresa su numero de celular" required>
                </div>

                <div class="mb-4">
                    <label for="date" class="form-label"> Fecha de nacimiento </label>
                    <input type="date" class="form-control"  name="fecha_nacimiento" id="date" value="<?= $_SESSION['user']['fecha_nacimiento'];?>">
                </div>

            </div>
        </div>
        <?php 
            if(isset($array['datos_personales'])){?>
                <div class="text-center">
                    <p class="h6 text-<?=$array['color']?>"> <?= $array['datos_personales']?> </p>
                </div>
            <?php
            }
        ?>
        <div class="text-center">
            <input type="submit" value="Guardar" name="datos_personales" class="button btn btn-outline-light border rounded-pill">
        </div>
        
    </form>
</div>
<hr>

<!--  Seccion de cambiar tema -->
<p class="mx-4 h6"> 
    <i class="bi bi-gear-fill px-2 icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
        </svg>
    </i>
    Cambiar tema 
    <span class="mx-2" onclick="cambiarTema()" id="flecha_tema" style="cursor:pointer;"> ⇲ </span> 
</p>
<div style="display:none" id="cambiar_tema" class="container pt-2">
    <form action="" method="post" class="d-flex flex-row">
        <div class="">
            <div>
                <input type="radio" name="tema" value="claro">
                <label class="h6">Tema claro</label>
            </div>
            <div>
                <input type="radio" name="tema" value="oscuro" checked>
                <label class="h6">Tema oscuro</label>
            </div>
            <div>
                <input type="radio" name="tema" value="oscuro">
                <label class="h6">Tema personalizado</label>
            </div>
        </div>
        <div class="align-self-center mx-5">
            <input type="submit" value="Aplicar" name="cambiar_tema" class="button btn btn-outline-light border rounded-pill">
        </div>
    </form>
</div>
<hr>
    
<script type="text/javascript">
    function editarPerfil(){
        const input = document.getElementById('editar_perfil');
        if(input.style.display == 'none'){
            input.style.display = 'block';
            flecha_editar.innerHTML="⇱";

        }else{
        input.style.display = 'none';
        flecha_editar.innerHTML="⇲";
        }
    }


    function cambiarContraseña(){
        const input = document.getElementById('cambiar_contraseña');
        if(input.style.display == 'none'){
            input.style.display = 'block';
            flecha_password.innerHTML="⇱";

        }else{
        input.style.display = 'none';
        flecha_password.innerHTML="⇲";
        }
    }

    function datosPersonales(){
        const input = document.getElementById('datos_personales');
        if(input.style.display == 'none'){
            input.style.display = 'block';
            flecha_datos.innerHTML="⇱";

        }else{
        input.style.display = 'none';
        flecha_datos.innerHTML="⇲";
        }
    }

    function cambiarTema(){
        const input = document.getElementById('cambiar_tema');
        if(input.style.display == 'none'){
            input.style.display = 'block';
            flecha_tema.innerHTML="⇱";

        }else{
        input.style.display = 'none';
        flecha_tema.innerHTML="⇲";
        }
    }


</script>

<br>
<br>
<br>