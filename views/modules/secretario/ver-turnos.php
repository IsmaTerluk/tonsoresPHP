<!-- <link rel="stylesheet" href="../public/css/secretario/turnos.css"> -->

<?php 
    function convertirServiciosaString($lista_servicios, $all_servicios){
        //Descomponemos los servicios
        $lista_servicios = explode(',', $lista_servicios);
        $servicios = '';
        foreach($lista_servicios as $servicio){
            $servicios = $servicios . $all_servicios[$servicio-1]['servicio']."+";
        }
        //Saca el ultimo caracter
        $servicios = trim($servicios, '+');
        return $servicios;
    }

?>


<div class="container  d-flex flex-column mt-2">

    <?php echo "<p class='text-center subtitle mt-1'>" . $array['title_horario']. "</p>";?>

<!--Seccion buscador-->
    <form action="/tonsores/secretario/ver-turnos" method="post" class="mt-3 mb-3 pt-2 pb-2">
        <h6 class="text-center ">Buscar por: </h4>
        
        <div class="d-flex justify-content-around pt-2 pb-3">
            <div class="container d-flex justify-content-around">
                <label for=""> Barbero: </label>
                <select name="id_empleado" style="width: 20vw;" class="form-select" required>
                        <?php   
                            foreach($array['barberos'] as $barbero){
                                if(isset($array['barbero'])){
                                    if($array['barbero']['id'] == $barbero['id']){?>
                                        <option selected value="<?=$barbero['id']?>"> <?= $barbero['name']." ".$barbero['lastname']?> </option> 
                                    <?php
                                    }else{?>
                                    <option value="<?=$barbero['id']?>"> <?= $barbero['name']." ".$barbero['lastname']?> </option> 
                                    <?php
                                    }?>
                                <?php
                                }else{?>
                                    <option value="<?=$barbero['id']?>"> <?= $barbero['name']." ".$barbero['lastname']?> </option> 
                                <?php
                                }
                            }?>
                </select>
            </div>
            <div class="container d-flex flex-column ">
                <div class="d-flex justify-content-around">
                    <label for="" style="width: 50%;">Celular del cliente: </label>
                    <?php 
                        if(isset($array['cellphone'])){?>
                            <input type="text" value="<?=$array['cellphone']?>" placeholder="Ingrese celular del cliente" name="cellphone_cliente"  class="form-control">
                        <?php
                        }else{?>
                            <input type="text" placeholder="Ingrese celular del cliente" name="cellphone_cliente" class="form-control">
                        <?php
                    }?>
                </div>
            </div>
        </div>
        <div class="text-end">
            <?php
                if(isset($array['error'])){
                    echo "<p class='text-danger'>".$array['error'] ."</p>";
                }
            ?>
        </div>
        <div class="text-center">
            <input type="submit" value="Buscar" name="submit" class="btn btn-outline-dark button border rounded-pill mt-2" style="width: 20vw;">
        </div>

    </form>
    <hr>
    <br>
    <?php
        if(isset($array['info_turno'])){
            if(($array['info_turno'])!=false){?>
                <div class="text-center">
                    <p class="text-<?=$array['info_turno']['color'] ?>"> <?=$array['info_turno']['mensaje'] ?> </p>
                </div>
            <?php
            }
        }
    ?>

<!--Seccion por el barbero -->
<?php
    if(isset($array['seccion-por-barbero'])){?>
        <div class="container d-flex justify-content-center">
            <div class="" style="width: 60vw;">
                <p class="text-center" ><strong><?=$array['barbero']['name'] ." ".$array['barbero']['lastname']?></strong></p>
                <div>
                    <table class="table text-center text-dark">
                        <thead class="subtitle2">
                            <tr>
                                <th scope="col">Cliente</th>
                                <th scope="col">Horario</th>
                                <th scope="col">Servicio/s</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cancelar</th>
                                <th scope="col">Confirmar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($array['lista_turnos'] as $turnos){?>
                                    <tr>
                                        <th scope="row"> <?= $turnos['name']." ".$turnos['lastname']?> </th>
                                        <td><?= $array['horarios'][$turnos['id_horario']-1]['horario'] ?></td>
                                        <td> <?= convertirServiciosaString($turnos['servicios'], $array['servicios'])?></td>
                                        <td> $<?= $turnos['total_pagar']?></td>
                                        <td> 
                                            <i class="bi bi-trash-fill text-danger" id="btnCancelar" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#modalCancelar" data-name="<?=$turnos['name'] ." ". $turnos['lastname']?>" data-idturno="<?= $turnos['id'] ?> ">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                </svg>
                                            </i>
                                        </td>
                                        <td>
                                            <i class="bi bi-check-circle-fill text-success" id="bntConfirmar"  style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#modalConfirmar" data-name="<?= $turnos['name'] ." " . $turnos['lastname']?>" data-idturno="<?= $turnos['id'] ?> ">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                </svg>
                                            </i>
                                        </td>
                                    </tr>
                                <?php
                                }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
<?php
}?>

<?php
    //Cuando la busqueda es por el celular
    if(isset($array['seccion-por-cellphone'])){?>

        <div class="container border rounded p-2" style="width:40%">
            <div class="header text-center">
                <p> <strong><?=$array['barbero']['name'] ." ".$array['barbero']['lastname']?></strong> </p>
                <hr>
            </div>
            <div class="body">
                <p><strong>Cliente:</strong> <?= $array['datos_cliente']['name']." ".$array['datos_cliente']['lastname']?> </p>
                <p><strong>Horario:</strong> <?= $array['horarios'][$array['datos_cliente']['id_horario']-1]['horario'] ?> </p>
                <p><strong>Servicio/s:</strong> <?= convertirServiciosaString($array['datos_cliente']['servicios'], $array['servicios'])?> </p>
                <p><strong>Precio:</strong> $<?= $array['datos_cliente']['total_pagar']?> </p>
                <hr>
            </div>
            <div class="footer d-flex justify-content-around">
                <i class="bi bi-trash-fill text-danger" id="btnCancelar" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#modalCancelar" data-name=<?= $array['datos_cliente']['name']." ".$array['datos_cliente']['lastname']?> data-idturno="<?= $array['datos_cliente']['id'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                    </svg>
                </i>

                <i class="bi bi-check-circle-fill text-success" id="bntConfirmar"  style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#modalConfirmar" data-name=<?= $array['datos_cliente']['name']." ".$array['datos_cliente']['lastname']?> data-idturno="<?= $array['datos_cliente']['id'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                </i>
            </div>
        </div>

    <?php
    }?>


</div>



<!--  Script para enviar los datos al modal-->
<script>
    $(document).on("click", "#btnCancelar", function(){

        var name = $(this).data('name');
        var idturno = $(this).data('idturno');
        
        document.getElementById("id_name").innerHTML = name;
        $("#idturno").val(idturno);
        
    })


    $(document).on("click", "#bntConfirmar", function(){
        var name = $(this).data('name');
        var idturno = $(this).data('idturno');
        
        document.getElementById("id_name_confirm").innerHTML = name;
        $("#idturno_confirm").val(idturno);
        
    })
</script>



<br>
<br>
<br>
<br>

<!-- Modal cancelar -->
<div class="modal fade text-dark " id="modalCancelar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ATENCIÓN</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p class="text-center"> ¿Seguro desea cancelar el turno de <span id="id_name"></span> ?</p>
        </div> 
        <div class="modal-footer p-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            <form action="/tonsores/secretario/ver-turnos" method="POST">
                <input type="hidden" name="action" value="cancelar">
                <input type="hidden" name="id_turno" id="idturno" >
                <input type="submit" name="cancelar-confirmar" class="btn btn-danger" value="Cancelar">
            </form>
        </div> 
    </div>
  </div>
</div>


<!-- Modal confirmar -->
<div class="modal fade text-dark " id="modalConfirmar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">CONFIRMACIÓN</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p class="text-center"> ¿Confirma el turno de <span id="id_name_confirm"></span> ?</p>
        </div> 
        <div class="modal-footer p-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            <form action="/tonsores/secretario/ver-turnos" method="POST">
                <input type="hidden" name="action" value="confirmar">
                <input type="hidden" name="id_turno" id="idturno_confirm" >
                <input type="submit" name="cancelar-confirmar" class="btn btn-success" value="Confirmar">
            </form>
        </div> 
    </div>
  </div>
</div>