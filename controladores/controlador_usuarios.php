<?php
// Este archivo actúa como un intermediario para las peticiones AJAX relacionadas con usuarios.
include '../clases/conexion.php';
include '../clases/usuarios.php';

// Verificamos que se haya enviado el parámetro 'operacion' para saber qué hacer.
if (isset($_REQUEST['operacion'])) {
    $datos_usuarios = new Usuarios();
    $msg = "Operación no encontrada";
    switch ($_REQUEST['operacion']) {
        case 1: // Insertar un nuevo usuario
            $rs = $datos_usuarios->insertUsuario(
                $_REQUEST['nombres'],
                $_REQUEST['apellidos'],
                $_REQUEST['direccion'],
                $_REQUEST['telefono'],
                $_REQUEST['depto'],
                $_REQUEST['municipio'],
                $_REQUEST['email'],
                $_REQUEST['usuario'],
                $_REQUEST['contrasena'],
                $_REQUEST['tipoUsuario']
            );
            echo $rs;
            break;

        case 2: // Actualizar un usuario existente
            // CORREGIDO: El nombre del parámetro de departamento debe coincidir con el del formulario.
            $rs = $datos_usuarios->updateUsuario(
                $_REQUEST['id_usuario'],
                $_REQUEST['nombres'],
                $_REQUEST['apellidos'],
                $_REQUEST['direccion'],
                $_REQUEST['telefono'],
                $_REQUEST['departamento'], // Antes era 'depto', ahora es 'departamento'.
                $_REQUEST['municipio'],
                $_REQUEST['email'],
                $_REQUEST['usuario'],
                $_REQUEST['contrasena'],
                $_REQUEST['tipoUsuario']
            );
            echo $rs; // Devuelve 1 si tuvo éxito, 0 si falló.
            break;

        default:
            echo $msg;
            break;
    }
}

