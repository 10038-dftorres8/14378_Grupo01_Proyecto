var tableRecetas;
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableRecetas = $('#tableRecetas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Recetas/getRecetas",
            "dataSrc":""
        },
        "columns":[
            {"data":"IdReceta"},
            {"data":"N_Consulta"},
            {"data":"NombreMedicamento"},
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


    if(document.querySelector("#formReceta")){
        var formReceta = document.querySelector("#formReceta");
        formReceta.onsubmit = function(e) {
            e.preventDefault();
            var intConsulta = document.querySelector('#listConsultas').value;
            var intMedicamento = document.querySelector('#listMedicamentos').value;
            var intCantidad = document.querySelector('#intCantidad').value;

            if(intCantidad == '' || intMedicamento == ''  || intCantidad == '')
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
            var ajaxUrl = base_url+'/Recetas/setReceta'; 
            var formData = new FormData(formReceta);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        $('#modalFormReceta').modal("hide");
                        formReceta.reset();
                        swal("Recetas", objData.msg ,"success");
                        tableRecetas.api().ajax.reload();
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
        fntListMedicamentos();
        fntListConsultas();
    }, false);

    function fntListConsultas(){
        if(document.querySelector('#listConsultas')){
            var ajaxUrl = base_url+'/Recetas/getSelectConsultas';
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    document.querySelector('#listConsultas').innerHTML = request.responseText;
                    $('#listConsultas').selectpicker('render');
                }
            }
        }
    }

    function fntListMedicamentos(){
        if(document.querySelector('#listMedicamentos')){
            var ajaxUrl = base_url+'/Recetas/getSelectMedicamentos';
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    document.querySelector('#listMedicamentos').innerHTML = request.responseText;
                    $('#listMedicamentos').selectpicker('render');
                }
            }
        }
    }


function fntViewInfo(idreceta){
    var idreceta = idreceta;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Recetas/getReceta/'+idreceta;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);

            if(objData.status){
                document.querySelector("#celConsulta").innerHTML = objData.data.N_Consulta;
                document.querySelector("#celMedicamento").innerHTML = objData.data.Nombre_M;
                document.querySelector("#celCantidad").innerHTML = objData.data.Cantidad;                

                $('#modalViewReceta').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(idreceta){
    document.querySelector('#titleModal').innerHTML ="Actualizar Receta";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    var idreceta = idreceta;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Recetas/getReceta/'+idreceta;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector("#idReceta").value = objData.data.IdReceta;
                document.querySelector("#listConsultas").value = objData.data.N_Consulta;
                document.querySelector("#listMedicamentos").value = objData.data.idmedi;
                document.querySelector("#intCantidad").value = objData.data.Cantidad;

                $('#listMedicamentos').selectpicker('render');
                $('#listConsultas').selectpicker('render');
                
            }
        }
    
        $('#modalFormReceta').modal('show');
    }
}

function fntDelInfo(idreceta){

    var idReceta = idreceta;
    swal({
        title: "Eliminar Receta",
        text: "¿Realmente desea eliminar la Receta?",
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
            var ajaxUrl = base_url+'/Recetas/delReceta';
            var strData = "idReceta="+idReceta;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar", objData.msg , "success");
                        tableRecetas.api().ajax.reload();
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
    document.querySelector('#idReceta').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Receta";
    document.querySelector("#formReceta").reset();
    $('#modalFormReceta').modal('show');
}

