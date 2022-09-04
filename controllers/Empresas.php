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


    }