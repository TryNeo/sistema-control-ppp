<?php
    require_once ("./libraries/core/controllers.php");

    class Logout extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if(isset($_SESSION['id_usuario'])){
                $this->model->updateLastLogin($_SESSION['id_usuario']);
                session_unset();
                session_destroy();
                session_regenerate_id(true);
                header('location:'.server_url.'login');
            }else{
                header('location:'.server_url.'Errors');
            }

        }

    }

