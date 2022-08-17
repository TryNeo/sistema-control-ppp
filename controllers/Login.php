<?php
    require_once ("./libraries/core/controllers.php");
    class Login extends Controllers{
        public function __construct(){
            session_start();
            session_regenerate_id();
            if (isset($_SESSION['login'])) {
                header('location:'.server_url.'dashboard');
            }
            parent::__construct();
        }
        
        public function login(){
            if (empty($_SESSION['token'])) {
                $_SESSION['token'] = bin2hex(random_bytes(32));
                $_SESSION['token-expire'] = time() + 30*60;
            }
            $token = $_SESSION['token'];
            $data["page_id"] = 4;
            $data["tag_pag"] = "Login";
            $data["page_title"] = "Login - Iniciar sesión";
            $data["page_name"] = "login";
            $data["page"] = "login";
            $data["csrf"] = $token;
            $this->views->getView($this,"login",$data);

        }

        public function loginUser(){
            if ($_POST) {
                if(empty(preg_matchall(array(strclean($_POST['password'])),regex_password))){
                    if (empty(strclean($_POST['email'])) || empty(strclean($_POST['password']))) {
                        $data = array('status' => false,'formErrors'=> array(
                            'email' => 'el campo email se encuentra vacio',
                            'password' => 'el campo password se encuentra vacio'
                        ));
                    }else{ 

                        if (empty($_POST['csrf'])) {
                            $data = array('status' => false,'msg' => 'Oops hubo un error, intentelo de nuevo','formErrors'=> array());
                        }else{
                            if (hash_equals($_SESSION['token'], $_POST['csrf'])) {
                                
                                if (time() >=  $_SESSION['token-expire']){
                                    $data = array('status' => false,'msg' => 'Hubo un error, recargue la pagina porfavor');
                                }


                                if (isset($_POST['remember'])){
                                    if(strclean($_POST['remember']) == 1){
                                        setcookie('unemail',$_POST['email'],time()+30 * 60,"/");
                                        setcookie('upass',$_POST['password'],time()+30 * 60,"/");
                                    }
                                }
                                
                                $str_email = strtolower(strclean($_POST['email']));
                                $str_password = strclean($_POST['password']);
                                $request_user = $this->model->login_user($str_email);
                                if (empty($request_user)) {
                                    $data = array('status' => false,'msg' => 'Las Credenciales no son validas',
                                        'formErrors'=> array());
                                }else{
                                    $data = $request_user;
                                    if ($data['estado'] == 1) {
                                        if(password_verify($str_password,$data['password'])){
                                            $_SESSION['id_usuario'] = $data['id_usuario'];
                                            $_SESSION['login'] = true;
                                            $arrResponse = $this->model->sessionLogin($_SESSION['id_usuario']);
                                            $_SESSION['user_data'] = $arrResponse;
                                            unset($_SESSION['token']);
                                            unset($_SESSION['token-expire']);
                                            $data = array('status' => true,'msg' => 'Ha iniciado sesión correctamente','url' => server_url."dashboard");
                                        }else{
                                            $data = array('status' => false,'formErrors'=> array(
                                                    'password' => 'la contraseña es incorrecta'
                                            ));
                                        }
                                    }
                                }
                            } else {
                                $data = array('status' => false,'msg' => 'Oops hubo un error, intentelo de nuevo');
                            }
                        }
                    }
                }else{
                    $data = array('status' => false,'formErrors'=> array(
                        'email' => 'El campo usuario es obligatorio',
                        'password' => 'El campo contraseña es obligatorio',
                    ));
                }
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        
    }