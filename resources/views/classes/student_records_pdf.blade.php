<body>
<div>
<section>
    <div>
        <h1>{{$student->fullname}}</h1>
        <div>
        <table>
            <thead>
            <tr>
                <th>Class Name</th>
                <th>Grade</th>
                <th>Attendance</th>
                <th>Rating</th>
            </tr>
            </thead>
            <tbody>
                @if ($lists->count())
                    @foreach ($lists as $data)
                        <tr>
                            <td>
                                <div>
                                <div>
                                    <div aria-hidden="true"></div>
                                </div>
                                <div>
                                    <p>{{  $data->name  }}</p>
                                </div>
                                </div>
                            </td>
                            @if($data->grade >= 40)
                                <td>
                                    <span>{{  number_format((float)$data->grade, 0, '.', '')  }}%</span>
                                </td>
                            @else
                                <td>
                                    <span>{{  number_format((float)$data->grade, 0, '.', '')  }}%</span>
                                </td>
                            @endif
                            @if($data->attendance >= 40)
                                <td>
                                    <span>{{  number_format((float)$data->attendance, 0, '.', '')  }}%</span>
                                </td>
                            @else
                                <td>
                                    <span>{{  number_format((float)$data->attendance, 0, '.', '')  }}%</span>
                                </td>
                            @endif
                            @if($data->attendance < 30 && $data->grade < 30)
                                <td>
                                    <span>3</span>
                                </td>
                            @elseif($data->attendance >= 60 && $data->grade >= 70)
                                <td>
                                    <span>1</span>
                                </td>
                            @else
                                <td>
                                    <span>2</span>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @else
                        <p>There is no data</p>
                @endif
            </tbody>
        </table>
        </div>
    </div>
</section>
</div>
</body>