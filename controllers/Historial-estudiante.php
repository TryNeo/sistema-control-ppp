<?php
require_once("./libraries/core/controllers.php");
require_once ("./libraries/html2pdf/vendor/autoload.php");
use Spipu\Html2Pdf\Html2Pdf;

class Historialestudiante extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location:' . server_url . 'login');
        }
        getPermisos(10);
    }

    public function historialestudiante()
    {
        if (empty($_SESSION['permisos_modulo']['r']) ) {
            header('location:'.server_url.'Errors');
        }
        $data["page_id"] = 10;
        $data["tag_pag"] = "";
        $data["page_title"] = "Historial estudiante | Inicio";
        $data["page_name"] = "Historial estudiante";
        $data['page'] = "historial-estudiante";
        $this->views->getView($this,"historial-estudiante",$data);
    }

    public function getHistorialEstudiante($search_alumno = 0)
    {
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:' . server_url . 'Errors');
            $data = array("status" => false, "msg" => "Error no tiene permisos");
        } else {
            if($_SESSION['user_data']['id_rol'] != 2){
                $id_usuario = Intval(strclean($search_alumno));
                $data = $this->model->selectHistorialAlumno($id_usuario);
            }else{
                $data = $this->model->selectHistorialAlumno($_SESSION['user_data']['id_usuario']);
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getSelectHistorialAlumno()
    {
        if (empty($_SESSION['permisos_modulo']['u'])) {
            header('location:' . server_url . 'Errors');
            $data = array("status" => false, "msg" => "Error no tiene permisos");
        } else {
            if (empty($_POST)) {
                $request_data =  $this->model->selectHistorialAlumnoSearch('');
                foreach ($request_data as $row) {
                    $data[] = array(
                        "id" => $row['id_usuario'],"cedula" => $row['cedula'],
                        "text" => $row['nombre_estudiante']
                    );
                }
            } else {
                $search_alumno = strclean($_POST['search']);
                $request_data = $this->model->selectHistorialAlumnoSearch($search_alumno);
                foreach ($request_data as $row) {
                    $data[] = array(
                        "id" => $row['id_usuario'],"cedula" => $row['cedula'],
                        "text" => $row['nombre_estudiante']
                    );
                }
            }
        }
        if (!isset($data)) {
            $data = array();
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function certificadopppempresarial($int_id_alumno = 0){
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:'.server_url.'Errors');
        }else{
            if($_SESSION['user_data']['id_rol'] != 2){
                $int_id_alumno = Intval(strclean($int_id_alumno));
                if($int_id_alumno == 0){
                    header('location:'.server_url.'Errors');
                }else{
                    $getAlumno= $this->model->selectCertificadoAlumno($int_id_alumno);
                    $date_du_jour = fechaCastellano(date("d-m-Y"));
                    $data[0] = $getAlumno;
                    $data[0]['tipo']='EMPRESARIAL';
                    $data[1] = $date_du_jour;
                    $data[3] = $this->model->selectCertificadoAlumnoDetalle($int_id_alumno,1);
                    $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
                    ob_end_clean();
                    $html = getFile('template/reporte/reporte_ppp_general',$data);
                    $html2pdf->setDefaultFont('times');
                    $html2pdf->pdf->SetTitle('Certificado practicas pre-profesionales');
                    $html2pdf->writeHTML($html);
                    $html2pdf->output('certificado_ppp_empresarial_'.date("d_m_Y_H_i").'.pdf');
                }
            }else{
                $getAlumno= $this->model->selectCertificadoAlumno($_SESSION['user_data']['id_usuario']);
                $date_du_jour = fechaCastellano(date("d-m-Y"));
                $data[0] = $getAlumno;
                $data[0]['tipo']='EMPRESARIAL';
                $data[1] = $date_du_jour;
                $data[3] = $this->model->selectCertificadoAlumnoDetalle($_SESSION['user_data']['id_usuario'],1);
                $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
                ob_end_clean();
                $html = getFile('template/reporte/reporte_ppp_general',$data);
                $html2pdf->setDefaultFont('times');
                $html2pdf->pdf->SetTitle('Certificado practicas pre-profesionales');
                $html2pdf->writeHTML($html);
                $html2pdf->output('certificado_ppp_empresarial_'.date("d_m_Y_H_i").'.pdf');
            }

        }
    }
    
    public function certificadopppcomunitario($int_id_alumno = 0){
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:'.server_url.'Errors');
        }else{
            if($_SESSION['user_data']['id_rol'] != 2){
                $int_id_alumno = Intval(strclean($int_id_alumno));
                if($int_id_alumno == 0){
                    header('location:'.server_url.'Errors');
                }else{
                    $getAlumno= $this->model->selectCertificadoAlumno($int_id_alumno);
                    $date_du_jour = fechaCastellano(date("d-m-Y"));
                    $data[0] = $getAlumno;
                    $data[0]['tipo']='SERVICIO A LA COMUNIDAD';
                    $data[1] = $date_du_jour;
                    $data[3] = $this->model->selectCertificadoAlumnoDetalle($int_id_alumno,2);
                    $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
                    ob_end_clean();
                    $html = getFile('template/reporte/reporte_ppp_general',$data);
                    $html2pdf->setDefaultFont('times');
                    $html2pdf->pdf->SetTitle('Certificado practicas pre-profesionales');
                    $html2pdf->writeHTML($html);
                    $html2pdf->output('certificado_ppp_comunitario_'.date("d_m_Y_H_i").'.pdf');
                }
            }else{
                $getAlumno= $this->model->selectCertificadoAlumno($_SESSION['user_data']['id_usuario']);
                $date_du_jour = fechaCastellano(date("d-m-Y"));
                $data[0] = $getAlumno;
                $data[0]['tipo']='SERVICIO A LA COMUNIDAD';
                $data[1] = $date_du_jour;
                $data[3] = $this->model->selectCertificadoAlumnoDetalle($_SESSION['user_data']['id_usuario'],2);
                $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
                ob_end_clean();
                $html = getFile('template/reporte/reporte_ppp_general',$data);
                $html2pdf->setDefaultFont('times');
                $html2pdf->pdf->SetTitle('Certificado practicas pre-profesionales');
                $html2pdf->writeHTML($html);
                $html2pdf->output('certificado_ppp_comunitario_'.date("d_m_Y_H_i").'.pdf');
            }
        }
    }

}
