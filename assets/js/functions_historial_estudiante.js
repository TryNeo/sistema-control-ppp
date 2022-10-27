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
    searchAlumno(tableHistorialAlumno);
    cargapdf('#pppEmpresarial','modalReporteEmpresarial',9000);
    cargapdf('#pppComunitario','modalReporteComunitario',9000);

});

function formatRepo (repo) {
    if (repo.loading) {
        return repo.text;
    }

    var option = $(
        '<div class="wrapper">'
            +'<p style="margin-bottom:12;">'
                +'<b>Cedula: </b>'+repo.cedula+'<br>'
                +'<b>Nombre y Apellido: </b>'+repo.text+'<br>'
            +'</p>'
        +'</div>'
    )

    return option;
}


function searchAlumno(tableHistorialAlumno){
    $('#SearchAlumno').select2({
        theme: "bootstrap-5",
        language:'es',
        allowClear:true,
        ajax: {
            url: base_url+"historial-estudiante/getSelectHistorialAlumno",
            type: "POST",
            dataType: 'json',
            delay:250,
            data: function (params) {
                let queryParameters = {
                    search: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        placeholder:"Buscar alumno por cedula / nombre / apellido",
        templateResult: formatRepo,
    }).on('select2:select',function(e){
        let data = e.params.data;
        $('#SearchAlumno').val('');
        $('#SearchAlumno').trigger('change.select2');
        tableHistorialAlumno.ajax.url(base_url+"historial-estudiante/getHistorialEstudiante/"+data.id).load();
        $('#modalEmpresarialppp').attr('href',base_url+"historial-estudiante/certificado-ppp-empresarial/"+data.id);
        $('#pdfcertificadoppEmpresarial').attr('src',base_url+"historial-estudiante/certificado-ppp-empresarial/"+data.id+"#toolbar=0");
        $('#modalComunitarioppp').attr('href',base_url+"historial-estudiante/certificado-ppp-comunitario/"+data.id);
        $('#pdfcertificadoppComunitario').attr('src',base_url+"historial-estudiante/certificado-ppp-comunitario/"+data.id+"#toolbar=0");
    });

}


function cargapdf(id,modalName,seconds){
    $(id).click(function(){
        $.LoadingOverlaySetup({
            image           : "https://i.ibb.co/DQstGsn/favicon1.png",
            imageColor      : "#ffcc00",
            imageAnimation  : "pulse 2.5s",
            imageAutoResize         : true,
        });
        $.LoadingOverlay("show");
        setTimeout(function(){
            $.LoadingOverlay("hide");
            abrir_modal_reporte(modalName);
        }, seconds);
    });
}
