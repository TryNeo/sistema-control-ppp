<?php
    require_once("./libraries/core/mysql.php");
    class LoginModel extends Mysql{
        public $int_id_usuario;
        public $int_id_rol;
        public $str_email;
        
        public function __construct(){
            parent::__construct();
        }

        public function login_user(string $str_email){
            $this->str_email = $str_email;
            $sql = "SELECT id_usuario,password,ultimo_online,estado,id_rol
                FROM usuarios WHERE email_institucional = '$this->str_email' and estado = 1 and email_activo = 1";
            $request = $this->select_sql($sql);
            return $request;
        }        


        public function sessionLogin(int $int_id_usuario,int $int_id_rol){
            $this->int_id_usuario = $int_id_usuario;
            $this->int_id_rol = $int_id_rol;
            
            $sql_update = "UPDATE usuarios SET ultimo_online = ?,fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
            $data = array(1);
            $request_update = $this->update_sql($sql_update,$data);
            if($request_update > 0){
                if ($this->int_id_usuario == 1) {
                    $sql = "SELECT us.id_usuario,us.ultimo_online,us.usuario,us.email_institucional,r.id_rol,r.nombre_rol,us.estado 
                    FROM usuarios us INNER JOIN roles r ON us.id_rol = r.id_rol WHERE us.id_usuario = $this->int_id_usuario";
                    $request = $this->select_sql($sql);
                }else{
                    $sql = "SELECT us.id_usuario,
                        IFNULL(al.nombre, pro.nombre) nombre,
                        IFNULL(al.apellido, pro.apellido) apellido,
                        us.ultimo_online,
                        us.usuario,us.email_institucional,r.id_rol,r.nombre_rol,us.estado
                        FROM
                            usuarios as us
                        INNER JOIN roles as r ON
                            us.id_rol = r.id_rol
                        LEFT JOIN alumnos as al on us.id_usuario = al.id_usuario
                        LEFT JOIN profesores as pro on us.id_usuario = pro.id_usuario
                        WHERE us.id_usuario = $this->int_id_usuario and r.id_rol = $this->int_id_rol";
                        $request = $this->select_sql($sql);
                }
                return $request;
            }
        }
    }

?>