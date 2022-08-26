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

        public function getAlumnos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectAlumnos();
                for ($i=0; $i < count($data); $i++) { 
                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-custom-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-custom-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    }

                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
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

        public function setAlumno(){
            if ($_POST) {
                $id_alumno = Intval(strclean($_POST['id_alumno']));
                $cedula = strclean($_POST['cedula']);
                $nombre = ucwords(strtolower(strclean($_POST['nombre'])));
                $apellido = ucwords(strtolower(strclean($_POST['apellido'])));
                $email_personal = strtolower(strclean($_POST['email_personal']));
                $telefono = strclean($_POST['telefono']);
                $sexo   =  strclean($_POST['sexo']);
                $id_carrera = Intval(strclean($_POST['id_carrera']));
                $id_usuario = Intval(strclean($_POST['id_usuario']));
                $validate_data = array($id_alumno,$cedula,$nombre,$apellido,$email_personal,$telefono,$sexo,$id_carrera,$id_usuario);

                if(!validateEmptyFields($validate_data)){
                    $data = array('status' => false,'msg' => "Verifique que algunos de los campos no se encuentre vacio");
                }
                
                if(!empty(preg_matchall(array($nombre,$apellido),regex_string))){
                    $data = array('status' => false,'formErrors'=> array(
                        'nombre' => "El nombre contiene numero o caracteres especiales",
                        'apellido' => "La apellido contiene numero o caracteres especiales",
                    ));
                }

                if(!empty(preg_matchall(array($id_carrera,$id_alumno,$id_usuario),regex_numbers))){
                    $data = array('status' => false,'formErrors'=> array(
                        'id_carrera' => "La carrera contiene letras o caracteres especiales",
                        'id_usuario' => "El usuario contiene letras o caracteres especiales",
                    ));
                }

                if ($id_alumno == 0){
                    if (empty($_SESSION['permisos_modulo']['w'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                        $response_alumno = 0;
                    }else{
                        $response_alumno = $this->model->insertAlumno($cedula,$nombre,$apellido,$email_personal,
                                        $telefono,$sexo,$id_carrera,$id_usuario);
                        $option = 1;
                    }
                }

                if ($response_alumno > 0){ 
                    if ($option == 1){
                        $data = array('status' => true, 'msg' => 'Datos guardados correctamente');
                    }
                }else if ($response_alumno == 'exist'){
                    $data = array('status' => false,'formErrors'=> array(
                        'cedula' => "La cedula ".$cedula." ya existe, ingrese uno nuevo",
                    ));
                }else{
                    $data = array('status' => false,'msg' => 'Hubo un error no se pudieron guardar los datos');
                }
            }else{
                header('location:'.server_url.'Errors');
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function getSelectUsuarios(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if(empty($_POST)){
                    $request_data =  $this->model->selectUsuariosNoInactivos('');
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_usuario'], "text"=>$row['usuario'],
                        "descripcion" => $row['email_institucional'], "rol" => $row['nombre_rol']);
                    }
                }else{
                    $search_usuario = strclean($_POST['search']);
                    $request_data = $this->model->selectUsuariosNoInactivos($search_usuario);
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_usuario'], "text"=>$row['usuario'],
                        "descripcion" => $row['email_institucional'], "rol" => $row['nombre_rol']);
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