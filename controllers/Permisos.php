<?php
    require_once ("./libraries/core/controllers.php");

    class Permisos extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(5);
        }

        public function permisos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 5;
            $data["tag_pag"] = "Permisos";
            $data["page_title"] = "Permisos | Inicio";
            $data["page_name"] = "Listado de Permisos";
            $data['page'] = "permisos";
            $this->views->getView($this,"permisos",$data);

        }

        public function getPermisos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $request_data = $this->model->selectPermisos();
                for ($i=0; $i < count($request_data); $i++) { 
                    $btnEditarPermiso = '';
                    $btnEliminarPermiso ='';
                    $request_data[$i]['modulos'] = "<b>".str_replace(",", "<br>", $request_data[$i]['modulos'])."</b>";
                    
                    if ($_SESSION['permisos_modulo']['u']) {
                        if ($_SESSION['user_data']['id_rol'] != 1 and $request_data[$i]['id_rol'] != 1 ){
                            $btnEditarRol = '<button class="btn btn-primary btnEditarRol btn-circle " title="editar" 
                                onClick="return clickModalEditingPermisos('.$request_data[$i]['id_rol'].');">
                                <i class="fa fa-edit"></i></button>';
                        }else{
                            if($_SESSION['user_data']['id_rol'] == 1){
                                $btnEditarRol = '<button class="btn btn-primary btnEditarRol btn-circle " title="editar" 
                                onClick="return clickModalEditingPermisos('.$request_data[$i]['id_rol'].');">
                                <i class="fa fa-edit"></i></button>';
                            }else{
                                $btnEditarRol = '<button class="btn btn-primary  btn-circle " title="editar" disabled>
                                <i class="fa fa-edit"></i></button>';  
                            }

                        }
                    }

                    $request_data[$i]['opciones'] = $btnEditarRol;
                }
            }
            echo json_encode($request_data,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function getPermiso(int $id_rol){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $id_rol  = Intval(strclean($id_rol));
                if(validateEmptyFields([$id_rol])){
                    if(empty(preg_matchall([$id_rol],regex_numbers))){
                        if ($id_rol > 0){
                            $data = $this->model->selectPermiso($id_rol);
                            if (empty($data)){
                                $data_response = array();
                            }else{
                                for ($i=0; $i < count($data); $i++) { 
                                    $btnEliminarPermisoModulo ='';

                                    if ($_SESSION['permisos_modulo']['d']) {
                                        $btnEliminarPermisoModulo = '<button  class="btn btn-danger btn-circle btnEliminarPermisoModulo" 
                                        title="eliminar" onClick="return deleteServerSidePermisoModulo('.$data[$i]['id_permiso'].')"><i class="far fa-trash-alt"></i></button>';
                                    }

                                    $data[$i]['id_permiso'] = $btnEliminarPermisoModulo;
                                }
                                $data_response =  $data;
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


        public function getSelectModulos()
        {   
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if(empty($_POST)){
                    $request_data = $this->model->selectModulos('');
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_modulo'], "text"=>$row['nombre'],
                        "descripcion" => $row['descripcion']);
                    }
                }else{
                    $search_modulo = strclean($_POST['search']);
                    $request_data = $this->model->selectModulos($search_modulo);
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_modulo'], "text"=>$row['nombre'],
                        "descripcion" => $row['descripcion']);
                    }
                }            
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function getSelectSearchModulos(int $int_id_modulo){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $intEmpleado  = Intval(strclean($int_id_modulo));
                if ($intEmpleado > 0){
                    $data = $this->model->selectSearchModulo($int_id_modulo);
                    if (empty($data)){
                        $data_response = array('status' => false,'msg'=> 'Datos no encontrados');
                    }else{
                        $data_response = array('status' => true,'msg'=> $data);
                    }
                }
            }
            echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setPermisoModulo(){
            if ($_POST) {
                $intModulo = Intval(strclean($_POST['id_modulo']));
                $intRol = Intval(strclean($_POST['id_rol']));
                $request_insert_permiso = $this->model->insertPermisoModulo($intModulo,$intRol);
                if ($request_insert_permiso > 0){ 
                    if (empty($_SESSION['permisos_modulo']['w'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                    }else{
                        $data = array('status' => true);
                    }
                }else if ($request_insert_permiso == 'exist'){
                    $data = array('status' => false,'msg' => 'Error el modulo ya esta agregado');
                }else{
                    $data = array('status' => false,'msg' => 'Hubo un error no se pudieron guardar los datos');
                }
            }else{
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error Hubo problemas");
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function setPermiso(){
            if ($_POST) {
                if(isset($_POST['id_rol'])){
                    $id_rol = Intval(strclean($_POST['id_rol']));
                    $validate_data = [$id_rol];
                    if(validateEmptyFields($validate_data)){

                        if (empty($_SESSION['permisos_modulo']['w'])){
                            header('location:'.server_url.'Errors');
                            $data= array("status" => false, "msg" => "Error no tiene permisos");
                        }else{
                            $response_permiso = $this->model->insertPermiso($id_rol);
                        }


                        if ($response_permiso > 0){ 
                            $data = array('status' => true, 'msg' => 'Permiso creado correctamente');
                        }else if ($response_permiso == 'exist'){
                            $data = array('status' => false,'msg' => 'Este permiso con rol , ya ha sido creado, escoga uno diferente');
                        }else{
                            $data = array('status' => false,'msg' => 'Hubo un error no se pudieron guardar los datos');
                        }                
                    
                    }else{
                        $data = array('status' => false,'formErrors' => array(
                            'id_rol' => "El campo usuario se encuentra vacio",
                        ));
                    }
                }else{
                    $data = array('status' => false,'msg' => 'error');
                }
            }else{
                header('location:'.server_url.'Errors');
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function setPermisoCheckBox(){
            if (empty($_SESSION['permisos_modulo']['u']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if ($_POST) {
                    $id_permiso = intval(strclean($_POST['id_permiso']));
                    $id_rol = intval(strclean($_POST['id_rol']));
                    $checkbox = intval(strclean($_POST['cbox']));
                    $typePerm = strtolower(strclean($_POST["typePerm"]));
                    $validate_data = [$id_permiso,$id_rol,$checkbox];
                    if(validateEmptyFields($validate_data)){
                        if(empty(preg_matchall($validate_data,regex_numbers))){
                            if ($typePerm == "read"){
                                $response_update = $this->model->updatePermisoModulo($id_permiso,$id_rol,$checkbox,$typePerm);
                            }

                            if ($typePerm == "write"){
                                $response_update = $this->model->updatePermisoModulo($id_permiso,$id_rol,$checkbox,$typePerm);
                            }

                            if ($typePerm == "update"){
                                $response_update = $this->model->updatePermisoModulo($id_permiso,$id_rol,$checkbox,$typePerm);
                            }

                            if ($typePerm == "delete"){
                                $response_update = $this->model->updatePermisoModulo($id_permiso,$id_rol,$checkbox,$typePerm);
                            }

                            dep($response_update);
                        }else{
                            $data = array('status' => false,'msg' => 'Los campos estan mal escritos, verifique y vuelva a ingresarlo');
                        }
                    }else{
                        $data = array('status' => false,'msg' => 'Los campo se encuentra vacio , verifique y vuelva a ingresarlo');
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
    
    
        public function delPermisoModulo(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if ($_POST){
                    $id_permiso = intval(strclean($_POST["id_permiso"]));
                    $id_rol = intval(strclean($_POST["id_rol"]));
                    if(validateEmptyFields([$id_permiso,$id_rol])){
                        if(empty(preg_matchall([$id_permiso,$id_rol],regex_numbers))){
                            $response_del = $this->model->deletePermisoModulo($id_permiso,$id_rol);
                            if ($response_del == "ok"){
                                $data = array("status" => true, "msg" => "permiso eliminado correctamente");
                            }else{
                                $data = array("status" => false, "msg" => "Error hubo problemas al eliminar el permiso");
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
}