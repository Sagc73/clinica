<?php
class Usuarios extends Conexion
{
    /**
     * Obtiene todos los usuarios con sus respectivos nombres de departamento y municipio.
     * Se usa LEFT JOIN para asegurar que si un usuario no tiene depto/municipio, igual aparezca.
     */
    public function usuarios()
    {
        $sql = "SELECT u.*, d.departamento, m.municipio 
                FROM usuarios u
                LEFT JOIN departamentos d ON u.departamento_id = d.id_departamento
                LEFT JOIN municipios m ON u.municipio_id = m.id_municipio
                ORDER BY u.nombres, u.apellidos";
        $conx = parent::conx_pdo();
        $stm = $conx->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene los datos de UN SOLO usuario por su ID.
     * CORREGIDO: Usa una sentencia preparada para seguridad y fetch() para eficiencia.
     */
    public function select_usuario($id)
    {
        // El placeholder :id_usuario previene inyección SQL.
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
        $conx = parent::conx_pdo();
        $stm = $conx->prepare($sql);
        // Vinculamos el valor del ID al placeholder.
        $stm->bindParam(':id_usuario', $id, PDO::PARAM_INT);
        $stm->execute();
        // Usamos fetch() en lugar de fetchAll() porque solo esperamos un resultado. Es más rápido.
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza los datos de un usuario en la base de datos.
     * CORREGIDO: Reescrito para usar sentencias preparadas con un array de parámetros,
     * lo cual es mucho más limpio, seguro y fácil de mantener.
     */
    public function updateUsuario(
        $id_usuario, 
        $nombres, 
        $apellidos, 
        $direccion, 
        $telefono, 
        $departamento, 
        $municipio, 
        $email, 
        $usuario, 
        $contrasena, 
        $tipousuario){
        try {
            // Esto hace el código más legible que usar bindValue() múltiples veces.
            $params = [
                ':nombres' => mb_convert_encoding($nombres, 'UTF-8', 'ISO-8859-1'),
                ':apellidos' => mb_convert_encoding($apellidos, 'UTF-8', 'ISO-8859-1'),
                ':direccion' => mb_convert_encoding($direccion, 'UTF-8', 'ISO-8859-1'),
                ':departamento' => $departamento,
                ':municipio' => $municipio,
                ':telefono' => $telefono,
                ':email' => $email,
                ':usuario' => $usuario,
                ':tipousuario' => $tipousuario,
                ':id_usuario' => $id_usuario
            ];

            // 2. Construimos la consulta SQL base.
            $sql = "UPDATE usuarios SET 
                        nombres = :nombres, 
                        apellidos = :apellidos, 
                        direccion = :direccion, 
                        departamento_id = :departamento, 
                        municipio_id = :municipio, 
                        telefono = :telefono, 
                        email = :email, 
                        usuario = :usuario, 
                        tipousuario_id = :tipousuario";

            // 3. Lógica para actualizar la contraseña SÓLO si se proporciona una nueva.
            if (!empty($contrasena)) {
                $sql .= ", password = :password"; // Añadimos la parte de la contraseña a la consulta.
                $params[':password'] = md5($contrasena); // Añadimos la contraseña al array de parámetros.
            }

            // 4. Finalizamos la consulta SQL.
            $sql .= " WHERE id_usuario = :id_usuario";

            $conn = parent::conx_pdo();
            $stm = $conn->prepare($sql);

            // 5. Ejecutamos la consulta pasando el array completo de parámetros. PDO se encarga del resto.
            $stm->execute($params);

            return 1; // Devolvemos 1 para indicar éxito.
        } catch (PDOException $e) {
            // En producción, es bueno registrar el error: error_log($e->getMessage());
            return 0; // Devolvemos 0 para indicar un error.
        }
    }
    // ... tu método insertUsuario() permanece aquí sin cambios ...
    public function insertUsuario($nombres = null, $apellidos = null, $direccion = null, $telefono = null, $departamento = null, $municipio = null, $email = null, $usuario = null, $contrasena = null, $tipoUsuario = null)
    {
        $contrasena = md5($contrasena);
        $nombres = mb_convert_encoding($nombres, 'UTF-8', 'ISO-8859-1');
        $apellidos = mb_convert_encoding($apellidos, 'UTF-8', 'ISO-8859-1');
        $direccion = mb_convert_encoding($direccion, 'UTF-8', 'ISO-8859-1');
        try {
            $sql = "INSERT INTO usuarios (nombres, apellidos, direccion, departamento_id, municipio_id, telefono, email, usuario, password, tipousuario_id, creado)
                VALUES ('$nombres', '$apellidos', '$direccion', $departamento, $municipio, '$telefono', '$email', '$usuario', '$contrasena', $tipoUsuario, NOW())";
            $conx = parent::conx_pdo();
            $stm = $conx->prepare($sql);
            $stm->execute();
            return 1;
        } catch (PDOException $e) {
            return 0;
        }
    }
}

?>