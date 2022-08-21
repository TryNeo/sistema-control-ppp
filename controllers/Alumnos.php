<?php
    require_once ("./libraries/core/controllers.php");

    class Alumnos extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(6);
        }

        public function alumnos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 6;
            $data["tag_pag"] = "Alumnos";
            $data["page_title"] = "Alumnos | Inicio";
            $data["page_name"] = "Listado de Alumnos";
            $data['page'] = "alumnos";
            $this->views->getView($this,"alumnos",$data);

        }

        public function getSelectCarreras()
        {   
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $html_options = "";
                $data = $this->model->selectCarrerasNoInactivos();
                if (count($data) > 0) {
                    for ($i=0; $i < count($data) ; $i++) { 
                        $html_options .='<option value="'.$data[$i]['id_carrera'].'">'.$data[$i]['nombre_carrera'].'</option>';
                    }
                }
                echo $html_options;                
                die();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }

        public function getSelectUsuarios(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if(empty($_POST)){
                    $request_data =  $this->model->selectUsuariosNoInactivos('');
                    foreach ($request_data as $row) {    
                        $data[] = array("id_usuario"=>$row['id_usuario'], "usuario"=>$row['usuario'],
                        "email_institucional" => $row['email_institucional'],"nombre_rol" => $row['nombre_rol']);
                    }
                }else{
                    $search_usuario = strclean($_POST['search']);
                    $request_data = $this->model->selectUsuariosNoInactivos($search_usuario);
                    foreach ($request_data as $row) {    
                        $data[] = array("id_usuario"=>$row['id_usuario'], "usuario"=>$row['usuario'],
                        "email_institucional" => $row['email_institucional'],"nombre_rol" => $row['nombre_rol']);
                    }
                }      
            }
            if (!isset($data)) {
                $data = array();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
    }