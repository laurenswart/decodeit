@extends('layouts.teacher')


@section('content')

    <h2 class="light-card block-title layer-2">Add Students</h2>

    <div class="row">
      <div class="col-12 col-xl-5">
        <div class="form-section layer-2">
          <h3 class="title-3">Current Students</h3>
          <table class="table">
              <thead>
                  <tr>
                      <th>Firstname</th>
                      <th>Lastname</th>
                      <th>Email</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($students as $student)
                  <tr>
                      <td>{{ $student->firstname }}</td>
                      <td>{{ $student->lastname }}</td>
                      <td>{{ $student->email }}</td>
                  </tr>
                
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="col ml-3">
        <div class="form-section layer-2">
          <h3 class="title-3">New Students</h3>
          <div class="form-group">
              <label>Type a country name</label>
              <input type="text" name="country" id="country" placeholder="Enter country name" class="form-control">
          </div>
          <div id="options"></div>
          <div id="newStudents"></div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
            window.onload = function(){
             
              let options = document.getElementById('options');
              let newStudents = document.getElementById('newStudents');
              document.getElementById('country').addEventListener('keyup', function(){
                var query = this.value; 
                let xhr = new XMLHttpRequest();

                xhr.onload = function() { //Fonction de rappel
                  //console.log(this);
                  if(this.status === 200) {
                    let data = this.responseText;
                    console.log(data);
                    console.log(options);
                    options.innerHTML = data;

                    document.querySelectorAll('#options li').forEach( (x) => {
                      x.onclick = function(){
                        let option = this;
                        let name = option.querySelector('span:first-of-type');
                        let email = option.querySelector('small:first-of-type');
                        newStudents.innerHTML += option.innerText;
                        options.innerHTML = "";
                      }
                    })
                  }
                };
                const data = JSON.stringify({
                  country:query,
                  _token: "<?= csrf_token() ?>"
                });

                xhr.open('POST', "{{ route('student_teacherSearch') }}");
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.send(data);
                // end of ajax call
              });

              
            };

            function add(userId){
              newStudents.innerHTML += chosen;
            }
        </script>
@endsection

