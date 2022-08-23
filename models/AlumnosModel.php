<?php
    require_once("./libraries/core/mysql.php");
    class AlumnosModel extends Mysql{
        public $str_search_usuario;
        public $intUsuario;

        public function __construct(){
            parent::__construct();
        }

        public function selectCarrerasNoInactivos(){
            $sql = "SELECT id_carrera,nombre_carrera,descripcion FROM carreras WHERE estado =1";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectUsuariosNoInactivos(string $str_search_usuario){
            $this->str_search_usuario = $str_search_usuario;
            $sql = "SELECT us.id_usuario,us.usuario,us.email_institucional,rl.nombre_rol FROM usuarios as us INNER JOIN roles as rl ON us.id_rol = rl.id_rol 
                WHERE us.estado = 1 and us.email_activo = 0 and us.id_usuario != 1 and rl.id_rol = 2 and us.usuario like '%".$this->str_search_usuario."%' ";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectSearchUsuario(int $intUsuario){
            $this->intUsuario= $intUsuario;
            $sql = "SELECT us.id_usuario,us.usuario,us.email_institucional,rl.nombre_rol FROM usuarios as us INNER JOIN roles as rl ON us.id_rol = rl.id_rol 
            WHERE us.estado = 1 and us.email_activo = 0 and us.id_usuario != 1 and rl.id_rol = 2 and us.id_usuario = $this->intUsuario";
            $request = $this->select_sql($sql);
            return $request;
        }
    }
?>

