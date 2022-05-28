<link rel="stylesheet" href="public/css/ganapuntos.css">

<p class="title text-center mt-3"> GANÁ PUNTOS</p>
<hr>

<div class="container d-flex justify-content-around">

    <div class="container  border-start p-3" style="width: 55%;">
        <p> <span class="span">#GanaPuntos</span>  es un programa que Tonsores Barbería utiliza para beneficiar y recompensar tu fidelidad y lealtad. </p>
        <hr>
        <p class="text-center"> <span class="subtitle"> ¿Cómo funciona? </span>  ¡Muy sencillo! </p>
        <p>Una vez resgistrado en Tonsores Barbería, por el solo hecho de solicitar turnos y asistir, irás acumulando puntos que luego puedes canjear para obtener un saldo a favor. </p>
        <p>Dependiendo de los <a href="/tonsores/servicios"> servicios </a> que solicites, son los puntos que acumulas.</p>
    </div>

    <div class="container border-bottom border-end p-2 mx-3" style="width: 45%;">
        <p class="text-center subtitle">¿Cómo registrarse?</p>
        <p>¡Es GRATIS, fácil y sencillo! <a href="/tonsores/create/user">REGISTRATE haciendo click acá.</a></p>
        <p>Al registrarte también podras acudir a distintas promociones.</p>
        <p class="text-center"> <span onclick="mostrarPromociones()" style="cursor: pointer;" id="promo"> Ver promociones </span> </p>
        <div class=" text-center" style="display: none;" id="promociones"> 
                    <?php
                    foreach($array['promociones'] as $promocion){?>
                    <p class="p2">
                        <i class="bi bi-chevron-double-right">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                                    <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </i>
                        Seleccionando <?=$promocion['cant_servicios']?> servicios obtienes un descuento del <?=$promocion['descuento']?>%
                        </p>
                    <?php 
                    }
                    ?>
                </div>
        <div class="container mt-3 d-flex flex-column text-end p-5">
            <span class="title1">TONSORES</span>
            <span class="subtitle1">ENCUENTRA TU ESTILO</span>

        </div>
    </div>

</div>

<script type="text/javascript">
    function mostrarPromociones(){
        const promociones = document.getElementById('promociones');
        const msj_promo = document.getElementById('promo');
        if(promociones.style.display == 'none'){
            promociones.style.display = 'block';
            msj_promo.innerHTML = "Ocultar promociones";
        }else{
            promociones.style.display = 'none';
            msj_promo.innerHTML = "Ver promociones";
        }
    }

</script>