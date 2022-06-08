  
$(document).ready(function(){
     
    getCountsData();
    
    function getCountsData() {
        $.ajax({
          url: "./dashboard/getCountsData",
          type: "GET",
          cache: false,
          success: function (dataResult) {
            var datass = JSON.parse(dataResult);    

            $('#person_count').text(datass.data.person.recipient + ' - ' + datass.data.person.count);
            $('#country_count').text(datass.data.country.country + ' - ' + datass.data.country.count);
            $('#career_count').text(datass.data.career.career + ' - ' + datass.data.career.count);

          }
        });
    }

    

    getChartsData();

    function getChartsData() {
        $.ajax({
          url: "./dashboard/getChartData",
          type: "GET",
          cache: false,
          success: function (dataResult) {
            var datass = JSON.parse(dataResult);  


            
            // person
            var personlabel = [];
            var persondata = [];
            $.each(datass.data.person, function (index, val) {
                personlabel.push(val.recipient); 
                persondata.push(val.count);  
            }); 
 
            personChart(personlabel, persondata);

            
            // countries
            var countrylabel = [];
            var countrydata = [];
            $.each(datass.data.country, function (index, val) {
                countrylabel.push(val.country); 
                countrydata.push(val.count);  
            }); 
 
            countriesChart(countrylabel, countrydata);

            
            // career
            var careerlabel = [];
            var careerdata = [];
            $.each(datass.data.career, function (index, val) {
                careerlabel.push(val.career);
                careerdata.push(val.count);  
            });
 
            careerChart(careerlabel, careerdata);


          }
        });
    }



    function personChart(personlabel, persondata)
    {
        
        const ctx = $('#myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: personlabel,
                datasets: [{
                    label: '# of Entries',
                    data: persondata,
                    backgroundColor: [ 
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ], 
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
    }



    function countriesChart(countrylabel, countrydata)
    { 
    
        new Chart(
            document.getElementById('myChart2'),{
                type: 'line',
                data: {
                    labels:countrylabel,
                    datasets: [{
                        label: '# of Entries',
                        data: countrydata,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
            }
        );
    }



    function careerChart(careerlabel, careerdata)
    {
        new Chart(
            document.getElementById('CareerChart'),{
                type: 'pie',
                data: {
                    labels: careerlabel,
                    datasets: [{
                        label: '# of Entries',
                        data: careerdata,
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
    }
});