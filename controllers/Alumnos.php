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
                    $btnEliminarAlumno = '';
                    $btnEditarAlumno = '';

                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-custom-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-custom-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    }


                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnEditarAlumno = '<button class="btn btn-primary btnEditarRol btn-circle " title="editar" 
                        onClick="return clickModalEditingAl('."'getAlumno/".$data[$i]['id_alumno']."'".
                        ','."'Actualizacion | Alumno'".','."'id_alumno'".','."['cedula','email_personal','nombre','apellido','telefono']".
                        ','."'#modalAlumno'".','.'true'.','."['sexo','id_carrera']".','.'true'.','."'#id_usuario'".');">
                        <i class="fa fa-edit"></i></button>';
                    }


                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarAlumno = '<button  class="btn btn-danger btn-circle btnEliminarAlumno" 
                            title="eliminar" onClick="return deleteServerSide('."'delAlumno/'".','.$data[$i]['id_alumno'].','."'¿Desea eliminar el alumno ".$data[$i]['nombre']." ".$data[$i]['apellido']."?'".','."'.tableAlumno'".');"><i class="far fa-thumbs-down"></i></button>';
                    }

                    $data[$i]['opciones'] = $btnEditarAlumno .' '.$btnEliminarAlumno;
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
                if ($id_alumno == 0) {
                    $id_usuario = Intval(strclean($_POST['id_usuario']));
                }else{
                    $id_usuario = 1;
                }
                
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
                }else{
                    if (empty($_SESSION['permisos_modulo']['u'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                        $response_alumno = 0;
                    }else{
                        $response_alumno = $this->model->updateAlumno($id_alumno,$cedula,$nombre,$apellido,$email_personal,
                                        $telefono,$sexo,$id_carrera);
                        $option = 2;
                    }
                }

                if ($response_alumno > 0){ 
                    if ($option == 1){
                        $data = array('status' => true, 'msg' => 'Datos guardados correctamente');
                    }
                    if ($option == 2){
                        $data = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                    }
                }else if ($response_alumno == 'exist'){
                    $data = array('status' => false,'formErrors'=> array(
                        'cedula' => "La cedula ".$cedula." ya existe, ingrese uno nuevo",
                        'email_personal' => "El email ".$email_personal." ya existe, ingrese uno nuevo",
                    ));
                }else if ($response_alumno == 'error_email') { 
                    $data = array('status' => false,'formErrors'=> array(
                        'email_personal' => "El email ".$email_personal." no puede ser igual al del usuario",
                    ));
                }else{
                    $data = array('status' => false,'msg' => 'Hubo un error no se pudieron guardar los datos');
                }
            }else{
                header('location:'.server_url.'Errors');
            }
            sleep(3);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getAlumno(int $id_alumno){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $id_alumno  = Intval(strclean($id_alumno));
                if(!validateEmptyFields([$id_alumno])){
                    $data = array('status' => false,'msg' => 'El campo se encuentra vacio , verifique y vuelva a ingresarlo');
                }

                if(!empty(preg_matchall([$id_alumno],regex_numbers))){
                    $data = array('status' => false,'msg' => 'El campo estan mal escrito , verifique y vuelva a ingresarlo');
                }

                if ($id_alumno > 0){
                    $data = $this->model->selectAlumno($id_alumno);
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

        public function delAlumno(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{

                if (!$_POST){
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }

                $id_alumno = intval(strclean($_POST["id"]));

                if(!validateEmptyFields([$id_alumno])){
                    $data = array('status' => false,'msg' => 'El campo se encuentra vacío, verifique y vuelva a ingresarlo');
                }

                if(!empty(preg_matchall([$id_alumno],regex_numbers))){
                    $data = array('status' => false,'msg' => 'El campo esta mal escrito, verifique y vuelva a ingresarlo');
                }

                $response_del = $this->model->deleteAlumno($id_alumno);
                if($response_del == "ok"){
                    $data = array("status" => true, "msg" => "Se ha eliminado el alumno");
                }else if ($response_del == "error_online"){
                    $data = array("status" => false, "msg" => "El alumno no se puede eliminar porque esta conectado");
                }else if ($response_del == "exist"){
                    $data = array("status" => false, "msg" => "porque tiene registros asociados en el modulo de practicas pre profesionales");
                }else{
                    $data = array("status" => false, "msg" => "Error al eliminar alumno");
                }
            }
            sleep(3);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

    }