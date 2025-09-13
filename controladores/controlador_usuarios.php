<?php
// MultipleFiles/controlador_usuarios.php - Versión mejorada
include '../clases/conexion.php';
include '../clases/usuarios.php';

if (isset($_REQUEST['operacion'])) {
    $datos_usuarios = new Usuarios();
    $msg = "Operación no encontrada";
    
    switch ($_REQUEST['operacion']) {
        case 1: // Insertar
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

        case 2: // Actualizar
            $rs = $datos_usuarios->updateUsuario(
                $_REQUEST['id_usuario'],
                $_REQUEST['nombres'],
                $_REQUEST['apellidos'],
                $_REQUEST['direccion'],
                $_REQUEST['telefono'],
                $_REQUEST['departamento'],
                $_REQUEST['municipio'],
                $_REQUEST['email'],
                $_REQUEST['usuario'],
                $_REQUEST['contrasena'],
                $_REQUEST['tipoUsuario']
            );
            echo $rs;
            break;

        default:
            echo $msg;
            break;
    }
}