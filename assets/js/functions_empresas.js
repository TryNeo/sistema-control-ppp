$(function(){
    const columnData = [
        {"data":"ruc_empresa"},
        {"data":"nombre_empresa"},
        {"data":"correo_empresa"},
        {"data":"nombre_representante"},
        {"data":"telefono_representante"},
        {"data":"estado"},
    ]

    const tableEmpresa = configDataTables('.tableEmpresa',base_url+"empresas/getEmpresas",columnData);

    clickModal("#modalEmpresa","Crear | Empresa","#fntEmpresa");
})

