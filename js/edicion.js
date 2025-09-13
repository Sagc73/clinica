$(document).ready(function () {

    // Precargar selecciones al cargar la página
    if (tipoUsuario) {
        $("#tipoUsuario").val(tipoUsuario);
    }

    if (deptoUsuario) {
        $("#departamento").val(deptoUsuario);
        $("#departamento").trigger("change");
    }

    // Carga dinámica de municipios
    $("#departamento").on("change", function () {
        let depto_id = $(this).val();
        if (!depto_id) return;

        $.ajax({
            url: "../controladores/controlador_helper.php",
            type: "POST",
            dataType: "html",
            data: { operacion: 1, depto_id: depto_id },
        })
        .done(function (respuesta) {
            $("#municipio").html(respuesta);
            
            // Preseleccionar municipio después de cargar
            if (municipioUsuario) {
                $("#municipio").val(municipioUsuario);
            }
        })
        .fail(function () {
            alert("Error: No se pudieron cargar los municipios.");
        });
    });

    // Envío del formulario de actualización
    $("#frm2").on("submit", function (e) {
        e.preventDefault();

        let formData = {
            operacion: 2,
            id_usuario: $("#id_usuario").val(),
            nombres: $("#nombres").val(),
            apellidos: $("#apellidos").val(),
            direccion: $("#direccion").val(),
            telefono: $("#telefono").val(),
            email: $("#email").val(),
            usuario: $("#usuario").val(),
            contrasena: $("#contrasena").val(),
            tipoUsuario: $("#tipoUsuario").val(),
            departamento: $("#departamento").val(),
            municipio: $("#municipio").val()
        };

        $.ajax({
            url: "../controladores/controlador_usuarios.php",
            type: "POST",
            dataType: "html",
            data: formData,
        })
        .done(function (respuesta) {
            if (respuesta.trim() === "1") {
                alert("Usuario actualizado con éxito.");
                window.location.href = "../index.php";
            } else {
                alert("Error al actualizar el usuario. Respuesta: " + respuesta);
            }
        })
        .fail(function () {
            alert("Error de comunicación con el servidor.");
        });
    });
});