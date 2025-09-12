<?php
include '../clases/conexion.php';
include '../clases/usuarios.php';
include '../clases/helper.php';

$data = new Helper();
$usuario_obj = new Usuarios();
$usuario_data;
/*
// Verificamos que se haya pasado un ID en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario_editar = $_GET['id'];
    // Obtenemos los datos del usuario usando el método modificado
    $usuario_data = $usuario_obj->select_usuario($id_usuario_editar);

    // Si no encontramos al usuario, detenemos la ejecución
    if (!$usuario_data) {
        die("Error: Usuario no encontrado.");
    }
} else {
    die("Error: ID de usuario no válido o no proporcionado.");
}*/
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-lg rounded-3">
            <div class="card-header bg-success text-white text-center">
                <!-- Título cambiado -->
                <h4 class="mb-0">Edición de Usuario</h4>
            </div>
            <div class="card-body">
                <!-- El ID del formulario se mantiene para reutilizar el JS -->
                <form name="frm2" method="post" id="frm2">
                    
                    <!-- Campo oculto para enviar el ID del usuario que se está editando -->
                    <input type="hidden" id="id_usuario" value="<?php echo json_decode($usuario_data['id_usuario']); ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombres" class="form-label">Nombres</label>
                            <!-- Usamos 'value' para rellenar el campo con los datos del usuario -->
                            <input type="text" class="form-control" id="nombres" value="<?php json_decode($usuario_data['nombres'])?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" value="<?php echo json_decode($usuario_data['apellidos']); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" value="<?php echo json_decode($usuario_data['direccion']); ?>" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <select class="form-select" id="departamento" required>
                                <option disabled value="">Seleccione un departamento</option>
                                <?php echo $data->vistaDepartamentos(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="municipio" class="form-label">Municipio</label>
                            <select class="form-select" id="municipio" required>
                                <!-- Los municipios se cargarán con AJAX -->
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" value="<?php echo json_decode($usuario_data['telefono']); ?>" pattern="[0-9]{4}-[0-9]{4}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($usuario_data['email']); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" value="<?php echo htmlspecialchars($usuario_data['usuario']); ?>" minlength="4" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <!-- La contraseña no se precarga por seguridad -->
                            <input type="password" class="form-control" id="contrasena" placeholder="Dejar en blanco para no cambiar" minlength="6">
                            <div class="form-text">Si no desea cambiar la contraseña, deje este campo vacío.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tipoUsuario" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" id="tipoUsuario" required>
                            <option disabled value="">Seleccione un tipo de usuario</option>
                            <option value="1">Administrador</option>
                            <option value="2">Recepcionista</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="../index.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Script para activar validaciones de Bootstrap
        (function() {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <!-- Incluimos un nuevo archivo JS para la lógica de edición -->
    <script type="text/javascript" src="../js/edicion.js"></script>
</body>

</html>
