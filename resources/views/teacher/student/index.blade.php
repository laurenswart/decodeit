@extends('layouts.teacher')


@section('content')

		<h2 class=" block-title light-card layer-2">Students</h2>

    
      <div class="form-section layer-2">
        <div class="d-flex justify-content-end">
          <form method="get" action="{{ route('student_teacherIndex') }}">
            @csrf
            <input type="text" placeholder="Search.." name="filter" value="{{ $currentQueries['filter'] ?? ''}}">
            <input type="text" hidden value="{{ $currentQueries['sort'] }}" name="sort">
            <input type="text" hidden value="{{ $currentQueries['order'] }}" name="order">
            <button class="myButton">Search</button>
          </form>
        </div>
        <table class="table" id="students">
            <thead>
                <tr>
                    <th><a href="{{ route('student_teacherIndex', ['sort'=>'firstname', 'order'=> ($currentQueries['sort']=='firstname' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Firstname</a></th>
                    <th><a href="{{ route('student_teacherIndex', ['sort'=>'lastname', 'order'=> ($currentQueries['sort']=='lastname' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Lastname</a></th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
              @foreach($students as $student)
                
                <tr>
                    <td>{{ $student->firstname }}</td>
                    <td>{{ $student->lastname }}</td>
                    <td>{{ $student->email }}</td>
                    <td><a href="{{ route('student_teacherShow', $student->id) }}"><i class="fas fa-arrow-alt-square-right"></i>Manage</a></td>
                </tr>
              
              @endforeach
          </tbody>
        </table>
        {{ $students->links() }}
      </div>
      


    <div class="row">
      <div class="col">
        <div class="form-section layer-2">
          <h3 class="title-3">Add New Students</h3>
          <div class="form-group">
              <label>Type a student's firstname or lastname</label>
              <input type="text" name="search" id="search" placeholder="Enter Name" class="form-control">
          </div>
          <div id="options"></div>
        </div>
      </div>
      <div class="col-12 col-xl-3 col-md-4 form-section layer-2 ml-4">
        <h3 class="title-3">Details</h3>
      </div>
    </div>
@endsection

@section('scripts')
	<script type="text/javascript">
		let csrfToken = "<?= csrf_token() ?>";
	</script>
	<script src="{{ asset('js/teacher/teacherStudentIndex.js') }}"></script>
@endsection


