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
    <form action="{{  route('graph')  }}" method="post">
        @csrf
        <div class="flex justify-center">
        <input name="class_id" value="{{$class->id}}" type="hidden">
            <label class="text-xl mt-4">Select Graph: </label>
            <select name="graphtype" id="graphtype" class="p-3 text-black text-bold bg-gray-200 border-2 rounded-lg">
                <option value="Student Grades" selected>Student Grades</option>
                <option value="Student Attendance">Student Attendance</option>
                <option value="Student Ratings">Student Ratings</option>
            </select>
            <button type="submit" class="mb-4 mt-3 bg-blue-400 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                Generate
            </button>
        </div>
    </form>
    <div class="container-fluid p-5 ml-9 mr-9 flex justify-center">
    <div id="barchart_material" style="width: 1300px; height: 700px;"></div>
    </div>
    </div>
</body>
@endsection