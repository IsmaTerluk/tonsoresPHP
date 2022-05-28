<link rel="stylesheet" href="public/css/servicios.css">

<div class="container mt-2">
    <h4 style="font-family: 'Vast Shadow', cursive; font-size:6vh;" class="text-center">SERVICIOS </h4>
</div>

<div class="container d-flex flex-column justify-content-start">


<?php 

    foreach($array['servicios'] as $servicio){?>
        <div class="align-self-center m-4" style="width: 100%;">
            <div class="d-flex flex-row">        
                <div class="" style="width: 15%;">
                    <img src="http://localhost/tonsores/public/uploads/image/servicios/<?=$servicio['imagen']?>" class="border rounded-circle" alt="No se pudo cargar la imagen" width="100%">
                </div>
                <div class=" align-self-center px-3" style="width: 85%";>
                    <div class="" >
                        <h5 class=""  style="font-family: 'Train One', cursive; font-size:4vh;"><?=$servicio['servicio']?></h5>
                        <p class="" style="font-family:cursive; font-size:2.5vh;"> <strong>Precio: </strong>  $<?=$servicio['precio']?> </p>
                        <p class="" style="font-family:cursive; font-size:2.5vh;" >  <?=$servicio['descripcion']?></p>
                    </div>
                </div>
            </div> 
        </div>
        <hr>
    <?php
    }
?>

</div>
<br>