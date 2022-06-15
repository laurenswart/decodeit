require('./functions.js');
window.onload = function(){
    document.querySelectorAll('button.add').forEach( x => x.addEventListener('click', function(){createEnrolment(x.value);}));
  }

  function createEnrolment(courseId){
    //ajax request
    var xhr = new XMLHttpRequest();

    xhr.onload = function () {
      if (this.status === 200) {
        var _data = this.responseText;
        _data = JSON.parse(_data); //console.log(data);

        if (_data.success) {
          console.log('success');
          //remove row from current table
          let btnAdd = document.querySelector('button[value="'+courseId+'"]');
          btnAdd.closest('tr').remove();

          //add row to left table
          let tableBody = document.querySelector('#existingEnrolments tbody');
          let tr = document.createElement('TR');
          tr.innerHTML = '<th class="label" scope="row"><a href="'+_data.route+'">'+_data.courseName+'</a></th><td>'+_data.created+'</td><td>-</td>';
          tableBody.appendChild(tr);
          createFlashPopUp('New Enrolment Created');
          return;
        }
      }
      createFlashPopUp('Oops, Something Went Wrong', true);
    };

    var data = JSON.stringify({
      _token: csrfToken,
      courseId: courseId
    });
    xhr.open('POST', "/teacher/students/"+studentId+"/enrolments");
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(data);
    
  }