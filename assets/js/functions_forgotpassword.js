
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
            $.LoadingOverlay("show");
            $.ajax({
                url: url,
                type: $(idForm).attr("method"),
                data: formData,
                dataType: 'json'
            }).done(function (data) {
                if(data.status){
                    setTimeout(function(){
                        $.LoadingOverlay("hide");
                        mensaje('success','Exitoso',data.msg);
                        $('#fntForgotpassword').trigger("reset");
                        $('form').removeClass('was-validated');
                        $("input").removeClass("is-valid");
                    },900);
                }else{
                    if (!jQuery.isEmptyObject(data.formErrors)){
                        console.log(data.formErrors)
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
            }).fail(function (error) {
                mensaje("error","Error",'Hubo problemas con el servidor, intentelo nuevamente')
            })
        }else{
            console.log("error")
        }
    })
}
