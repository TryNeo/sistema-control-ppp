<?php
require_once("./libraries/core/mysql.php");
class ProfesoresModel extends Mysql
{
    public $str_search_usuario;
    public $intUsuario;

    public $int_id_profesor;
    public $str_cedula;
    public $str_nombre;
    public $str_apellido;
    public $str_email_personal;
    public $str_telefono;
    public $str_sexo;
    public $int_id_campus;
    public $int_id_usuario;

    public function __construct()
    {
        parent::__construct();
    }


    public function selectProfesores()
    {
        $sql = "SELECT pr.id_profesor,pr.cedula,pr.nombre,pr.apellido,us.usuario,pr.email_personal,us.email_institucional,pr.estado
                    FROM profesores pr
                    INNER JOIN usuarios us ON us.id_usuario = pr.id_usuario
                    where pr.estado=1 and us.email_activo=1 and us.estado=1 ORDER BY pr.id_profesor DESC";
        $request = $this->select_sql_all($sql);
        return $request;
    }

    public function selectCampusNoInactivos()
    {
        $sql = "SELECT id_campus,nombre_campus,descripcion FROM campus WHERE estado =1";
        $request = $this->select_sql_all($sql);
        return $request;
    }



    public function selectProfesor(int $id_profesor)
    {
        $this->int_id_profesor = $id_profesor;
        $sql = "SELECT id_profesor,cedula,email_personal,nombre,apellido,telefono,sexo,id_campus,id_usuario FROM profesores where id_profesor =$this->int_id_profesor";
        $request = $this->select_sql($sql);
        return $request;
    }

    public function selectUsuariosNoInactivos(string $str_search_usuario)
    {
        $this->str_search_usuario = $str_search_usuario;
        $sql = "SELECT us.id_usuario,us.usuario,us.email_institucional,rl.nombre_rol FROM usuarios as us INNER JOIN roles as rl ON us.id_rol = rl.id_rol 
                WHERE us.estado = 1 and us.email_activo = 0 and us.id_usuario != 1 and rl.id_rol = 3 and us.usuario like '%" . $this->str_search_usuario . "%' ";
        $request = $this->select_sql_all($sql);
        return $request;
    }

    public function insertProfesor(
        string $cedula,
        string $nombre,
        string $apellido,
        string $email_personal,
        string $telefono,
        string $sexo,
        int $id_campus,
        int $id_usuario
    ) {
        $this->str_cedula = $cedula;
        $this->str_nombre = $nombre;
        $this->str_apellido = $apellido;
        $this->str_email_personal = $email_personal;
        $this->str_telefono = $telefono;
        $this->str_sexo = $sexo;
        $this->int_id_campus = $id_campus;
        $this->int_id_usuario = $id_usuario;

        $sql_email_ver = "SELECT email_institucional FROM usuarios WHERE email_institucional = '{$this->str_email_personal}' and estado = 1";
        $request_email_ver = $this->select_sql($sql_email_ver);
        if (!empty($request_email_ver)) {
            $return = "error_email";
        } else {
            $sql = "SELECT * FROM profesores as pr
                            WHERE pr.cedula = '{$this->str_cedula}' or pr.email_personal='{$this->str_email_personal}' and estado = 1";
            $request = $this->select_sql_all($sql);
            if (empty($request)) {
                $sql_insert = "INSERT INTO profesores (cedula,nombre,apellido,email_personal,telefono,sexo,id_campus,id_usuario,estado,fecha_crea)  
                                    values (?,?,?,?,?,?,?,?,1,now())";
                $data = array(
                    $this->str_cedula, $this->str_nombre, $this->str_apellido, $this->str_email_personal,
                    $this->str_telefono, $this->str_sexo,$this->int_id_campus,$this->int_id_usuario
                );
                $request_insert = $this->insert_sql($sql_insert, $data);

                $update_email = "UPDATE usuarios set email_activo = ? , fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
                $data = array(1);
                $request_update = $this->update_sql($update_email, $data);
                $return = $request_insert;
            } else {
                $return = "exist";
            }
        }
        return $return;
    }



    public function updateProfesor(
        int $id_profesor,
        string $cedula,
        string $nombre,
        string $apellido,
        string $email_personal,
        string $telefono,
        string $sexo,
        int $id_campus
    ) {

        $this->int_id_profesor = $id_profesor;
        $this->str_cedula = $cedula;
        $this->str_nombre = $nombre;
        $this->str_apellido = $apellido;
        $this->str_email_personal = $email_personal;
        $this->str_telefono = $telefono;
        $this->str_sexo = $sexo;
        $this->int_id_campus = $id_campus;

        $sql = "SELECT cedula FROM profesores WHERE cedula = '{$this->str_cedula}'
            and estado=1  and id_profesor = $this->int_id_profesor";
        $request = $this->select_sql_all($sql);

        if (empty($request)) {
            $request = 'exist';
        } else {
            $sql = "UPDATE profesores SET cedula = ?,nombre = ?,apellido = ?,email_personal = ?,telefono = ?,sexo = ?,id_campus=?,fecha_modifica = now() WHERE id_profesor = $this->int_id_profesor";
            $data = array(
                $this->str_cedula, $this->str_nombre, $this->str_apellido, $this->str_email_personal,
                $this->str_telefono, $this->str_sexo,$this->int_id_campus
            );
            $request = $this->update_sql($sql, $data);
        }

        return $request;
    }



    public function deleteProfesor(int $int_id_profesor)
    {
        $this->int_id_profesor = $int_id_profesor;

        $sql = "UPDATE profesores SET estado = ?, fecha_modifica = now() WHERE id_profesor = $this->int_id_profesor";
        $data = array(0);
        $request_delete = $this->update_sql($sql, $data);

        if ($request_delete) {
            $request_delete = 'ok';
            $sql_alu_email = "UPDATE  usuarios SET email_activo = ?, fecha_modifica = now() WHERE id_usuario = (SELECT id_usuario FROM profesores WHERE id_profesor = $this->int_id_profesor)";
            $data = array(0);
            $request_update = $this->update_sql($sql_alu_email, $data);
        } else {
            $request_delete = 'error';
        }
        return $request_delete;
    }

}