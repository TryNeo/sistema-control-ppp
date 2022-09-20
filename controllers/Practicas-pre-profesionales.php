<?php
    require_once ("./libraries/core/controllers.php");

    class Practicaspreprofesionales extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(9);
        }

        public function practicaspreprofesionales(){  
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 9;
            $data["tag_pag"] = "";
            $data["page_title"] = "Practicas pre profesionales | Inicio";
            $data["page_name"] = "practicas";
            $data["page"] = "practicas";
            $this->views->getView($this,"practicas-pre-profesionales",$data);

        }

        
        public function agregar(){
            $data = [];
            $data["page_id"] = 9;
            $data["tag_pag"] = "";
            $data["page_title"] = "Agregar practicas";
            $data["page_name"] = "practicas";
            $data["page"] = "practicas";
            $this->views->getView($this, "agregar-practicas", $data);
            die();
        }


        public function getSelectAlumnos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if(empty($_POST)){
                    $request_data =  $this->model->selectAlumnosNoInactivos('');
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_alumno'], "text"=>$row['nombre']." ".$row['apellido'],
                        "cedula" => $row['cedula'],"carrera" => $row['nombre_carrera']);
                    }
                }else{
                    $search_alumno = strclean($_POST['search']);
                    $request_data = $this->model->selectAlumnosNoInactivos($search_alumno);
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_alumno'], "text"=>$row['nombre']." ".$row['apellido'],
                        "cedula" => $row['cedula'], "carrera" => $row['nombre_carrera']);
                    }
                }      
            }
            if (!isset($data)) {
                $data = array();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        
        public function getSelectProfesor(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if(empty($_POST)){
                    $request_data =  $this->model->selectProfesorNoInactivos('');
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_profesor'], "text"=>$row['nombre']." ".$row['apellido'],
                        "cedula" => $row['cedula'],"campus" => $row['nombre_campus']);
                    }
                }else{
                    $search_profesor = strclean($_POST['search']);
                    $request_data = $this->model->selectProfesorNoInactivos($search_profesor);
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_profesor'], "text"=>$row['nombre']." ".$row['apellido'],
                        "cedula" => $row['cedula'],"campus" => $row['nombre_campus']);
                    }
                }      
            }
            if (!isset($data)) {
                $data = array();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function getSelectEmpresas(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if(empty($_POST)){
                    $request_data =  $this->model->selectEmpresaNoInactivos('');
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_empresa'], "text"=>$row['nombre_empresa'],
                        "nombre" => $row['nombre_representante'],"telefono" => $row['telefono_representante']);
                    }
                }else{
                    $search_empresa = strclean($_POST['search']);
                    $request_data = $this->model->selectEmpresaNoInactivos($search_empresa);
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_empresa'], "text"=>$row['nombre_empresa'],
                        "nombre" => $row['nombre_representante'],"telefono" => $row['telefono_representante']);
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