<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" bg-white border-b border-gray-200">

                    <div class="float-container" id="cont">

                        <div class="float-child">
                          <div class="red">
                              <img src="/uploads/demo1.png"/>
                          </div>
                            <a href="#" class="btn btn-success text-center" style="width: 100%;margin-top: 10px;" id="control" onclick="controls()">select</a> 
                        </div>
                        
                        <div class="float-child">
                          <div class="blue">
                              <img src="uploads/demo2.png"/>
                          </div>
                          <a href="#" class="btn btn-success text-center" style="width: 100%;margin-top: 10px;" id="variation" onclick="variations()">select</a> 
                        </div>
                        
                      </div>
                      
                  
                       
                      <!-- <canvas id="myChart" style="width:100%;max-width:600px"></canvas> -->
                      <canvas id="speedChart" width="600" height="200"></canvas>

                       
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



<script>
/*
window.onload = function()
{
    window.scrollTo(0, document.body.scrollHeight);
}*/


    function controls()
    {
        var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        //console.log(this.responseText)
        window.location = "/dashboard";
        // $('body').animate({scrollTop: $('#cont').prop("scrollHeight")}, 1000);
       

      }
    };
    xmlhttp.open("GET", "/control");
    xmlhttp.send();
    }
    function variations()
    {
        var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText)
        //window.location = "/dashboard";
      }
    };
    xmlhttp.open("GET", "/variation");
    xmlhttp.send();
    }
            
            </script>


<script>

   
   var minutes = [
@foreach ($minute as $min)
    "{{ $min }}m" , 
@endforeach
];
   var control = [
@foreach ($control as $cont)
    {{ $cont }} , 
@endforeach
];
   var variation = [
@foreach ($variation as $var)
    {{ $var }} , 
@endforeach
];


    
    var speedCanvas = document.getElementById("speedChart");
    
    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 14;
    
    var dataFirst = {
        label: "CONTROL (left)",
        data: control,
        lineTension: 0,
        fill: false,
        borderColor: 'red',
        borderWidth: 1.5,
        lineWidth:0.5
      };
    
    var dataSecond = {
        label: "VARIATION (right)",
        data: variation,
        lineTension: 0,
        fill: false,
      borderColor: 'blue',
      borderWidth: 1.5,
      lineWidth:0.5
      };
    
    var speedData = {
      labels: minutes,
      datasets: [dataFirst, dataSecond]
    };
    
    var chartOptions = {
      legend: {
        display: true,
        position: 'top',
        labels: {
          boxWidth: 10,
          fontColor: 'black',
          fontSize: 10
        }
      }
    };
    
    var lineChart = new Chart(speedCanvas, {
      type: 'line',
      data: speedData,
      options: chartOptions
    });
             
    

      
    
    </script>



