<?php 
    if(!isset($array['create_empleado']))
        $display = 'none';
    else
        $display = 'block';
?>

<p class="mx-4 h6"> Agregar empleado <span onclick="agregarEmpleado()" id="flecha_agregar" style="cursor:pointer;"> ⇲ </span> </p>
<div class="container " style="display:<?=$display?>" id="form_agregar"> 
    <div class="container mb-3 " style="width: 40%;">
        <select class="form-select opciones" aria-label="Default select example">
            <option selected>Selecciona empleado</option>
            <option value="empleado"> 1 - Barbero </option>
            <option value="secretario">2 - Secretario </option>
        </select>
    </div>

    <p id="mensaje" class="text-center text-<?=$array['color']?>"> <?=$array['mensaje']?> </p>  

    <!-- seccion para agregar un secretario -->
    <div class="container" style="display: none; width:75%;" id="agregar_secretario">
        <form method="post" class="formulario" action="/tonsores/seccion/empleados" enctype="multipart/form-data">  

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
                    <input type="text" class="form-control" placeholder="DNI (sin puntos)" name="dni" required>
                </div>
                <div class="col-6">
                    <input type="date" class="form-control" placeholder="Fecha de nacimiento" name="fecha_nacimiento" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <input type="number" class="form-control" placeholder="Horas a trabajar mensualmente" name="horas_trabajadas" required>
                </div>
                <div class="col-6">
                    <input type="number" class="form-control" placeholder="Precio por hora" name="precio_hora" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-2 text-center">
                    <label>Imagen </label>
                </div>
                <div class="col-10">
                    <input type="file" class="form-control" name="image_empleado" required>
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

            <input type="hidden" name="rol_id" value="<?=$array['id_secretario']?>">   <!-- Oculto:  es para enviar el rol id-->
            <input type="hidden" name="imagen" value="usuario.png">
            <input type="hidden" name="action" value="agregar">

            <div class="row d-flex justify-content-center">
                <button type="submit" name="submit" class="btn btn-outline-dark rounded-pill" style="width: 40%;" >Agregar</button>
            </div>

        </form>


    </div>

    <!-- seccion para agregar un barbero -->
    <div class="container" style="display: none; width:75%;" id="agregar_barbero">
        <form method="post" class="formulario" action="/tonsores/seccion/empleados" enctype="multipart/form-data">  

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
                    <input type="text" class="form-control" placeholder="DNI (sin puntos)" name="dni" required>
                </div>
                <div class="col-6">
                    <input type="date" class="form-control" placeholder="Fecha de nacimiento" name="fecha_nacimiento" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <input type="number" class="form-control" placeholder="Horas a trabajar mensualmente" name="horas_trabajadas" required>
                </div>
                <div class="col-6">
                    <input type="number" class="form-control" placeholder="Precio por hora" name="precio_hora" required>
                </div>
            </div>

            <div class="row mb-3 border-bottom ">
                <p class="h6">Servicios: </p>
                <div class="d-flex flex-row justify-content-around border-top">
                    <?php   
                        foreach($array['servicios'] as $servicio){?>
                            <div>
                                <input type="checkbox" name="servicios[]" value="<?=$servicio['id']?>">  
                                <label for=""> <?= $servicio['servicio'] ?></label>
                            </div>
                        <?php
                        }
                    ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-2 text-center">
                    <label>Imagen </label>
                </div>
                <div class="col-10">
                    <input type="file" class="form-control" name="image_empleado" required>
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
            

            <input type="hidden" name="rol_id" value="<?=$array['id_empleado']?>">   <!-- Oculto:  es para enviar el rol id-->
            <input type="hidden" name="imagen" value="usuario.png">
            <input type="hidden" name="action" value="agregar">

            <div class="row d-flex justify-content-center">
                <button type="submit" name="submit" class="btn btn-outline-dark rounded-pill" style="width: 40%;" >Agregar</button>
            </div>

        </form>


    </div>
</div>