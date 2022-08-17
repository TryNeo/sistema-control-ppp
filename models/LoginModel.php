<?php
    require_once("./libraries/core/mysql.php");
    class LoginModel extends Mysql{
        public $int_id_usuario;
        public $str_email;
        
        public function __construct(){
            parent::__construct();
        }

        public function login_user(string $str_email){
            $this->str_email = $str_email;
            $sql = "SELECT id_usuario,password,estado FROM usuarios WHERE email = '$this->str_email'";
            $request = $this->select_sql($sql);
            return $request;
        }        


        public function sessionLogin(int $int_id_usuario){
            $this->int_id_usuario = $int_id_usuario;

            $sql_update = "UPDATE usuarios SET ultimo_online = ?,fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
            $data = array(1);
            $request_update = $this->update_sql($sql_update,$data);
            if($request_update > 0){
                $sql = "SELECT us.id_usuario,us.nombre,us.apellido,us.ultimo_online,us.foto,us.usuario,us.email,r.id_rol,r.nombre_rol,us.estado 
                FROM usuarios us INNER JOIN roles r ON us.id_rol = r.id_rol WHERE us.id_usuario = $this->int_id_usuario";
                $request = $this->select_sql($sql);
                return $request;
            }
        }
    }

?>