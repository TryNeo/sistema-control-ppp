<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://i.ibb.co/DQstGsn/favicon1.png" sizes="16x16" />
    <title>Certificado de practicas pre-profesionales</title>
    <style>
        .imagen-logo {
            height: 100px;
            width: 650px;
            padding-top: 100px;
            padding: 20px;
        }

        .fecha-general {
            text-align: right;
            font-size: 16px;
        }

        .titulo-principal {
            padding-top: 40px;
            padding-bottom: 40px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .mensaje-ppp {
            padding-bottom: 20px;
            font-size: 17px;
            letter-spacing: 1.4px;
            word-spacing: 1.2px;
        }

        .table-ppp {
            border-collapse: collapse;
            text-align: center;
            font-size: 14px;
        }

        .w16-entidad{
            border: 1px;
            width: 250px;
        }

        .w17-tipo{
            width: 180px;
            border: 1px;
        }

        .w18-fecha{
            width: 80px;
            border: 1px;
        }

        .w19-horas{
            width: 120px;
            border: 1px;
        }
        
        .w20-total{
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 15px;
        }

        .w21-firma{
            padding: 100px;
            font-size: 14px;
        }


        .w22-advertencia{
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 14px;
            color: red;
        }

        .w23-separar-firmas{
            padding: 30px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td class="imagen-logo">
                <img src="https://i.ibb.co/DQstGsn/favicon1.png" alt="logo" width="110" height="110">
            </td>
        </tr>
        <tr>
            <td class="fecha-general">
                <span><?php echo $data[1]?></span>
            </td>
        </tr>
        <tr>
            <td class="titulo-principal">
                <span>CERTIFICADO DE PRACTICAS PRE-PROFESIONALES</span>
            </td>
        </tr>
        <tr>
            <td class="mensaje-ppp">
                <span>Por medio de la presente certificamos que el estudiante 
                    <?php if(!isset($data[0]['nombre_estudiante'])) { echo 'SIN NOMBRE'; }else{ echo $data[0]['nombre_estudiante']; }?> 
                    con cédula de identidad No. <?php if(!isset($data[0]['cedula'])) { echo '099999999'; }else{ echo $data[0]['cedula']; }?> , 
                    de la carrera <?php if(!isset($data[0]['nombre_carrera'])) { echo 'SIN CARRERA'; }else{ echo $data[0]['nombre_carrera']; }?> , 
                    ha cumplido con las siguientes prácticas pre-profesionales de tipo <?php echo $data[0]['tipo'] ?>:</span>
            </td>
        </tr>
    </table>
    <table class="table-ppp">
        <thead>
            <tr>
                <th class="w16-entidad">Entidad Receptora</th>
                <th class="w17-tipo">Tipo</th>
                <th class="w19-horas">Horas Ejecutadas</th>
                <th class="w18-fecha">Fecha Inicio</th>
                <th class="w18-fecha">Fecha Fin</th>
            </tr>
        </thead>
        <tbody>
            <?php  $suma_total_horas=0 ?>
            <?php foreach ($data[3] as $key => $value) { $suma_total_horas+=$value['total_horas_ppp'] ?>
                <tr>
                    <td class="w16-entidad"><?php echo $value['nombre_empresa'] ?></td>
                    <td class="w17-tipo">
                        <?php if ($value['tipo_practica'] == 2) { ?>
                            SERVICIO A LA COMUNIDAD
                        <?php } else { ?>
                            EMPRESARIAL
                        <?php } ?>
                    </td>
                    <td class="w19-horas"><?php echo $value['total_horas_ppp'] ?></td>
                    <td class="w18-fecha"><?php echo $value['fecha_inicio'] ?></td>
                    <td class="w18-fecha"><?php echo $value['fecha_fin'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <table>
        <tr>
            <td class="w20-total">
                <span>Total Horas : <?php echo $suma_total_horas ?></span>
            </td>
        </tr>
        <tr>
            <td class="mensaje-ppp">
                <span>Para constancia de lo detallado anteriormente, se mantiene un archivo con el expediente de PPP del estudiante, mismo que reposa en 
                    la secretaria de la Coordinación de la Carrera.</span>
            </td>
        </tr>
    </table>
    <table class="w21-firma">
        <tr>
            <td class="w23-separar-firmas">
                <span>______________________________</span>
                <br>
                <br>
                <span>Gestor de PPP</span>
            </td>
            <td class="w23-separar-firmas">
                <span>______________________________</span>
                <br>
                <br>
                <span>Coordinador(a) de la Carrera</span>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="w22-advertencia">
                <span>Este documento, NO ES VALIDO sin las firmas respectivas.</span>
            </td>
        </tr>
    </table>
</body>

</html>