<?php
    require_once("./libraries/core/mysql.php");
    class UsuariosModel extends Mysql{
        public $int_id_usuario;
        public $str_usuario;
        public $str_email_institucional;
        public $int_id_rol;
        public $int_estado;
        public $str_password;

        public function __construct(){
            parent::__construct();
        }

        public function selectUsuarios(){
            $where_admin = "";
            if ($_SESSION['id_usuario'] != 1){
                $where_admin = " and us.id_usuario !=1";
            }
            $sql = "SELECT us.id_usuario,us.usuario,us.email_institucional,us.email_activo,us.ultimo_online,rl.id_rol,rl.nombre_rol,us.estado
                FROM Usuarios  as us INNER JOIN Roles as rl ON us.id_rol = rl.id_rol WHERE rl.estado !=0 and us.estado!=0".$where_admin;
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectUsuario(int $id_usuario){
            $this->int_id_usuario = $id_usuario;
            $sql = "SELECT us.id_usuario,us.usuario,us.email_institucional,rl.id_rol,us.estado
                FROM Usuarios  as us INNER JOIN Roles as rl ON us.id_rol = rl.id_rol WHERE us.id_usuario =  $this->int_id_usuario ";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function insertUsuario(string $str_usuario,string $str_email_institucional,string $str_password,int $int_id_rol)
        {   
            $return = 0;
            $this->str_usuario = $str_usuario;
            $this->str_email_institucional = $str_email_institucional;
            $this->int_id_rol = $int_id_rol;
            $this->str_password = $str_password;
            
            $sql_usuario = "SELECT usuario,email_institucional FROM Usuarios WHERE usuario = '{$this->str_usuario}' or  email_institucional = '{$this->str_email_institucional}'";
            $request_usuario = $this->select_sql_all($sql_usuario);

            if (empty($request_email_inst) && empty($request_usuario)){
                if ($this->int_id_rol != 2){
                    if($this->int_id_rol != 3){
                        $sql_insert = "INSERT INTO Usuarios (usuario,password,email_institucional,email_activo,id_rol,estado,fecha_crea) values (?,?,?,1,?,1,now())";
                        $data = array($this->str_usuario,$this->str_password,$this->str_email_institucional,$this->int_id_rol);
                        $request_insert = $this->insert_sql($sql_insert,$data);
                        $return = $request_insert;
                    }else{
                        $sql_insert = "INSERT INTO Usuarios (usuario,password,email_institucional,id_rol,estado,fecha_crea) values (?,?,?,?,1,now())";
                        $data = array($this->str_usuario,$this->str_password,$this->str_email_institucional,$this->int_id_rol);
                        $request_insert = $this->insert_sql($sql_insert,$data);
                        $return = $request_insert;   
                    }
                }else{
                    $sql_insert = "INSERT INTO Usuarios (usuario,password,email_institucional,id_rol,estado,fecha_crea) values (?,?,?,?,1,now())";
                    $data = array($this->str_usuario,$this->str_password,$this->str_email_institucional,$this->int_id_rol);
                    $request_insert = $this->insert_sql($sql_insert,$data);
                    $return = $request_insert;   
                }
            }else{
                $return = "exist";
            }
            return $return;
        }
        
        public function updateUsuario(int $int_id_usuario,string $str_usuario,string $str_email_institucional,string $str_password,int $int_id_rol){
            $this->int_id_usuario = $int_id_usuario;
            $this->str_usuario = $str_usuario;
            $this->str_email_institucional = $str_email_institucional;
            $this->str_password = $str_password;
            $this->int_id_rol = $int_id_rol;

            $sql = "SELECT usuario,email_institucional FROM Usuarios 
                WHERE (usuario = '{$this->str_usuario}' or  email_institucional = '{$this->str_email_institucional}') and id_usuario != $this->int_id_usuario";
            
            $request = $this->select_sql($sql);
            
            if (empty($request)){
                if ($this->str_password != "" ) {
                    $sql_update = "UPDATE Usuarios SET usuario = ?,email_institucional = ?,id_rol = ?,password = ?,fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
                    $data = array($this->str_usuario,$this->str_email_institucional,$this->int_id_rol,$this->str_password);
                }else{
                    $sql = "UPDATE Usuarios SET usuario = ?,email_institucional = ?,id_rol = ?,fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
                    $data = array($this->str_usuario,$this->str_email_institucional,$this->int_id_rol);
                    
                }
                $request = $this->update_sql($sql_update,$data);
            }else{
                $request = "exist";
            }
            return $request;
        }

        
        public function selectImage(int $int_id_usuario){
            $this->int_id_usuario = $int_id_usuario;
            $sql = "SELECT foto FROM Usuarios WHERE id_usuario = $this->int_id_usuario" ;
            $request_image = $this->select_sql($sql);
            return $request_image;
        }


        public function selectPassword(int $int_id_usuario){
            $this->int_id_usuario = $int_id_usuario;
            $sql = "SELECT * FROM Usuarios WHERE id_usuario = $this->int_id_usuario" ;
            $request_password = $this->select_sql_all($sql);
            return $request_password;
        }


        public function updatePassword(int $int_id_usuario,string $str_password){
            $this->int_id_usuario = $int_id_usuario;
            $this->str_password = $str_password;
            $sql_update = "UPDATE Usuarios SET password = ?,fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
            $data = array($this->str_password);
            $request = $this->update_sql($sql_update,$data);
            return $request;
        }

        public function deleteUsuario(int $int_id_usuario,int $int_id_rol){
            $this->int_id_usuario = $int_id_usuario;
            $this->int_id_rol = $int_id_rol;
            

            $sql_ultimo_online = "SELECT ultimo_online FROM Usuarios WHERE id_usuario = $this->int_id_usuario";
            $response_ultimo_online = $this->select_sql($sql_ultimo_online);
            if($response_ultimo_online['ultimo_online'] == 1){
                $request_delete = 'error_online';
            }else{
                
                if ($this->int_id_rol == 2){
                    $sql_validate_exist_al = "SELECT * FROM Usuarios as us 
                            INNER JOIN Alumnos as al ON us.id_usuario = al.id_usuario 
                            WHERE us.id_usuario = $this->int_id_usuario and al.estado = 1";
                    $request_delete = $this->select_sql_all($sql_validate_exist_al);
                    if(empty($request_delete)){
                        $sql = "UPDATE Usuarios SET email_activo= ?,estado = ?, fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
                        $data = array(0,0);
                        $request_delete = $this->update_sql($sql,$data);
                        $request_delete = 'ok';
                    }else{
                        $request_delete = 'error_alumno';
                    }
                }else if ($this->int_id_rol == 3) {
                    $sql_validate_exist_pr = "SELECT * FROM Usuarios as us 
                            INNER JOIN Profesores as pr ON us.id_usuario = pr.id_usuario 
                            WHERE us.id_usuario = $this->int_id_usuario and pr.estado = 1";
                    $request_delete = $this->select_sql_all($sql_validate_exist_pr);
                    if(empty($request_delete)){
                        $sql = "UPDATE Usuarios SET email_activo= ?,estado = ?, fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
                        $data = array(0,0);
                        $request_delete = $this->update_sql($sql,$data);
                        $request_delete = 'ok';
                    }else{
                        $request_delete = 'error_profesor';
                    }
                }else{
                    $sql = "UPDATE Usuarios SET email_activo= ?,estado = ?, fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
                    $data = array(0,0);
                    $request_delete = $this->update_sql($sql,$data);
                    $request_delete = 'ok';
                }
            }
            
            return $request_delete;
        }

    }
?>