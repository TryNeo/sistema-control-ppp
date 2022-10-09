<?php
    require_once("./libraries/core/mysql.php");
    class HistorialestudianteModel extends Mysql{
        public $int_id_usuario;

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

    }
?>