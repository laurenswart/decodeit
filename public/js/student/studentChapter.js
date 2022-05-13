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
/*!****************************************!*\
  !*** ./resources/js/studentChapter.js ***!
  \****************************************/
__webpack_require__(/*! ./functions.js */ "./resources/js/functions.js");

window.onload = function () {
  var readBtn = document.getElementById('readBtn');
  readBtn.addEventListener('click', function () {
    console.log('clicked');
    var xhr = new XMLHttpRequest();

    xhr.onload = function () {
      //Fonction de rappel
      if (this.status === 200) {
        var _data = this.responseText;
        _data = JSON.parse(_data);

        if (_data.isRead) {
          if (readBtn.classList.contains('btn-highlight')) {
            readBtn.classList.remove('btn-highlight');
            readBtn.classList.add('empty');
          }

          readBtn.innerText = 'Mark as not read';
        } else if (!_data.isRead) {
          if (!readBtn.classList.contains('btn-highlight')) {
            readBtn.classList.add('btn-highlight');
            readBtn.classList.remove('empty');
          }

          readBtn.innerText = 'I Have Read This Chapter';
        }
      }
    };

    var data = JSON.stringify({
      _token: csrfToken
    });
    xhr.open('POST', "/student/chapters/" + chapterId);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(data); // end of ajax call
  });
};
})();

/******/ })()
;