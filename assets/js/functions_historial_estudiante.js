$(function(){
    const columnData = [
        {"data":"id_practica"},
        {"data":"nombre_empresa"},
        {"data":"tutor_docente"},
        {"data":"tipo_practica"},
        {"data":"horas"},
        {"data":"fecha_inicio"},
        {"data":"fecha_fin"},
    ]

    const columnDefs = [
        {
            targets:[3],
            orderable:false,
            render:function(data,type,row){
                if (row.tipo_practica === "1"){
                    return '<button type="button" class="btn btn-outline-primary btn-icon icon-left">'+
                            '<i class="fas fa-business-time"></i> EMPRESARIAL'+
                            '</button>'
                }else{
                    return '<button type="button" class="btn btn-outline-info btn-icon icon-left">'+
                            '<i class="fas fa-poll-h"></i> SERVICIO A LA COMUNIDAD'+
                            '</button>'
                }
            }
        }
    ]

    const tableHistorialAlumno = configDataTables('.tableHistorialAlumno',base_url+"historial-estudiante/getHistorialEstudiante",columnData,columnDefs);

})