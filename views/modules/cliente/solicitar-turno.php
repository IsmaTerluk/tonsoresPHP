<link rel="stylesheet" href="../public/css/cliente/solicitar_turno.css">

<?php

    $class = $array['class'];
    $disabled = $array['disabled'];
?>
<!-- Migas de pan o breadcrumb-->
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class=" mt-2 mx-2">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/tonsores/login" class="link">Inicio</a></li>
        <?php if(!isset($array['seccion-servicio'])){?>
            <li class="breadcrumb-item selected" aria-current="page">Barberos</li>
        <?php
        }else{?>
            <li class="breadcrumb-item"> <a href="/tonsores/solicitarturno/barbero"  class="link">Barberos</a></li>
            <li class="breadcrumb-item selected" aria-current="page">Servicios</li>
    <?php
    }?>
  </ol>
</nav>

<p class="text-center mt-2 subtitle">Nuestros barberos</p>

<!-- Paginacion -->
<div aria-label="...">
  <ul class="pagination pagination-sm justify-content-center">
    <?php
      for($i=0; $i<$_SESSION['paginacion']['total_paginas']; $i++){
        ($_SESSION['paginacion']['pagina_actual'] == $i+1)? $active = 'active' :$active ='';?>
        <li class="page-item <?= $active?>  mx-1"> 
          <?php if($class=='text-muted'){?>
            <a class="page-link <?=$class?>"> <?=$i+1?></a>
          <?php 
          }else {?>
            <a class="page-link " href='/tonsores/solicitarturno/barbero?pag=<?=$i+1?>' > <?=$i+1?></a>
          <?php 
          } 
          ?>
        </li>
      <?php
      }?>
  </ul>
  </div>

<?php

    require_once '../views/components/cliente/seccion-barberos.php';

    if(isset($array['seccion-servicio'])){?>
        <?php require_once '../views/components/cliente/seccion-servicio.php';
    }
?>

<br>
<br>
<br>
<br>