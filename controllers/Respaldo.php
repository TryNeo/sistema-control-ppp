<?php
    require_once ("./libraries/core/controllers.php");
    require_once ("./controllers/Logout.php");
    class Respaldo extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(4);
        }

        public function respaldo(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 4;
            $data["tag_pag"] = "Respaldo";
            $data["page_title"] = "Respaldo | Inicio";
            $data["page_name"] = "Respaldo - Base de datos";
            $data["page"] = "respaldo";
            $this->views->getView($this,"respaldo",$data);

        }

        public function backup(){
            if (empty($_SESSION['permisos_modulo']['w']) ) {
                header('location:'.server_url.'Errors');
                $data = array('status' => false, 'msg' => 'Error no tiene permisos');
            }else{
                if (isset($_GET)){
                    $day =date("d");
                    $mont =date("m");
                    $year =date("Y");
                    $hora =date("H-i-s");
                    $fecha =$day.'_'.$mont.'_'.$year;
                    $name_database = "CONTROLPPP_BD";
                    $data_base ='base_de_datos_'.$fecha."_(".$hora."_hrs).sql";
                    $tables=array();
                    $result=$this->model->respaldo_sql("SHOW TABLES");
                    if($result){
                        while($row=mysqli_fetch_row($result)){
                            $tables[] = $row[0];
                        }
                        $sql='SET FOREIGN_KEY_CHECKS=0;'."\n\n";
                        $sql.='DROP DATABASE  IF EXISTS CONTROLPPP_BD;'."\n".'CREATE DATABASE IF NOT EXISTS '.$name_database.";\n\n";
                        $sql.='USE '.$name_database.";\n\n";;
                        $error=0;
                        foreach($tables as $table){
                            $result=$this->model->respaldo_sql('SELECT * FROM '.$table);
                            if($result){
                                $numFields=mysqli_num_fields($result);
                                $row2=mysqli_fetch_row($this->model->respaldo_sql('SHOW CREATE TABLE '.$table));
                                $sql.="\n\n".$row2[1].";\n\n";
                                for ($i=0; $i < $numFields; $i++){
                                    while($row=mysqli_fetch_row($result)){
                                        $sql.='INSERT INTO '.$table.' VALUES(';
                                        for($j=0; $j<$numFields; $j++){
                                            $row[$j]=addslashes($row[$j]);
                                            $row[$j]=str_replace("\n","\\n",$row[$j]);
                                            if (isset($row[$j])){
                                                $sql .= '"'.$row[$j].'"' ;
                                            }
                                            else{
                                                $sql.= '""';
                                            }
                                            if ($j < ($numFields-1)){
                                                $sql .= ',';
                                            }
                                        }
                                        $sql.= ");\n";
                                    }
                                }
                                $sql.="\n\n\n";
                            }else{
                                $error=1;
                            }
                        }
                        if($error ==1){
                            $data = array('status' => false, 'msg' => 'Hubo un error al hacer respaldo');
                        }else{
                            $sql.='SET FOREIGN_KEY_CHECKS=1;';
                            $handle=fopen('./backups/'.$data_base,'w+');
                            if(fwrite($handle, $sql)){
                                fclose($handle);
                                $data = array('status' => true, 'msg' => 'Copia realizada con exito');
                            }else{
                                $data = array('status' => false, 'msg' => 'Hubo un error al hacer respaldo');
                            }
                        }
                    }else{
                        $data = array('status' => false, 'msg' => 'Hubo un error al hacer respaldo');
                    }
                    mysqli_free_result($result);
                }else{
                    $data = array('status' => false, 'msg' => 'Hubo un error al hacer respaldo');
                }
            }
            sleep(5);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);                
            die();
        }

        public function setBackups(){
            if (empty($_SESSION['permisos_modulo']['u']) ) {
                header('location:'.server_url.'Errors');
                $data = array('status' => false, 'msg' => 'Error no tiene permisos');
            }else{
                if($_GET){
                    $route = strclean($_GET['route']);
                    $request_restore = $this->model->restore_sql($route);
                    if($request_restore){
                        $data = array('status' => true, 'msg' => 'Respaldo Insertado correctamente en la base de datos');
                    }else{
                        $data = array('status' => false, 'msg' => 'Hubo un error al insertar la base de datos');
                    }
                }else{
                    $data = array('status' => false, 'msg' => 'Hubo un error al insertar la base de datos');
                }
            }
            sleep(5);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);                
            die();
        }

        public function getBackups(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array('status' => false, 'msg' => 'Error no tiene permisos');
            }else{
                $ruta = './backups/';
                $id = 0;
                $btnRestore = '';
                $btnRestoreEliminar = '';
                $data = [];
                if (is_dir($ruta)){
                    if($aux = opendir($ruta)){
                        while (($archivo = readdir($aux)) !== false ){
                            $html_options = "";
                            if($archivo!="."&&$archivo!=".."){
                                $nombre_archivo = str_replace(".sql","",$archivo);
                                $nombre_archivo = str_replace("-",":",$nombre_archivo);
                                $ruta_completa = $ruta.$archivo;
                                if(is_dir($ruta_completa)){
                                }else{
                                    $id++;
                                    
                                    if ($_SESSION['permisos_modulo']['u']) {
                                        $btnRestore = '<button type="button" class="btn btn-outline-info btn-circle btnRestore" title="restaurar"  onClick="return fntSetBackups('."'".$ruta_completa."'".')"><i class="fa fa-upload"></i></button>';
                                    }
                    
                                    if ($_SESSION['permisos_modulo']['d']) {
                                        $btnRestoreEliminar = '<button type="button" class="btn btn-outline-danger btn-circle btnRestoreEliminar" title="eliminar" onClick="return fntDeleteBackup('."'".$ruta_completa."'".')"><i class="fa fa-trash"></i></button>';
                                    }

                                    $data[] = array(
                                        "id" => $id,
                                        "nombre" => $nombre_archivo,
                                        "opciones" => '<div class="text-center">'.$btnRestore.' '.$btnRestoreEliminar.'</div>'
                                    );

                                }
                            }
                        }
                        closedir($aux);
                    }
                }
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        }

        public function delBackups(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array('status' => false, 'msg' => 'Error no tiene permisos');
            }else{
                if($_GET){
                    $route = strclean($_GET['route']);
                    if(file_exists($route)){
                        if(unlink($route)){
                            $data = array('status' => true, 'msg' => 'Copia eliminada exitosamente');
                        }else{
                            $data = array('status' => false, 'msg' => 'Hubo un error al eliminar la copia');
                        }
                    }else{
                        $data = array('status' => false, 'msg' => 'No existe tal copia de la base de datos');
                    }
                }else{
                    $data = array('status' => false, 'msg' => 'Hubo un error al eliminar la copia');
                }
            }
            sleep(5);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);                
            die();
        }
    }

?>