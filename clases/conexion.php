<?php
class Conexion
{

    public function conx_pdo()
    {

        $conexion = null;
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=clinica;port=3306', 'root', 'root');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo "Error al realizar la conexión! Consultar con el administrador del sistema" . $ex->getMessage() . $ex->getLine();
            exit;
        }
        return $conexion;
    }
}
