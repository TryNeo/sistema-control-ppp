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
                $pdf = new reporte();
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetTitle('');
                $pdf->renderText('');
                $pdf->SetFont('arial', '', 10);
                $y = $pdf->GetY() + 8;
                $pdf->Output('', 'certificado_ppp_empresarial_'.date("d_m_Y_H_i").'.pdf');
            }else{
                $pdf = new reporte();
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetTitle('Certificado practicas pre-profesionales');
                $date_du_jour = fechaCastellano(date("d-m-Y"));
                $pdf->renderHeader('CERTIFICADO DE PRACTICAS PRE-PROFESIONALES',$date_du_jour,'https://i.ibb.co/DQstGsn/favicon1.png',10,15,23);
                $pdf->SetY(87);
                $getAlumno= $this->model->selectCertificadoAlumno($_SESSION['user_data']['id_usuario']);
                $mensaje = "Por medio de la presente certificamos que el estudiante ".$getAlumno['nombre_estudiante'].
                " con cédula de identidad No. ".$getAlumno['cedula'].", de la carrera ".$getAlumno['nombre_carrera'].
                ", ha cumplido con las prácticas siguientes prácticas pre-profesionales de tipo EMPRESARIAL:";
                $pdf->Write(7, utf8_decode($mensaje));
                $y = $pdf->GetY() + 13;

                $pdf->SetXY(12, $y);
                $pdf->MultiCell(50, 8, utf8_decode("Entidad Receptora"), 1, 'C');
                
                $pdf->SetXY(62, $y); 
                $pdf->MultiCell(40, 8, utf8_decode("Tipo"), 1, 'C');

                $pdf->SetXY(102, $y); 
                $pdf->MultiCell(40, 8, utf8_decode("Horas Ejectudas"), 1, 'C');

                $pdf->SetXY(142, $y); 
                $pdf->MultiCell(26, 8, utf8_decode("Fecha inicio"), 1, 'C');

                $pdf->SetXY(168, $y); 
                $pdf->MultiCell(26, 8, utf8_decode("Fecha Fin"), 1, 'C');

                $suma_total_horas=0;

                $data = $this->model->selectCertificadoAlumnoDetalle($_SESSION['user_data']['id_usuario'],1);
                foreach ($data as $value) {
                    $y = $pdf->GetY();
                    $pdf->SetXY(12, $y);
                    $pdf->MultiCell(50,16, utf8_decode($value['nombre_empresa']), 1, 'J');
                    $pdf->SetXY(62, $y);
                    if ($value['tipo_practica'] == 1) {
                        $pdf->MultiCell(40, 16, utf8_decode("EMPRESARIAL"), 1, 'J');
                    }
                    $pdf->SetXY(102, $y);
                    $pdf->MultiCell(40, 16, utf8_decode($value['total_horas_ppp']), 1, 'C');
                    $suma_total_horas+=$value['total_horas_ppp'];
                    $pdf->SetXY(142, $y); 
                    $pdf->MultiCell(26, 16, utf8_decode($value['fecha_inicio']), 1, 'C');

                    $pdf->SetXY(168, $y); 
                    $pdf->MultiCell(26, 16, utf8_decode($value['fecha_fin']), 1, 'C');
    
                }
                $y = $pdf->GetY() + 8;
                $pdf->SetY(120);
                $pdf->SetXY(10, $y);
                $pdf->MultiCell(30, 16, utf8_decode("Total Horas : "),2, 'J');

                $pdf->SetXY(23, $y);
                $pdf->MultiCell(30, 16, $suma_total_horas,2, 'C');

                $mensaje = "Para constancia de lo detallado anteriormente, se mantiene un archivo con el expediente de PPP del estudiante, mismo que reposa en la secretaria de la Coordinación de la Carrera.";
                $pdf->Write(5, utf8_decode($mensaje));

                $pdf->Output('', 'certificado_ppp_empresarial_'.date("d_m_Y_H_i").'.pdf');
            }

        }
    }

}
