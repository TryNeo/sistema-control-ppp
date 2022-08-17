<?php
    require_once ("./libraries/core/controllers.php");

    class Roles extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(3);
        }

        public function roles(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 3;
            $data["tag_pag"] = "Roles";
            $data["page_title"] = "Roles | Inicio";
            $data["page_name"] = "Listado de Roles";
            $data['page'] = "roles";
            $this->views->getView($this,"roles",$data);

        }

        public function getRoles(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectRoles();
                for ($i=0; $i < count($data); $i++) { 
                    $btnPermisoRol = '';
                    $btnEditarRol = '';
                    $btnEliminarRol='';
    
                   if ($data[$i]['estado'] == 1){
                       $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-custom-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                   }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-custom-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                   }
                   
          
    
                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnEditarRol = '<button class="btn btn-primary btnEditarRol btn-circle " title="editar" 
                        onClick="return clickModalEditing('."'getRol/".$data[$i]['id_rol']."'".','."'Actualizacion | Rol'".','."'id_rol'".','."['nombre_rol','descripcion']".','."'#modalRol'".');">
                        <i class="fa fa-edit"></i></button>';
                    }
    
                    
                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarRol = '<button  class="btn btn-danger btn-circle btnEliminarRol" 
                        title="eliminar" onClick="return deleteServerSide('."'delRol/'".','.$data[$i]['id_rol'].','."'¿Desea eliminar el Rol ".$data[$i]['nombre_rol']."?'".','."'.tableRol'".');"><i class="far fa-thumbs-down"></i></button>';
                    }
    
                    $data[$i]['opciones'] = $btnEditarRol.' '.$btnEliminarRol;
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getRol(int $id_rol){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $id_rol  = Intval(strclean($id_rol));
                if(validateEmptyFields([$id_rol])){
                    if(empty(preg_matchall([$id_rol],regex_numbers))){
                        if ($id_rol > 0){
                            $data = $this->model->selectRol($id_rol);
                            if (empty($data)){
                                $data_response = array('status' => false,'msg'=> 'Datos no encontrados');
                            }else{
                                $data_response = array('status' => true,'msg'=> $data);
                            }
                        }
                    }else{
                        $data = array('status' => false,'msg' => 'El campo estan mal escrito , verifique y vuelva a ingresarlo');
                    }
                }else {
                    $data = array('status' => false,'msg' => 'El campo se encuentra vacio , verifique y vuelva a ingresarlo');
                }
            }
            echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
            die();
        }

        
        public function setRol(){
            if ($_POST) {
                $id_rol = Intval(strclean($_POST['id_rol']));
                $nombre_rol = ucwords(strtolower(strclean($_POST["nombre_rol"])));
                $descripcion_rol = ucwords(strtolower(strclean($_POST["descripcion"])));
                $validate_data = [$nombre_rol,$descripcion_rol];

                if(validateEmptyFields($validate_data)){
                    if(empty(preg_matchall($validate_data,regex_string))){

                        if ($id_rol == 0){
                            if (empty($_SESSION['permisos_modulo']['w'])){
                                header('location:'.server_url.'Errors');
                                $data= array("status" => false, "msg" => "Error no tiene permisos");
                                $response_rol = 0;
                            }else{
                                $response_rol = $this->model->insertRol($nombre_rol,$descripcion_rol);
                                $option = 1;
                            }
                        }else{
                            if (empty($_SESSION['permisos_modulo']['w'])){
                                header('location:'.server_url.'Errors');
                                $data= array("status" => false, "msg" => "Error no tiene permisos");
                                $response_rol = 0;
                            }else{
                                $response_rol = $this->model->updateRol($id_rol,$nombre_rol,$descripcion_rol);
                                $option = 2;
                            }
                        }

                        if ($response_rol > 0){ 
                            if ($option == 1){
                                $data = array('status' => true, 'msg' => 'Datos guardados correctamente');
                            }
    
                            if ($option == 2){
                                $data = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                            }
                        }else if ($response_rol == 'exist'){
                            $data = array('status' => false,'formErrors'=> array(
                                'nombre_rol' => "El rol ".$nombre_rol." ya existe, ingrese uno nuevo",
                            ));
                        
                        }else{
                            $data = array('status' => false,'msg' => 'Hubo un error no se pudieron guardar los datos');
                        }


                    }else{
                        $data = array('status' => false,'formErrors'=> array(
                            'nombre_rol' => "El nombre contiene numero o caracteres especiales",
                            'descripcion' => "La descripcion contiene numero o caracteres especiales",
                        ));

                    }
                }else{
                    $data = array('status' => false,'formErrors' => array(
                        'nombre_rol' => "El campo usuario se encuentra vacio",
                        'descripcion' => "La descripcion se encuentra vacio",
                    ));
                }
            }else{
                header('location:'.server_url.'Errors');
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function delRol(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if ($_POST){
                    $id_rol = intval(strclean($_POST["id"]));
                    if(validateEmptyFields([$id_rol])){
                        if(empty(preg_matchall([$id_rol],regex_numbers))){
                            $response_del = $this->model->deleteRol($id_rol);
                            if($response_del == "ok"){
                                $data = array("status" => true, "msg" => "Se ha eliminado el rol");
                            }else if ($response_del == "exist"){
                                $data = array("status" => false, "msg" => "No es posisible eliminar rol asociado a usuarios");
                            }else{
                                $data = array("status" => false, "msg" => "Error al eliminar rol");
                            }
                        }else{
                            $data = array('status' => false,'msg' => 'El campo estan mal escrito , verifique y vuelva a ingresarlo');
                        }
                    }else{
                        $data = array('status' => false,'msg' => 'El campo se encuentra vacio , verifique y vuelva a ingresarlo');
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getSelectRoles()
        {   
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $html_options = "";
                $data = $this->model->selectRolesNoInactivos();
                if (count($data) > 0) {
                    for ($i=0; $i < count($data) ; $i++) { 
                        if($data[$i]['nombre_rol'] == "Administrador" and $_SESSION['user_data']['id_rol'] == 1) {
                            $html_options .='<option value="'.$data[$i]['id_rol'].'">'.$data[$i]['nombre_rol'].'</option>';
                        }else{
                            if($data[$i]['nombre_rol'] == "Administrador"){

                            }else{
                                $html_options .='<option value="'.$data[$i]['id_rol'].'">'.$data[$i]['nombre_rol'].'</option>';
                            }
                        }
                    }
                }
                echo $html_options;                
                die();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }

    }
