$(function(){
    const columnData = [
        {"data":"id"},
        {"data":"nombre"},
        {"data":"opciones"}]

    const tableRespaldo =  configDataTables('.tableRespaldo',base_url+"respaldo/getBackups",columnData);
    fntBackups(tableRespaldo);
})



function fntSetBackups(rbd){
    Swal.fire({
        title:  "Restauracion de base la datos",
        text: '¿Desea realizar la restauracion de la base de datos?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, restaurar',
        cancelButtonText : 'No, restaurar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.LoadingOverlaySetup({
                image           : "https://i.ibb.co/DQstGsn/favicon1.png",
                imageColor      : "#ffcc00",
                imageAnimation  : "pulse 2.5s",
                imageAutoResize         : true,
            });
            $.LoadingOverlay("show");
            if (rbd === ""){
                $.LoadingOverlay("hide");
                mensaje("error","Error","Opps! hubo un problema esta base de datos no existe");
            }else{
                $.LoadingOverlaySetup({
                    image           : "https://i.ibb.co/DQstGsn/favicon1.png",
                    imageColor      : "#ffcc00",
                    imageAnimation  : "pulse 2.5s",
                    imageAutoResize         : true,
                });
                $.LoadingOverlay("show");
                $.ajax({
                    type: 'GET',
                    url: base_url+"respaldo/setBackups?route="+rbd
                }).then(function (data) {
                    console.log(data)
                    let objdata = JSON.parse(data); 
                    if (objdata.status){
                        $.LoadingOverlay("hide");
                        mensaje("success","Exitoso",objdata.msg);
                        $('.tableRespaldo').DataTable().ajax.reload();
                    }else{
                        $.LoadingOverlay("hide");
                        mensaje("error","Error",objdata.msg);
                    }
                    $.LoadingOverlay("hide");
                });
            }    
        }
    });
}


function fntDeleteBackup(rbd){
    Swal.fire({
        title:  "Eliminar copia de base de datos",
        text: '¿Desea eliminar esta copia de base de datos?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar',
        cancelButtonText : 'No, cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.LoadingOverlaySetup({
                image           : "https://i.ibb.co/DQstGsn/favicon1.png",
                imageColor      : "#ffcc00",
                imageAnimation  : "pulse 2.5s",
                imageAutoResize         : true,
            });
            $.LoadingOverlay("show");
            if (rbd === ""){
                $.LoadingOverlay("hide");
                mensaje("error","Error","Opps! hubo un problema esta base de datos no existe");
            }else{
                $.LoadingOverlaySetup({
                    image           : "https://i.ibb.co/DQstGsn/favicon1.png",
                    imageColor      : "#ffcc00",
                    imageAnimation  : "pulse 2.5s",
                    imageAutoResize         : true,
                });
                $.LoadingOverlay("show");
                $.ajax({
                    type: 'GET',
                    url: base_url+"respaldo/delBackups?route="+rbd
                }).then(function (data) {
                    let objdata = JSON.parse(data); 
                    if (objdata.status){
                        $.LoadingOverlay("hide");
                        mensaje("success","Exitoso",objdata.msg);
                        $('.tableRespaldo').DataTable().ajax.reload();
                    }else{
                        $.LoadingOverlay("hide");
                        mensaje("error","Error",objdata.msg);
                    }
                    $.LoadingOverlay("hide");
                });
            }    
        }
    });
}


function fntBackups(tableRespaldo){
    $('#backupbd').on('click',function (e) {
        Swal.fire({
            title: "Realizar respaldo de la base de datos",
            text: '¿Desea realizar esta copia de seguridad de base la datos?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, realizar',
            cancelButtonText : 'No, cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.LoadingOverlaySetup({
                    image           : "https://i.ibb.co/DQstGsn/favicon1.png",
                    imageColor      : "#ffcc00",
                    imageAnimation  : "pulse 2.5s",
                    imageAutoResize         : true,
                });
                $.LoadingOverlay("show");
                $.ajax({
                    type: 'GET',
                    url: base_url+"respaldo/backup"
                }).then(function (data) {
                    let objdata = JSON.parse(data); 
                    if (objdata.status){
                        $.LoadingOverlay("hide");
                        mensaje("success","Exitoso",objdata.msg);
                        tableRespaldo.ajax.reload();
                    }else{
                        $.LoadingOverlay("hide");
                        mensaje("error","Error",objdata.msg);
                    }
                    $.LoadingOverlay("hide");
                });
            }
        });
    });
}

