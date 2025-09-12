<?php
// Incluimos las clases necesarias para la conexión y las operaciones de usuario.
include 'clases/conexion.php';
include 'clases/usuarios.php';

// Creamos un objeto de la clase Usuarios.
$usuario_obj = new Usuarios();
// Llamamos al método usuarios() para obtener la lista completa de usuarios de la base de datos.
// Este método ahora incluye los nombres del departamento y municipio gracias a los JOINs en la consulta SQL.
$lista_usuarios = $usuario_obj->usuarios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Clínica</title>
    <!-- CSS de Bootstrap para los estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap para los botones -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Lista de Usuarios</h1>
            <!-- Botón que lleva al formulario para agregar nuevos usuarios -->
            <a href="vistas/agregar.php" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-2"></i>Agregar Usuario
            </a>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Usuario</th>
                                <th>Departamento</th>
                                <th>Municipio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lista_usuarios)): ?>
                                <!-- Si hay usuarios, recorremos el array para mostrar cada uno en una fila -->
                                <?php foreach ($lista_usuarios as $usuario): ?>
                                    <tr>
                                        <!-- Usamos htmlspecialchars() para prevenir ataques XSS al mostrar los datos -->
                                        <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['nombres']); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['departamento']); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['municipio']); ?></td>
                                        <td>
                                            <!-- BOTÓN EDITAR: Este es el enlace clave. Pasa el ID del usuario a editar.php -->
                                            <a href="vistas/editar.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <!-- Botón de eliminar (funcionalidad a futuro) -->
                                            <a href="#" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Si no hay usuarios, mostramos un mensaje -->
                                <tr>
                                    <td colspan="7" class="text-center">No hay usuarios registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>