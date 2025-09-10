<?php
class Usuarios extends Conexion
{
    public function usuarios()
    {
        $sql = "SELECT * FROM usuarios";
        $conx = parent::conx_pdo();
        $stm = $conx->prepare($sql);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function select_usuario($id)
    {
        $sql = "SELECT * FROM usuarios WHERE estado = 1 AND id_usuario = $id";
        $conx = parent::conx_pdo();
        $stm = $conx->prepare($sql);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function insertUsuario($nombres = null, $apellidos = null, $direccion = null, $telefono = null, $departamento = null, $municipio = null, $email = null, $usuario = null, $contrasena = null, $tipoUsuario = null)
    {
         $contrasena = md5($contrasena);
         $nombres = mb_convert_encoding($nombres, 'UTF-8', 'ISO-8859-1');
         $apellidos = mb_convert_encoding($apellidos, 'UTF-8', 'ISO-8859-1');
         $direccion = mb_convert_encoding($direccion, 'UTF-8', 'ISO-8859-1');
        #echo $nombres.' '.$apellidos.' '.$direccion.' '.$telefono.' '.$departamento.' '.$municipio.' '.$email.' '.$usuario.' '.$contrasena.' '.$tipoUsuario;
        try {
            $sql = "INSERT INTO usuarios (nombres, apellidos, direccion, departamento_id, municipio_id, telefono, email, usuario, password, tipousuario_id, creado)
                VALUES ('$nombres', '$apellidos', '$direccion', $departamento, $municipio, '$telefono', '$email', '$usuario', '$contrasena', $tipoUsuario, NOW())";
            $conx = parent::conx_pdo();
            $stm = $conx->prepare($sql);
            $stm->execute();
            return 1;
        } catch (PDOException $e) {
            return 0;
            #return $e->getMessage();
        }
       
        

    }
}