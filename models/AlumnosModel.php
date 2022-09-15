<?php
require_once("./libraries/core/mysql.php");
class AlumnosModel extends Mysql
{
    public $str_search_usuario;
    public $intUsuario;

    public $int_id_alumno;
    public $str_cedula;
    public $str_nombre;
    public $str_apellido;
    public $str_email_personal;
    public $str_telefono;
    public $str_sexo;
    public $int_id_carrera;
    public $int_id_usuario;

    public function __construct()
    {
        parent::__construct();
    }


    public function selectAlumnos()
    {
        $sql = "SELECT al.id_alumno,al.cedula,al.nombre,al.apellido,us.usuario,al.email_personal,us.email_institucional,al.estado
                    FROM alumnos al
                    INNER JOIN usuarios us ON us.id_usuario = al.id_usuario
                    where al.estado=1 and us.email_activo=1 and us.estado=1 ORDER BY al.id_alumno DESC";
        $request = $this->select_sql_all($sql);
        return $request;
    }

    public function selectCarrerasNoInactivos()
    {
        $sql = "SELECT id_carrera,nombre_carrera,descripcion FROM carreras WHERE estado =1";
        $request = $this->select_sql_all($sql);
        return $request;
    }

    public function selectAlumno(int $id_alumno)
    {
        $this->int_id_alumno = $id_alumno;
        $sql = "SELECT id_alumno,cedula,email_personal,nombre,apellido,telefono,sexo,id_carrera,id_usuario FROM alumnos where id_alumno =$this->int_id_alumno";
        $request = $this->select_sql($sql);
        return $request;
    }

    public function selectUsuariosNoInactivos(string $str_search_usuario)
    {
        $this->str_search_usuario = $str_search_usuario;
        $sql = "SELECT us.id_usuario,us.usuario,us.email_institucional,rl.nombre_rol FROM usuarios as us INNER JOIN roles as rl ON us.id_rol = rl.id_rol 
                INNER JOIN alumnos as al ON us.id_usuario = al.id_usuario
                WHERE us.estado = 1 and us.email_activo = 0 and us.id_usuario != 1 and rl.id_rol = 2 and  us.id_usuario != al.id_usuario and us.usuario like '%" . $this->str_search_usuario . "%' ";
        $request = $this->select_sql_all($sql);
        return $request;
    }

    public function insertAlumno(
        string $cedula,
        string $nombre,
        string $apellido,
        string $email_personal,
        string $telefono,
        string $sexo,
        int $id_carrera,
        int $id_usuario
    ) {
        $this->str_cedula = $cedula;
        $this->str_nombre = $nombre;
        $this->str_apellido = $apellido;
        $this->str_email_personal = $email_personal;
        $this->str_telefono = $telefono;
        $this->str_sexo = $sexo;
        $this->int_id_carrera = $id_carrera;
        $this->int_id_usuario = $id_usuario;

        $sql_email_ver = "SELECT email_institucional FROM usuarios WHERE email_institucional = '{$this->str_email_personal}' and estado = 1";
        $request_email_ver = $this->select_sql($sql_email_ver);
        if (!empty($request_email_ver)) {
            $return = "error_email";
        } else {
            $sql = "SELECT * FROM alumnos as al
                            WHERE al.cedula = '{$this->str_cedula}' or al.email_personal='{$this->str_email_personal}' and estado = 1";
            $request = $this->select_sql_all($sql);
            if (empty($request)) {
                $sql_insert = "INSERT INTO alumnos (cedula,nombre,apellido,email_personal,telefono,sexo,id_carrera,id_usuario,estado,fecha_crea)  
                                    values (?,?,?,?,?,?,?,?,1,now())";
                $data = array(
                    $this->str_cedula, $this->str_nombre, $this->str_apellido, $this->str_email_personal,
                    $this->str_telefono, $this->str_sexo, $this->int_id_carrera, $this->int_id_usuario
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

    public function updateAlumno(
        int $id_alumno,
        string $cedula,
        string $nombre,
        string $apellido,
        string $email_personal,
        string $telefono,
        string $sexo,
        int $id_carrera
    ) {

        $this->int_id_alumno = $id_alumno;
        $this->str_cedula = $cedula;
        $this->str_nombre = $nombre;
        $this->str_apellido = $apellido;
        $this->str_email_personal = $email_personal;
        $this->str_telefono = $telefono;
        $this->str_sexo = $sexo;
        $this->int_id_carrera = $id_carrera;

        $sql = "SELECT cedula FROM empresas WHERE cedula = '{$this->str_cedula}'
            and estado=1  and id_alumno = $this->int_id_alumno";
        $request = $this->select_sql_all($sql);

        if (empty($request)) {
            $request = 'exist';
        } else {
            $sql = "UPDATE alumnos SET cedula = ?,nombre = ?,apellido = ?,email_personal = ?,telefono = ?,sexo = ?,id_carrera = ?,fecha_modifica = now() WHERE id_alumno = $this->int_id_alumno";
            $data = array(
                $this->str_cedula, $this->str_nombre, $this->str_apellido, $this->str_email_personal,
                $this->str_telefono, $this->str_sexo, $this->int_id_carrera
            );
            $request = $this->update_sql($sql, $data);
        }

        return $request;
    }

    public function deleteAlumno(int $int_id_alumno)
    {
        $this->int_id_alumno = $int_id_alumno;

        $sql = "UPDATE alumnos SET estado = ?, fecha_modifica = now() WHERE id_alumno = $this->int_id_alumno";
        $data = array(0);
        $request_delete = $this->update_sql($sql, $data);

        if ($request_delete) {
            $request_delete = 'ok';
            $sql_alu_email = "UPDATE  usuarios SET email_activo = ?, fecha_modifica = now() WHERE id_usuario = (SELECT id_usuario FROM alumnos WHERE id_alumno = $this->int_id_alumno)";
            $data = array(0);
            $request_update = $this->update_sql($sql_alu_email, $data);
        } else {
            $request_delete = 'error';
        }
        return $request_delete;
    }
}
