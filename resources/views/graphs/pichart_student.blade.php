@extends('layouts.app')

@section('content')
  <head>
    <title>Laravel 8 Google Bar Chart Example Tutorial - Tutsmake.com</title>
    <meta charset="utf-8">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
 
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
 
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Rating', 'Count'],
            ['Rating 1 - Excellent', {{$ratingCount1}}],
            ['Rating 2 - Good', {{$ratingCount2}}],
            ['Rating 3 - Failing', {{$ratingCount3}}]
        ]);
 
        var options = {
            chart: {title: 'Student Class Ratings'}
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
</head>
    <body>
        <div class="ml-12 mr-12 mt-9">
            <h2 class="text-2xl font-extrabold flex justify-center mb-6">Student {{  $student->fullname  }} Class Ratings</h2>
        </div>
        <div  class="flex justify-center">
            <div id="piechart" style="width: 1300px; height: 700px;"></div>
        </div>
  </body>
@endsection