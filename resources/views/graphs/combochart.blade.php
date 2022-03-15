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
    <form action="{{  route('graph')  }}" method="post">
        @csrf
        <div class="flex justify-center">
        <input name="student_id" value="{{$student->id}}" type="hidden">
            <label class="text-xl mt-4">Select Graph: </label>
            <select name="graphtype" id="graphtype" class="p-3 text-black text-bold bg-gray-200 border-2 rounded-lg">
                <option value="Combo" selected>Grades And Attendance</option>
                <option value="Student">Ratings</option>
            </select>
            <button type="submit" class="mb-4 mt-3 bg-blue-400 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                Generate
            </button>
        </div>
    </form>
    <div class="flex justify-center">
        <div id="chart_div" style="width: 1300px; height: 700px;"></div>
    </div>
  </body>
</html>
@endsection