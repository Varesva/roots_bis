(self["webpackChunk"] = self["webpackChunk"] || []).push([["checkout"],{

/***/ "./assets/checkout.js":
/*!****************************!*\
  !*** ./assets/checkout.js ***!
  \****************************/
/***/ (() => {

var stripe = Stripe("pk_test_51KquMELfBciygh7TnoJXg5vdJCTm6Vey9p0Q4mXEHpUkxxLwoNP7AorVW0mySoU8x4ZDRWQiii0nLDKhumnr1FWU005AFZWxGX");
var options = {
  clientSecret: '{{clientSecret}}'
}; // Set up Stripe.js and Elements to use in checkout form, passing the client secret obtained in step 2

var elements = stripe.elements(options); // Create and mount the Payment Element

var paymentElement = elements.create('payment');
paymentElement.mount('#payment-element');
var form = document.getElementById('payment-form');

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ var __webpack_exports__ = (__webpack_exec__("./assets/checkout.js"));
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiY2hlY2tvdXQuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7QUFBQSxJQUFNQSxNQUFNLEdBQUdDLE1BQU0sQ0FBQyw2R0FBRCxDQUFyQjtBQUdNLElBQU1DLE9BQU8sR0FBRztFQUNoQkMsWUFBWSxFQUFFO0FBREUsQ0FBaEIsRUFJQTs7QUFDQSxJQUFNQyxRQUFRLEdBQUdKLE1BQU0sQ0FBQ0ksUUFBUCxDQUFnQkYsT0FBaEIsQ0FBakIsRUFFQTs7QUFDQSxJQUFNRyxjQUFjLEdBQUdELFFBQVEsQ0FBQ0UsTUFBVCxDQUFnQixTQUFoQixDQUF2QjtBQUNBRCxjQUFjLENBQUNFLEtBQWYsQ0FBcUIsa0JBQXJCO0FBRUEsSUFBTUMsSUFBSSxHQUFHQyxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsY0FBeEIsQ0FBYiIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL2Fzc2V0cy9jaGVja291dC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyJjb25zdCBzdHJpcGUgPSBTdHJpcGUoXCJwa190ZXN0XzUxS3F1TUVMZkJjaXlnaDdUbm9KWGc1dmRKQ1RtNlZleTlwMFE0bVhFSHBVa3h4THdvTlA3QW9yVlcwbXlTb1U4eDRaRFJXUWlpaTBuTERLaHVtbnIxRldVMDA1QUZaV3hHWFwiKTtcclxuXHJcblxyXG4gICAgICBjb25zdCBvcHRpb25zID0ge1xyXG4gICAgICBjbGllbnRTZWNyZXQ6ICd7e2NsaWVudFNlY3JldH19JyBcclxuICAgICAgfTtcclxuXHJcbiAgICAgIC8vIFNldCB1cCBTdHJpcGUuanMgYW5kIEVsZW1lbnRzIHRvIHVzZSBpbiBjaGVja291dCBmb3JtLCBwYXNzaW5nIHRoZSBjbGllbnQgc2VjcmV0IG9idGFpbmVkIGluIHN0ZXAgMlxyXG4gICAgICBjb25zdCBlbGVtZW50cyA9IHN0cmlwZS5lbGVtZW50cyhvcHRpb25zKTtcclxuXHJcbiAgICAgIC8vIENyZWF0ZSBhbmQgbW91bnQgdGhlIFBheW1lbnQgRWxlbWVudFxyXG4gICAgICBjb25zdCBwYXltZW50RWxlbWVudCA9IGVsZW1lbnRzLmNyZWF0ZSgncGF5bWVudCcpO1xyXG4gICAgICBwYXltZW50RWxlbWVudC5tb3VudCgnI3BheW1lbnQtZWxlbWVudCcpO1xyXG5cclxuICAgICAgY29uc3QgZm9ybSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdwYXltZW50LWZvcm0nKTtcclxuXHJcbiJdLCJuYW1lcyI6WyJzdHJpcGUiLCJTdHJpcGUiLCJvcHRpb25zIiwiY2xpZW50U2VjcmV0IiwiZWxlbWVudHMiLCJwYXltZW50RWxlbWVudCIsImNyZWF0ZSIsIm1vdW50IiwiZm9ybSIsImRvY3VtZW50IiwiZ2V0RWxlbWVudEJ5SWQiXSwic291cmNlUm9vdCI6IiJ9