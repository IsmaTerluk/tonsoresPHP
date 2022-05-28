<?php

  function obtenerFechaEnLetra($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $dia.' '.$num.' de '.$mes; //del '.$anno;
  }

  function conocerDiaSemanaFecha($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
  }

  //Para mostrar los estilos dependiendo de donde viene el llamado
  if(isset($array['mensaje_delete_turno'])){?>
    <link rel="stylesheet" href="../public/css/cliente/home.css">
  <?php
  }else{?>
    <link rel="stylesheet" href="public/css/cliente/home.css">
  <?php
  }
?>



  <p> 
      <?php  
        if(isset($array['restringir_acceso']))
          echo $array['restringir_acceso'];
      ?> 
  </p>

  <section class="container d-flex mt-5 ">

    <div class="container  text-center" style="width: 50%;">
      <div class="container mt-4">
        <a href="/tonsores/solicitarturno/barbero?pag=1" class=" button btn btn-outline-light btn-lg rounded-pill"> 
          <i class="bi bi-scissors">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-scissors" viewBox="0 0 20 20">
              <path d="M3.5 3.5c-.614-.884-.074-1.962.858-2.5L8 7.226 11.642 1c.932.538 1.472 1.616.858 2.5L8.81 8.61l1.556 2.661a2.5 2.5 0 1 1-.794.637L8 9.73l-1.572 2.177a2.5 2.5 0 1 1-.794-.637L7.19 8.61 3.5 3.5zm2.5 10a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0zm7 0a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0z"/>
            </svg>
          </i>  
          Solicitar turno 
        </a>
      </div>

      <div class="container mt-4">
        <a href="/tonsores/turnos/solicitados" class=" button btn btn-lg btn-outline-light rounded-pill ">
          <i class="bi bi-list-task">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-list-task" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
              <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
              <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
            </svg>
          </i>
           Turnos asistidos 
          </a>
      </div>

      <div class="container mt-4">
        <button class="btn btn-lg btn-outline-light rounded-pill button " 
          <?php 
            if($_SESSION['user']['puntos']>0){?>
              data-bs-toggle="modal" data-bs-target="#modalCanje"
            <?php
            }else{?>
            data-bs-toggle="modal" data-bs-target="#modalCanjeSinPuntos"
            <?php
          }?>
        >
          <i class="bi bi-hand-thumbs-up">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 20 20">
              <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
            </svg>
          </i>
          Canjear puntos
        </button>
      </div>
      
    </div>

    <?php 
      if(!isset($array['turnopendiente'])){?>
        <div class="container d-flex flex-column align-self-center text-center" style="width: 50%;" >
          <p class="subtitle"> No tienes turno pendiente </p>
          <?php
            if(isset($array['mensaje_delete_turno'])){?>
              <p class="paragraph text-<?=$array['color']?>"> <?=$array['mensaje_delete_turno']?> </p>
            <?php
            }
          ?>
        </div>
      <?php
      }else{?>
        <!--Seccion de tarjeta-->
        <div class="container d-flex flex-column align-self-center" style="width: 50%;" >

          <div class="container border rounded p-3" >
            <div class="container text-center">
              <h6 class="subtitle">Turno asignado</h6>
              <hr>
            </div>

            <div class="container">
              <p class="paragraph"><strong> Fecha: </strong> <span> <?=obtenerFechaEnLetra($array['turnopendiente']['fecha'])?></span></p>
              <p class="paragraph"><strong> Hora: </strong> <span> <?=$array['horarios'][$array['turnopendiente']['id_horario']-1]['horario']?> hs.</span></p>
              <hr>
            </div>
            
            <div class="container d-flex justify-content-around ">
              <div>
                <a href="" data-bs-toggle="modal" data-bs-target="#modalDetalle">Ver detalle</a>
              </div>
              <div>
                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalDelete">
                  <i class="bi bi-trash-fill">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 20 20 ">
                      <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                    </svg>
                  </i> 
                  Eliminar
                </button>
              </div>
              
            </div>
          </div>

          <div class="container text-center mt-4">
          <i class="bi bi-exclamation-diamond-fill text-warning px-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-diamond-fill" viewBox="0 0 16 16">
            <path d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098L9.05.435zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
          </i>
            <em> RECUERDA: Si no puedes asistir, elimina el turno. Caso contrario no recuperaras el saldo a favor en caso de haberlo utilizado.</em>
          </div>

        </div>
      <?php
      } 
    ?>

  </section>
  <br>
  <br>


  <section class="container text-center mt-5">
    <?php
      if(isset($array['mensaje_canje'])){?>
        <p class="text-center text-danger"> <?=$array['mensaje_canje']?> </p>
      <?php
      }
    ?>
    <p class="paragraph">
      <i class="bi bi-hand-thumbs-up">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 20 20">
          <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
        </svg>
      </i>
      Puntos acumulados: <?=$_SESSION['user']['puntos']?></p>
      <p class="paragraph">
      <i class="bi bi-currency-dollar">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 20 20">
          <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
        </svg>
      </i>
      Saldo a favor: $<?=$_SESSION['user']['saldoafavor']?>
    </p>
  </section>


<!-- Modal delete -->
<div class="modal fade text-dark " id="modalDelete" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ATENCIÓN</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p> ¿Seguro  desea eliminar el turno asignado? </p>
        </div>
        <div class="modal-footer p-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <form action="/tonsores/delete/turno" method="POST">
                <input type="hidden" name="id_turno" value="<?=$array['turnopendiente']['id']?>" id="id_number">
                <input type="submit" name="submit" class="btn btn-danger" value="Eliminar">
            </form>
        </div> 
    </div>
  </div>
</div>


<!-- Modal detalle -->
<div class="modal fade text-dark " id="modalDetalle" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detalles del turno</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
              <p><strong>Fecha: </strong><span><?=obtenerFechaEnLetra($array['turnopendiente']['fecha'])?></span></p>
              <p><strong>Hora: </strong><span><?=$array['horarios'][$array['turnopendiente']['id_horario']-1]['horario']?> hs.</span></p>
              <p class=""><strong>Barbero: </strong><span> <?=$array['turnopendiente']['name'] . " " . $array['turnopendiente']['lastname'] ?></span></p>
              <p>
                <strong>Servicios: </strong>
                <span>
                  <?php
                      //Descompones los servicios para mostrar
                      $servicios = explode(',',$array['turnopendiente']['servicios']);
                      foreach($servicios as $servicio){?>
                          <?= "+" .$array['servicios'][$servicio-1]['servicio']?>
                      <?php
                  }?>
                </span>
              </p>
              <p class=""><strong>Puntos a adquirir: </strong><span> <?=$array['turnopendiente']['puntos'] ?></span></p>
              <p class=""><strong>Saldo a favor: </strong><span> $<?=$array['turnopendiente']['saldoafavor'] ?></span></p>
              <p class=""><strong>Precio: </strong><span> $<?=$array['turnopendiente']['total_pagar'] ?></span></p>
            </div>
        </div> 
    </div>
  </div>
</div>


<!-- Modal canje -->
<div class="modal fade text-dark " id="modalCanje" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Canjear Puntos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
              <p class="text-center"> Al canjear puntos obtendrás un saldo a favor que luego puedes utilizarlo como forma de pago</p>
              <form action="/tonsores/login?action=canjear" method="post">
                <p class="text-center"> <strong>Puntos acumulados: </strong><?=$_SESSION['user']['puntos']?> </p>
                <p class="text-center">¿Cuántos puntos desea canjear?</p>
                <div class="container">
                  <input type="number" class="form-control" min="0" max="<?=$_SESSION['user']['puntos']?>" name="puntos_canje">
                </div>
                <hr>
                <div class="container text-center">
                  <input type="submit" value="Canjear" class="btn btn-secondary" name="submit">
                </div>
              </form>
            </div>
        </div> 
        
    </div>
  </div>
</div>

<!-- Modal canje sin puntos -->
<div class="modal fade text-dark " id="modalCanjeSinPuntos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">No tienes puntos acumulados</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>  
        <p class="text-center"> Al canjear puntos obtendrás un saldo a favor que luego puedes utilizarlo como forma de pago</p>
    </div>
  </div>
</div>
  