@extends('layouts.teacher')


@section('content')

		<h2 class=" block-title light-card layer-2">Students</h2>

    
      <div class="form-section layer-2">
        <table class="table" id="students">
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
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
            
            let body = document.querySelector('tbody');

            function addStudent(email){
              options.innerHTML = "";
              searchInput.value = "";

              let xhr = new XMLHttpRequest();

              xhr.onload = function() { //Fonction de rappel
                if(this.status === 200) {
                  let data = JSON.parse(this.responseText);
                  if(data.success){
                    let student = data.student;
                    let tr = "<tr><td>"+student.firstname+"</td><td>"+student.lastname+"</td><td>"+student.email+"</td><td><a href='/teacher/students/"+student.id+"'><i class='fas fa-arrow-alt-square-right'></i>Manage</a></td>";
                    body.innerHTML += tr;
                    //show message
                    createFlashPopUp('Student Successfully Added');
                  }
                } else if(this.status === 403) {
                  let data = JSON.parse(this.responseText);
                  createFlashPopUp(data.msg, true);
                } else {
                  createFlashPopUp('Oops, Something Went Wrong', true);
                }
              };
              const data = JSON.stringify({
                email:email,
                _token: "<?= csrf_token() ?>"
              });

              xhr.open('POST', "{{ route('student_teacherStore') }}");
              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
              xhr.setRequestHeader("Content-Type", "application/json");
              xhr.send(data);
            }
          };
        </script>
@endsection

