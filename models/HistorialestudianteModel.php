<?php
    require_once("./libraries/core/mysql.php");
    class HistorialestudianteModel extends Mysql{
        public $int_id_usuario;
        public $int_tipo_practica;
        public $str_search_alumno;

        public function __construct(){
            parent::__construct();
        }

        public function selectHistorialAlumno($int_id_usuario){
            $this->int_id_usuario = $int_id_usuario;

            $sql = "SELECT ppp.id_practica,emp.nombre_empresa,CONCAT(pr.nombre,' ',pr.apellido) as tutor_docente,ppp.tipo_practica,
                    ppp.total_horas_ppp as horas,ppp.fecha_inicio,ppp.fecha_fin
                    FROM Practicas_pre_profesionales as ppp
                    INNER JOIN Alumnos as al ON ppp.id_alumno = al.id_alumno
                    INNER JOIN Usuarios as us on al.id_usuario = us.id_usuario
                    INNER JOIN Profesores as pr ON ppp.id_profesor = pr.id_profesor
                    INNER JOIN Empresas as emp ON ppp.id_empresa = emp.id_empresa
                    WHERE us.id_usuario = $this->int_id_usuario and ppp.estado = 1";
            $request = $this->select_sql_all($sql);
            return $request;
        }


        public function selectHistorialAlumnoSearch($str_search_alumno){
            $this->str_search_alumno = $str_search_alumno;
            $sql = "SELECT DISTINCT al.id_usuario,al.cedula,CONCAT(al.nombre,' ',al.apellido) as nombre_estudiante FROM Practicas_pre_profesionales as ppp 
            INNER JOIN Alumnos as al ON ppp.id_alumno = al.id_alumno
            INNER JOIN Usuarios as us ON al.id_usuario = us.id_usuario
            WHERE (al.estado = 1 and us.estado = 1 and us.email_activo = 1 and al.cedula like '%" . $this->str_search_alumno . "%')
                or (al.estado = 1 and us.estado = 1 and us.email_activo = 1 and al.nombre like '%" . $this->str_search_alumno . "%')
                or (al.estado = 1 and us.estado = 1 and us.email_activo = 1 and al.apellido like '%" . $this->str_search_alumno . "%') LIMIT 5";
            $request = $this->select_sql_all($sql);
            return $request;
        }


        public function selectCertificadoAlumno($int_id_usuario){
            $this->int_id_usuario = $int_id_usuario;
            $sql = "SELECT UPPER(CONCAT(al.nombre,' ',al.apellido)) as nombre_estudiante,al.cedula,UPPER(cr.nombre_carrera) as nombre_carrera
                    FROM Alumnos as al
                    INNER JOIN Usuarios as us ON al.id_usuario = us.id_usuario
                    INNER JOIN Carreras as cr ON al.id_carrera = cr.id_carrera
                    WHERE  us.id_usuario = $this->int_id_usuario and us.estado = 1 and al.estado = 1 and us.email_activo = 1";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function selectCertificadoAlumnoDetalle($int_id_usuario,$int_tipo_practica){
            $this->int_id_usuario = $int_id_usuario;
            $this->int_tipo_practica = $int_tipo_practica;

            $sql = "SELECT emp.nombre_empresa,ppp.tipo_practica,ppp.total_horas_ppp,ppp.fecha_inicio,ppp.fecha_fin 
            FROM Practicas_pre_profesionales as ppp 
            INNER JOIN Alumnos as al ON ppp.id_alumno = al.id_alumno
            INNER JOIN Empresas as emp ON ppp.id_empresa = emp.id_empresa
            INNER JOIN Usuarios as us ON al.id_usuario = us.id_usuario
            WHERE us.id_usuario = $this->int_id_usuario and ppp.tipo_practica = $int_tipo_practica";
            $request = $this->select_sql_all($sql);
            return $request;
        }

    }
?>