<?php
    require_once("./libraries/core/mysql.php");
    class RolesModel extends Mysql{
        public $intRol;
        public $strRol;
        public $strDescrip;
        public $intEstado;
        public $strFechaCrea;

        public function __construct(){
            parent::__construct();
        }

        public function selectRoles(){
            $sql = "SELECT id_rol,nombre_rol,descripcion,estado FROM Roles where estado=1  and id_rol !=1 ORDER BY id_rol DESC";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectRolesNoInactivos(){
            $where_admin = "";
            if($_SESSION['id_usuario'] = 1){
                $where_admin = " and id_rol !=1";
            }
            $sql = "SELECT id_rol,nombre_rol,descripcion,estado FROM Roles WHERE estado =1 and id_rol !=1";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectRol(int $id_rol){
            $this->intRol = $id_rol;
            $sql = "SELECT id_rol,nombre_rol,descripcion,estado FROM Roles where id_rol =$this->intRol";
            $request = $this->select_sql($sql);
            return $request;

        }

        public function insertRol(string $rolInput,string $descriInput)
        {   
            $return = "";
            $this->strRol = $rolInput;
            $this->strDescrip = $descriInput;
            $sql = "SELECT * FROM Roles WHERE nombre_rol = '{$this->strRol}'";
            $request = $this->select_sql_all($sql);
            if (empty($request)){
                $sql_insert = "INSERT INTO Roles(nombre_rol,descripcion,estado,fecha_crea) values (?,?,1,now())";
                $data = array($this->strRol,$this->strDescrip);
                $request_insert = $this->insert_sql($sql_insert,$data);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }
        

        public function updateRol(int $intRol,string $rolInput,string $descriInput)
        {   
            $this->intRol = $intRol;
            $this->strRol = $rolInput;
            $this->strDescrip = $descriInput;
            
            $sql = "SELECT id_rol,nombre_rol FROM Roles WHERE (nombre_rol = '$this->strRol' and id_rol != $this->intRol)";
            $request_update= $this->select_sql_all($sql);
            if(empty($request_update)){
                $sql_udpate = "UPDATE Roles SET nombre_rol = ?, descripcion = ?,fecha_modifica = now()  WHERE id_rol = $this->intRol";
                $data = array($this->strRol,$this->strDescrip);
                $request_update = $this->update_sql($sql_udpate,$data);
            }else{
                $request_update = "exist";
            }
            return $request_update;
        }


        public function deleteRol(int $intRol){
            $this->intRol = $intRol;
            $sql = "SELECT * FROM Usuarios WHERE id_rol = $this->intRol and estado = 1";
            $request_delete = $this->select_sql_all($sql);
            if(empty($request_delete)){
                $sql = "UPDATE Roles set estado = ? , fecha_modifica = now() WHERE id_rol = $this->intRol";
                $data = array(0);
                $request_delete = $this->update_sql($sql,$data);
                if ($request_delete){
                    $request_delete = 'ok';
                    $sql_delete = "DELETE FROM Permisos WHERE id_rol = $this->intRol";
                    $request_delete_perm = $this->delete_sql($sql_delete);
                }else{
                    $request_delete = 'error';
                }
            }else{
                $request_delete = 'exist';
            }
            return $request_delete;
        }
    }
?>