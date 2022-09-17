<?php
    require_once ("./libraries/core/controllers.php");

    class Profesores extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(7);
        }

        public function profesores(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 7;
            $data["tag_pag"] = "Profesores";
            $data["page_title"] = "Docentes | Inicio";
            $data["page_name"] = "Listado de Docentes";
            $data['page'] = "profesores";
            $this->views->getView($this,"profesores",$data);
        }

        public function getProfesores(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectProfesores();
                for ($i=0; $i < count($data); $i++) { 
                    $btnEliminarProfesor = '';
                    $btnEditarProfesor = '';

                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-custom-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-custom-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    }


                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnEditarProfesor = '<button class="btn btn-primary btn-circle " title="editar" 
                        onClick="return clickModalEditingPr('."'getProfesor/".$data[$i]['id_profesor']."'".
                        ','."'Actualizacion | Profesor'".','."'id_profesor'".','."['cedula','email_personal','nombre','apellido','telefono']".
                        ','."'#modalProfesor'".','.'true'.','."['sexo','id_campus']".','.'true'.','."'#id_usuario'".');">
                        <i class="fa fa-edit"></i></button>';
                    }


                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarProfesor = '<button  class="btn btn-danger btn-circle btnEliminarProfesor" 
                            title="eliminar" onClick="return deleteServerSide('."'delProfesor/'".','.$data[$i]['id_profesor'].','."'¿Desea eliminar el docente ".$data[$i]['nombre']." ".$data[$i]['apellido']."?'".','."'.tableProfesores'".');"><i class="far fa-thumbs-down"></i></button>';
                    }

                    $data[$i]['opciones'] = $btnEditarProfesor .' '.$btnEliminarProfesor;
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getSelectCampus()
        {   
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $html_options = "";
                $data = $this->model->selectCampusNoInactivos();
                if (count($data) > 0) {
                    for ($i=0; $i < count($data) ; $i++) { 
                        $html_options .='<option value="'.$data[$i]['id_campus'].'">'.$data[$i]['nombre_campus'].'</option>';
                    }
                }
                echo $html_options;                
                die();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }


        public function setProfesor(){
            if ($_POST) {
                $id_profesor = Intval(strclean($_POST['id_profesor']));
                $cedula = strclean($_POST['cedula']);
                $nombre = ucwords(strtolower(strclean($_POST['nombre'])));
                $apellido = ucwords(strtolower(strclean($_POST['apellido'])));
                $email_personal = strtolower(strclean($_POST['email_personal']));
                $telefono = strclean($_POST['telefono']);
                $sexo   =  strclean($_POST['sexo']);
                $id_campus = Intval(strclean($_POST['id_campus']));
                if ($id_profesor == 0) {
                    $id_usuario = Intval(strclean($_POST['id_usuario']));
                }else{
                    $id_usuario = 1;
                }
                
                $validate_data = array($id_profesor,$cedula,$nombre,$apellido,$email_personal,$telefono,$sexo,$id_campus,$id_usuario);

                if(!validateEmptyFields($validate_data)){
                    $data = array('status' => false,'msg' => "Verifique que algunos de los campos no se encuentre vacio");
                }
                
                if(!empty(preg_matchall(array($nombre,$apellido),regex_string))){
                    $data = array('status' => false,'formErrors'=> array(
                        'nombre' => "El nombre contiene numero o caracteres especiales",
                        'apellido' => "La apellido contiene numero o caracteres especiales",
                    ));
                }

                if(!empty(preg_matchall(array($id_campus,$id_usuario),regex_numbers))){
                    $data = array('status' => false,'formErrors'=> array(
                        'id_campus' => "La carrera contiene letras o caracteres especiales",
                        'id_usuario' => "El usuario contiene letras o caracteres especiales",
                    ));
                }

                if ($id_profesor == 0){
                    if (empty($_SESSION['permisos_modulo']['w'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                        $response_profesor = 0;
                    }else{
                        $response_profesor = $this->model->insertProfesor($cedula,$nombre,$apellido,$email_personal,
                                        $telefono,$sexo,$id_campus,$id_usuario);
                        $option = 1;
                    }
                }else{
                    if (empty($_SESSION['permisos_modulo']['u'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                        $response_profesor = 0;
                    }else{
                        $response_profesor = $this->model->updateProfesor($id_profesor,$cedula,$nombre,$apellido,$email_personal,
                                        $telefono,$sexo,$id_campus);
                        $option = 2;
                    }
                }

                if ($response_profesor > 0){ 
                    if ($option == 1){
                        $data = array('status' => true, 'msg' => 'Datos guardados correctamente');
                    }
                    if ($option == 2){
                        $data = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                    }
                }else if ($response_profesor == 'exist'){
                    $data = array('status' => false,'formErrors'=> array(
                        'cedula' => "La cedula ".$cedula." ya existe, ingrese uno nuevo",
                    ));
                }else if ($response_profesor == 'error_email') { 
                    $data = array('status' => false,'formErrors'=> array(
                        'email_personal' => "El email ".$email_personal." no puede ser igual al del usuario",
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



        public function getProfesor(int $id_profesor){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $id_profesor  = Intval(strclean($id_profesor));
                if(!validateEmptyFields([$id_profesor])){
                    $data = array('status' => false,'msg' => 'El campo se encuentra vacio , verifique y vuelva a ingresarlo');
                }

                if(!empty(preg_matchall([$id_profesor],regex_numbers))){
                    $data = array('status' => false,'msg' => 'El campo estan mal escrito , verifique y vuelva a ingresarlo');
                }

                if ($id_profesor > 0){
                    $data = $this->model->selectProfesor($id_profesor);
                    if (!empty($data)){
                        $data_response = array('status' => false,'msg'=> 'Datos no encontrados');
                    }
                    $data_response = array('status' => true,'msg'=> $data);
                }
            }
            echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
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

        public function delProfesor(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{

                if (!$_POST){
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }

                $id_profesor = intval(strclean($_POST["id"]));

                if(!validateEmptyFields([$id_profesor])){
                    $data = array('status' => false,'msg' => 'El campo se encuentra vacio , verifique y vuelva a ingresarlo');
                }

                if(!empty(preg_matchall([$id_profesor],regex_numbers))){
                    $data = array('status' => false,'msg' => 'El campo estan mal escrito , verifique y vuelva a ingresarlo');
                }

                $response_del = $this->model->deleteProfesor($id_profesor);
                if($response_del == "ok"){
                    $data = array("status" => true, "msg" => "Se ha eliminado el profesor");
                }else{
                    $data = array("status" => false, "msg" => "Error al eliminar profesor");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }


    }