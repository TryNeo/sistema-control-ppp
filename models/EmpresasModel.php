<?php
require_once("./libraries/core/mysql.php");
class EmpresasModel extends Mysql
{

    public $int_id_empresa;
    public $str_ruc_empresa;
    public $str_nombre_empresa;
    public $str_direccion_empresa;
    public $str_correo_empresa;
    public $str_telefono_empresa;
    public $str_cedula_representante;
    public $str_nombre_representante;
    public $str_telefono_representante;
    public $str_descripcion_empresa;


    public function __construct()
    {
        parent::__construct();
    }


    public function selectEmpresas()
    {
        $sql = "SELECT id_empresa,ruc_empresa,nombre_empresa,
                            correo_empresa,nombre_representante,telefono_representante,estado
                    FROM Empresas
                    where estado=1 ORDER BY id_empresa DESC";
        $request = $this->select_sql_all($sql);
        return $request;
    }


    public function selectEmpresa(int $id_empresa){
        $this->int_id_empresa = $id_empresa;
        $sql = "SELECT id_empresa,ruc_empresa,nombre_empresa,direccion_empresa,correo_empresa,telefono_empresa,
        cedula_representante,nombre_representante,telefono_representante,descripcion_empresa FROM Empresas where id_empresa =$this->int_id_empresa";
        $request = $this->select_sql($sql);
        return $request;

    }

    public function insertEmpresa(
        string $ruc_empresa,
        string $nombre_empresa,
        string $direccion_empresa,
        string $correo_empresa,
        string $telefono_empresa,
        string $cedula_representante,
        string $nombre_representante,
        string $telefono_representante,
        string $descripcion_empresa
    ) {

        $this->str_ruc_empresa = $ruc_empresa;
        $this->str_nombre_empresa = $nombre_empresa;
        $this->str_direccion_empresa = $direccion_empresa;
        $this->str_correo_empresa = $correo_empresa;
        $this->str_telefono_empresa = $telefono_empresa;
        $this->str_cedula_representante = $cedula_representante;
        $this->str_nombre_representante = $nombre_representante;
        $this->str_telefono_representante = $telefono_representante;
        $this->str_descripcion_empresa = $descripcion_empresa;

        $sql = "SELECT ruc_empresa,cedula_representante FROM Empresas WHERE ruc_empresa = '{$this->str_ruc_empresa}' or cedula_representante = '{$this->str_cedula_representante}'
                and estado=1";
        $request = $this->select_sql_all($sql);
        if (empty($request)) {
            $sql = "INSERT INTO Empresas(ruc_empresa,nombre_empresa,direccion_empresa,correo_empresa,telefono_empresa,
                            cedula_representante,nombre_representante,telefono_representante,descripcion_empresa,estado,fecha_crea)
                        VALUES(?,?,?,?,?,?,?,?,?,1,now())";

            $arrData = array(
                $this->str_ruc_empresa,
                $this->str_nombre_empresa,
                $this->str_direccion_empresa,
                $this->str_correo_empresa,
                $this->str_telefono_empresa,
                $this->str_cedula_representante,
                $this->str_nombre_representante,
                $this->str_telefono_representante,
                $this->str_descripcion_empresa
            );

            $return = $this->insert_sql($sql, $arrData);
        } else {
            $return = 'exist';
        }
        return $return;
    }

    public function updateEmpresa(
        int $id_empresa,
        string $ruc_empresa,
        string $nombre_empresa,
        string $direccion_empresa,
        string $correo_empresa,
        string $telefono_empresa,
        string $cedula_representante,
        string $nombre_representante,
        string $telefono_representante,
        string $descripcion_empresa
    ) {

        $this->int_id_empresa = $id_empresa;
        $this->str_ruc_empresa = $ruc_empresa;
        $this->str_nombre_empresa = $nombre_empresa;
        $this->str_direccion_empresa = $direccion_empresa;
        $this->str_correo_empresa = $correo_empresa;
        $this->str_telefono_empresa = $telefono_empresa;
        $this->str_cedula_representante = $cedula_representante;
        $this->str_nombre_representante = $nombre_representante;
        $this->str_telefono_representante = $telefono_representante;
        $this->str_descripcion_empresa = $descripcion_empresa;

        $sql = "SELECT id_empresa,ruc_empresa,cedula_representante FROM Empresas 
            WHERE (ruc_empresa = '{$this->str_ruc_empresa}' and id_empresa != '{$this->int_id_empresa}' ) 
                    or (cedula_representante = '{$this->str_cedula_representante}' and id_empresa != '{$this->int_id_empresa}')";
        $request = $this->select_sql_all($sql);
        
        if (empty($request)) {
            $sql = "UPDATE Empresas SET ruc_empresa = ?,nombre_empresa = ?,direccion_empresa = ?,correo_empresa = ?,telefono_empresa = ?,
            cedula_representante = ?,nombre_representante = ?,telefono_representante = ?,descripcion_empresa = ?,fecha_modifica = now()
            WHERE id_empresa = $this->int_id_empresa";
            $arrData = array(
            $this->str_ruc_empresa,
            $this->str_nombre_empresa,
            $this->str_direccion_empresa,
            $this->str_correo_empresa,
            $this->str_telefono_empresa,
            $this->str_cedula_representante,
            $this->str_nombre_representante,
            $this->str_telefono_representante,
            $this->str_descripcion_empresa
            );
            $request = $this->update_sql($sql, $arrData);
        } else {
            $request = 'exist';
        }
        return $request;
    }


    public function deleteEmpresa(int $int_id_empresa)
    {
        $this->int_id_empresa = $int_id_empresa;
        
        $sql_validate_exist = "SELECT * FROM Practicas_pre_profesionales WHERE id_empresa = $int_id_empresa and estado = 1";
        $request_delete = $this->select_sql_all($sql_validate_exist);
        if($request_delete){
            $sql = "UPDATE Empresas SET estado = ?, fecha_modifica = now() WHERE id_empresa = $this->int_id_empresa";
            $data = array(0);
            $request_delete = $this->update_sql($sql, $data);
            if ($request_delete) {
                $request_delete = 'ok';
            } else {
                $request_delete = 'error';
            }
        }else{
            $request_delete = 'exist';
        }

        return $request_delete;
    }
}
