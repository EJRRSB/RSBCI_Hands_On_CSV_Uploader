@extends('layouts.app')
<style>
    .dataTables_filter {
        float: right;
    }
    #sampletable_length{
        float: left;
    }
    .id{
        display:none;
    }

  
</style>
@section('content')
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}"/>
<div class="container">


    <div class="row justify-content-center" id ="upload_form" style ="display:none;">
        <div class="col-md-9"> 
            <div class="card shadow bg-white rounded">
                <div class="card-header">CSV File Upload Form</div>

                <div class="card-body">                          
                    <form method="POST" id="form_csv">
                        @csrf
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Select a Csv File</label>
                            <input type="file" class="form-control" id="csv_file" name ="csv_file" required>
                        </div>
                        <div class="mb-3">
                            <label for="ErrorLog" class="form-label">Error log</label>
                            <textarea class="form-control" id="ErrorLog" name ="ErrorLog" rows="7" style="color:red;"></textarea>
                        </div> 
                        <div class="col-md-8 mt-3">  
                            <button type="submit" class="btn btn-primary" id="BtnSave">Upload</button>  
                            <a href="javascript:;" class="btn btn-success" id="BtnClose"> Close</a> 
                        </div> 
                    </form> 
                </div>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center" id ="report_form" style ="display:none;">
        <div class="col-md-4"> 
            <div class="card shadow bg-white rounded">
                <div class="card-header">CSV Report Form</div>

                <div class="card-body">                          
                    <form method="POST" id="report_form_csv">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-6">                            
                                <div class="mb-3">
                                    <label for="date_report1" class="form-label">Select From Year</label> 
                                    <select class="form-control" id="date_report1" name ="date_report1" required>                                   
                                    </select> 
                                </div>
                            </div>
                            <div class="col-md-6">                            
                                <div class="mb-3">
                                    <label for="date_report2" class="form-label">Select To Year</label> 
                                    <select class="form-control" id="date_report2" name ="date_report2" required>                                   
                                    </select> 
                                </div>
                            </div>
                        </div>
                         
                        <div class="col-md-8 mt-3">  
                            <button type="submit" class="btn btn-primary" id="BtnSaveReport">Export</button>   
                            <a href="javascript:;" class="btn btn-success" id="BtnCloseReport"> Close</a> 
                        </div> 
                    </form> 
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center" id ="generate_csv_form" style ="display:none;">
        <div class="col-md-4"> 
            <div class="card shadow bg-white rounded">
                <div class="card-header">CSV Report Form</div>

                <div class="card-body">                          
                    <form method="POST" id="generate_form_csv">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-12">                            
                                <div class="mb-3">
                                    <label for="report_limit" class="form-label">Input Report Limit</label>   
                                    <input type="number" min="1" max="999" class="form-control" id="report_limit" name ="report_limit" required> 
                                </div>
                            </div> 
                        </div>
                         
                        <div class="col-md-8 mt-3">  
                            <button type="submit" class="btn btn-primary" id="BtnGenerateReport">Generate</button>    
                            <a href="javascript:;" class="btn btn-success" id="BtnCloseGenerateReport"> Close</a>
                        </div> 
                    </form> 
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row justify-content-center">  
        <div class="col-md-9">  
            <hr>        
            <button class="btn btn-primary ml-4" id="btnShowUploadForm" style ="float:right;">Import CSV File</button>  
            <p style="float:right; color: white;"> | </p> 
            <button class="btn btn-success ml-4" id="btnDownloadCsv" style ="float:right;">Export CSV File</button>  
            <p style="float:right; color: white;""> | </p> 
            <button class="btn btn-success mr-3" id="btnGenerateCsv" style ="float:right;">Gegenrate CSV File</button>   
        </div>
    </div>

     

    <br>
    <div class="row justify-content-center">
        
        <div class="col-md-9"> 
            
            
            <div class="card shadow bg-white rounded">
                <div class="card-header">Forbes Top 10</div>
                <div class="card-body mb-3">
                    <div class="mb-3" style = "float:right;">
                        <label for="searchby" class="form-label">Search By:</label>
                        <select  id="searchby" style = "width:180px; border: 1px solid #aaa; padding:5px; border-radius: 3px; background-color: transparent;">
                            <option value="year" selected="selected">Year</option>
                            <option value="rank">Rank</option>
                            <option value="recipient">Recipient</option>
                            <option value="country">Country</option>
                            <option value="career">Career</option>
                            <option value="tied">Tied</option>
                            <option value="title">Title</option> 
                        </select>
                    </div>
                    
                    <table id="sampletable" class="table table-hover table-responsive table-sm" >
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Year</th>
                            <th scope="col">Rank</th> 
                            <th scope="col">Recipient</th>
                            <th scope="col">Country</th>
                            <th scope="col">Career</th>
                            <th scope="col">Tied</th>
                            <th scope="col">Title</th>
                            </tr>
                        </thead>
                        <tbody> 
                        </tbody>
                    </table>
                </div>
            </div>

            

        </div> 

    </div>
</div>


<div class="modal" id="processing_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered " role="document">
    <div class="modal-content"> 
        <div class="modal-body"> 
        <center>
        <h5 style="color: red" id="processing_text">PROCESSING.</h5>
        </center>
        </div> 
    </div>
    </div>
</div>
@endsection

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
 

<!-- DATATABLE --> 
<!-- <script src="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script> -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

 
<!-- DATE RANGE -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> 


<script src="{{asset('js/sample.js')}}"></script>
