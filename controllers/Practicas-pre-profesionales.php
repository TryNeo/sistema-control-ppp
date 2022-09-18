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

        
    }