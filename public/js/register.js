/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/register.js ***!
  \**********************************/
document.querySelector('#terms').addEventListener('change', function () {
  console.log(this);
  console.log(this.checked);
  document.querySelector('button.myButton').disabled = !this.checked;
});
/******/ })()
;