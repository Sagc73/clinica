<?php
class Helper extends Conexion
{
    public function municipios($depto_id)
    {
        $sql = "SELECT * FROM municipios WHERE departamento_id = $depto_id";
        $conx = parent::conx_pdo();
        $stm = $conx->prepare($sql);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function departamentos()
    {
        $sql = "SELECT * FROM departamentos";
        $conx = parent::conx_pdo();
        $stm = $conx->prepare($sql);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function sp_municipios($depto_id)
    {
        $sql = "CALL sp_municipios($depto_id)";
        $conx = parent::conx_pdo();
        $stm = $conx->prepare($sql);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function vistaMunicipios($depto_id = null)
    {
        $html = '';
        if(!isset($depto_id) || $depto_id == '')
        {
            #Si no está presente el valor del parámetro del departamento entoces tomará por defecto el valor de 6.
            #6 es el valor de San Salvador
            $depto_id = 6;
        }
        $municipios = $this->municipios($depto_id);
        foreach ($municipios as $v) {
            $id = $v['id_municipio'];
            $municipio =  mb_convert_encoding($v['municipio'], 'UTF-8', 'ISO-8859-1');
            #$municipio =  $v['municipio'];
            $html .= "<option value='$id'>$municipio</option>";
           
        }

        return $html;
    }

    public function vistaDepartamentos()
    {
        $html = '';
        $departamentos = $this->departamentos();
        foreach ($departamentos as $v) {
            $id = $v['id_departamento'];
            $departamento =  mb_convert_encoding($v['departamento'], 'UTF-8', 'ISO-8859-1');
            $html .= "<option value='$id'>$departamento</option>";
        }

        return $html;
    }

    public function spVistaMunicipios($depto_id = null)
    {
        $html = '';
        if(!isset($depto_id) || $depto_id == '')
        {
            #Si no está presente el valor del parámetro del departamento entoces tomará por defecto el valor de 6.
            #6 es el valor de San Salvador
            $depto_id = 6;
        }
        $municipios = $this->municipios($depto_id);
        foreach ($municipios as $v) {
            $id = $v['id'];
            $municipio =  mb_convert_encoding($v['municipio'], 'UTF-8', 'ISO-8859-1');
            $html .= "<option value='$id'>$municipio</option>";
           
        }

        return $html;
    }



    
}

?>