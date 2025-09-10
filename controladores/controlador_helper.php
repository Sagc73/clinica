<?php
include '../clases/conexion.php';
include '../clases/helper.php';

if (isset($_REQUEST['operacion'])) {
    $datos_helper = new Helper();
    $msg = "Selección no encontrada";
    switch ($_REQUEST['operacion']) {
        case 1:
            $rs = $datos_helper->vistaMunicipios($_REQUEST['depto_id']);
            echo $rs;
            break;
        
        default:
            echo $msg;
            break;
    }
}
