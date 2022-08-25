<?php
    require_once("./libraries/core/mysql.php");
    class AlumnosModel extends Mysql{
        public $str_search_usuario;
        public $intUsuario;

        public function __construct(){
            parent::__construct();
        }


        public function selectAlumnos(){
            $sql = "SELECT al.cedula,al.nombre,al.apellido,us.usuario,us.email_institucional,al.estado
                    FROM alumnos al
                    INNER JOIN usuarios us ON us.id_usuario = al.id_usuario
                    where al.estado=1 and us.email_activo=1 and us.estado=1 ORDER BY al.id_alumno DESC";
            $request = $this->select_sql_all($sql);
            return $request;
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

    }
?>

