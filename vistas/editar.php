<?php
// Incluimos las clases necesarias.
include '../clases/conexion.php';
include '../clases/usuarios.php';
include '../clases/helper.php';

// Creamos los objetos necesarios.
$data_helper = new Helper();
$usuario_obj = new Usuarios();
$usuario_data = null; // Inicializamos la variable para evitar errores.

// --- LÓGICA PARA CARGAR LOS DATOS DEL USUARIO ---
// 1. Verificamos que se haya pasado un ID numérico en la URL (ej: editar.php?id=5).
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario_editar = $_GET['id'];

    // 2. Obtenemos los datos del usuario usando el método seguro y corregido.
    $usuario_data = $usuario_obj->select_usuario($id_usuario_editar);

    // 3. Si el método no devuelve un usuario (porque el ID no existe), detenemos y mostramos un error.
    if (!$usuario_data) {
        die("Error: Usuario no encontrado o no válido.");
    }
} else {
    // Si no se proporciona un ID, no podemos editar.
    die("Error: Se requiere un ID de usuario para la edición.");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg rounded-3">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Edición de Usuario</h4>
            </div>
            <div class="card-body p-4">
                <form name="frm2" method="post" id="frm2">

                    <!-- Campo oculto con el ID del usuario que se está editando. Es crucial para la consulta UPDATE. -->
                    <input type="hidden" id="id_usuario"
                        value="<?php echo htmlspecialchars($usuario_data['id_usuario']); ?>">

                    <!-- Rellenamos los campos de texto con los datos obtenidos de la base de datos -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres"
                                value="<?php echo htmlspecialchars($usuario_data['nombres']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos"
                                value="<?php echo htmlspecialchars($usuario_data['apellidos']); ?>" required>
                        </div>
                    </div>

                    <!-- Más campos de texto rellenados -->
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion"
                            value="<?php echo htmlspecialchars($usuario_data['direccion']); ?>" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <select class="form-select" id="departamento" required>
                                <option disabled value="">Seleccione un departamento</option>
                                <?php echo $data_helper->vistaDepartamentos(); /* PHP carga la lista de todos los deptos */ ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="municipio" class="form-label">Municipio</label>
                            <select class="form-select" id="municipio" required>
                                <option disabled value="">Seleccione un departamento primero</option>
                                <!-- Este select se llenará dinámicamente con JavaScript/AJAX -->
                            </select>
                        </div>
                    </div>

                    <!-- ... resto de campos (teléfono, email, usuario) ... -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono"
                                value="<?php echo htmlspecialchars($usuario_data['telefono']); ?>"
                                pattern="[0-9]{4}-[0-9]{4}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email"
                                value="<?php echo htmlspecialchars($usuario_data['email']); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario"
                                value="<?php echo htmlspecialchars($usuario_data['usuario']); ?>" minlength="4"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="contrasena" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="contrasena"
                                placeholder="Dejar en blanco para no cambiar" minlength="6">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tipoUsuario" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" id="tipoUsuario" required>
                            <option disabled value="">Seleccione un tipo</option>
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

    <!-- Librería jQuery (necesaria para AJAX) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- =================================================================== -->
    <!--          PUENTE DE DATOS: PASANDO VALORES DE PHP A JAVASCRIPT         -->
    <!-- =================================================================== -->
    <script>
        // Aquí PHP "imprime" los IDs del usuario actual como variables de JavaScript.
        // json_encode() convierte los valores de PHP a un formato que JavaScript entiende de forma segura.
        const deptoUsuario = <?php echo json_encode($usuario_data['departamento_id']); ?>;
        const municipioUsuario = <?php echo json_encode($usuario_data['municipio_id']); ?>;
        const tipoUsuario = <?php echo json_encode($usuario_data['tipousuario_id']); ?>;
    </script>

    <!-- Nuestro script personalizado que usará las variables de arriba -->
    <script type="text/javascript" src="../js/edicion.js"></script>
</body>

</html>