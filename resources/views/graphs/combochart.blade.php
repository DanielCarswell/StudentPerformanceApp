@extends('layouts.app')

@section('content')
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Class Name', 'Grade', 'Attendance'],
            @php
                foreach($classes as $class) {
                    echo "['".$class->name."', ".$class->grade.", ".$class->attendance."],";
                }
            @endphp
        ]);

        var options = {
          title : 'Class Grades and Attendance',
          vAxis: {title: 'Percentage'},
          hAxis: {title: 'Class'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div class="ml-12 mr-12 mt-9">
        <h2 class="text-2xl font-extrabold flex justify-center mb-6">Student {{  $student->fullname  }} Class Details</h2>
    </div>
    <div class="flex justify-center">
        <div id="chart_div" style="width: 1300px; height: 700px;"></div>
    </div>
  </body>
</html>
@endsection