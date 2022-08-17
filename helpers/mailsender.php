<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ("./phpmailer/Exception.php");
require_once ("./phpmailer/PHPMailer.php");
require_once ("./phpmailer/SMTP.php");

class MailSender {

	var $mailer;
	var $template;
	var $body = '';
	var $body_alt = '';

	public function __construct($host, $username, $password, $isHTML = false) {
		$mail = new PHPMailer;
		$mail->isSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 0;  
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host = $host;  			
        $mail->Username = $username;   
		$mail->Password = $password;    
        $mail->isHTML($isHTML);       
		$mail->CharSet = 'UTF-8';
		$this->mailer = $mail;
	}

	public function setTemplateURL($path) {
		$this->template = $path;
		$this->body = file_get_contents($this->template);
	}

	public function setBodyAlt($string) {
		$this->body_alt = $string;
	}

	public function compose($args) {
		if(is_array($args)) {
			foreach($args as $key => $value){
				if(!is_array($value)) $this->body = preg_replace('/{{'.$key.'}}/', $value, $this->body);	
			}
		}
	}

    public function sendEmail($from,$to,$subject,$errors = array('Hubo un error al enviar el enlance al correo, intentelo nuevamente ','Hemos enviado un enlance de restablecimiento de contraseña')){

        if(is_array($from) and is_array($to)){
            $this->mailer->setFrom($from[0], $from[1]);
            $this->mailer->addAddress($to[0]);
        } 
		$this->mailer->Subject = $subject;
        $this->mailer->MsgHTML($this->body);
        $this->mailer->AltBody = strip_tags($this->body);

        if (!$this->mailer->send()) {
            $data = array('status' => false,'msg' => $errors[0].$this->mailer->ErrorInfo);
        } else {
            $data = array('status' => true, 'msg' => $errors[1], 'url' => server_url.'login');
        }
        return $data;
    }
}
