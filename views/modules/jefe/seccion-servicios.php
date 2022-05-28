<p class="h4 text-center mt-3 mb-4"> Sección servicios </p>

<div class="container mb-5">
    <table class="table text-center">
        <thead>
            <tr>
            <th scope="col">Id servicio</th>
            <th scope="col">Servicio</th>
            <th scope="col">Precio</th>
            <th scope="col">Puntos</th>
            <th scope="col">Solicitudes</th>
            <th scope="col">Editar</th>
            <th scope="col">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach($array['servicios'] as $servicio){?>
                    <tr>
                        <th scope="row"><?=$servicio['id']?></th>
                        <td><?=$servicio['servicio']?></td>
                        <td>$<?=$servicio['precio']?></td>
                        <td><?=$servicio['puntos']?></td>
                        <td><?=$servicio['cantidad']?></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpdate" id="btnUpdate" data-id="<?=$servicio['id']?>" data-servicio="<?=$servicio['servicio']?>" data-precio="<?=$servicio['precio']?>" data-puntos="<?=$servicio['puntos']?>" data-description="<?=$servicio['descripcion']?>" data-image="<?=$servicio['imagen']?>" >
                                <i class="bi bi-pencil-square">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </i>
                            </button>
                        </td>

                        <!--  Script para manejar los datos del modal update-->
                        <script>
                            $(document).on("click", "#btnUpdate", function(){
                                var id = $(this).data('id');
                                var servicio = $(this).data('servicio');
                                var precio = $(this).data('precio');
                                var puntos = $(this).data('puntos');
                                var description = $(this).data('description');
                                var image = $(this).data('image');

                                $("#id_num").val(id);
                                $("#id_servicio").val(servicio);
                                $("#id_precio").val(precio);
                                $("#id_puntos").val(puntos);
                                $("#id_description").val(description);
                                document.getElementById("id_image").src = "http://localhost/tonsores/public/uploads/image/servicios/"+image;                   
                            })
                        </script> 

                        <td>
                            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDelete" id="btnDelete" data-id="<?=$servicio['id']?>" data-servicio="<?=$servicio['servicio']?>" >
                                <i class="bi bi-trash3-fill">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                </i>
                            </button>
                        </td>

                        <!--  Script para manejar los datos del modal delete-->
                        <script>
                            $(document).on("click", "#btnDelete", function(){
                                var id = $(this).data('id');
                                var servicio = $(this).data('servicio');

                                $("#id_number").val(id);
                                document.getElementById("id_servicio_delete").innerHTML = servicio;
                                
                            })
                        </script>

                    </tr>
                <?php
                }
            ?>
        </tbody>
    </table>
</div>

<div class="container text-center">
    <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreate" id="btnCreate" id="boton_agregar_servicio">
        <i class="bi bi-file-earmark-plus">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/>
                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
            </svg>
        </i>  
        Agregar Servicio
    </button>
</div>

<div class="container mt-3">
    <p class="text-center text-danger h6"> <?=$array['mensaje']?> </p>
</div>

<!-- Modal delete -->
<div class="modal fade text-dark" id="modalDelete" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ATENCION !</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p> ¿Seguro  desea eliminar el servicio " <span id="id_servicio_delete"></span> " </p>
        </div>
        <div class="modal-footer p-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            <form action="/tonsores/seccion/servicios" method="POST">
                <input type="hidden" name="id" id="id_number">
                <input type="hidden" name="action" value="eliminar">
                <input type="submit" name="submit" class="btn btn-danger" value="Eliminar">
            </form>
        </div> 
    </div>
  </div>
</div>

<!-- Modal update -->
<div class="modal fade text-dark" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="exampleModalLabel">Editar Servicio <span id="id_empleado"></span> <span id="id_name_lastname"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/tonsores/seccion/servicios" method="POST" enctype="multipart/form-data">
            <div class="text-center">
                <img class="border rounded-circle" src="" alt="No se cargo la imagen" id="id_image" width="20%">
                <input type="file" class="form-control" name="imagen_servicio">
            </div>

            <div class="">
                <label for=""> Servicio </label>
                <input type="text" class="form-control" name="servicio" id="id_servicio">
            </div>

            <div class="">
                <label for="">Precio</label>
                <input type="number" class="form-control" name="precio" id="id_precio">
            </div>

            <div class="">
                <label for="">Puntos</label>
                <input type="number" class="form-control" name="puntos" id="id_puntos">
            </div>

            <div class="">
                <label for="">Descripcion</label>
                <textarea name="description" id="id_description" cols="30" rows=""  class="form-control"></textarea>
            </div>

            <input type="hidden" name="id" id="id_num">
            <input type="hidden" name="action" value="editar">

            <hr>

            <div class="text-center">
                <input type="submit" name="submit" class="btn btn-outline-primary"  value="Editar">
            </div>

        </form>
      </div>
      
    </div>
  </div>
</div>

<!-- Modal create -->
<div class="modal fade text-dark" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
        <div class="modal-body">
            <!-- Como vamos a enviar archivos(la imagen) debo agregar el enctype-->
            <form action="/tonsores/seccion/servicios" method="POST" enctype="multipart/form-data">
                <div class="">
                    <label for=""> Servicio </label>
                    <input type="text" class="form-control" name="servicio" required>
                </div>

                <div class="">
                    <label for="">Precio</label>
                    <input type="number" class="form-control" name="precio" required>
                </div>

                <div class="">
                    <label for="">Puntos</label>
                    <input type="number" class="form-control" name="puntos" required>
                </div>

                <div class="">
                    <label for="">Descripcion</label>
                    <textarea name="description" rows="5" class="form-control" required></textarea>
                </div>

                <div class="">
                    <label for="">Imagen</label>
                    <input type="file" class="form-control" name="imagen_servicio" size="20" required >
                </div>

                <input type="hidden" name="action" value="agregar">

                <hr>

                <div class="text-center">
                    <input type="submit" name="submit" class="btn btn-outline-primary"  value="Agregar">
                </div>

            </form>
        </div>
      
    </div>
  </div>
</div>

