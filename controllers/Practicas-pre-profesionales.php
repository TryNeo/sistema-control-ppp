<?php

use JetBrains\PhpStorm\ArrayShape;

require_once("./libraries/core/controllers.php");

class Practicaspreprofesionales extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location:' . server_url . 'login');
        }
        getPermisos(9);
    }

    public function practicaspreprofesionales()
    {
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:' . server_url . 'Errors');
        }
        $data["page_id"] = 9;
        $data["tag_pag"] = "";
        $data["page_title"] = "Practicas pre profesionales | Inicio";
        $data["page_name"] = "practicas";
        $data["page"] = "practicas";
        $this->views->getView($this, "practicas-pre-profesionales", $data);
    }


    public function agregar()
    {
        $data = [];
        $data["page_id"] = 9;
        $data["tag_pag"] = "";
        $data["page_title"] = "Agregar practicas";
        $data["page_name"] = "practicas";
        $data["page"] = "practicas";
        $this->views->getView($this, "agregar-practicas", $data);
        die();
    }


    public function getPracticaspreprofesionales()
    {
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:' . server_url . 'Errors');
            $data = array("status" => false, "msg" => "Error no tiene permisos");
        } else {
            $data = $this->model->selectPracticasPreProfesionales();
            for ($i=0; $i < count($data); $i++) { 
                $btnEliminarPractica = '';
                $btnEditarPractica = '';

                if ($_SESSION['permisos_modulo']['u']) {
                    $btnEditarPractica = '<button class="btn btn-primary btnEditarPractica btn-circle " title="editar">
                    <i class="fa fa-edit"></i></button>';
                }


                if ($_SESSION['permisos_modulo']['d']) {
                    $btnEliminarPractica = '<button  class="btn btn-danger btn-circle btnEliminarPractica" 
                        title="eliminar" onClick="return deleteServerSide('."'delPracticaspreprofesionales/'".','.$data[$i]['id_practica'].','."'¿Desea eliminar la practica pre profesional del alumno ".$data[$i]['nombre']." ".$data[$i]['apellido']."?'".','."'.tablePracticas'".');"><i class="far fa-thumbs-down"></i></button>';
                }

                $data[$i]['opciones'] = $btnEditarPractica.' '.$btnEliminarPractica;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setPracticaspreprofesionales(){
        if($_POST){
            $id_practicas = intval(strclean($_POST['id_practicas']));
            $id_alumno = intval(strclean($_POST['id_alumno']));
            $id_profesor = intval(strclean($_POST['id_profesor']));
            $id_empresa = intval(strclean($_POST['id_empresa']));
            $tipo_practica = intval(strclean($_POST['id_tipo_practica']));
            $alcance_proyecto = intval(strclean($_POST['id_alcance_proyecto']));
            $departamento = ucwords(strclean($_POST['departamento_ep']));
            $nivel = intval(strclean($_POST['id_nivel_pasantias']));
            $fecha_inicio = strclean($_POST['fecha_ini']);
            $fecha_fin = strclean($_POST['fecha_fin']);
            $total_ppp_emp = intval(strclean($_POST['total_emp']));
            $total_ppp_serv = intval(strclean($_POST['total_serv']));
            $total_ppp = intval(strclean($_POST['total_ppp']));
            $total_horas = intval(strclean($_POST['total_horas']));
            

            $validate_data=array($id_practicas,$id_alumno,$id_profesor,$id_empresa,
                                $tipo_practica,$alcance_proyecto,$departamento,$nivel,$fecha_inicio,$fecha_fin,$total_ppp,$total_horas);

            if(!validateEmptyFields($validate_data)){
                $data = array('status' => false,'msg' => "Verifique que algunos de los campos no se encuentre vacio");
            }

            if(!empty(preg_matchall(array($id_practicas,$id_alumno,$id_profesor,$id_empresa,
                                $tipo_practica,$alcance_proyecto,$nivel,$total_ppp,$total_horas),regex_numbers))){
                $data = array('status' => false,'msg'=> "Verifique que los campos numericos no contengan letras");
            }

            $total_ppp_emp = $total_ppp_emp+$total_horas;
            $total_ppp_serv = $total_ppp_serv+$total_horas;
            $suma_total_horas = $total_ppp+$total_horas;

            if ($suma_total_horas > 400) {
                $data = array("status" => false, "msg" => "La suma de las horas sobre pasa las 400 horas, verifique las horas ingresadas");
            }else if($total_ppp_emp > 240 and $tipo_practica == 1){
                $data = array('status' => false,'msg'=> "El total de horas empresariales sobre pasa las 240 horas");
            }else if($total_ppp_serv > 160 and $tipo_practica == 2){
                $data = array('status' => false,'msg'=> "El total de horas de servicio a la comunida sobre pasa las 160 horas");
            }else{
                if ($id_practicas == 0){
                    if (empty($_SESSION['permisos_modulo']['w'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                        $response_practicas = 0;
                    }else{
                        $response_practicas = $this->model->insertPracticaspreprofesionales($id_alumno, $id_profesor,$tipo_practica, $alcance_proyecto, $id_empresa,
                            $departamento, $nivel, $fecha_inicio, $fecha_fin,$total_horas);
                        $option = 1;
                    }
                }
                if ($response_practicas > 0){ 
                    if ($option == 1){
                        $data = array('status' => true, 'msg' => 'Datos guardados correctamente');
                    }
                }else{
                    $data = array('status' => false,'msg' => 'Hubo un error no se pudieron guardar los datos');
                }
            }
        }else{
            header('location:'.server_url.'Errors');
        }
        sleep(3);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }


    public function getSelectAlumnos()
    {
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:' . server_url . 'Errors');
            $data = array("status" => false, "msg" => "Error no tiene permisos");
        } else {
            if (empty($_POST)) {
                $request_data =  $this->model->selectAlumnosNoInactivos('');
                foreach ($request_data as $row) {
                    $data[] = array(
                        "id" => $row['id_alumno'], "text" => $row['nombre'] . " " . $row['apellido'],
                        "cedula" => $row['cedula'], "carrera" => $row['nombre_carrera']
                    );
                }
            } else {
                $search_alumno = strclean($_POST['search']);
                $request_data = $this->model->selectAlumnosNoInactivos($search_alumno);
                foreach ($request_data as $row) {
                    $data[] = array(
                        "id" => $row['id_alumno'], "text" => $row['nombre'] . " " . $row['apellido'],
                        "cedula" => $row['cedula'], "carrera" => $row['nombre_carrera']
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

    public function getSelectEmpresarialServiciosAlacomunidad($int_id_alumno){
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:' . server_url . 'Errors');
            $data_response = array("status" => false, "msg" => "Error no tiene permisos");
        } else {
            $intAlumno  = Intval(strclean($int_id_alumno));
            if ($intAlumno > 0) {
                $data_emp = $this->model->selectHorasEmpresariales($intAlumno);
                $data_ser = $this->model->selectHorasServicioComunitario($intAlumno);
                if (empty($data_emp['total_horas']) and empty($data_ser['total_horas'])) {
                    $data_emp['total_horas'] = 0;
                    $data_ser['total_horas'] = 0;
                    $data_response = array('status' => true, 'total_horas_emp' => $data_emp,'total_horas_ser' => $data_ser);
                } else {
                    $data_response = array('status' => true, 'total_horas_emp' => $data_emp,'total_horas_ser' => $data_ser);
                }
            } else {
                $data_response = array('status' => false, 'msg' => 'No existe correctamente el id del alumno');
            }
        }
        echo json_encode($data_response, JSON_UNESCAPED_UNICODE);
        die();
    }



    public function getSelectTotalHorasppp($int_id_alumno)
    {
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:' . server_url . 'Errors');
            $data_response = array("status" => false, "msg" => "Error no tiene permisos");
        } else {
            $intAlumno  = Intval(strclean($int_id_alumno));
            if ($intAlumno > 0) {
                $data = $this->model->selectAlumnoTotalHorasppp($intAlumno);
                if (empty($data['total_horas'])) {
                    $data['total_horas'] = 0;
                    $data_response = array('status' => true, 'msg' => $data);
                } else {
                    $data_response = array('status' => true, 'msg' => $data);
                }
            } else {
                $data_response = array('status' => false, 'msg' => 'No existe correctamente el id del alumno');
            }
        }
        echo json_encode($data_response, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function getSelectProfesor()
    {
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:' . server_url . 'Errors');
            $data = array("status" => false, "msg" => "Error no tiene permisos");
        } else {
            if (empty($_POST)) {
                $request_data =  $this->model->selectProfesorNoInactivos('');
                foreach ($request_data as $row) {
                    $data[] = array(
                        "id" => $row['id_profesor'], "text" => $row['nombre'] . " " . $row['apellido'],
                        "cedula" => $row['cedula'], "campus" => $row['nombre_campus']
                    );
                }
            } else {
                $search_profesor = strclean($_POST['search']);
                $request_data = $this->model->selectProfesorNoInactivos($search_profesor);
                foreach ($request_data as $row) {
                    $data[] = array(
                        "id" => $row['id_profesor'], "text" => $row['nombre'] . " " . $row['apellido'],
                        "cedula" => $row['cedula'], "campus" => $row['nombre_campus']
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


    public function getSelectEmpresas()
    {
        if (empty($_SESSION['permisos_modulo']['r'])) {
            header('location:' . server_url . 'Errors');
            $data = array("status" => false, "msg" => "Error no tiene permisos");
        } else {
            if (empty($_POST)) {
                $request_data =  $this->model->selectEmpresaNoInactivos('');
                foreach ($request_data as $row) {
                    $data[] = array(
                        "id" => $row['id_empresa'], "text" => $row['nombre_empresa'],
                        "nombre" => $row['nombre_representante'], "telefono" => $row['telefono_representante']
                    );
                }
            } else {
                $search_empresa = strclean($_POST['search']);
                $request_data = $this->model->selectEmpresaNoInactivos($search_empresa);
                foreach ($request_data as $row) {
                    $data[] = array(
                        "id" => $row['id_empresa'], "text" => $row['nombre_empresa'],
                        "nombre" => $row['nombre_representante'], "telefono" => $row['telefono_representante']
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


    public function delPracticaspreprofesionales(){
        if (empty($_SESSION['permisos_modulo']['d']) ) {
            header('location:'.server_url.'Errors');
            $data = array("status" => false, "msg" => "Error no tiene permisos");
        }else{

            if (!$_POST){
                $data = array("status" => false, "msg" => "Error Hubo problemas");
            }

            $id_practica = intval(strclean($_POST["id"]));

            if(!validateEmptyFields([$id_practica])){
                $data = array('status' => false,'msg' => 'El campo se encuentra vacio , verifique y vuelva a ingresarlo');
            }

            if(!empty(preg_matchall([$id_practica],regex_numbers))){
                $data = array('status' => false,'msg' => 'El campo estan mal escrito , verifique y vuelva a ingresarlo');
            }

            $response_del = $this->model->deletePracticapreprofesional($id_practica);
            
            if($response_del == "ok"){
                $data = array("status" => true, "msg" => "Se ha eliminado la practica pre profesional correctamente");
            }else{
                $data = array("status" => false, "msg" => "Error al eliminar  la practica pre profesional ");
            }
        }
        sleep(3);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }

}
