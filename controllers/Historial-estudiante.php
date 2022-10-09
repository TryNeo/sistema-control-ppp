<?php
require_once("./libraries/core/controllers.php");
require_once ("./controllers/Reporte.php");

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


    public function getHistorialEstudiante($search_alumno = '')
    {
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:' . server_url . 'Errors');
            $data = array("status" => false, "msg" => "Error no tiene permisos");
        } else {
            if($_SESSION['user_data']['id_rol'] != 2){
                $data = [];
            }else{
                $data = $this->model->selectHistorialAlumno($_SESSION['user_data']['id_usuario']);
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function certificadopppEmpresarial(){
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:'.server_url.'Errors');
        }else{
            $pdf = new reporte();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetTitle('');
            $pdf->renderText('');
            $pdf->SetFont('arial', '', 10);
            $y = $pdf->GetY() + 8;
            $pdf->Output('', 'certificado_ppp_empresarial_'.date("d_m_Y_H_i").'.pdf');
        }
    }

}
