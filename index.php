<?php
include 'clases/conexion.php';
include 'clases/usuarios.php';

$obj = new Usuarios();
/*echo "<pre>";
print_r($obj->usuarios());
echo "</pre>";*/
$data = $obj->usuarios();

#echo $data[0]['nombres'];

print_r($obj->select_usuario(2));

?>