<link rel="stylesheet" href="../public/css/cliente/solicitar_turno.css">

<!-- Migas de pan o breadcrumb-->
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mt-2 mx-2">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a href="/tonsores/login" class="link">Inicio</a></li>
      <li class="breadcrumb-item"> <a href="/tonsores/solicitarturno/barbero" class="link">Barberos</a></li>
      <li class="breadcrumb-item"> <a href="javascript:enviar_formulario_servicio()" class="link"> Servicios</a></li>
        <?php if($array['seccion-confirmar']==false){?>
            <li class="breadcrumb-item selected" aria-current="page">Horarios</li>
        <?php
        }else{?>
            <li class="breadcrumb-item "> <a href="javascript:enviar_formulario_horario()" class="link">Horarios</a> </li>
            <li class="breadcrumb-item selected" aria-current="page">Confirmar</li>
    <?php
    }?>
  </ol>


        
<div class="d-flex ">
    <?php 

        $class = $array['class'];
        $disabled = $array['disabled'];

        include_once "../views/components/cliente/seccion-horario.php";

        if($array['seccion-confirmar']==True){?>
            <?php include_once "../views/components/cliente/seccion-confirmar.php";
        }else{?>
            <div class="container border invisible" style="width:50%;"></div>
        <?php
        }
    ?>

</div>