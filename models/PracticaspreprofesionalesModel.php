<?php
require_once("./libraries/core/mysql.php");
class PracticaspreprofesionalesModel extends Mysql
{
    public $str_search_alumno;
    public $str_search_profesor;
    public $str_search_empresa;

    public $int_id_practicas;
    public $int_id_alumno;
    public $int_id_profesor;
    public $int_id_empresa;
    public $int_id_tipo_practica;
    public $int_id_alcance_proyecto;
    public $str_departamento;
    public $int_id_nivel;
    public $date_fecha_inicio;
    public $date_fecha_fin;
    public $int_total_ppp;
    public $int_total_horas;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectPracticasPreProfesionales()
    {
        $sql = "SELECT ppp.id_practica,CONCAT(al.cedula,'<br>',al.nombre,' ',al.apellido) as ced_nom_ape_al,
                    CONCAT(em.ruc_empresa,'-',em.nombre_empresa,'<br>','(',pr.nombre,' ',pr.apellido,')') as ruc_nom_ape_pr_em,
                    ppp.fecha_inicio,ppp.fecha_fin,ppp.tipo_practica
        FROM Practicas_pre_profesionales as ppp
        INNER JOIN Alumnos as al ON al.id_alumno = ppp.id_alumno
        INNER JOIN profesores as pr ON pr.id_profesor = ppp.id_profesor
        INNER JOIN empresas as em ON em.id_empresa = ppp.id_empresa
        where ppp.estado=1  ORDER BY ppp.id_practica DESC";
        $request = $this->select_sql_all($sql);
        return $request;
    }

    public function selectAlumnosNoInactivos(string $str_search_alumno)
    {
        $this->str_search_alumno = $str_search_alumno;
        $sql = "SELECT al.id_alumno,al.cedula,al.nombre,al.apellido,cr.nombre_carrera FROM Alumnos as al 
                    INNER JOIN Usuarios as us ON al.id_usuario = us.id_usuario
                    INNER JOIN Carreras as cr ON al.id_carrera = cr.id_carrera
                    WHERE al.estado = 1 and us.email_activo = 1 and cr.estado = 1 and us.id_rol = 2 and al.cedula like '%" . $this->str_search_alumno . "%' 
                        or al.apellido like '%" . $this->str_search_alumno . "%' or al.nombre like '%" . $this->str_search_alumno . "%' LIMIT 5";
        $request = $this->select_sql_all($sql);
        return $request;
    }


    public function selectProfesorNoInactivos(string $str_search_profesor)
    {
        $this->str_search_profesor = $str_search_profesor;
        $sql = "SELECT pr.id_profesor,pr.cedula,pr.nombre,pr.apellido,cp.nombre_campus FROM Profesores as pr 
                    INNER JOIN Usuarios as us ON pr.id_usuario = us.id_usuario
                    INNER JOIN Campus as cp ON pr.id_campus = cp.id_campus
                    WHERE pr.estado = 1 and us.email_activo = 1 and cp.estado = 1 and us.id_rol = 3 and pr.cedula like '%" . $this->str_search_profesor . "%' 
                        or pr.apellido like '%" . $this->str_search_profesor . "%' or pr.nombre like '%" . $this->str_search_profesor . "%' LIMIT 5";
        $request = $this->select_sql_all($sql);
        return $request;
    }

    public function selectEmpresaNoInactivos(string $str_search_empresa)
    {
        $this->str_search_empresa = $str_search_empresa;
        $sql = "SELECT ep.id_empresa,ep.nombre_empresa,ep.nombre_representante,ep.telefono_representante FROM Empresas as ep
                    WHERE (ep.estado = 1  and ep.nombre_empresa like '%" . $this->str_search_profesor . "%')
                        or (ep.estado = 1 and ep.nombre_representante like '%" . $this->str_search_profesor . "%' ) or ( ep.estado = 1 and 
                            ep.ruc_empresa like '%" . $this->str_search_profesor . "%') LIMIT 5";
        $request = $this->select_sql_all($sql);
        return $request;
    }



    public function selectAlumnoTotalHorasppp(int $str_search_alumno)
    {
        $this->str_search_alumno = $str_search_alumno;
        $sql = "SELECT SUM(ppp.total_horas_ppp) as total_horas FROM Practicas_pre_profesionales as ppp
                    INNER JOIN Alumnos as al ON al.id_alumno = ppp.id_alumno
                    WHERE al.estado = 1 and ppp.estado = 1 and al.id_alumno = $this->str_search_alumno";
        $request = $this->select_sql($sql);
        return $request;
    }

    public function insertPracticaspreprofesionales(
        int $id_alumno,
        int $id_profesor,
        int $id_tipo_practica,
        int $id_alcance_proyecto,
        int $id_empresa,
        string $departamento,
        int $id_nivel,
        string $fecha_inicio,
        string $fecha_fin,
        int $total_horas
    ) {

        $this->int_id_alumno = $id_alumno;
        $this->int_id_profesor = $id_profesor;
        $this->int_id_tipo_practica = $id_tipo_practica;
        $this->int_id_alcance_proyecto = $id_alcance_proyecto;
        $this->int_id_empresa = $id_empresa;
        $this->str_departamento = $departamento;
        $this->int_id_nivel = $id_nivel;
        $this->str_fecha_inicio = $fecha_inicio;
        $this->str_fecha_fin = $fecha_fin;
        $this->int_total_horas = $total_horas;

        $sql_insert = "INSERT INTO Practicas_pre_profesionales(
                id_alumno,id_profesor,tipo_practica,alcance_proyecto,id_empresa,departamento,nivel,fecha_inicio,fecha_fin,total_horas_ppp,estado,fecha_crea)
                VALUES(?,?,?,?,?,?,?,?,?,?,1,now())";

        $arrData = array($this->int_id_alumno, $this->int_id_profesor,$this->int_id_tipo_practica,
                    $this->int_id_alcance_proyecto,$this->int_id_empresa,$this->str_departamento,
                    $this->int_id_nivel,$this->str_fecha_inicio,$this->str_fecha_fin,$this->int_total_horas);

        $request = $this->insert_sql($sql_insert, $arrData);
        return $request;
    }
}
