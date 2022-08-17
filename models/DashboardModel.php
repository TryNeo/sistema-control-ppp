<?php
    require_once("./libraries/core/mysql.php");
    class DashboardModel extends Mysql{
        
        public function __construct(){
            parent::__construct();
        }

        public function getTotalUsuarios(){
            $query = "SELECT * FROM usuarios WHERE estado !=0";
            $request_query = $this->select_count($query);
            return $request_query;
        }

        public function getUsuariosOnline(){
            $query = "SELECT * FROM usuarios WHERE estado !=0 and ultimo_online !=0";
            $request_query = $this->select_count($query);
            return  $request_query;
        }

    }

?>