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
/*!**************************************!*\
  !*** ./resources/js/studentForum.js ***!
  \**************************************/
__webpack_require__(/*! ./functions.js */ "./resources/js/functions.js");

document.querySelector('.forum').scrollTop = document.querySelector('.forum').scrollHeight;
document.querySelector('#newMessage button').addEventListener('click', function () {
  var content = document.querySelector('#newMessage textarea').value; //if question empty do nothing

  if (content == '') {
    return;
  }

  var xhr = new XMLHttpRequest();

  xhr.onload = function () {
    //Fonction de rappel
    if (this.status === 200) {
      var _data = JSON.parse(this.responseText);

      createMessage(_data.msg, _data.date);
      document.querySelector('textarea').value = '';
    } else {
      createFlashPopUp('Oops, Something went wrong', true);
    }
  };

  var data = JSON.stringify({
    content: content,
    _token: csrfToken
  });
  xhr.open('POST', "/student/courses/" + courseId + "/forum");
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.send(data); // end of ajax call
});

function createMessage(content, date) {
  var div = document.createElement('div');
  div.classList.add('layer-2', 'forum-msg', 'form-section', 'right');
  var innerDiv = document.createElement('div');
  div.classList.add('msg-header');
  var divSpan1 = document.createElement('span');
  divSpan1.innerText = 'Me';
  var divSpan2 = document.createElement('span');
  divSpan2.classList.add('date');
  divSpan2.innerText = date;
  var p = document.createElement('p');
  p.innerText = content;
  innerDiv.appendChild(divSpan1);
  innerDiv.appendChild(divSpan2);
  div.appendChild(innerDiv);
  div.appendChild(p);
  document.querySelector('.forum').appendChild(div);
  document.querySelector('.forum').scrollTop = document.querySelector('.forum').scrollHeight;
}
})();

/******/ })()
;