<link rel="stylesheet" href="public/css/jefe/home.css">

<h4 class="text-center mt-2">Hola <?= $_SESSION['user']['name']." ". $_SESSION['user']['lastname']?> </h4>
<hr>

<p> 
    <?php  
        if(isset($array['restringir_acceso']))
          echo $array['restringir_acceso'];
    ?> 
</p>

<div class="container text-center">

    <div class="container mb-3">
        <a href="/tonsores/seccion/empleados" class="btn btn-outline-dark btn-lg rounded-pill"> Sección empleados </a>
    </div>

    <div class="container mb-3">
        <a href="/tonsores/seccion/servicios" class="btn btn-outline-dark btn-lg rounded-pill"> Sección servicios </a>
    </div>

    <div class="container mb-3">
        <a href="" class="btn btn-outline-dark btn-lg rounded-pill"> Sección descuentos </a>
    </div>

    <div class="container mb-3">
        <a href="" class="btn btn-outline-dark btn-lg rounded-pill"> Sección horarios </a>
    </div>

</div>











