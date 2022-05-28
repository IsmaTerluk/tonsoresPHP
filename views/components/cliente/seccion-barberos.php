<div class="container border-bottom pt-3 pb-3 mb-5">
    <form action="/tonsores/solicitarturno/barbero-servicio" method="POST" class="container" >
        <div class="d-flex justify-content-evenly ">
        
            <?php 
            foreach($array['empleados'] as $empleado){?>
                <div class="card <?=$class?>" style="width: 15rem;">
                    <div class="container p-2">
                        <div class="form-check d-flex justify-content-between">
                            <input class="form-check-input" type="radio" name="id_empleado" value="<?=$empleado['id'];?>" id="flexRadioDefault1" required <?=$disabled?> <?php if($array['id_empleado']==$empleado['id']){?> checked<?php
                        }?> >
                            <label class="form-check-label " for="flexRadioDefault1">
                                <strong class=""><?= $empleado['name']. " " . $empleado['lastname'] ?></strong>
                            </label>
                            <label 
                                <?php 
                                    if($disabled!="disabled"){?>
                                        style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalBarberos" id="btnBarbero" data-name ="<?= $empleado['name']. " " . $empleado['lastname'] ?>" data-image="<?=$empleado['imagen_perfil']?>" data-cellphone="<?=$empleado['cellphone']?>" data-email="<?= $empleado['email']?>" data-description="<?= $empleado['description']?>">
                                    <?php
                                    }
                                ?> 
                                <i class="bi bi-three-dots-vertical">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    </svg>
                                </i>
                            </label>
                        </div>
                    </div>
                    <div class="container d-flex flex-column">
                        <p class="<?=$class?> text-center border"><strong>Servicios</strong></p>
                        <?php
                            //Descompones los servicios para mostrar
                            $servicios = explode(',',$empleado['servicios']);
                            foreach($servicios as $servicio){?>
                                <div class="text-center mb-1">
                                    <span><?=$array['servicios'][$servicio-1]['servicio']?></span>
                                </div>
                            <?php
                        }?> 
                       
                   </div>
                </div>
                
            <?php }?>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <input class="button btn btn-outline-light border rounded-pill" type="submit" value="Siguiente" name="barbero" <?=$disabled?>>
        </div>
    </form>
</div>

<!--  Script para enviar los datos del barbero al modal-->
<script>
    $(document).on("click", "#btnBarbero", function(){
        var name = $(this).data('name');
        var image = $(this).data('image');
        var cellphone = $(this).data('cellphone');
        var email = $(this).data('email');
        var description = $(this).data('description');

        console.log(image);
        
        document.getElementById("id_name").innerHTML = name;
        document.getElementById("id_image").src = "http://localhost/tonsores/public/uploads/image/empleados/"+image;
        document.getElementById("id_cellphone").innerHTML = cellphone;
        document.getElementById("id_email").innerHTML = email;
        //document.getElementById("id_description").innerHTML = description;
        
    })
</script>


<!-- Modal para los barberos  -->
<div class="modal fade text-dark " id="modalBarberos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
         <div class="container d-flex justify-content-between p-3">
            
            <div style="width:40%">
                <img class="border rounded-circle" src="" alt="No se cargo la imagen" id="id_image" width="90%">
            </div>

            <div style="width:55%">
                <p class="subtitle text-dark"> <span id="id_name"></span></p>
                <hr>
                <p>
                    <i class="bi bi-envelope">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                        </svg>
                        <span id="id_email" class="px-2"></span>
                    </i>
                </p>
                <p>
                    <i class="bi bi-telephone-fill">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>  
                        <span id="id_cellphone" class="px-2"></span>
                    </i>
                </p>
            </div>

             <div style="width:5%" class="text-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  
             </div>
             
         </div>
        
    </div>
  </div>
</div>