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
                 <div class="card-header"style="color:red;">Person with the most entries</div>
                 <div class="card-body mb-3">
                     <span class="medium text-danger stretched-link" id="person_count" >{{ $person->recipient }} - {{$person->count}}</span>                       
                 </div>
             </div> 
        </div>
        <div class="col-md-4"> 
             <div class="card shadow bg-white rounded">
                 <div class="card-header"style="color:red;">Country with the most entries</div>
                 <div class="card-body mb-3">
                     <span class="medium text-danger stretched-link" id="country_count" >{{ $country->country }} - {{$country->count}}</span>                       
                 </div>
             </div> 
        </div>
             
        <div class="col-md-4"> 
             <div class="card shadow bg-white rounded">
                 <div class="card-header"style="color:red;">Career with the most entries</div>
                 <div class="card-body mb-3">
                     <span class="medium text-danger stretched-link" id="career_count" >{{ $career->career }} - {{$career->count}}</span>                       
                 </div>
             </div>  
 
 
         </div>
    </div>
    <div class="row justify-content-center mb-4 h-20" >
        
        <div class="col-md-6 h-20" > 
             
            <div class="card shadow bg-white rounded">
                <div class="card-header"style="color:red;">Top 3 People in Forbes</div>
                <div class="card-body mb-3">
                    <div>
                        <canvas id="myChart" style="Height:50px;"></canvas> 
                    </div>
                     
                </div>
            </div>           

        </div> 

        <div class="col-md-6 h-20"> 
             
            <div class="card shadow bg-white rounded">
                <div class="card-header"style="color:red;">Top 3 Countries in Forbes</div>
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
                <div class="card-header"style="color:red;">Top 3 Careers in Forbes</div>
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

<script> 

$(document).ready(function(){
    const ctx = $('#myChart');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow',],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


  
  
    const myChart2 = new Chart(
        document.getElementById('myChart2'),{
            type: 'line',
            data: {
                labels:['Red', 'Blue'],
                datasets: [{
                    label: 'My First Dataset',
                    data: [65, 59],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
        }
    );




    const CareerChart = new Chart(
        document.getElementById('CareerChart'),{
            type: 'pie',
            data: {
                labels: [
                    'Red',
                    'Blue',
                    'Yellow'
                ],
                datasets: [{
                    label: 'My First Dataset',
                    data: [10, 5, 20],
                    backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
        }
    );
});

</script>
