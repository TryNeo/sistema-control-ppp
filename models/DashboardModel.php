<?php
    require_once("./libraries/core/mysql.php");
    class DashboardModel extends Mysql{
        
        public function __construct(){
            parent::__construct();
        }

        public function getTotalUsuarios(){
            $query = "SELECT * FROM Usuarios WHERE estado !=0";
            $request_query = $this->select_count($query);
            return $request_query;
        }

        public function getUsuariosOnline(){
            $query = "SELECT * FROM Usuarios WHERE estado !=0 and ultimo_online !=0";
            $request_query = $this->select_count($query);
            return  $request_query;
        }

        public function getAlumnos(){
            $query = "SELECT * FROM Alumnos as al 
            INNER JOIN Usuarios as us ON us.id_usuario = al.id_usuario WHERE us.estado !=0 and al.estado !=0 and us.email_activo !=0";
            $request_query = $this->select_count($query);
            return $request_query;
        }

        public function getEmpresas(){
            $query = "SELECT * FROM Empresas WHERE estado !=0 ";
            $request_query = $this->select_count($query);
            return $request_query;
        }

        public function getProfesores(){
            $query = "SELECT * FROM Profesores as pr 
            INNER JOIN Usuarios as us ON us.id_usuario = pr.id_usuario WHERE us.estado !=0 and pr.estado !=0 and us.email_activo !=0";
            $request_query = $this->select_count($query);
            return $request_query;
        }
    }

?>