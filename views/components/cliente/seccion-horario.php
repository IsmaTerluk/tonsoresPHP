<div class="container" style="width:50%;">
    <div class="container mt-3 " style="width:60%;">
        <p class="subtitle text-center mb-4">Horarios</p>
        <form action="/tonsores/solicitarturno/barbero-servicio-horario-confirmar" method="post" class="text-light">  
            <div>
                <div class="d-flex justify-content-between mb-4">
                    <p style="width:50%">Fecha: </p>
                    <input type="date" name="fecha" id="input" class="form-control form-control-sm" value="<?=$array['fecha_actual']?>" min="<?=date('Y-m-d')?>" max="<?=$array['fecha_fin']?>" <?=$disabled?>>
                </div>
                
                <div class="d-flex flex-column bd-highlight">
                    <?php
                        foreach($array['turnos'] as $turno){?>
                            <?php 
                                if(in_array($turno['id'],$array['horarios_ocupados'])){?>
                                    <div class="d-flex justify-content-around border rounded-pill p-2">
                                        <div class="d-flex align-items-center"> <input type="radio" name="horario" value="<?=$turno['id']."_".$turno['horario'];?>" disabled > </div>
                                        <div class="d-flex align-items-center"> <span class="text-center text-muted <?=$class?>"><del><?=$turno['horario'];?></del></span> </div>
                                        <div class="d-flex align-items-center"> <span class="text-center text-danger <?=$class?>">Ocupado</span> </div>
                                    </div>
                                <?php
                                }else{?>
                                    <div class="d-flex justify-content-around border rounded-pill p-2">
                                        <div class="d-flex align-items-center"> 
                                            <input type="radio" name="horario" value="<?=$turno['id']."_".$turno['horario'];?>" required <?=$disabled?> 
                                                <?php if(isset($_SESSION['turno']['id_horario'])){
                                                    if($_SESSION['turno']['id_horario']==$turno['id']){?>
                                                        checked
                                                    <?php
                                                    }
                                                }?>
                                            >
                                        </div>
                                        <div class="d-flex align-items-center"> <span class="text-center <?=$class?>"><?=$turno['horario'];?></span></div>
                                        <div class="d-flex align-items-center"> <span class="text-center text-success <?=$class?>">Disponible</span></div>
                                    </div>
                                <?php 
                                }?>
                        </tr>
                    <?php
                    }?>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <input class="btn btn-outline-light button rounded-pill" type="submit" value="Siguiente" name="confirmar" <?=$disabled?> >
                </div>

            </div>
            
        </form>
    </div>

    <script type="text/javascript">
        //Me traigo el input
        const input = document.querySelector('input');
        //Le añado un evento
        input.addEventListener('change', redireccionar);
        //Redirecciono
        function redireccionar() {
            window.location.href = "/tonsores/solicitarturno/barbero-servicio-horario?fecha="+input.value;
        }
    </script> 


    <!-- Todo este show es para poder volver para atras -->
    <form action="/tonsores/solicitarturno/barbero-servicio" method="post" name="servicio">
        <input type="hidden" name="barbero" value="barbero">
        <input type="hidden" name="id_empleado" value="<?=$_SESSION['turno']['id_empleado']?>">
    </form>

</div>

    <script type="text/javascript">
        function enviar_formulario_servicio(){
            document.servicio.submit()
        }
    </script> 


