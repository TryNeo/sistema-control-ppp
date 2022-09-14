<?php
    require_once ("./libraries/core/controllers.php");

    class Empresas extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(8);
        }

        public function empresas(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 8;
            $data["tag_pag"] = "Empresas";
            $data["page_title"] = "Empresas | Inicio";
            $data["page_name"] = "Listado de Empresas";
            $data['page'] = "empresas";
            $this->views->getView($this,"empresas",$data);
        }

        public function getEmpresas(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectEmpresas();
                for ($i=0; $i < count($data); $i++) { 
                    $btnEditarEmpresa='';
                    $btnEliminarEmpresa='';

                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-custom-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-custom-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    }

                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnEditarEmpresa = '<button class="btn btn-primary btnEditarEmpresa btn-circle " title="editar" 
                        onClick="return clickModalEditing('."'getEmpresa/".$data[$i]['id_empresa']."'".','."'Actualizacion | Empresa'".','."'id_empresa'".','."['ruc_empresa','nombre_empresa','direccion_empresa','correo_empresa',
                        'telefono_empresa','cedula_representante','nombre_representante','telefono_representante','descripcion_empresa']".','."'#modalEmpresa'".');">
                        <i class="fa fa-edit"></i></button>';
                    }


                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarEmpresa = '<button  class="btn btn-danger btn-circle btnEliminarAlumno" 
                            title="eliminar" onClick="return deleteServerSide('."'delEmpresa/'".','.$data[$i]['id_empresa'].','."'¿Desea eliminar la empresa ".$data[$i]['nombre_empresa']."?'".','."'.tableEmpresa'".');"><i class="far fa-thumbs-down"></i></button>';
                    }

                    $data[$i]['opciones'] = $btnEditarEmpresa." ".$btnEliminarEmpresa;
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function getEmpresa(int $id_empresa){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $id_empresa  = Intval(strclean($id_empresa));
                if(!validateEmptyFields([$id_empresa])){
                    $data = array('status' => false,'msg' => 'El campo se encuentra vacio , verifique y vuelva a ingresarlo');
                }

                if(!empty(preg_matchall([$id_empresa],regex_numbers))){
                    $data = array('status' => false,'msg' => 'El campo estan mal escrito , verifique y vuelva a ingresarlo');
                }

                if ($id_empresa > 0){
                    $data = $this->model->selectEmpresa($id_empresa);
                    if (!empty($data)){
                        $data_response = array('status' => false,'msg'=> 'Datos no encontrados');
                    }
                    $data_response = array('status' => true,'msg'=> $data);
                }
            }
            echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
            die();
        }



        public function setEmpresa(){
            if ($_POST) {
                $id_empresa = Intval(strclean($_POST['id_empresa']));
                $ruc_empresa = strclean($_POST['ruc_empresa']);
                $nombre_empresa = ucwords(strtolower(strclean($_POST['nombre_empresa'])));
                $direccion_empresa = strclean($_POST['direccion_empresa']);
                $correo_empresa = strclean($_POST['correo_empresa']);
                $telefono_empresa = strclean($_POST['telefono_empresa']);
                $cedula_representante = strclean($_POST['cedula_representante']);
                $nombre_representante = ucwords(strtolower(strclean($_POST['nombre_representante'])));
                $telefono_representante = strclean($_POST['telefono_representante']);
                $descripcion_empresa = ucwords(strtolower(strclean($_POST['descripcion_empresa'])));
                
                $validate_data = array($id_empresa,$ruc_empresa,$nombre_empresa,$direccion_empresa,$correo_empresa,
                    $telefono_empresa,$cedula_representante,$nombre_representante,$telefono_representante);

                if(!validateEmptyFields($validate_data)){
                    $data = array('status' => false,'msg' => "Verifique que algunos de los campos no se encuentre vacio");
                }

                if ($id_empresa == 0){
                    if (empty($_SESSION['permisos_modulo']['w'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                        $response_empresa = 0;
                    }else{
                        $response_empresa = $this->model->insertEmpresa($ruc_empresa,$nombre_empresa,
                                    $direccion_empresa,$correo_empresa,$telefono_empresa,$cedula_representante,
                                    $nombre_empresa,$telefono_representante,$descripcion_empresa);
                        $option = 1;
                    }
                }else{
                    if (empty($_SESSION['permisos_modulo']['u'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                        $response_empresa = 0;
                    }else{
                        $response_empresa = $this->model->updateEmpresa($id_empresa,$ruc_empresa,$nombre_empresa,
                                    $direccion_empresa,$correo_empresa,$telefono_empresa,$cedula_representante,
                                    $nombre_empresa,$telefono_representante,$descripcion_empresa);
                        $option = 2;
                    }
                }
                if ($response_empresa > 0){ 
                    if ($option == 1){
                        $data = array('status' => true, 'msg' => 'Datos guardados correctamente');
                    }
                    if ($option == 2){
                        $data = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                    }
                }else if ($response_empresa == 'exist'){
                    $data = array('status' => false,'formErrors'=> array(
                            'ruc_empresa' => "El Ruc ".$ruc_empresa." ya existe, ingrese uno nuevo",
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


        public function delEmpresa(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{

                if (!$_POST){
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }

                $id_empresa = intval(strclean($_POST["id"]));

                if(!validateEmptyFields([$id_empresa])){
                    $data = array('status' => false,'msg' => 'El campo se encuentra vacio , verifique y vuelva a ingresarlo');
                }

                if(!empty(preg_matchall([$id_empresa],regex_numbers))){
                    $data = array('status' => false,'msg' => 'El campo estan mal escrito , verifique y vuelva a ingresarlo');
                }

                $response_del = $this->model->deleteEmpresa($id_empresa);
                if($response_del == "ok"){
                    $data = array("status" => true, "msg" => "Se ha eliminado la empresa");
                }else{
                    $data = array("status" => false, "msg" => "Error al eliminar la empresa");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }



    }