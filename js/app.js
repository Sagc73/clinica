$("#departamento").on("change", function () {
    let depto_id = $("#departamento").val();
    $.ajax({
        url: "../controladores/controlador_helper.php",
        type: "POST",
        dataType: 'html',
        data: { operacion: 1, depto_id },
    }).done(function (respuesta) {
        $("#municipio").html('');
        if (respuesta) {
            $("#municipio").append(respuesta);
        } else {

        }
    });
});

$("#frm1").on("submit", function (e) {
    e.preventDefault();
    let depto = $("#departamento").val();
    let municipio = $("#municipio").val();
    let nombres = $("#nombres").val();
    let apellidos = $("#apellidos").val();
    let direccion = $("#direccion").val();
    let telefono = $("#telefono").val();
    let email = $("#email").val();
    let usuario = $("#usuario").val();
    let contrasena = $("#contrasena").val();
    let tipoUsuario = $("#tipoUsuario").val();
    $.ajax({
        url: "../controladores/controlador_usuarios.php",
        type: "POST",
        dataType: 'html',
        data: { operacion: 1, nombres, apellidos, direccion, telefono, email, depto, municipio, usuario, contrasena, tipoUsuario },
    }).done(function (respuesta) {
        if(respuesta.trim() === "1"){
            alert("Usuario registrado con éxito.");
            window.location.href = "../index.php";
        }else{
            alert("Error al registrar el usuario."+respuesta);
        }
    }); 
});