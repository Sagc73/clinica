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

    public function updateUsuario($id_usuario,$nombres,$apellidos,$direccion,$telefono,$departamento,$municipio,$email,$usuario,$contrasena,$tipousuario){
        try {
            $sql = "UPDATE usuarios SET nombres=?, apellidos=?, direccion=?, departamento_id=?, municipio_id=?, telefono=?, email=?, usuario=?, tipousuario_id=?";
            #logica para actualizar la contraseña solo llegase a proporcionar una nueva
            if(!empty($contrasena)){
                $sql.=", password = ?";
            }
            #Continua la consulta sql
            $sql .= "WHERE id_usuario = ?";
            $conn = parent::conx_pdo();
            $stm = $conn->prepare($sql);
            #asignando los valores a los palcerholders
            $stm->bindValue(1, mb_convert_encoding($nombres, 'UTF-8', 'ISO-8859-1'));
            $stm->bindValue(2, mb_convert_encoding($apellidos, 'UTF-8', 'ISO-8859-1'));
            $stm->bindValue(3, mb_convert_encoding($direccion, 'UTF-8', 'ISO-8859-1'));
            $stm->bindValue(4, $departamento);
            $stm->bindValue(5, $municipio);
            $stm->bindValue(6, $telefono);
            $stm->bindValue(7, $email);
            $stm->bindValue(8, $usuario);
            $stm->bindValue(9, $tipousuario);
            #si la contraseña no esta vacia, se encripta y la añadimos a la consulta
            $paramIndex = 10;
            if(!empty($contrasena)){
                $stm->bindValue($paramIndex, md5($contrasena));
                $paramIndex++;
            }
            #finalizando, añadimos el ID del usuario
            $stm->execute();
            return 1;#exito en la transferencia de datos
        } catch (PDOException $e) {
            return 0;##error en la transferencia de datos
        }
    }
}