$(document).ready(function(){ 
 
 
    DatatableForbes();

    var exam = $('#sampletable').DataTable();
    function DatatableForbes()
    { 
        exam = $('#sampletable').DataTable({
            processing:true,
            serverSide:true,
            info: true,
            stateSave: false,
            fixedHeaders: true,
            lengthMenu: [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ], 
            ajax: {
                "url": '/forbes/getForbesData',
                "type": "GET",
                 "data": {
                    search_option: $('#searchby').val()  
                }
            },
            columns:[
                {"data":'id'},
                {"data":'year'},
                {"data":'rank'},
                {"data":'recipient'},
                {"data":'country'},
                {"data":'career'},
                {"data":'tied'},
                {"data":'title'},
            ],
            order: [
                [0, 'asc']
            ]
        });
    }



    $('#btnShowUploadForm').on('click', function(){ 
        $('#csv_file').val('');
        $('#ErrorLog').val('');
        $('#upload_form').show(); 
    });


    $('#BtnClose').on('click', function(){ 
        $('#upload_form').hide();  
    });
 


    
    $('#searchby').on('change', function () {      
 
        if (exam != null) {
            exam.destroy();
            DatatableForbes();
        } else {
            DatatableForbes();
        }

    });




    $('#csv_file').on('click', function(){

        $('#csv_file').val('');
        
    });




    $('#csv_file').on('change', function () {
        var csv = $("#csv_file").val().split('.');
        if (csv[csv.length - 1].toUpperCase() != 'CSV') { 
            alert("File must be a CSV file.");
            $('#csv_file').val('');
        }
    });
 








    ///////////////////////////////// UPLOAD CSV ///////////////////////////////////////

    $('#form_csv').on('submit', function (event) {
        event.preventDefault(); 

        $.ajax({
            url: '/forbes',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false, 
            cache: false,
            beforeSend: function () { 
                ErrorlogInput('Uploading csv.....');
            }, 
            success: function (dataResult) {
                var dataResult = JSON.parse(dataResult); 

                if (dataResult.statusCode == 200) { 

                    $('#exam_csv').val('');
                    $('#upload_form').hide(); 
                    alert(dataResult.message);
                    exam.ajax.reload(null, false);

                } else if (dataResult.statusCode == 201) { 
                    ErrorlogInput(dataResult.message);
                } else if (dataResult.statusCode == 202) {  
                    $.each(dataResult.message, function (index, val) {
                        ErrorlogInput(val);     
                    });
                }

            },
            error: function (e) {
                ErrorlogInput('An error occured, please try again.');
            }
        });

    });

    

    function ErrorlogInput(message){
        $('#ErrorLog').val($('#ErrorLog').val() + '----------------------------------------\n' + message + '\n'); 
        $('#ErrorLog').scrollTop($('#ErrorLog')[0].scrollHeight); 
    }
 
      
});