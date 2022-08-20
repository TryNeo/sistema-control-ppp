<?php
    require_once ("./libraries/core/controllers.php");

    class Usuarios extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(2);

        }

        public function usuarios(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }

            $data['page_id'] = 2;
            $data["tag_pag"] = "Usuarios";
            $data["page_title"] = "Usuarios| Inicio";
            $data["page_name"] = "Listado de usuarios";
            $data['page'] = "usuario";
            $this->views->getView($this,"usuarios",$data);

        }

        public function getUsuarios(){
            if (empty($_SESSION['permisos_modulo']['r'])) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectUsuarios();
                for ($i=0; $i < count($data); $i++) { 
                    
                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-custom-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-1">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-custom-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-1">Inactivo</span></span>';
                    }

                    if ($data[$i]['ultimo_online'] == 1){
                        $data[$i]['ultimo_online']= '<span  class="btn btn-success btn-icon-split btn-custom-sm"><i class="icon fas fa-signal"></i><span class="label text-padding text-white-1">&nbsp;&nbsp;Online</span></span>';
                    }else{
                        $data[$i]['ultimo_online']='<span  class="btn btn-danger btn-icon-split btn-custom-sm"><i class="icon fas fa-ban"></i><span class="label text-padding text-white-1">0ffline</span></span>';
                    }
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function setUsuario(){
            if ($_POST) {
                $id_usuario = intval(strclean($_POST['id_usuario']));
                $usuario_name = strclean($_POST['usuario']);
                $email_institucional = strclean($_POST['email_institucional']);
                $id_rol_usuario = intval(strclean($_POST['id_rol']));
                $validate_data = array($id_usuario,$usuario_name,$email_institucional,$id_rol_usuario);

                if(validateEmptyFields($validate_data)){

                    if(!empty(preg_matchall(array($usuario_name),regex_username))){
                        $data = array('status' => false,'formErrors' => array(
                            'usuario' => 'El usuario '.$usuario_name.' ingresada no es valido',
                        ));
                    }

                    if ($id_usuario == 0){
                        if (empty($_SESSION['permisos_modulo']['w'])){
                            header('location:'.server_url.'Errors');
                            $data= array("status" => false, "msg" => "Error no tiene permisos");
                            $response_usuario = 0;
                        }else{
                            $str_password = password_hash(strclean($_POST['password']),PASSWORD_DEFAULT,['cost' => 10]);
                            $response_usuario = $this->model->insertUsuario(
                                                                    $usuario_name,
                                                                    $email_institucional,
                                                                    $str_password,
                                                                    $id_rol_usuario
                                                                    );
                            $option = 1;
                        }
                    }else{

                    }

                    if ($response_usuario > 0){ 
                        if ($option == 1){
                            $data = array('status' => true, 'msg' => 'Datos guardados correctamente');
                        }

                        if ($option == 2){
                            $data = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                        }
                    
                    }else if ($response_usuario== 'exist'){
                        $data = array('status' => false,'formErrors'=> array(
                            'usuario' => "El usuario ".$usuario_name." ya existe, ingrese uno nuevo",
                        ));
                    }else{
                        $data = array('status' => false,'msg' => 'Hubo un error no se pudieron guardar los datos');
                    }
                }else{
                    $data = array('status' => false,'msg' => "Verifique que algunos de los campos no se encuentre vacio");
                }
            }else{
                $data = array("status" => false, "msg" => "Error Hubo problemas");
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();

        }

    }

