<?php
//Obtenemos el id del lavado
$id_lavado = 4;

?>


<section class="border-bottom container text-light">
    <form action="/tonsores/solicitarturno/barbero-servicio-horario" method="POST">
        <div class="container d-flex flex-column">
            <div class="d-flex  justify-content-between">
                <p class="text-center subtitle" style="width:30%">Servicios</p>
                <p class="text-center subtitle" style="width:55%">Promociones</p>
                <p class="text-center subtitle" style="width:15%">Turnos</p>
            </div>

            <div class="d-flex  justify-content-between">
                <div class="" style="width:30%">
                    <table class="table table-borderless text-light">
                        <thead>
                            <tr>
                            <th scope="col" class="text-center"></th>
                            <th scope="col" class="text-center">Servicios</th>
                            <th scope="col" class="text-center">Precio</th>
                            <th scope="col" class="text-center">Puntos</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            //Descomponemos los servicios
                        $servicios = explode(',',$array['empleado']['servicios']);
                        foreach($servicios as $servicio){?>
                            <tr>
                                <td class="text-center"> <input type="checkbox" name="servicios[]" value="<?=$array['servicios'][$servicio-1]['id']?>" onclick="validaCheckbox()"?> </td>
                                <td class="text-center"><?=$array['servicios'][$servicio-1]['servicio']?></td>
                                <td class="text-center">$ <?=$array['servicios'][$servicio-1]['precio'] ?></td>
                                <td class="text-center"><?=$array['servicios'][$servicio-1]['puntos']?></td>
                            </tr>
                            <?php
                            }?>        
                        </tbody>
                    </table>
                </div>
            

                <div class=" text-center" style="width:55%"> 
                    <?php
                    foreach($array['promociones'] as $promocion){?>
                    <p>
                        <i class="bi bi-chevron-double-right">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                                    <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </i>
                        Seleccionando <?=$promocion['cant_servicios']?> servicios obtienes un descuento del <?=$promocion['descuento']?>%
                        </p>
                    <?php 
                    }
                    ?>
                </div>

                <div class="" style="width: 15%;">       
                    <select name="name_tabla" class="form-select" required>
                        <optgroup label="Elige una opción"> 
                            <option  selected value="1-turnos_mañana"> Turno Mañana </option> 
                            <option  value="2-turnos_tarde"> Turno Tarde </option> 
                        </optgroup>  
                    </select>                
                </div>

            </div>

            <div class="text-end mb-3">
                <input class="btn btn-outline-light button border rounded-pill" type="submit" name='submit' value="Siguiente">
            </div>

        </div>
    </form>
</section>
