// $(document).ready() asegura que el código se ejecute solo después de que toda la página (DOM) se haya cargado.
$(document).ready(function () {

    // ======================================================================
    // PARTE 1: PRE-SELECCIÓN DE DATOS AL CARGAR LA PÁGINA
    // ======================================================================
    // Las variables 'deptoUsuario', 'municipioUsuario' y 'tipoUsuario' fueron creadas
    // por PHP en el archivo editar.php y ahora están disponibles para nosotros aquí.

    // Preseleccionar el tipo de usuario.
    if (tipoUsuario) {
        $("#tipoUsuario").val(tipoUsuario);
    }

    // Preseleccionar el departamento del usuario.
    if (deptoUsuario) {
        $("#departamento").val(deptoUsuario);
        // ¡Este es un paso CRUCIAL!
        // Disparamos manualmente el evento 'change' del select de departamentos.
        // Esto hace que la lógica de la PARTE 2 se ejecute inmediatamente,
        // cargando los municipios del departamento preseleccionado.
        $("#departamento").trigger("change");
    }


    // ======================================================================
    // PARTE 2: CARGA DINÁMICA DE MUNICIPIOS (AJAX)
    // ======================================================================
    // Este evento se activa cada vez que el usuario selecciona un nuevo departamento.
    $("#departamento").on("change", function () {
        // Obtenemos el ID del departamento seleccionado.
        let depto_id = $(this).val();
        // Si no hay un ID, no hacemos nada.
        if (!depto_id) return;

        // Aquí comienza la llamada AJAX. Es una comunicación asíncrona con el servidor.
        $.ajax({
            url: "../controladores/controlador_helper.php", // El archivo PHP que procesará la petición.
            type: "POST",           // Método de envío.
            dataType: "html",       // El tipo de datos que esperamos de vuelta (fragmentos de <option>).
            data: { operacion: 1, depto_id: depto_id }, // Los datos que enviamos al servidor.
        })
        .done(function (respuesta) {
            // .done() se ejecuta si la llamada AJAX tuvo éxito.
            // La 'respuesta' contiene el HTML (<option>...) generado por el controlador.
            $("#municipio").html(respuesta);
            
            // Después de cargar los municipios, intentamos preseleccionar el que le corresponde al usuario.
            // Esto es importante para la carga inicial de la página.
            if (municipioUsuario) {
                $("#municipio").val(municipioUsuario);
            }
        })
        .fail(function () {
            // .fail() se ejecuta si hubo un error de red o del servidor.
            alert("Error: No se pudieron cargar los municipios.");
        });
    });


    // ======================================================================
    // PARTE 3: ENVÍO DEL FORMULARIO PARA ACTUALIZAR (AJAX)
    // ======================================================================
    // Capturamos el evento 'submit' del formulario.
    $("#frm2").on("submit", function (e) {
        // e.preventDefault() evita que el formulario se envíe de la manera tradicional (recargando la página).
        e.preventDefault();

        // Creamos un objeto para agrupar todos los datos del formulario.
        // Es más limpio que enviar variables sueltas.
        let formData = {
            operacion: 2, // Indicamos al controlador que queremos actualizar.
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

        // Segunda llamada AJAX, esta vez para enviar los datos y actualizar.
        $.ajax({
            url: "../controladores/controlador_usuarios.php",
            type: "POST",
            dataType: "html",
            data: formData, // Enviamos el objeto con todos los datos.
        })
        .done(function (respuesta) {
            // La respuesta del servidor debería ser "1" si todo salió bien.
            if (respuesta.trim() === "1") {
                alert("Usuario actualizado con éxito.");
                // Redirigimos al usuario de vuelta a la lista principal.
                window.location.href = "../index.php";
            } else {
                // Si la respuesta no es "1", mostramos el error que nos devolvió el servidor.
                alert("Error al actualizar el usuario. Respuesta del servidor:\n" + respuesta);
            }
        })
        .fail(function () {
            alert("Error de comunicación con el servidor. No se pudo actualizar.");
        });
    });
});