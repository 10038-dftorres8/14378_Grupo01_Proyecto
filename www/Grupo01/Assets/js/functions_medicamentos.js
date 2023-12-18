var tableMedicamentos;
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableMedicamentos = $('#tableMedicamentos').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Medicamentos/getMedicamentos",
            "dataSrc":""
        },
        "columns":[
            {"data":"IdMedicamento"},
            {"data":"Nombre"},
            {"data":"Tipo"},
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


    if(document.querySelector("#formMedicamento")){
        var formMedicamento = document.querySelector("#formMedicamento");
        formMedicamento.onsubmit = function(e) {
            e.preventDefault();
            var strNombre = document.querySelector('#txtNombre').value;
            var strTipo = document.querySelector('#txtTipo').value;

            if(strNombre == '' || strTipo == '')
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
            var ajaxUrl = base_url+'/Medicamentos/setMedicamento'; 
            var formData = new FormData(formMedicamento);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        $('#modalFormMedicamento').modal("hide");
                        formMedicamento.reset();
                        swal("Medicamentos", objData.msg ,"success");
                        tableMedicamentos.api().ajax.reload();
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


function fntViewInfo(idmedicamento){
    var idmedicamento = idmedicamento;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Medicamentos/getMedicamento/'+idmedicamento;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);

            if(objData.status){
                document.querySelector("#celNombre").innerHTML = objData.data.Nombre;
                document.querySelector("#celTipo").innerHTML = objData.data.Tipo;

                $('#modalViewMedicamento').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(idmedicamento){
    document.querySelector('#titleModal').innerHTML ="Actualizar Medicamento";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    var idmedicamento = idmedicamento;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Medicamentos/getMedicamento/'+idmedicamento;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector("#idMedicamento").value = objData.data.IdMedicamento;
                document.querySelector("#txtNombre").value = objData.data.Nombre;
                document.querySelector("#txtTipo").value = objData.data.Tipo;
            }
        }
    
        $('#modalFormMedicamento').modal('show');
    }
}

function fntDelInfo(idmedicamento){

    var idMedicamento = idmedicamento;
    swal({
        title: "Eliminar Medicamento",
        text: "¿Realmente quiere eliminar el Medicamento?",
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
            var ajaxUrl = base_url+'/Medicamentos/delMedicamento';
            var strData = "idMedicamento="+idMedicamento;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar", objData.msg , "success");
                        tableMedicamentos.api().ajax.reload();
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
    document.querySelector('#idMedicamento').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Medicamento";
    document.querySelector("#formMedicamento").reset();
    $('#modalFormMedicamento').modal('show');
}

