@extends('layouts.teacher')


@section('content')

		<div class="h-end-link light-card  mt-4 layer-2 mb-4">
			<h2 class=" block-title">Students</h2>
			<a href="{{ route('student_teacherCreate') }}"><i class="fas fa-plus-square"></i>New</a>
		</div>

    <div class="form-section layer-2">
    <table class="table" id="students">
        <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
          @foreach($students as $student)
            
            <tr>
                <td>{{ $student->firstname }}</td>
                <td>{{ $student->lastname }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->created_at }}<td>
            </tr>
          
          @endforeach
      </tbody>
    </table>
    </div>

    <div class="row">
      <div class="col-12 col-md-6">
        <div class="form-section layer-2">
          <h3 class="title-3">Add New Students</h3>
          <div class="form-group">
              <label>Type a student's firstname or lastname</label>
              <input type="text" name="search" id="search" placeholder="Enter Name" class="form-control">
          </div>
          <div id="options"></div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
            window.onload = function(){
             
              let options = document.getElementById('options');
              let students = document.getElementById('students');
              let searchInput = document.getElementById('search');

              searchInput.addEventListener('keyup', function(){
                var query = this.value; 
                let xhr = new XMLHttpRequest();

                xhr.onload = function() { //Fonction de rappel
                  //console.log(this);
                  if(this.status === 200) {
                    let data = this.responseText;
                    options.innerHTML = data;

                    document.querySelectorAll('#options button').forEach( (x) => {
                      x.onclick = function(){
                        let option = this.closest('li');
                        //let name = option.querySelector('span:first-of-type');
                        let email = option.querySelector('small:first-of-type');
                        //add student to db by ajax request
                        addStudent(email.innerText);
                      };
                    });
                  }
                };
                const data = JSON.stringify({
                  search:query,
                  _token: "<?= csrf_token() ?>"
                });

                xhr.open('POST', "{{ route('student_teacherSearch') }}");
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.send(data);
                // end of ajax call
              });

              function addStudent(email){
                  console.log('adding student: '+email);
                  options.innerHTML = "";
                  searchInput.value = "";
                }

              
            };

            function add(userId){
              newStudents.innerHTML += chosen;
            }
        </script>
@endsection

