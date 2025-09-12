$(document).ready(function () {
    //PRESELECCIONANDO EL DEPARTAMENTO DEL USUARIO
    if(depto){
        $("#departamento").val(depto);
        $("#departamento").trigger("change");
    }
    //preseleccionando el tipo de usuario
    if(tipoUsuario){
        $("#tipoUsuario").val(tipoUsuario);
    }

    //departamento y municipio cuando cambia un depto cambia el municipio
    $("#departamento").on("change", function(){
        let depto_id = $(this).val();
        $.ajax({
            url: "../controladores/controlador_helper.php",
            type: "POST",
            dataType: "html",
            data: { operacion: 1, depto_id},
        }).done(function(respuesta){
            $("#municipio").html(respuesta);
            //una ves cargados, preseleccionar los municipios y el selcccionar el usuario.
            if(municipio){
                $("municipio").val(municipio);
            }
        });
    });

    //formulario donde se envia la actualizacion via AJAX
    $("#frm2").on("submit", function(e){
        e.preventDefault();
        //recolectando datos del formulario editar.php
        let id_usuario = $("#id_usuario").val();
        let nombres = $("#nombres").val();
        let apellidos = $("#apellidos").val();
        let direccion = $("#direccion").val();
        let telefono = $("#telefono").val();
        let email = $("#email").val();
        let usuario = $("#usuario").val();
        let contrasena = $("#contrasena").val();
        let tipoUsuario = $("#tipoUsuario").val();
        let departamento = $("#departamento").val();
        let municipio = $("#municipio").val();

        //enviando la peticion ajax al controlador php con la operacion 2
        $.ajax({
            url: "../controladores/controlador_usuarios.php",
            type: "POST",
            dataType: "html",
            data: { operacion: 2, 
                id_usuario, 
                nombres, 
                apellidos, 
                direccion, 
                telefono, 
                email, 
                usuario, 
                contrasena, 
                tipoUsuario, 
                departamento, 
                municipio },
        }).done(function(respuesta){
            if(respuesta.trim() == "1"){
                alert("Usuario actualizado con exito");
                window.location.href = "../index.php";
            }else{
                alert("Error al actualizar el usuario: \n"+respuesta);
            }
        }).fail(function(){
            alert("Error de comunicacion con el servidor2");
        });
    });
});