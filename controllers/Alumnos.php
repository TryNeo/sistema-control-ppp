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
    }