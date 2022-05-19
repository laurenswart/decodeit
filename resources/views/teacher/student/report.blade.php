<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    
    <style type="text/css" media="all">
        h1 {
            text-align:center;
            width: 100%;
        }
        .final-mark{
            text-align:right;
            font-weight: bold;
            color: #352751;
        }
        
        h2{
            margin-bottom:10px;
        }


        th{
            text-align:left;
        }

        table{
            width: 100%;;
        }

        h2{
            background-color: #ededed;
            border-radius: 5px;
            padding:5px 10px;
        }

        h1, h2{
            font-family: 'Ubuntu';
            color:#352751;
        }
        table th:nth-of-type(1){
            width: 88%;;
        }
        table th{
            color: #702c94;;
        }
    </style>
  </head>
  <body>
    
    <div>
        {{ ucfirst($student->firstname)}} {{ucfirst($student->lastname)}} 
        <br>{{$student->email}}
    </div>
    <h1>Report</h1>
    @foreach($student->courses as $course)
    
    <h2>{{ ucwords($course->title) }}</h2>
    <p class="final-mark">Final Mark: {{ $course->enrolmentForStudent($student->id)->final_mark ?? '-' }} / 100</p>
        @if(count($course->skills)>0)
            <table>
                <thead>
                    <tr>
                        <th>Skills</th>
                        <th >Mark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course->skills as $skill)
                    <tr>
                        <td>{{ $skill->title }}</td>
                        <td>{{ $skill->studentMark($student->id)!==null ? $skill->studentMark($student->id).' /100' : '-'}}</td>
                    </tr>
                    @if($skill->description)
                        <tr >
                            <td colspan="2" style="padding-left:20px;"><em>{{ $skill->description }}</em></td>
                        </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        @endif
        <h3></h3>
        <!--ASSIGNMENTS-->
        

        @if(count($course->assignments)>0)
          <table class="table">
              <thead>
                <tr>
                  <th scope="col">Assignments</th>
                  <th scope="col">Mark</th>
                </tr>
              </thead>
              <tbody>
              @foreach($course->assignments as $assignment)
                <tr>
                    <td>{{ ucfirst($assignment->title) }}</td>
                    @if($assignment->studentAssignmentByStudent($student->id) )
                        <td>
                        @if($assignment->studentAssignmentByStudent($student->id)->mark!==null) 
                            {{$assignment->studentAssignmentByStudent($student->id)->mark}} / {{ $assignment->max_mark}}
                        @else 
                            -
                        @endif
                        </td>
                    @else
                        <td>-</td>
                    @endif
                </tr>              
              @endforeach
              </tbody>
            </table>
        @endif
    @endforeach
  </body>
</html>