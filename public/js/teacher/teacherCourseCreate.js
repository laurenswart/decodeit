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
  !*** ./resources/js/teacherCourseCreate.js ***!
  \*********************************************/
__webpack_require__(/*! ./functions.js */ "./resources/js/functions.js");

window.onload = function () {
  var options = document.getElementById('options');
  var students = document.getElementById('students');
  var searchInput = document.getElementById('search');
  var nbNewStudentsInPage = document.querySelectorAll('#students div.newStudent');
  var nbNewStudents = nbNewStudentsInPage != null ? nbNewStudentsInPage.length : 0;
  searchInput.addEventListener('keyup', function () {
    var query = this.value;
    var xhr = new XMLHttpRequest();

    xhr.onload = function () {
      //Fonction de rappel
      if (this.status === 200) {
        var _data = this.responseText;
        options.innerHTML = _data;
        document.querySelectorAll('#options button').forEach(function (x) {
          x.onclick = function () {
            var option = this.closest('li');
            var name = option.querySelector('span:first-of-type');
            var email = option.querySelector('small:first-of-type'); //add student current form

            addStudent(name.innerText, email.innerText);
          };
        });
      }
    };

    var data = JSON.stringify({
      search: query,
      _token: csrfToken
    });
    xhr.open('POST', "/teacher/searchMyStudents");
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(data); // end of ajax call
  });

  window.addStudent = function (name, email) {
    nbNewStudents++;
    options.innerHTML = "";
    searchInput.value = "";
    var div = document.createElement('div');
    div.classList.add('d-flex', 'justify-content-between', 'mt-2', 'newStudent');
    var string = '<input type="hidden" name="students[' + nbNewStudents + '][name]" value="' + name + '"><input type="hidden" name="students[' + nbNewStudents + '][email]" value="' + email + '"><span>' + name + '</span><button type="button" class="btn btn-outline-danger" onclick="remove(this)">x</button>';
    div.innerHTML = string;
    students.appendChild(div);
  };
};

window.remove = function (button) {
  button.closest('div').remove();
};
})();

/******/ })()
;