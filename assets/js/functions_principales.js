const base_url = "http://localhost/sistema-control-ppp/";
const base_url_assets = "http://localhost/sistema-control-ppp/assets/";
const base_url_image = "http://localhost/sistema-control-ppp/assets/images/";


function clickModal(nameSelector,modalName,formSelector='',formSelect2='',select2=[]){
    $('#openModal').on('click',function (e) {
        var options = {
            "backdrop" : "static",
            "keyboard": false,
            "show":true
        }
        
        document.querySelector('#modalTitle').innerHTML = modalName;
        document.querySelector('.changeText').innerHTML = "Crear ";
        if (formSelector != ''){
            $(formSelector).trigger("reset");
            $('form').removeClass('was-validated');
            $("input").removeClass("is-valid");
            $("input").removeClass("is-invalid");
            $("textarea").removeClass("is-valid");
            $("textarea").removeClass("is-invalid");
            $("select").removeClass("is-valid");
            $("select").removeClass("is-invalid");
            select2.forEach(function(element,index){
                $(element).prop('selectedIndex',0);
            })

        }

        if(formSelect2 != ''){
            $(formSelect2).val('').trigger('change')
            $(formSelect2).removeAttr('disabled');   

        }

        $(nameSelector).modal(options);
    });
}

function clickModalEditing(urlData,modalName,nameSelectorId,listCamps,nameSelectorModal,isSelect =false,
        listSelect = [],isSelect2=false,nameSelect2='') {
    $(nameSelectorModal).modal("show");
    document.querySelector('#modalTitle').innerHTML = modalName;
    document.querySelector('.changeText').innerHTML = " Actualizar registro ";
    (async () => {
        try {
            let options = { method: "GET"}
            let response = await fetch(urlData,options);
            if (response.ok) {
                let data = await response.json();
                
                document.querySelector('#'+nameSelectorId).value = data.msg[nameSelectorId];
                listCamps.forEach(function(element,index){
                    document.querySelector('#'+element).value = data.msg[element];
                    $('#'+element).removeClass('is-invalid');
                    $('#'+element).addClass('is-valid');
                })

                if(isSelect){
                    listSelect.forEach(function(element,index){
                        let a = document.querySelector("#"+element).getElementsByTagName('option');
                        for (let item of a){
                            console.log(data.msg[element])
                            if (item.value === data.msg[element]) {
                                item.setAttribute("selected","");
                            }else{
                                item.removeAttribute("selected");
                            }
                        }
                        $('#'+element).removeClass('is-invalid');
                        $('#'+element).addClass('is-valid');
                    })
                }

                if(isSelect2){
                    $(nameSelect2).attr('disabled','disabled');
                    $(nameSelect2).addClass('hidden-data');
                    $(nameSelect2).removeClass('is-invalid');
                }

            }else {
                mensaje("error","Error",'Hubo problemas con el servidor,intentelo nuevamente ,si el problema persiste comuniquese con el administrador del sistema');
            }
        } catch (err) {
            console.log(err)
        }
    })();
}


function closeModal(nameSelector,listCamps){
    $(nameSelector).modal("hide");
    listCamps.forEach(element => {
        document.querySelector(element).value = '';
    });
}




function configDataTables(nameSelector,urlAjax,ColumnData,columnDefs = [],
        sDom = '<"row" <"col-sm-12 col-md-6"l> <"col-sm-12 col-md-6"f> >rt<"row" <"col-sm-12 col-md-5"i> <"col-sm-12 col-md-7"p> >',pageLength=10,rowCallback=""){
    let tableData =  $(nameSelector).DataTable({
        "sDom": sDom,
        "aProcessing":true,
        "aServerSide":true,
        "pageLength": pageLength,
        responsive:true,
        "language":{
            "url" : "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        },
        "ajax":{
            "url" : urlAjax,
            "dataSrc":""
        },
        "columns":ColumnData,
        "columnDefs":columnDefs,
        "rowCallback":rowCallback,
    });
    
    $('div.dataTables_length select').addClass("form-control form-control-sm");
    $('div.dataTables_filter input').addClass("form-control form-control-sm");

    return tableData;
}


function mensaje(icon,title,text){
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
    })
}





function sendingDataServerSide(idForm,validatorServerSide,fieldsToValidate,listCamps,configTable,urlMethod,modalNameSelector){
    $(idForm).on('submit',function (e) {
        e.preventDefault();
        if(validatorServerSide.checkAll('.needs-validation') === 0){
            let formData = $(this).serializeArray();
            $.ajax({
                url: base_url+urlMethod,
                type: $(idForm).attr("method"),
                data: formData,
                dataType: 'json'
            }).done(function (data) {
                if(data.status){
                    closeModal(modalNameSelector,listCamps)
                    mensaje('success','Exitoso',data.msg);
                    configTable.ajax.reload();
                }else{
                    if (!jQuery.isEmptyObject(data.formErrors)){
                        fieldsToValidate.forEach((value,index) => {
                            if (data.formErrors.hasOwnProperty(fieldsToValidate[index])){
                                validatorServerSide.errorTrigger($('[name='+fieldsToValidate[index]+']'), data.formErrors[''+fieldsToValidate[index]+'']);
                            }
                        });
                    }else{
                        if(data.msg == "error"){
                        }else{
                            mensaje("error","Error",data.msg);
                        }
                    }
    
                }
            }).fail(function (error) {
                mensaje("error","Error",'Hubo problemas con el servidor,intentelo nuevamente ,si el problema persiste comuniquese con el administrador del sistema');
            })
        }
    })
}


function deleteServerSide(url,id,text,nameSelectortable){
    Swal.fire({
            title: "Eliminar Registro",
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText : 'No, cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            (async () => {
                try {
                    let data = new FormData();data.append("id",id);
                    let options = { method: "POST", body :data}
                    let response = await fetch(url,options);
                    if (response.ok) {
                        let data = await response.json();
                        if(data.status){
                            mensaje("success","Exitoso",data.msg);
                            $(nameSelectortable).DataTable().ajax.reload();
                        }else{
                            mensaje("error","Error",data.msg);
                        }
                    }else {
                        mensaje("error","Error",'Hubo problemas con el servidor,intentelo nuevamente ,si el problema persiste comuniquese con el administrador del sistema');
                    }
                } catch (err) {
                    mensaje("error","Error",'Hubo problemas con el servidor,intentelo nuevamente ,si el problema persiste comuniquese con el administrador del sistema');
                }
            })();
        }
    });
}


async function fetchSelect(urlData,nameSelectorSelect,messageDefault){
    try {
        let options = { method: "GET"}
        let response = await fetch(urlData,options);
        if (response.ok) {
            let data = await response.text();
            if(document.querySelector(nameSelectorSelect) !=null){
                document.querySelector(nameSelectorSelect).innerHTML = "<option  selected disabled='disabled'  value=''>"+messageDefault+"</option>"+data;
            }
        }else {
            mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
        }
    } catch (err) {
        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
    }
};


function abrir_modal_restaurar(){
    let options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    $('#modalRestaurar').appendTo("body").modal(options);
}


function mostrarPassword(){
    var cambio = document.getElementById("password");
    if(cambio.type == "password"){
        cambio.type = "text";
        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }else{
        cambio.type = "password";
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
} 


function printPdf(idFrame){
    let objFra = document.getElementById(idFrame);
    objFra.contentWindow.focus();
    objFra.contentWindow.print();
}


function abrir_modal_reporte(idModal){
    let options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    $('#'+idModal).modal(options);
}

