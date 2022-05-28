<?php 
  $active = isset($array['active']) ? $array['active'] : '';
?>

<link rel="stylesheet" href="public/css/navbar.css">


<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark px-2">
    <div class="container-fluid">  
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <?php if(isset($_SESSION['user'])){?>
              <strong> <a class="nav-link <?php if($active == 'sesion') echo 'active' ?>" href="/tonsores/login"> HOME </a></strong>
            <?php
            }else{?>
              <strong> 
                <a class="nav-link <?php if($active == 'Inicio') echo 'active'?> " href="/tonsores/" > 
                TONSORES 
                </a> 
              </strong>
            <?php }?>
          </li>
          <li class="nav-item">
            <strong> <a class="nav-link <?php if($active == 'Servicios') echo 'active'?>" aria-current="page" href="/tonsores/servicios">Servicios</a></strong>
          </li>
          <li class="nav-item">
            <strong> <a class="nav-link <?php if($active == 'Contacto') echo 'active'?>" aria-current="page" href="/tonsores/contacto">Contacto</a> </strong>
          </li>
          <li class="nav-item">
            <strong> <a class="nav-link <?php if($active == 'Gana Puntos') echo 'active'?>" aria-current="page" href="/tonsores/ganapuntos">Ganá Puntos</a> </strong>
          </li>
          
        </ul>

          

        

        <?php 
          if(isset($_SESSION['user'])){?>
              <li class="nav-item dropdown d-flex navbar-nav mx-3 " aria-current="page">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="http://localhost/tonsores/public/uploads/image/img_perfil/<?=$_SESSION['user']['imagen_perfil']?>" class="borber rounded-circle mx-2" alt="" width="35" height="29">
                  <strong> <?=strtoupper($_SESSION['user']['name'])?> </strong>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li class="border-bottom">
                    <a class="dropdown-item" href="/tonsores/configuracion">
                      <i class="bi bi-gear">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 20 20">
                        <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                        <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                      </svg>
                      Configuración
                      </i>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/tonsores/login?action=logout">
                      <i class="bi bi-box-arrow-in-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-left" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                          <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                        </svg>
                        Cerrar Sesión
                      </i>
                    </a>
                  </li>
                </ul>
              </li>
          <?php
          }else{?>
              <a type="button" class="btn btn-outline-light border rounded-pill" aria-current="page" href="/tonsores/login">
                <i class="bi bi-box-arrow-in-right">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                  </svg>
                </i>
                Iniciar Sesión
              </a>
          <?php } 
        ?>

        

      </div>
  </div>
</nav>


