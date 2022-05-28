function mostrarPassword(){

        //Mapeo el input
        var pass = document.getElementById("password");
        if(pass.type === "password"){
            pass.type ="text";
        }else{
            pass.type = "password";
        }
}