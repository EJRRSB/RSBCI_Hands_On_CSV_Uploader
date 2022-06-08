@extends('layouts.app')
<style>
    .dataTables_filter {
        float: right;
    }
    #sampletable_length{
        float: left;
    }
  
</style>
@section('content')
<div class="container">


    

    <br>
    <div class="row justify-content-center mb-4">
        <div class="col-md-4"> 
             
             <div class="card shadow bg-white rounded">
                 <div class="card-header"style="color:#00008B;"><strong>Person with the most entries</strong></div>
                 <div class="card-body mb-3"> 
                     <span class="medium stretched-link" id="person_count" >-</span>                       
                 </div>
             </div> 
        </div>  
        <div class="col-md-4"> 
             <div class="card shadow bg-white rounded">
                 <div class="card-header"style="color:#00008B;"><strong>Country with the most entries</strong></div>
                 <div class="card-body mb-3"> 
                     <span class="medium stretched-link" id="country_count" >-</span>                      
                 </div>
             </div>  
        </div>
        <div class="col-md-4"> 
             <div class="card shadow bg-white rounded">
                 <div class="card-header"style="color:#00008B;"><strong>Career with the most entries</strong></div>
                 <div class="card-body mb-3"> 
                     <span class="medium stretched-link" id="career_count" >-</span>                      
                 </div>
             </div>  
        </div>
    </div>
    <div class="row justify-content-center mb-4 h-20" >
        
        <div class="col-md-6 h-20" > 
             
            <div class="card shadow bg-white rounded">
                <div class="card-header"style="color:#00008B;"><strong>Top 3 People in Forbes</strong></div>
                <div class="card-body mb-3">
                    <div>
                        <canvas id="myChart" style="Height:50px;"></canvas> 
                    </div>
                     
                </div>
            </div>           

        </div> 

        <div class="col-md-6 h-20"> 
             
            <div class="card shadow bg-white rounded">
                <div class="card-header"style="color:#00008B;"><strong>Top 3 Countries in Forbes</strong></div>
                <div class="card-body mb-3">
                    <div>
                        <canvas id="myChart2" style="Height:50px;"></canvas> 
                    </div>
                     
                </div>
            </div>           

        </div> 
       

    </div>

    <div class="row justify-content-center">
         
        <div class="col-md-6" > 
             
            <div class="card shadow bg-white rounded">
                <div class="card-header"style="color:#00008B;"><strong>Top 3 Careers in Forbes</strong></div>
                <div class="card-body mb-3 ">
                    <div>
                        <canvas id="CareerChart"  ></canvas> 
                    </div>
                     
                </div>
            </div>           

        </div>  
       

    </div>

</div>
@endsection 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
 

<!-- DATATABLE -->  
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script src="{{asset('js/dashboard.js')}}"></script> 