
$(function(){
    
    const fieldsToValidate = ['emailuser']

    let validatorServerSide = $('form.needs-validation').jbvalidator({
        errorMessage: true,
        successClass: true,
        language: base_url_assets+"js/jbvalidatorLangEs.json",
    });
    validatorServerSide.validator.custom = function(el, event){

        if($(el).is('[name=emailuser]')){
            let value= $(el).val()
            
            if (!validateEmptyField(value)){
                return 'El campo email es obligatorio';
            }

            if (!validaEmail(value)){
                return 'El email '+value +' ingresado es incorrecto';
            }
        }

    }

    sendingDataServerSideForgotpassword('#fntForgotpassword',validatorServerSide,fieldsToValidate);
});


function sendingDataServerSideForgotpassword(idForm,validatorServerSide,fieldsToValidate){
    let url = $(idForm).attr("action");
    $(idForm).on('submit',function (e) {
        e.preventDefault();
        if(validatorServerSide.checkAll('.needs-validation') === 0){
            let formData = $(this).serializeArray();
            $.LoadingOverlaySetup({
                image           : "https://i.ibb.co/DQstGsn/favicon1.png",
                imageColor      : "#ffcc00",
                imageAnimation  : "pulse 2.5s",
                imageAutoResize         : true,
            });
            $.LoadingOverlay("show");
            $.ajax({
                url: url,
                type: $(idForm).attr("method"),
                data: formData,
                dataType: 'json'
            }).done(function (data) {
                if(data.status){
                    mensaje('success','Exitoso',data.msg);
                    $('#fntForgotpassword').trigger("reset");
                    $('form').removeClass('was-validated');
                    $("input").removeClass("is-valid");
                }else{
                    if (!jQuery.isEmptyObject(data.formErrors)){
                        $.LoadingOverlay("hide");
                        fieldsToValidate.forEach((value,index) => {
                            if (data.formErrors.hasOwnProperty(fieldsToValidate[index])){
                                validatorServerSide.errorTrigger($('[name='+fieldsToValidate[index]+']'), data.formErrors[''+fieldsToValidate[index]+'']);
                            }
                        });
                    }else{
                        $.LoadingOverlay("hide");
                        mensaje("error","Error",data.msg);
                    }
                }
                $.LoadingOverlay("hide");
            }).fail(function (error) {
                $.LoadingOverlay("hide");
                mensaje("error","Error",'Hubo problemas con el servidor, intentelo nuevamente')
            })
        }else{
            $.LoadingOverlay("hide");
            console.log("error")
        }
    })
}
