<?php
    require_once("./libraries/core/mysql.php");
    class EmpresasModel extends Mysql{

        public function __construct(){
            parent::__construct();
        }


        public function selectAlumnos(){
            $sql = "SELECT id_empresa
                    FROM empresas
                    where estado=1 ORDER BY id_empresa DESC";
            $request = $this->select_sql_all($sql);
            return $request;
        }

    }
?>

