<?php
require_once("./libraries/core/controllers.php");
require_once("./config/secretinfo.php");
require_once("./helpers/mailsender.php");
class Forgotpassword extends Controllers
{
    public function __construct()
    {
        session_start();
        session_regenerate_id();
        if (isset($_SESSION['login'])) {
            header('location:' . server_url . 'dashboard');
        }
        parent::__construct();
    }

    public function forgotpassword()
    {
        if (empty($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['token'];
        $data["page_id"] = 11;
        $data["tag_pag"] = "Forgot";
        $data["page_title"] = "Restablecer contraseña";
        $data["page_name"] = "forgotpassword";
        $data["page"] = "forgotpassword";
        $data["csrf"] = $token;
        $this->views->getView($this, "forgotpassword", $data);
    }


    public function sendEmailCode()
    {
        if ($_POST) {
            $emaiL_user = strtolower(strclean($_POST["emailuser"]));
            $recaptcha_response = strclean($_POST["g-recaptcha-response"]);
            if (validateEmptyFields(array($emaiL_user))) {

                if (empty($_POST['csrf']) != 0) {
                    $data = array('status' => false, 'msg' => 'Oops hubo un error, intentelo de nuevo', 'formErrors' => array());
                }
                if (hash_equals($_SESSION['token'], $_POST['csrf'])) {
                    $cu = curl_init();
                    curl_setopt($cu, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                    curl_setopt($cu, CURLOPT_POST, 1);
                    curl_setopt($cu, CURLOPT_POSTFIELDS, http_build_query(array('secret' => GOOGLE_KEY, 'response' => $recaptcha_response)));
                    curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($cu);
                    curl_close($cu);
                    $datos = json_decode($response, true);

                    if ($datos['success'] == 1 && $datos['score'] >= 0.5) {
                        $request_email = $this->model->searchEmail($emaiL_user);
                        if (empty($request_email) != 0) {
                            $data = array(
                                'status' => false, 'msg' => 'El email ingresado no existe, verifique que este escrito bien y vuelva a ingresarlo',
                                'formErrors' => array()
                            );
                        }
                        $code = bin2hex(random_bytes(32));
                        $request_email_code = $this->model->generateCodeEmail($code, $emaiL_user);
                        if ($request_email_code > 0) {
                            $mail = new MailSender('smtp.gmail.com', CORREO, CONTRASEÑA, true);
                            $mail->setTemplateURL('./views/template/mail/mail_forgotpassword.html');
                            $mail->compose(array(
                                'link' => "'" . server_url . 'forgotpassword/reset?token=' . $code . "'",
                            ));
                            $_SESSION['emailtemp'] = $emaiL_user;
                            $_SESSION['token-expire'] = time() + 5 * 60;
                            $data = $mail->sendEmail(array(
                                CORREO, 'Gestoria PPP'
                            ), array(
                                $emaiL_user
                            ), 'Restablece tu contraseña de Gestoria PPP');
                        }
                    } else {
                        $data = array('status' => false, 'msg' => 'El  reCAPTCHA ha sido invalido, recargue la pagiina e  intentelo nuevamente');
                    }
                } else {
                    $data = array('status' => false, 'msg' => 'Oops hubo un error, intentelo de nuevo');
                }
            } else {
                $data = array('status' => false, 'formErrors' => array(
                    'emailuser' => 'el campo email se encuentra vacio',
                ));
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    public function reset()
    {
        if (isset($_GET['token'])) {
            if (empty($_SESSION['token'])) {
                $_SESSION['token'] = bin2hex(random_bytes(32));
            }
            $token = strclean($_SESSION['token']);
            $data['csrf'] = $token;
            $request_email_code = $this->model->verifyCodeEmail(strclean($_GET['token']));
            if ($request_email_code > 0) {
                if (isset($_SESSION['token-expire']) and  isset($_SESSION['emailtemp'])) {
                    if ($_SESSION['token-expire'] != NULL and $_SESSION['emailtemp'] != NULL) {
                        if (time() >=  $_SESSION['token-expire']) {
                            $this->model->resetCodeEmail($_SESSION['emailtemp']);
                            $data_res = array("status" => false, "msg" => "El token a expirado, porfavor reenvie el enlace para restablecer su contraseña nuevamente");
                        } else {
                            $data_res = array("status" => true);
                        }
                    }
                } else {
                    $data_res = array("status" => false, "msg" => "Error !, Esta tratando de reestablacer su contraseña en distintos navagedores");
                }
            } else {
                $data_res = array("status" => false, "msg" => "El token a expirado, porfavor reenvie el enlace para restablecer su contraseña nuevamente");
            }
        } else {
            header('location:' . server_url . 'login');
        }
        $data["error"] = json_encode($data_res, JSON_UNESCAPED_UNICODE);
        $this->views->getView($this, "reset", $data);
        die();
    }

    public function resetPassword()
    {
        if ($_POST) {
            if (!isset($_SESSION['token-expire'])) {
                header('location:' . server_url . 'Errors');
            }

            if (!$_SESSION['token-expire'] != NUlL) {
                header('location:' . server_url . 'Errors');
            }
            if (!time() >=  $_SESSION['token-expire']) {
                $data = array("status" => false, "msg" => "El token a expirado, porfavor reenvie el enlace para restablecer su contraseña nuevamente");
            }

            if (!empty($_POST['csrf'])) {
                $data = array('status' => false, 'msg' => 'Oops hubo un error, intentelo de nuevo', 'formErrors' => array());
            }

            if (hash_equals(strclean($_SESSION['token']), strclean($_POST['csrf']))) {
                $password = strclean($_POST['password']);
                $password_confirm = strclean($_POST['password_confirm']);
                if (validateEmptyFields(array($password, $password_confirm))) {
                    if ($password != $password_confirm) {
                        $data = array("status" => false, "msg" => "Las contraseñas no coinciden, verifique que estén escritas bien");
                    }
                    $str_password = password_hash(strclean($_POST['password']), PASSWORD_DEFAULT, ['cost' => 10]);
                    $response = $this->model->updatePassword($str_password, $_SESSION['emailtemp']);
                    if ($response > 0) {
                        $this->model->resetCodeEmail($_SESSION['emailtemp']);
                        $data = array("status" => true, "msg" => "La contraseña ha sido cambiado con exito", 'url' => server_url . 'login');
                        unset($_SESSION['token']);
                        unset($_SESSION['emailtemp']);
                        unset($_SESSION['token-expire']);
                    } else {
                        $data = array("status" => false, "msg" => "La contraseña no ha sido cambia con exito, intentelo nuevamente");
                    }
                } else {
                    $data = array('status' => false, 'formErrors' => array(
                        'password' => 'el campo se encuentra vacio',
                        'password_confirm' => 'el campo se encuentra vacio',
                    ));
                }
            } else {
                $data = array('status' => false, 'msg' => 'Oops hubo un errors, intentelo de nuevo');
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            header('location:' . server_url . 'login');
        }
        die();
    }
}
