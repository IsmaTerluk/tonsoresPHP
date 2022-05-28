<?php

  $servicios = '';

  foreach($_SESSION['turno']['servicios'] as $servicio){
    $servicios = $servicios . "" .$array['servicios'][$servicio-1]['servicio'] . "+";
  }

  //Saca el ultimo caracter
  $servicios = trim($servicios, '+');

  $fecha = obtenerFechaEnLetra($_SESSION['turno']['fecha']);

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


?>

<div class="container" style="width:40%;">
  <div class="container border rounded p-3">
    <p class="subtitle text-center">Solicitud de turno</p>
    <hr class="text-light">
    <form action="/tonsores/create/turno" method="post">
      <div class="container text-light">

        <div class="d-flex  justify-content-between mb-2 ">
          <strong>Barbero: </strong>
          </span><?=$_SESSION['turno']['name_empleado'] . " " . $_SESSION['turno']['lastname_empleado'] ?></span>
        </div>

        <div class="d-flex  justify-content-between mb-2 ">
          <strong>Horario: </strong>
          <span><?=$_SESSION['turno']['horario'] ?>hs. </span>
        </div>

        <div class="d-flex  justify-content-between mb-2 ">
          <strong>Fecha: </strong>
          </span><?=$fecha ?> </span>
        </div>

        <div class="d-flex  justify-content-between mb-2">
          <strong>Servicios: </strong> 
          </span><?=$servicios ?> </span>
        </div>

        <div class="d-flex  justify-content-between mb-2">
          <strong>Puntos que acumulas: </strong> 
          </span><?=$_SESSION['turno']['puntos'] ?> 
        </div>

        <div class="d-flex  justify-content-between mb-2">
          <strong>Precio: </strong>
          <span><?= "$".$_SESSION['turno']['precio'] ?> </span>
        </div>

        <div class="d-flex  justify-content-between mb-2">
          <strong>Descuento aplicado: </strong>
          <span> <?=$_SESSION['turno']['descuento']?>% </span>
        </div>

        <?php 
          if($_SESSION['user']['saldoafavor'] > 0){?>
            <div class="mb-2 border-bottom border-top text-center" style="display: block;" id="seccion_saldo">
              <p><strong> Tienes un saldo a favor de: $  <span id='saldo_favor'><?=$_SESSION['user']['saldoafavor']?></span></strong></p>
              <em>¿ Deseas utilizarlo ?</em> 
                <input type="radio" name="saldo_favor" value="si" id="si" onclick="saldoFavor()"  data-total="<?=$_SESSION['turno']['total_pagar']?>" data-saldofavor="<?=$_SESSION['user']['saldoafavor']?>" required>Si
                <input type="radio" name="saldo_favor" value="no" required>No
            </div>
          <?php
          }
        ?>

        <div class="d-flex  justify-content-between mb-2">
          <strong>Total a pagar: </strong>
          <span id="total_pagar"><?= "$". $_SESSION['turno']['total_pagar'] ?> </span>
        </div>

        <div class="text-center mt-4">
          <input type="submit" value="Confirmar" name="confirmar" class="btn button btn-outline-light border rounded-pill" style="width: 25%;">
        </div>

      </div>       
    </form>

    <!-- Todo este show es para poder volver para atras -->
    <form action="/tonsores/solicitarturno/barbero-servicio-horario" method="post" name="horario">
      <input type="hidden" name="modificar_id_horario">
    </form>
  </div>
</div>

<script type="text/javascript">
    function enviar_formulario_horario(){
        document.horario.submit()
    }


    function saldoFavor(){

      const input = document.getElementById('si');
      const precio = input.dataset.total;
      const saldofavor = input.dataset.saldofavor;

      document.getElementById("total_pagar").innerHTML=precio-saldofavor;
      document.getElementById("saldo_favor").innerHTML=0;
    }

</script> 