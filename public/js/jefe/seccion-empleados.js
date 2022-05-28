//Al hacer click en alguno de los empleados redirige
const selectElement = document.querySelector('.empleados');
//Añado un evento
selectElement.addEventListener('change', redireccionar); 
//Redirecciono
function redireccionar(){ 
    window.location.href = "/tonsores/seccion/empleados?id="+selectElement.value;
}

//Funcion para ocultar y mostrar el empleado
function agregarEmpleado(){
    const selectElement = document.querySelector('.opciones');
    //Añado un evento
    selectElement.addEventListener('change', (event) => {
    const formulario_barbero = document.getElementById('agregar_barbero');
    const formulario_secretario = document.getElementById('agregar_secretario');


    if(selectElement.value=='empleado'){
        if(formulario_secretario.style.display == "block"){
                formulario_secretario.style.display = "none";
        }
        if(formulario_barbero.style.display == "none"){
            formulario_barbero.style.display = "block";
        }    
    }else{
        if(formulario_barbero.style.display == "block"){
            formulario_barbero.style.display = "none";
        }
        if(formulario_secretario.style.display == "none"){
            formulario_secretario.style.display = "block";
        }

    }   
    
});


    const form_agregar = document.getElementById('form_agregar');
    if(form_agregar.style.display == 'none'){
        form_agregar.style.display = 'block';
        flecha_agregar.innerHTML="⇱";

    }else{
        form_agregar.style.display = 'none';
        flecha_agregar.innerHTML="⇲";
    }
}   

function eliminarEmpleado(){
    const form_eliminar = document.getElementById('form_eliminar');
    if(form_eliminar.style.display == 'none'){
        form_eliminar.style.display = 'block';
        flecha_eliminar.innerHTML="⇱";

    }else{
        form_eliminar.style.display = 'none';
        flecha_eliminar.innerHTML="⇲";
    }
}
