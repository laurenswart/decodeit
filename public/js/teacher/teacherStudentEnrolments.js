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
/*!**************************************************!*\
  !*** ./resources/js/teacherStudentEnrolments.js ***!
  \**************************************************/
__webpack_require__(/*! ./functions.js */ "./resources/js/functions.js");

window.onload = function () {
  console.log(document.querySelectorAll('button.add'));
  document.querySelectorAll('button.add').forEach(function (x) {
    return x.addEventListener('click', function () {
      createEnrolment(x.value);
    });
  });
};

function createEnrolment(courseId) {
  //ajax request
  var xhr = new XMLHttpRequest();

  xhr.onload = function () {
    if (this.status === 200) {
      var _data = this.responseText;
      _data = JSON.parse(_data); //console.log(data);

      if (_data.success) {
        console.log('success'); //remove row from current table

        var btnAdd = document.querySelector('button[value="' + courseId + '"]');
        btnAdd.closest('tr').remove(); //add row to left table

        var tableBody = document.querySelector('#existingEnrolments tbody');
        var tr = document.createElement('TR');
        tr.innerHTML = '<th class="label" scope="row"><a href="' + _data.route + '">' + _data.courseName + '</a></th><td>' + _data.created + '</td><td>-</td>';
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
  xhr.open('POST', "/teacher/students/" + studentId + "/enrolments");
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.send(data);
}
})();

/******/ })()
;