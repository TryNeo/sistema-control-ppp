<?php
    require_once("./libraries/core/mysql.php");
    class ForgotpasswordModel extends Mysql{
        public $str_email;
        public $str_code;
        public $str_password;

        public function __construct(){
            parent::__construct();
        }

        public function searchEmail(string $str_email){
            $this->str_email = $str_email;
            $sql = "SELECT email_institucional FROM usuarios WHERE email_institucional = '$this->str_email' and estado = 1 and email_activo = 1";
            $request = $this->select_sql($sql);
            return $request;
        } 

        public function generateCodeEmail(string $code,string $str_email){
            $this->str_email = $str_email;
            $this->str_code = $code;
            $sql_udpate = "UPDATE usuarios SET code = ?,fecha_modifica = now()  WHERE email_institucional = '$this->str_email'";
            $data = array($this->str_code);
            $request_update = $this->update_sql($sql_udpate,$data);
            return $request_update;
        }

        public function verifyCodeEmail(string $code){
            $this->str_code = $code;
            $sql = "SELECT * FROM usuarios WHERE code = '$this->str_code' and estado = 1 and email_activo = 1";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function resetCodeEmail(string $str_email){
            $this->str_email = $str_email;
            $sql_udpate  = "UPDATE usuarios SET code = ? ,fecha_modifica = now() WHERE email_institucional =  '$this->str_email' ";
            $data = array('0');
            $request_update = $this->update_sql($sql_udpate,$data);
            return $request_update;

        }

        public function updatePassword(string $str_password,string $str_email){
            $this->str_password = $str_password;
            $this->str_email = $str_email;
            $sql_udpate  = "UPDATE usuarios SET password = ?,ultimo_online=? ,fecha_modifica = now() WHERE email_institucional =  '$this->str_email' ";
            $data = array($this->str_password,0);
            $request_update = $this->update_sql($sql_udpate,$data);
            return $request_update;
        }



    }

?>