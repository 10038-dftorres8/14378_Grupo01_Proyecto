var tableMedicos;
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableMedicos = $('#tableMedicos').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Medicos/getMedicos",
            "dataSrc":""
        },
        "columns":[
            {"data":"IdMedico"},
            {"data":"User"},
            {"data":"Descripcion"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });


    if(document.querySelector("#formMedico")){
        var formMedico = document.querySelector("#formMedico");
        formMedico.onsubmit = function(e) {
            e.preventDefault();
            var strUser = document.querySelector('#listUsers').value;
            var strNombre = document.querySelector('#txtNombre').value;
            var strEspecialidad = document.querySelector('#listEspecialidad').value;

            if(strNombre == '' || strEspecialidad== ''  || strUser == '')
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    swal("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 


            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Medicos/setMedico'; 
            var formData = new FormData(formMedico);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        $('#modalFormMedico').modal("hide");
                        formMedico.reset();
                        swal("Médicos", objData.msg ,"success");
                        tableMedicos.api().ajax.reload();
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
    

    }, false);

    window.addEventListener('load', function() {
        fntListEspecialidades();
        fntListUsuarios();
    }, false);

    function fntListUsuarios(){
        if(document.querySelector('#listUsers')){
            var ajaxUrl = base_url+'/Medicos/getSelectUsers';
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    document.querySelector('#listUsers').innerHTML = request.responseText;
                    $('#listUsers').selectpicker('render');
                }
            }
        }
    }


    function fntListEspecialidades(){
        if(document.querySelector('#listEspecialidad')){
            var ajaxUrl = base_url+'/Medicos/getSelectEspecialidades';
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    document.querySelector('#listEspecialidad').innerHTML = request.responseText;
                    $('#listEspecialidad').selectpicker('render');
                }
            }
        }
    }


function fntViewInfo(idpersona){
    var idpersona = idpersona;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Medicos/getMedico/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);

            if(objData.status){
                document.querySelector("#celUser").innerHTML = objData.data.User;
                document.querySelector("#celNombre").innerHTML = objData.data.Nombre;
                document.querySelector("#celEspecialidad").innerHTML = objData.data.Descripcion;
                document.querySelector("#imgCategoria").innerHTML = '<img src="'+objData.data.url_portada+'"></img>';

                $('#modalViewUser').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(idpersona){
    document.querySelector('#titleModal').innerHTML ="Actualizar Médico";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    var idpersona = idpersona;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Medicos/getMedico/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector("#idUsuario").value = objData.data.id_user;
                document.querySelector("#listUsers").value = objData.data.UserMedico;
                document.querySelector("#txtNombre").value = objData.data.Nombre;
                document.querySelector("#listEspecialidad").value = objData.data.Espe;

                // document.querySelector("#listUsers").disabled = true;

                $('#listUsers').selectpicker('render');
                $('#listEspecialidad').selectpicker('render');

            }
        }
    
        $('#modalFormMedico').modal('show');
    }
}

function fntDelInfo(idpersona){

    var idUsuario = idpersona;
    swal({
        title: "Eliminar Médico",
        text: "¿Realmente quiere eliminar el Médico?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Medicos/delMedico';
            var strData = "idUsuario="+idUsuario;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar", objData.msg , "success");
                        tableMedicos.api().ajax.reload();
                    }else{
                        swal("¡Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}


function openModal()
{
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Médico";
    document.querySelector("#formMedico").reset();
    $('#modalFormMedico').modal('show');
    // removePhoto();
}