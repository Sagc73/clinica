<?php  
    
    include '../clases/conexion.php';
    include '../clases/usuarios.php';
    include '../clases/helper.php';
    #instancias de clases
    $data = new Helper();
    $usuarios_obj = new Usuarios();
    #variables para almacenar datos del usuario
    $usuarios_data = null;
    $id_usuario_edit = null;

    #verificando si se recibe el id por get
    if(isset($_REQUEST['id'] ) && is_numeric($_REQUEST['id'])){
       $id_usuario_edit = $_REQUEST['id'];
       #obteniendo los datos del usuario data base
       $usuarios_data = $usuarios_obj->select_usuario($id_usuario_edit);
       if(!$usuarios_data){
         die("Error: Usuario no encontrado.!");
       }
    }else{
        die("Error: ID de usuario no proporcionado.!");
    }
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
                <h4 class="mb-0">Formulario de Edición</h4>
            </div>
            <div class="card-body">
                <!-- El action del form enviará los datos a un script que procese la actualización. -->
                <form name="frm1" method="post" id="frm1" action="procesar_edicion.php">
                
                    <!-- 3. CAMPO OCULTO PARA ENVIAR EL ID -->
                    <!-- Es crucial para que el backend sepa qué registro actualizar. -->
                    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario_data['id']); ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombres" class="form-label">Nombres</label>
                            <!-- 4. RELLENAR LOS CAMPOS CON LOS DATOS OBTENIDOS -->
                            <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo htmlspecialchars($usuario_data['nombres']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario_data['apellidos']); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario_data['direccion']); ?>" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <!-- El valor del departamento se seleccionará con JavaScript más abajo -->
                            <select class="form-select" id="departamento" name="departamento" required>
                                <option selected disabled value="">Seleccione un departamento</option>
                                <?php echo $data->vistaDepartamentos(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="municipio" class="form-label">Municipio</label>
                            <select class="form-select" id="municipio" name="municipio" required>
                                <option selected disabled value="">Seleccione un municipio</option>
                                <?php echo $data->vistaMunicipios(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario_data['telefono']); ?>" pattern="[0-9]{4}-[0-9]{4}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario_data['email']); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario_data['usuario']); ?>" minlength="4" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <!-- IMPORTANTE: Por seguridad, la contraseña no se debe precargar. -->
                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Dejar en blanco para no cambiar" minlength="6">
                            <small class="form-text text-muted">Si no desea cambiar la contraseña, deje este campo vacío.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tipoUsuario" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" id="tipoUsuario" name="tipoUsuario" required>
                            <option selected disabled value="">Seleccione un tipo de usuario</option>
                            <option value="1">Administrador</option>
                            <option value="2">Recepcionista</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // 5. evento click para llenar el Formulario
        document.addEventListener('DOMContentLoaded',function(){
            //obteniendo los id
            const departamentoId = <?php echo json_encode($usuario_data['id_departamento']); ?>
            const departamentoId = <?php echo json_encode($usuario_data['id_municipio']); ?>
            const departamentoId = <?php echo json_encode($usuario_data['id_tipousuario']); ?>

            // Si tenemos un ID de departamento, lo seleccionamos en el dropdown.
            if (departamentoId) {
                document.getElementById('departamento').value = departamentoId;
            }

            // Hacemos lo mismo para municipio y tipo de usuario.
            if (municipioId) {
                document.getElementById('municipio').value = municipioId;
            }

            if (tipoUsuarioId) {
                document.getElementById('tipoUsuario').value = tipoUsuarioId;
            }
        })
    </script>
</body>
</html>