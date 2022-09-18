<?php
require_once("./libraries/core/mysql.php");
class PracticaspreprofesionalesModel extends Mysql
{
    public $str_search_alumno;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectAlumnosNoInactivos(string $str_search_alumno)
    {
        $this->str_search_alumno = $str_search_alumno;
        $sql = "SELECT al.id_alumno,al.cedula,al.nombre,al.apellido,cr.nombre_carrera FROM alumnos as al 
                    INNER JOIN usuarios as us ON al.id_usuario = us.id_usuario
                    INNER JOIN carreras as cr ON al.id_carrera = cr.id_carrera
                    WHERE al.estado = 1 and us.email_activo = 1 and cr.estado = 1 and us.id_rol = 2 and al.cedula like '%" . $this->str_search_alumno ."%' 
                        or al.apellido like '%" . $this->str_search_alumno ."%' or al.nombre like '%" . $this->str_search_alumno ."%' LIMIT 5" ;
        $request = $this->select_sql_all($sql);
        return $request;
    }


}
