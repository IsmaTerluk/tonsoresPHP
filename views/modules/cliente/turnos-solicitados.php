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
    $dias = array('Dom.', 'Lun.', 'Mar.', 'Miérc.', 'Juev.', 'Vier.', 'Sáb.');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
  }

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

<link rel="stylesheet" href="../public/css/cliente/turnos_solicitados.css">

<p class="h4 text-center mt-3 subtitle"> Turnos asistidos </p>

<?php
  //Listado vacio
    if(empty($array['listado_turnos'])){?>
      <p class="text-center mt-3"> Por el momento no tienes turnos</p>
    <?php
    }else{?>
      <div class="container mt-3">
        <table class="table text-center text-light">
          <thead>
            <tr>
              <th scope="col">Turnos</th>
              <th scope="col">Fecha</th>
              <th scope="col">Hora</th>
              <th scope="col">Servicios</th>
              <th scope="col">Barbero</th>
              <th scope="col">Descargar comprobante</th>
            </tr>
          </thead>
          <tbody>
              <?php 
                $cont=1;
                foreach($array['listado_turnos'] as $turno){?>
                    <tr>
                        <th scope="row"><?=$cont?> </th>
                        <td><?= obtenerFechaEnLetra($turno['fecha'])?></td>
                        <?php
                          if($turno['id_turno']==1){?>
                            <td><?= $array['horarios_mañana'][$turno['id_horario']-1]['horario']?></td>
                          <?php
                          }else{?>
                            <td><?= $array['horarios_tarde'][$turno['id_horario']-1]['horario']?></td>
                          <?php 
                          }?>
                        <td><?= convertirServiciosaString($turno['servicios'], $array['servicios'])?></td>
                        <td><?= $turno['name'] ." ".$turno['lastname']?></td>
                        <td>
                          <?php
                            if($turno['id_estado']==2){?>
                              <a href="/tonsores/descargar-comprobante?id_turno=<?=$turno['id']?>"  target="_blank">
                                <i class="bi bi-cloud-arrow-down-fill">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708z"/>
                                  </svg>
                                </i> 
                            </a>
                          <?php
                            }else{
                              echo "No asistió";
                            }
                          ?>
                      </td>
                    </tr>
                <?php
                $cont++;
                }?>
            
          </tbody>
        </table>
      </div>

  <?php 
  }
?>

