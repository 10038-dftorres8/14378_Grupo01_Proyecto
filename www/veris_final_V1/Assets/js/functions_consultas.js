var tableConsultas;
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableConsultas = $('#tableConsultas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Consultas/getConsultas",
            "dataSrc":""
        },
        "columns":[
            {"data":"IdConsulta"},
            {"data":"NombreMedico"},
            {"data":"NombrePaciente"},
            {"data":"FechaConsulta"},
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


    if(document.querySelector("#formConsulta")){
        var formConsulta = document.querySelector("#formConsulta");
        formConsulta.onsubmit = function(e) {
            e.preventDefault();
            var intPaciente = document.querySelector('#listPacientes').value;
            var intMedico = document.querySelector('#listMedicos').value;
            var strFechaConsulta = document.querySelector('#dateFecha').value;
            var strDiagnostico = document.querySelector('#txtDiagnostico').value;
            var strInicio = document.querySelector('#timeInicio').value;
            var strFin = document.querySelector('#timeFin').value;

            if(intPaciente == '' || intMedico == ''  || strFechaConsulta == '' || strDiagnostico == '' || strInicio == '' || strFin == '')
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
            var ajaxUrl = base_url+'/Consultas/setConsulta'; 
            var formData = new FormData(formConsulta);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        $('#modalFormConsulta').modal("hide");
                        formConsulta.reset();
                        swal("Consultas", objData.msg ,"success");
                        tableConsultas.api().ajax.reload();
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
        fntListPacientes();
        fntListMedicos();
    }, false);

    function fntListPacientes(){
        if(document.querySelector('#listPacientes')){
            var ajaxUrl = base_url+'/Consultas/getSelectPacientes';
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    document.querySelector('#listPacientes').innerHTML = request.responseText;
                    $('#listPacientes').selectpicker('render');
                }
            }
        }
    }


    function fntListMedicos(){
        if(document.querySelector('#listMedicos')){
            var ajaxUrl = base_url+'/Consultas/getSelectMedicos';
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    document.querySelector('#listMedicos').innerHTML = request.responseText;
                    $('#listMedicos').selectpicker('render');
                }
            }
        }
    }


function fntViewInfo(idconsulta){
    var idconsulta = idconsulta;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Consultas/getConsulta/'+idconsulta;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);

            if(objData.status){
                document.querySelector("#celPaciente").innerHTML = objData.data.NombreP;
                document.querySelector("#celMedico").innerHTML = objData.data.NombreM;
                document.querySelector("#celFechaConsulta").innerHTML = objData.data.FechaConsulta;
                document.querySelector("#celDiagnostico").innerHTML = objData.data.Diagnostico;
                document.querySelector("#celHoraInicio").innerHTML = objData.data.HI;
                document.querySelector("#celHoraFin").innerHTML = objData.data.HF;
                

                $('#modalViewConsulta').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(idconsulta){
    document.querySelector('#titleModal').innerHTML ="Actualizar Consulta";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    var idconsulta = idconsulta;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Consultas/getConsulta/'+idconsulta;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector("#idConsulta").value = objData.data.IdConsulta;
                document.querySelector("#listPacientes").value = objData.data.idpac;
                document.querySelector("#listMedicos").value = objData.data.idmed;
                document.querySelector("#dateFecha").value = objData.data.FechaConsulta;
                document.querySelector("#txtDiagnostico").value = objData.data.Diagnostico;
                document.querySelector("#timeInicio").value = objData.data.HI;
                document.querySelector("#timeFin").value = objData.data.HF;

                $('#listPacientes').selectpicker('render');
                $('#listMedicos').selectpicker('render');

            }
        }
    
        $('#modalFormConsulta').modal('show');
    }
}

function fntDelInfo(idconsulta){

    var idConsulta = idconsulta;
    swal({
        title: "Eliminar Consulta",
        text: "¿Realmente desea eliminar la Consulta?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Consultas/delConsulta';
            var strData = "idConsulta="+idConsulta;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar", objData.msg , "success");
                        tableConsultas.api().ajax.reload();
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
    document.querySelector('#idConsulta').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Consulta";
    document.querySelector("#formConsulta").reset();
    $('#modalFormConsulta').modal('show');
}

