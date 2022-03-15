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
            chart: {title: 'Class Student Ratings'}
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
</head>
    <body>
        <div class="ml-12 mr-12 mt-9">
            <h2 class="text-2xl font-extrabold flex justify-center mb-6">Class {{  $class->name  }} Student Ratings</h2>
        </div>
        <form action="{{  route('graph')  }}" method="post">
            @csrf
            <div class="flex justify-center">
            <input name="class_id" value="{{$class->id}}" type="hidden">
                <label class="text-xl mt-4">Select Graph: </label>
                <select name="graphtype" id="graphtype" class="p-3 text-black text-bold bg-gray-200 border-2 rounded-lg">
                    <option value="Student Grades">Student Grades</option>
                    <option value="Student Attendance">Student Attendance</option>
                    <option value="Student Ratings" selected>Student Ratings</option>
                </select>
                <button type="submit" class="mb-4 mt-3 bg-blue-400 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                    Generate
                </button>
            </div>
        </form>
        <div  class="flex justify-center">
            <div id="piechart" style="width: 1300px; height: 700px;"></div>
        </div>
  </body>
@endsection