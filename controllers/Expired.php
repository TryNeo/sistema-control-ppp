<?php
require_once("./libraries/core/controllers.php");
require_once("./models/LogoutModel.php");

class expired extends Controllers
{
    public function __construct()
    {
        session_start();
        session_regenerate_id();
        parent::__construct();
        
    }

    public function expired()
    {   
        if (empty($_SESSION['permisos_modulo']['r'])) { 
            header('location:'.server_url.'Errors');
        }
        
        $logout = new LogoutModel();
        $logout->updateLastLogin($_SESSION['id_usuario']);
        session_unset();
        session_destroy();
        $data['page_title'] = "Ha expirado la sesión";
        $error = "errorExpired";
        $this->views->getView($this, $error, $data);
    }
}
