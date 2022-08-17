<?php
    require_once("./libraries/core/mysql.php");
    class LogoutModel extends Mysql{
        public $int_id_usuario;
        
        public function __construct(){
            parent::__construct();
        }

        public function updateLastLogin(int $int_id_usuario){
            $this->int_id_usuario = $int_id_usuario;
            $sql_update = "UPDATE usuarios SET ultimo_online = ?,fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
            $data = array(0);
            $request_update = $this->update_sql($sql_update,$data);
            return $request_update;
        }
    }

?>