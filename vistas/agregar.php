<?php
include '../clases/conexion.php';
include '../clases/usuarios.php';
include '../clases/helper.php';

$data = new Helper();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>


<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-lg rounded-3">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Formulario de Registro</h4>
            </div>
            <div class="card-body">
                <!--<form class="needs-validation" novalidate>-->
                <form name="frm1" method="post" id="frm1">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" placeholder="Ingrese sus nombres" autocomplete="off" required>
                            <div class="invalid-feedback">Por favor ingrese sus nombres.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" placeholder="Ingrese sus apellidos" autocomplete="off" required>
                            <div class="invalid-feedback">Por favor ingrese sus apellidos.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" placeholder="Ingrese su dirección" autocomplete="off" required>
                        <div class="invalid-feedback">La dirección es obligatoria.</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <select class="form-select" id="departamento" required>
                                <option selected disabled value="">Seleccione un departamento</option>
                                <?php echo $data->vistaDepartamentos(); ?>
                            </select>
                            <div class="invalid-feedback">Seleccione un departamento.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="municipio" class="form-label">Municipio</label>
                            <select class="form-select" id="municipio" required>
                                <option selected disabled value="">Seleccione un municipio</option>
                                <?php echo $data->vistaMunicipios(); ?>
                            </select>
                            <div class="invalid-feedback">Seleccione un municipio.</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" placeholder="0000-0000"
                                pattern="[0-9]{4}-[0-9]{4}" autocomplete="off" required>
                            <div class="invalid-feedback">Ingrese un teléfono válido (formato: 0000-0000).</div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" placeholder="ejemplo@correo.com" autocomplete="off" required>
                            <div class="invalid-feedback">Ingrese un correo electrónico válido.</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" placeholder="Ingrese un usuario" minlength="4" required>
                            <div class="invalid-feedback">El usuario debe tener al menos 4 caracteres.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" placeholder="Ingrese su contraseña" minlength="6" required>
                            <div class="invalid-feedback">La contraseña debe tener al menos 6 caracteres.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tipoUsuario" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" id="tipoUsuario" required>
                            <option selected disabled value="">Seleccione un tipo de usuario</option>
                            <option value="1">Administrador</option>
                            <option value="2">Recepcionista</option>
                        </select>
                        <div class="invalid-feedback">Seleccione un tipo de usuario.</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Registrar</button>
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
    <script type="text/javascript" src="../js/app.js"></script>
</body>

</html>