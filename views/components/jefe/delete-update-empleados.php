<?php 
    if(!isset($array['seccion-update-delete']))
        $display = 'none';
    else
        $display = 'block';
?>



<!-- seccion para mostrar los empleados -->
<p class="mx-4 h6 mt-2"> Eliminar/editar empleado <span onclick="eliminarEmpleado()" id="flecha_eliminar" style="cursor:pointer;"> ⇲ </span> </p>
<div class="container" style="display:<?=$display?>;" id="form_eliminar">
    <form action="" class="formulario" class="">

        <div class="container d-flex flex-row justify-content-around">
        
            <div class="container">
                <select class="form-select empleados" name="name_tabla" required>
                    <option selected> Seleccion el empleado</option>
                    <optgroup label="Barberos">
                        <?php
                            foreach($array['barberos'] as $barbero){?>
                                <option value="<?=$barbero['id']."_empleado"?>"> <?= $barbero['name'] ." ". $barbero['lastname']?> </option>
                            <?php
                            }
                        ?>
                    </optgroup>
                    <optgroup label="Secretarios">
                        <?php
                            foreach($array['secretarios'] as $secretario){?>
                                <option value="<?=$secretario['id']."_secretario"?>"> <?= $secretario['name'] ." ". $secretario['lastname']?> </option>
                            <?php
                            }
                        ?>
                    </optgroup>
                </select>
            </div>

            <?php
                if(isset($array['seccion-update-delete'])){?>
                    <div style="width: 45%;">
                        <p class="text-center text-<?=$array['color']?>"> <?=$array['mensaje']?> </p>
                    </div>
                <?php
                }
            ?>

            <?php 
                if(isset($array['empleado'])){?>
                    <div class="container" style="width:45%;">
                            <div class="text-center">
                                <img class=" rounded-circle img-thumbnail" style="width: 50%;" src="http://localhost/tonsores/public/uploads/image/empleados/<?=$array['empleado']['imagen_perfil']?>" alt="No se pudo cargar la imagen">
                            </div>
                            <div class="text-center">
                                <p><?=$array['empleado']['name']." ".$array['empleado']['lastname']?></p>
                            </div>
                            <div class="d-flex flex-row justify-content-around" >
                               
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalUpdate" id="btnUpdate">
                                    <i class="bi bi-pencil-square">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </i>
                                    Editar
                                </button>
                                <button  type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalDelete" id="btnDelete"> 
                                    <i class="bi bi-trash-fill" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </i> 
                                    Eliminar
                                </button>
                            </div>
                    </div>
                <?php 
                }
            ?>
    
        </div>
    </form>
</div>

<!-- Modal delete -->
<div class="modal fade text-dark" id="modalDelete" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ATENCION !!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p> ¿Esta seguro que desea eliminar a <?=$array['empleado']['name'] . " " .$array['empleado']['lastname'] ?> ?</p>
        </div>
        <div class="modal-footer p-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            <form action="/tonsores/seccion/empleados" method="POST">
                <input type="hidden" name="action" value="eliminar">
                <input type="submit" name="submit" class="btn btn-danger" value="Eliminar">
            </form>
        </div> 
    </div>
  </div>
</div>


<!-- Modal update -->
<div class="modal fade text-dark" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar <span id="id_empleado"></span><span id="id_name_lastname"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/tonsores/seccion/empleados" method="POST" enctype="multipart/form-data">
            <div class="text-center mb-2">
                <img class="rounded-circle" src="http://localhost/tonsores/public/uploads/image/empleados/<?=$array['empleado']['imagen_perfil']?>" alt="No se puo cargar la img" width="20%">
                <input type="file" class="form-control" name="image_empleado">
            </div>
            <div class="">
                <label for="">Horas trabajadas</label>
                <input type="number" class="form-control" name="horas" value="<?=$array['empleado']['horas_trabajadas']?>">
            </div>

            <div class="">
                <label for="">Precio por hora</label>
                <input type="number" class="form-control" name="precio" value="<?=$array['empleado']['precio_x_hora']?>">
            </div>

            <?php
                if($_SESSION['empleado']['name_table']=='empleado'){
                    //convierte los servicios a un arreglo 
                    $servicios = explode(",", $array['empleado']['servicios'])?>
                    <div class="row mb-3 ">
                        <p class="h6">Servicios que realiza: </p>
                        <div class="d-flex flex-row justify-content-around border-top border-bottom">
                            <?php   
                                foreach($array['servicios'] as $servicio){?>
                                    <div>
                                        <input type="checkbox" name="servicios[]" value="<?=$servicio['id']?>" 
                                            <?php
                                                if(in_array($servicio['id'],$servicios)){?>
                                                    checked
                                                <?php
                                                }
                                            ?>
                                        >  
                                        <label for=""> <?= $servicio['servicio'] ?></label>
                                    </div>
                                <?php
                                }
                            ?>
                        </div>
                        <div class="mt-2">
                            <em><strong>Nota: <br></strong></em>
                            <em>Los servicios checkeados son los que actualmente realiza el barbero. <br> Si desea agregar seleccione el servicio correspondiente. <br> Si desea eliminar seleccione el servicio correspondiente de tal forma que no quede seleccionado</em>
                        </div>
                    </div>
                <?php 
                }
            ?>
            
            <hr>

            <div class="text-center">
                <input type="submit" name="submit" class="btn btn-outline-primary"  value="Editar">
            </div>

            <input type="hidden" name="action" value="actualizar">

        </form>
      </div>
      
    </div>
  </div>
</div>







