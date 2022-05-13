/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/functions.js":
/*!***********************************!*\
  !*** ./resources/js/functions.js ***!
  \***********************************/
/***/ (() => {

window.createFlashPopUp = function (msg) {
  var error = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
  var div = document.createElement('div');
  div.classList.add('alert', 'flash-popup');

  if (error) {
    div.classList.add('alert-danger');
  } else {
    div.classList.add('alert-success');
  }

  div.innerText = msg;
  setTimeout(function () {
    div.remove();
  }, 5000);
  document.body.appendChild(div);
};

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*********************************************!*\
  !*** ./resources/js/teacherStudentIndex.js ***!
  \*********************************************/
__webpack_require__(/*! ./functions.js */ "./resources/js/functions.js");

window.onload = function () {
  var options = document.getElementById('options');
  var students = document.getElementById('students');
  var searchInput = document.getElementById('search');
  searchInput.addEventListener('keyup', function () {
    var query = this.value;
    var xhr = new XMLHttpRequest();

    xhr.onload = function () {
      //Fonction de rappel
      //console.log(this);
      if (this.status === 200) {
        var _data = this.responseText;
        options.innerHTML = _data;
        document.querySelectorAll('#options button').forEach(function (x) {
          x.onclick = function () {
            var option = this.closest('li');
            var email = option.querySelector('small:first-of-type'); //add student to db by ajax request

            addStudent(email.innerText);
          };
        });
      }
    };

    var data = JSON.stringify({
      search: query,
      _token: csrfToken
    });
    xhr.open('POST', "/teacher/students/search");
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(data); // end of ajax call
  });
  var body = document.querySelector('tbody');

  function addStudent(email) {
    options.innerHTML = "";
    searchInput.value = "";
    var xhr = new XMLHttpRequest();

    xhr.onload = function () {
      //Fonction de rappel
      if (this.status === 200) {
        var _data2 = JSON.parse(this.responseText);

        if (_data2.success) {
          var student = _data2.student;
          var tr = "<tr><td>" + student.firstname + "</td><td>" + student.lastname + "</td><td>" + student.email + "</td><td><a href='/teacher/students/" + student.id + "'><i class='fas fa-arrow-alt-square-right'></i>Manage</a></td>";
          body.innerHTML += tr; //show message

          createFlashPopUp('Student Successfully Added');
        }
      } else if (this.status === 403) {
        var _data3 = JSON.parse(this.responseText);

        createFlashPopUp(_data3.msg, true);
      } else {
        createFlashPopUp('Oops, Something Went Wrong', true);
      }
    };

    var data = JSON.stringify({
      email: email,
      _token: csrfToken
    });
    xhr.open('POST', "/teacher/students/store");
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(data);
  }
};
})();

/******/ })()
;