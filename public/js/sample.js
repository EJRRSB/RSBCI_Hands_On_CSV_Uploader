$(document).ready(function(){ 
 
    // $('input[name="date_report"]').daterangepicker({ format: 'yyyy' }); 
  



 
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
                {"data":'id','className':'id'},
                {"data":'year',"orderable": true},
                {"data":'rank', "orderable": true},
                {"data":'recipient', "orderable": true},
                {"data":'country', "orderable": false},
                {"data":'career', "orderable": false},
                {"data":'tied', "orderable": false},
                {"data":'title', "orderable": false}    
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
        $('#report_form').hide();  
        $('#generate_csv_form').hide();
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
                $('#processing_modal').show();
            },   
            complete: function () {
                $('#processing_modal').hide();
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
 





    
    $('#btnDownloadCsv').on('click', function(){   
        $('#date_report1').empty();
        $('#date_report2').empty();
        getAvailableDates('0','date_report1');
        $('#report_form').show(); 
        $('#upload_form').hide();
        $('#generate_csv_form').hide();
    });





    // GET AVAILABLE DATES    
    function getAvailableDates(year,inputname) { 
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "./getAvailableDates",
            data: {
                _token: CSRF_TOKEN,
                year: year
            },
            type: "POST",
            cache: false,
            beforeSend: function () {  
                $('#processing_modal').show();
            }, 
            complete: function () {
                $('#processing_modal').hide();
            },
            success: function (dataResult) {
                var datass = JSON.parse(dataResult);
                $('#' + inputname).empty();
                $('#' + inputname).append('<option value="" disabled selected="selected">--</option>');    
                $.each(datass.message, function (index, val) {  
                    $('#' + inputname).append('<option value="' + val['year'] + '">' + val['year'] + '</option>');                      
                });    
           }
       });
    }


    


    
    $('#date_report1').on('change', function () {    
        getAvailableDates($(this).val(),'date_report2');
    });
 

    $('#BtnCloseReport').on('click', function(){
        $('#report_form').hide();  
    });











    ///////////////////////////////// DOWNLOAD CSV ///////////////////////////////////////

    $('#report_form_csv').on('submit', function (event) {
        event.preventDefault(); 

        $.ajax({
            url: '/csv_report',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false, 
            cache: false,
            beforeSend: function () {  
                $('#processing_modal').show();
            }, 
            complete: function () {
                $('#processing_modal').hide();
            }, 
            success: function (dataResult) {
                var dataResult = JSON.parse(dataResult); 

                if (dataResult.statusCode == 202) { // ERROR

                    var errors = '';  
                    $.each(dataResult.message, function (index, val) {    
                        errors += val;
                    });
                    alert(errors);

                } else if (dataResult.statusCode == 200) { // SUCCESS!
                   
                    $('#exam_csv').val('');
                    $('#upload_form').hide(); 
                    exam.ajax.reload(null, false); 

                    var csv = 'Year,Rank,Recipient,Country,Career,Tied,Title' + '\n'; // CREATE CSV
                     

                    $.each(dataResult.message, function (index, val) {  
                        csv += val['year'] + ", ";
                        csv += val['rank'] + ", ";
                        csv +=  val['recipient'].replace(",", " ") + ", ";
                        csv += val['country'] + ", ";
                        csv += val['career'] + ", ";
                        csv += val['tied'] + ", ";
                        csv += val['title'].replace(",", " ")  + ", ";
                        csv += "\n";
                    });

                    var hiddenElement = document.createElement('a');
                    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                    hiddenElement.target = '_blank';
                    hiddenElement.download = 'Report.csv';
                    hiddenElement.click();
                }

            },
            error: function (e) {
                $('#processing_modal').hide();
                alert('An error occured, please try again.'); 
            }
        });

    });







    
    $('#btnGenerateCsv').on('click', function(){   
        $('#report_form').hide(); 
        $('#upload_form').hide();
        $('#generate_csv_form').show(); 
        getMaxCountCsv();
    });


    
    $('#BtnCloseGenerateReport').on('click', function(){
        $('#generate_csv_form').hide();  
    });



    
 
    // GET MAX DATA COUNT    
    function getMaxCountCsv() {  
        $.ajax({
            url: "./getMaxData", 
            type: "GET",
            cache: false,
            beforeSend: function () {  
                $('#processing_modal').show();
            }, 
            complete: function () {
                $('#processing_modal').hide();
            },
            success: function (dataResult) {
                var datass = JSON.parse(dataResult); 
                $('#report_limit').val(datass.message);
            }
       });
    }




      ///////////////////////////////// GENERATE CSV ///////////////////////////////////////

      $('#generate_form_csv').on('submit', function (event) { 
        event.preventDefault(); 

        $.ajax({
            url: '/generateCsvLimit',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false, 
            cache: false,
            beforeSend: function () {  
                $('#processing_modal').show();
            }, 
            complete: function () {
                $('#processing_modal').hide();
            }, 
            success: function (dataResult) {
                var dataResult = JSON.parse(dataResult); 

                if (dataResult.statusCode == 202) { // ERROR

                    var errors = '';  
                    $.each(dataResult.message, function (index, val) {    
                        errors += val;
                    });
                    alert(errors);

                } else if (dataResult.statusCode == 200) { // SUCCESS!
                   
                    $('#exam_csv').val('');
                    $('#upload_form').hide(); 
                    exam.ajax.reload(null, false); 

                    var csv = 'Year,Rank,Recipient,Country,Career,Tied,Title' + '\n'; // CREATE CSV
                     

                    $.each(dataResult.message, function (index, val) {  
                        csv += val['year'] + ", ";
                        csv += val['rank'] + ", ";
                        csv +=  val['recipient'].replace(",", " ") + ", ";
                        csv += val['country'] + ", ";
                        csv += val['career'] + ", ";
                        csv += val['tied'] + ", ";
                        csv += val['title'].replace(",", " ")  + ", ";
                        csv += "\n";
                    });

                    var hiddenElement = document.createElement('a');
                    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                    hiddenElement.target = '_blank';
                    hiddenElement.download = 'GeneratedCsv.csv';
                    hiddenElement.click();
                }

            },
            error: function (e) {
                $('#processing_modal').hide();
                alert('An error occured, please try again.'); 
            }
        });

    });





 

    setInterval(function() { // TIMER 
        if($('#processing_text').text() == 'PROCESSING.'){
            $('#processing_text').text('PROCESSING..');
        }else if($('#processing_text').text() == 'PROCESSING..'){
            $('#processing_text').text('PROCESSING...');
        }else if($('#processing_text').text() == 'PROCESSING...'){
            $('#processing_text').text('PROCESSING....');
        }else if($('#processing_text').text() == 'PROCESSING....'){
            $('#processing_text').text('PROCESSING.....');
        }else if($('#processing_text').text() == 'PROCESSING.....'){
            $('#processing_text').text('PROCESSING.');
        }
      }, 100); 

      
});