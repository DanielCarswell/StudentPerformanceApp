@extends('layouts.app')

@section('content')
  <head>
    <title>Laravel 8 Google Bar Chart Example Tutorial - Tutsmake.com</title>
    <meta charset="utf-8">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
 
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
 
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Student Name', 'Grade'],
 
            @php
              foreach($grades_model as $model) {
                  echo "['".$model->fullname."', ".$model->grade."],";
              }
            @endphp
        ]);
 
        var options = {
            chart: {title: 'Bar Graph | Grade',subtitle: 'Id, Grade',}, 
            colors: ['hotpink','red'],
            bars: 'vertical'
        };
        var chart = new google.charts.Bar(document.getElementById('barchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
</head>
  <body>
    <div class="ml-12 mr-12 mt-9">
        <h2 class="text-2xl font-extrabold flex justify-center mb-6">Class {{  $class->name  }} Grades</h2>
    </div>
    <div class="container-fluid p-5 ml-9 mr-9">
    <div id="barchart_material" style="width: 1300px; height: 700px;"></div>
    </div>
</body>
@endsection