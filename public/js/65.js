(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[65],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _views_common_empty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/views/common/empty */ \"./resources/js/views/common/empty.vue\");\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  components: {\n    VEmptyView: _views_common_empty__WEBPACK_IMPORTED_MODULE_0__[\"default\"]\n  },\n  props: {\n    projectUuid: {\n      type: String,\n      required: true\n    },\n    taskUuid: {\n      type: String,\n      required: true\n    }\n  },\n  data: function data() {\n    return {\n      attachments: []\n    };\n  },\n  mounted: function mounted() {\n    this.getAttachments();\n  },\n  methods: {\n    getAttachments: function getAttachments() {\n      var _this = this;\n\n      axios.get(route('app:project.task.attachments.index', {\n        project: this.projectUuid,\n        task: this.taskUuid\n      })).then(function (response) {\n        _this.attachments = response.data;\n      });\n    }\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vcmVzb3VyY2VzL2pzL3ZpZXdzL2JhY2svYXBwL3Rhc2tzL3RhYi1hdHRhY2htZW50cy52dWU/YjdjYiJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQStCQTtBQUVBO0FBQ0E7QUFDQTtBQURBLEdBREE7QUFLQTtBQUNBO0FBQ0Esa0JBREE7QUFFQTtBQUZBLEtBREE7QUFLQTtBQUNBLGtCQURBO0FBRUE7QUFGQTtBQUxBLEdBTEE7QUFnQkEsTUFoQkEsa0JBZ0JBO0FBQ0E7QUFDQTtBQURBO0FBR0EsR0FwQkE7QUFzQkEsU0F0QkEscUJBc0JBO0FBQ0E7QUFDQSxHQXhCQTtBQTBCQTtBQUNBLGtCQURBLDRCQUNBO0FBQUE7O0FBQ0E7QUFDQSxpQ0FEQTtBQUVBO0FBRkEsVUFHQSxJQUhBLENBR0E7QUFDQTtBQUNBLE9BTEE7QUFNQTtBQVJBO0FBMUJBIiwiZmlsZSI6Ii4vbm9kZV9tb2R1bGVzL2JhYmVsLWxvYWRlci9saWIvaW5kZXguanM/IS4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2luZGV4LmpzPyEuL3Jlc291cmNlcy9qcy92aWV3cy9iYWNrL2FwcC90YXNrcy90YWItYXR0YWNobWVudHMudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPWpzJi5qcyIsInNvdXJjZXNDb250ZW50IjpbIjx0ZW1wbGF0ZT5cclxuICAgIDxkaXYgY2xhc3M9XCJmbGV4IGZsZXgtY29sXCI+XHJcbiAgICAgICAgPGRpdiBjbGFzcz1cImZsZXggZmxleC1jb2wgaXRlbXMtY2VudGVyXCIgdi1pZj1cImF0dGFjaG1lbnRzLmxlbmd0aCA9PT0gMFwiPlxyXG4gICAgICAgICAgICA8di1lbXB0eS12aWV3IDptZXNzYWdlPVwiJHRyYW5zKCdtZXNzYWdlcy5uby1kYXRhLXRvLXNob3ctaGVyZScpXCIvPlxyXG4gICAgICAgIDwvZGl2PlxyXG5cclxuICAgICAgICA8dWwgdi1pZj1cImF0dGFjaG1lbnRzLmxlbmd0aCA+IDBcIj5cclxuICAgICAgICAgICAgPGxpIGNsYXNzPVwicGwtMyBwci0yIHB5LTMgZmxleCBpdGVtcy1jZW50ZXIganVzdGlmeS1iZXR3ZWVuIHRleHQtc20gbGVhZGluZy01IHJvdW5kZWQtbGcgbWItMSBob3ZlcjpiZy1ncmF5LTEwMFwiIHYtZm9yPVwiYXR0YWNobWVudCBpbiBhdHRhY2htZW50c1wiPlxyXG4gICAgICAgICAgICAgICAgPGRpdiBjbGFzcz1cInctMCBmbGV4LTEgZmxleCBpdGVtcy1jZW50ZXJcIj5cclxuICAgICAgICAgICAgICAgICAgICA8c3ZnIGNsYXNzPVwiZmxleC1zaHJpbmstMCBoLTUgdy01IHRleHQtZ3JheS00MDBcIiBmaWxsPVwiY3VycmVudENvbG9yXCIgdmlld0JveD1cIjAgMCAyMCAyMFwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBmaWxsLXJ1bGU9XCJldmVub2RkXCIgZD1cIk04IDRhMyAzIDAgMDAtMyAzdjRhNSA1IDAgMDAxMCAwVjdhMSAxIDAgMTEyIDB2NGE3IDcgMCAxMS0xNCAwVjdhNSA1IDAgMDExMCAwdjRhMyAzIDAgMTEtNiAwVjdhMSAxIDAgMDEyIDB2NGExIDEgMCAxMDIgMFY3YTMgMyAwIDAwLTMtM3pcIiBjbGlwLXJ1bGU9XCJldmVub2RkXCI+PC9wYXRoPlxyXG4gICAgICAgICAgICAgICAgICAgIDwvc3ZnPlxyXG5cclxuICAgICAgICAgICAgICAgICAgICA8YSA6aHJlZj1cInJvdXRlKCdhcHA6cHJvamVjdC5hdHRhY2htZW50cy5kb3dubG9hZCcsIHtwcm9qZWN0OiBwcm9qZWN0VXVpZCwgYXR0YWNobWVudDogYXR0YWNobWVudC51dWlkfSlcIiBjbGFzcz1cImhvdmVyOnVuZGVybGluZVwiPlxyXG4gICAgICAgICAgICAgICAgICAgICAgICA8c3BhbiBjbGFzcz1cIm1sLTIgdHJ1bmNhdGVcIj57eyBhdHRhY2htZW50LmZpbGVuYW1lIH19PC9zcGFuPlxyXG4gICAgICAgICAgICAgICAgICAgIDwvYT5cclxuICAgICAgICAgICAgICAgIDwvZGl2PlxyXG5cclxuICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9XCJtbC00IGZsZXgtc2hyaW5rLTBcIj5cclxuICAgICAgICAgICAgICAgICAgICA8YSA6aHJlZj1cInJvdXRlKCdhcHA6cHJvamVjdC5hdHRhY2htZW50cy5kb3dubG9hZCcsIHtwcm9qZWN0OiBwcm9qZWN0VXVpZCwgYXR0YWNobWVudDogYXR0YWNobWVudC51dWlkfSlcIiBjbGFzcz1cImJ0biBidG4tZmxhdCBidG4teHNcIiA6dGl0bGU9XCIkdHJhbnMoJ2xhYmVscy5kb3dubG9hZCcpXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDxzdmcgY2xhc3M9XCJ3LTMgaC0zIGZpbGwtY3VycmVudFwiIHhtbG5zPVwiaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmdcIiB2aWV3Qm94PVwiMCAwIDIwIDIwXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPVwiTTEzIDhWMkg3djZIMmw4IDggOC04aC01ek0wIDE4aDIwdjJIMHYtMnpcIi8+XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIDwvc3ZnPlxyXG4gICAgICAgICAgICAgICAgICAgIDwvYT5cclxuICAgICAgICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICAgICA8L2xpPlxyXG4gICAgICAgIDwvdWw+XHJcbiAgICA8L2Rpdj5cclxuPC90ZW1wbGF0ZT5cclxuXHJcbjxzY3JpcHQ+XHJcbiAgICBpbXBvcnQgVkVtcHR5VmlldyBmcm9tICdAL3ZpZXdzL2NvbW1vbi9lbXB0eSdcclxuXHJcbiAgICBleHBvcnQgZGVmYXVsdCB7XHJcbiAgICAgICAgY29tcG9uZW50czoge1xyXG4gICAgICAgICAgICBWRW1wdHlWaWV3XHJcbiAgICAgICAgfSxcclxuXHJcbiAgICAgICAgcHJvcHM6IHtcclxuICAgICAgICAgICAgcHJvamVjdFV1aWQ6IHtcclxuICAgICAgICAgICAgICAgIHR5cGU6IFN0cmluZyxcclxuICAgICAgICAgICAgICAgIHJlcXVpcmVkOiB0cnVlXHJcbiAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgIHRhc2tVdWlkOiB7XHJcbiAgICAgICAgICAgICAgICB0eXBlOiBTdHJpbmcsXHJcbiAgICAgICAgICAgICAgICByZXF1aXJlZDogdHJ1ZVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSxcclxuXHJcbiAgICAgICAgZGF0YSgpIHtcclxuICAgICAgICAgICAgcmV0dXJuIHtcclxuICAgICAgICAgICAgICAgIGF0dGFjaG1lbnRzOiBbXVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSxcclxuXHJcbiAgICAgICAgbW91bnRlZCgpIHtcclxuICAgICAgICAgICAgdGhpcy5nZXRBdHRhY2htZW50cygpO1xyXG4gICAgICAgIH0sXHJcblxyXG4gICAgICAgIG1ldGhvZHM6IHtcclxuICAgICAgICAgICAgZ2V0QXR0YWNobWVudHMoKSB7XHJcbiAgICAgICAgICAgICAgICBheGlvcy5nZXQocm91dGUoJ2FwcDpwcm9qZWN0LnRhc2suYXR0YWNobWVudHMuaW5kZXgnLCB7XHJcbiAgICAgICAgICAgICAgICAgICAgcHJvamVjdDogdGhpcy5wcm9qZWN0VXVpZCxcclxuICAgICAgICAgICAgICAgICAgICB0YXNrOiB0aGlzLnRhc2tVdWlkXHJcbiAgICAgICAgICAgICAgICB9KSkudGhlbigocmVzcG9uc2UpID0+IHtcclxuICAgICAgICAgICAgICAgICAgICB0aGlzLmF0dGFjaG1lbnRzID0gcmVzcG9uc2UuZGF0YTtcclxuICAgICAgICAgICAgICAgIH0pXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICB9XHJcbjwvc2NyaXB0PlxyXG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=script&lang=js&\n");

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=template&id=42c324a0&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=template&id=42c324a0& ***!
  \****************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return render; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return staticRenderFns; });\nvar render = function() {\n  var _vm = this\n  var _h = _vm.$createElement\n  var _c = _vm._self._c || _h\n  return _c(\"div\", { staticClass: \"flex flex-col\" }, [\n    _vm.attachments.length === 0\n      ? _c(\n          \"div\",\n          { staticClass: \"flex flex-col items-center\" },\n          [\n            _c(\"v-empty-view\", {\n              attrs: { message: _vm.$trans(\"messages.no-data-to-show-here\") }\n            })\n          ],\n          1\n        )\n      : _vm._e(),\n    _vm._v(\" \"),\n    _vm.attachments.length > 0\n      ? _c(\n          \"ul\",\n          _vm._l(_vm.attachments, function(attachment) {\n            return _c(\n              \"li\",\n              {\n                staticClass:\n                  \"pl-3 pr-2 py-3 flex items-center justify-between text-sm leading-5 rounded-lg mb-1 hover:bg-gray-100\"\n              },\n              [\n                _c(\"div\", { staticClass: \"w-0 flex-1 flex items-center\" }, [\n                  _c(\n                    \"svg\",\n                    {\n                      staticClass: \"flex-shrink-0 h-5 w-5 text-gray-400\",\n                      attrs: { fill: \"currentColor\", viewBox: \"0 0 20 20\" }\n                    },\n                    [\n                      _c(\"path\", {\n                        attrs: {\n                          \"fill-rule\": \"evenodd\",\n                          d:\n                            \"M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z\",\n                          \"clip-rule\": \"evenodd\"\n                        }\n                      })\n                    ]\n                  ),\n                  _vm._v(\" \"),\n                  _c(\n                    \"a\",\n                    {\n                      staticClass: \"hover:underline\",\n                      attrs: {\n                        href: _vm.route(\"app:project.attachments.download\", {\n                          project: _vm.projectUuid,\n                          attachment: attachment.uuid\n                        })\n                      }\n                    },\n                    [\n                      _c(\"span\", { staticClass: \"ml-2 truncate\" }, [\n                        _vm._v(_vm._s(attachment.filename))\n                      ])\n                    ]\n                  )\n                ]),\n                _vm._v(\" \"),\n                _c(\"div\", { staticClass: \"ml-4 flex-shrink-0\" }, [\n                  _c(\n                    \"a\",\n                    {\n                      staticClass: \"btn btn-flat btn-xs\",\n                      attrs: {\n                        href: _vm.route(\"app:project.attachments.download\", {\n                          project: _vm.projectUuid,\n                          attachment: attachment.uuid\n                        }),\n                        title: _vm.$trans(\"labels.download\")\n                      }\n                    },\n                    [\n                      _c(\n                        \"svg\",\n                        {\n                          staticClass: \"w-3 h-3 fill-current\",\n                          attrs: {\n                            xmlns: \"http://www.w3.org/2000/svg\",\n                            viewBox: \"0 0 20 20\"\n                          }\n                        },\n                        [\n                          _c(\"path\", {\n                            attrs: {\n                              d: \"M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z\"\n                            }\n                          })\n                        ]\n                      )\n                    ]\n                  )\n                ])\n              ]\n            )\n          }),\n          0\n        )\n      : _vm._e()\n  ])\n}\nvar staticRenderFns = []\nrender._withStripped = true\n\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvdmlld3MvYmFjay9hcHAvdGFza3MvdGFiLWF0dGFjaG1lbnRzLnZ1ZT8wMmM3Il0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0Esb0JBQW9CLCtCQUErQjtBQUNuRDtBQUNBO0FBQ0E7QUFDQSxXQUFXLDRDQUE0QztBQUN2RDtBQUNBO0FBQ0Esc0JBQXNCO0FBQ3RCLGFBQWE7QUFDYjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsZUFBZTtBQUNmO0FBQ0EsMkJBQTJCLDhDQUE4QztBQUN6RTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDhCQUE4QjtBQUM5QixxQkFBcUI7QUFDckI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLHVCQUF1QjtBQUN2QjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EseUJBQXlCO0FBQ3pCO0FBQ0EscUJBQXFCO0FBQ3JCO0FBQ0Esa0NBQWtDLCtCQUErQjtBQUNqRTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyQkFBMkIsb0NBQW9DO0FBQy9EO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSx5QkFBeUI7QUFDekI7QUFDQTtBQUNBLHFCQUFxQjtBQUNyQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSx5QkFBeUI7QUFDekI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLDJCQUEyQjtBQUMzQjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFdBQVc7QUFDWDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiIuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9sb2FkZXJzL3RlbXBsYXRlTG9hZGVyLmpzPyEuL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9pbmRleC5qcz8hLi9yZXNvdXJjZXMvanMvdmlld3MvYmFjay9hcHAvdGFza3MvdGFiLWF0dGFjaG1lbnRzLnZ1ZT92dWUmdHlwZT10ZW1wbGF0ZSZpZD00MmMzMjRhMCYuanMiLCJzb3VyY2VzQ29udGVudCI6WyJ2YXIgcmVuZGVyID0gZnVuY3Rpb24oKSB7XG4gIHZhciBfdm0gPSB0aGlzXG4gIHZhciBfaCA9IF92bS4kY3JlYXRlRWxlbWVudFxuICB2YXIgX2MgPSBfdm0uX3NlbGYuX2MgfHwgX2hcbiAgcmV0dXJuIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwiZmxleCBmbGV4LWNvbFwiIH0sIFtcbiAgICBfdm0uYXR0YWNobWVudHMubGVuZ3RoID09PSAwXG4gICAgICA/IF9jKFxuICAgICAgICAgIFwiZGl2XCIsXG4gICAgICAgICAgeyBzdGF0aWNDbGFzczogXCJmbGV4IGZsZXgtY29sIGl0ZW1zLWNlbnRlclwiIH0sXG4gICAgICAgICAgW1xuICAgICAgICAgICAgX2MoXCJ2LWVtcHR5LXZpZXdcIiwge1xuICAgICAgICAgICAgICBhdHRyczogeyBtZXNzYWdlOiBfdm0uJHRyYW5zKFwibWVzc2FnZXMubm8tZGF0YS10by1zaG93LWhlcmVcIikgfVxuICAgICAgICAgICAgfSlcbiAgICAgICAgICBdLFxuICAgICAgICAgIDFcbiAgICAgICAgKVxuICAgICAgOiBfdm0uX2UoKSxcbiAgICBfdm0uX3YoXCIgXCIpLFxuICAgIF92bS5hdHRhY2htZW50cy5sZW5ndGggPiAwXG4gICAgICA/IF9jKFxuICAgICAgICAgIFwidWxcIixcbiAgICAgICAgICBfdm0uX2woX3ZtLmF0dGFjaG1lbnRzLCBmdW5jdGlvbihhdHRhY2htZW50KSB7XG4gICAgICAgICAgICByZXR1cm4gX2MoXG4gICAgICAgICAgICAgIFwibGlcIixcbiAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOlxuICAgICAgICAgICAgICAgICAgXCJwbC0zIHByLTIgcHktMyBmbGV4IGl0ZW1zLWNlbnRlciBqdXN0aWZ5LWJldHdlZW4gdGV4dC1zbSBsZWFkaW5nLTUgcm91bmRlZC1sZyBtYi0xIGhvdmVyOmJnLWdyYXktMTAwXCJcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwidy0wIGZsZXgtMSBmbGV4IGl0ZW1zLWNlbnRlclwiIH0sIFtcbiAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICBcInN2Z1wiLFxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiZmxleC1zaHJpbmstMCBoLTUgdy01IHRleHQtZ3JheS00MDBcIixcbiAgICAgICAgICAgICAgICAgICAgICBhdHRyczogeyBmaWxsOiBcImN1cnJlbnRDb2xvclwiLCB2aWV3Qm94OiBcIjAgMCAyMCAyMFwiIH1cbiAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgIF9jKFwicGF0aFwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICBcImZpbGwtcnVsZVwiOiBcImV2ZW5vZGRcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgZDpcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBcIk04IDRhMyAzIDAgMDAtMyAzdjRhNSA1IDAgMDAxMCAwVjdhMSAxIDAgMTEyIDB2NGE3IDcgMCAxMS0xNCAwVjdhNSA1IDAgMDExMCAwdjRhMyAzIDAgMTEtNiAwVjdhMSAxIDAgMDEyIDB2NGExIDEgMCAxMDIgMFY3YTMgMyAwIDAwLTMtM3pcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICAgXCJjbGlwLXJ1bGVcIjogXCJldmVub2RkXCJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICBdXG4gICAgICAgICAgICAgICAgICApLFxuICAgICAgICAgICAgICAgICAgX3ZtLl92KFwiIFwiKSxcbiAgICAgICAgICAgICAgICAgIF9jKFxuICAgICAgICAgICAgICAgICAgICBcImFcIixcbiAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgIHN0YXRpY0NsYXNzOiBcImhvdmVyOnVuZGVybGluZVwiLFxuICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICBocmVmOiBfdm0ucm91dGUoXCJhcHA6cHJvamVjdC5hdHRhY2htZW50cy5kb3dubG9hZFwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgIHByb2plY3Q6IF92bS5wcm9qZWN0VXVpZCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0YWNobWVudDogYXR0YWNobWVudC51dWlkXG4gICAgICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgIF9jKFwic3BhblwiLCB7IHN0YXRpY0NsYXNzOiBcIm1sLTIgdHJ1bmNhdGVcIiB9LCBbXG4gICAgICAgICAgICAgICAgICAgICAgICBfdm0uX3YoX3ZtLl9zKGF0dGFjaG1lbnQuZmlsZW5hbWUpKVxuICAgICAgICAgICAgICAgICAgICAgIF0pXG4gICAgICAgICAgICAgICAgICAgIF1cbiAgICAgICAgICAgICAgICAgIClcbiAgICAgICAgICAgICAgICBdKSxcbiAgICAgICAgICAgICAgICBfdm0uX3YoXCIgXCIpLFxuICAgICAgICAgICAgICAgIF9jKFwiZGl2XCIsIHsgc3RhdGljQ2xhc3M6IFwibWwtNCBmbGV4LXNocmluay0wXCIgfSwgW1xuICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgIFwiYVwiLFxuICAgICAgICAgICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgICAgICAgc3RhdGljQ2xhc3M6IFwiYnRuIGJ0bi1mbGF0IGJ0bi14c1wiLFxuICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICBocmVmOiBfdm0ucm91dGUoXCJhcHA6cHJvamVjdC5hdHRhY2htZW50cy5kb3dubG9hZFwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgIHByb2plY3Q6IF92bS5wcm9qZWN0VXVpZCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgYXR0YWNobWVudDogYXR0YWNobWVudC51dWlkXG4gICAgICAgICAgICAgICAgICAgICAgICB9KSxcbiAgICAgICAgICAgICAgICAgICAgICAgIHRpdGxlOiBfdm0uJHRyYW5zKFwibGFiZWxzLmRvd25sb2FkXCIpXG4gICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICBbXG4gICAgICAgICAgICAgICAgICAgICAgX2MoXG4gICAgICAgICAgICAgICAgICAgICAgICBcInN2Z1wiLFxuICAgICAgICAgICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICAgICAgICBzdGF0aWNDbGFzczogXCJ3LTMgaC0zIGZpbGwtY3VycmVudFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICBhdHRyczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHhtbG5zOiBcImh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmlld0JveDogXCIwIDAgMjAgMjBcIlxuICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICAgICAgW1xuICAgICAgICAgICAgICAgICAgICAgICAgICBfYyhcInBhdGhcIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGF0dHJzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICBkOiBcIk0xMyA4VjJIN3Y2SDJsOCA4IDgtOGgtNXpNMCAxOGgyMHYySDB2LTJ6XCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICBdXG4gICAgICAgICAgICAgICAgICAgICAgKVxuICAgICAgICAgICAgICAgICAgICBdXG4gICAgICAgICAgICAgICAgICApXG4gICAgICAgICAgICAgICAgXSlcbiAgICAgICAgICAgICAgXVxuICAgICAgICAgICAgKVxuICAgICAgICAgIH0pLFxuICAgICAgICAgIDBcbiAgICAgICAgKVxuICAgICAgOiBfdm0uX2UoKVxuICBdKVxufVxudmFyIHN0YXRpY1JlbmRlckZucyA9IFtdXG5yZW5kZXIuX3dpdGhTdHJpcHBlZCA9IHRydWVcblxuZXhwb3J0IHsgcmVuZGVyLCBzdGF0aWNSZW5kZXJGbnMgfSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=template&id=42c324a0&\n");

/***/ }),

/***/ "./resources/js/views/back/app/tasks/tab-attachments.vue":
/*!***************************************************************!*\
  !*** ./resources/js/views/back/app/tasks/tab-attachments.vue ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _tab_attachments_vue_vue_type_template_id_42c324a0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./tab-attachments.vue?vue&type=template&id=42c324a0& */ \"./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=template&id=42c324a0&\");\n/* harmony import */ var _tab_attachments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./tab-attachments.vue?vue&type=script&lang=js& */ \"./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ \"./node_modules/vue-loader/lib/runtime/componentNormalizer.js\");\n\n\n\n\n\n/* normalize component */\n\nvar component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(\n  _tab_attachments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n  _tab_attachments_vue_vue_type_template_id_42c324a0___WEBPACK_IMPORTED_MODULE_0__[\"render\"],\n  _tab_attachments_vue_vue_type_template_id_42c324a0___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"],\n  false,\n  null,\n  null,\n  null\n  \n)\n\n/* hot reload */\nif (false) { var api; }\ncomponent.options.__file = \"resources/js/views/back/app/tasks/tab-attachments.vue\"\n/* harmony default export */ __webpack_exports__[\"default\"] = (component.exports);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvdmlld3MvYmFjay9hcHAvdGFza3MvdGFiLWF0dGFjaG1lbnRzLnZ1ZT9iMTgzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQThGO0FBQzNCO0FBQ0w7OztBQUc5RDtBQUNzRztBQUN0RyxnQkFBZ0IsMkdBQVU7QUFDMUIsRUFBRSxxRkFBTTtBQUNSLEVBQUUsMEZBQU07QUFDUixFQUFFLG1HQUFlO0FBQ2pCO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0EsSUFBSSxLQUFVLEVBQUUsWUFpQmY7QUFDRDtBQUNlLGdGIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL3ZpZXdzL2JhY2svYXBwL3Rhc2tzL3RhYi1hdHRhY2htZW50cy52dWUuanMiLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgeyByZW5kZXIsIHN0YXRpY1JlbmRlckZucyB9IGZyb20gXCIuL3RhYi1hdHRhY2htZW50cy52dWU/dnVlJnR5cGU9dGVtcGxhdGUmaWQ9NDJjMzI0YTAmXCJcbmltcG9ydCBzY3JpcHQgZnJvbSBcIi4vdGFiLWF0dGFjaG1lbnRzLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIlxuZXhwb3J0ICogZnJvbSBcIi4vdGFiLWF0dGFjaG1lbnRzLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIlxuXG5cbi8qIG5vcm1hbGl6ZSBjb21wb25lbnQgKi9cbmltcG9ydCBub3JtYWxpemVyIGZyb20gXCIhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL3J1bnRpbWUvY29tcG9uZW50Tm9ybWFsaXplci5qc1wiXG52YXIgY29tcG9uZW50ID0gbm9ybWFsaXplcihcbiAgc2NyaXB0LFxuICByZW5kZXIsXG4gIHN0YXRpY1JlbmRlckZucyxcbiAgZmFsc2UsXG4gIG51bGwsXG4gIG51bGwsXG4gIG51bGxcbiAgXG4pXG5cbi8qIGhvdCByZWxvYWQgKi9cbmlmIChtb2R1bGUuaG90KSB7XG4gIHZhciBhcGkgPSByZXF1aXJlKFwiL2hvbWUvY2xpbnQvcHVibGljX2h0bWwvd3d3L21pbmRmbHV4LmNvL2Rhc2hib2FyZC9ub2RlX21vZHVsZXMvdnVlLWhvdC1yZWxvYWQtYXBpL2Rpc3QvaW5kZXguanNcIilcbiAgYXBpLmluc3RhbGwocmVxdWlyZSgndnVlJykpXG4gIGlmIChhcGkuY29tcGF0aWJsZSkge1xuICAgIG1vZHVsZS5ob3QuYWNjZXB0KClcbiAgICBpZiAoIWFwaS5pc1JlY29yZGVkKCc0MmMzMjRhMCcpKSB7XG4gICAgICBhcGkuY3JlYXRlUmVjb3JkKCc0MmMzMjRhMCcsIGNvbXBvbmVudC5vcHRpb25zKVxuICAgIH0gZWxzZSB7XG4gICAgICBhcGkucmVsb2FkKCc0MmMzMjRhMCcsIGNvbXBvbmVudC5vcHRpb25zKVxuICAgIH1cbiAgICBtb2R1bGUuaG90LmFjY2VwdChcIi4vdGFiLWF0dGFjaG1lbnRzLnZ1ZT92dWUmdHlwZT10ZW1wbGF0ZSZpZD00MmMzMjRhMCZcIiwgZnVuY3Rpb24gKCkge1xuICAgICAgYXBpLnJlcmVuZGVyKCc0MmMzMjRhMCcsIHtcbiAgICAgICAgcmVuZGVyOiByZW5kZXIsXG4gICAgICAgIHN0YXRpY1JlbmRlckZuczogc3RhdGljUmVuZGVyRm5zXG4gICAgICB9KVxuICAgIH0pXG4gIH1cbn1cbmNvbXBvbmVudC5vcHRpb25zLl9fZmlsZSA9IFwicmVzb3VyY2VzL2pzL3ZpZXdzL2JhY2svYXBwL3Rhc2tzL3RhYi1hdHRhY2htZW50cy52dWVcIlxuZXhwb3J0IGRlZmF1bHQgY29tcG9uZW50LmV4cG9ydHMiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/views/back/app/tasks/tab-attachments.vue\n");

/***/ }),

/***/ "./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_tab_attachments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./tab-attachments.vue?vue&type=script&lang=js& */ \"./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__[\"default\"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_tab_attachments_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[\"default\"]); //# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvdmlld3MvYmFjay9hcHAvdGFza3MvdGFiLWF0dGFjaG1lbnRzLnZ1ZT84MjU5Il0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQSx3Q0FBaU4sQ0FBZ0IsMlBBQUcsRUFBQyIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy92aWV3cy9iYWNrL2FwcC90YXNrcy90YWItYXR0YWNobWVudHMudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPWpzJi5qcyIsInNvdXJjZXNDb250ZW50IjpbImltcG9ydCBtb2QgZnJvbSBcIi0hLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL2JhYmVsLWxvYWRlci9saWIvaW5kZXguanM/P3JlZi0tNC0wIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9pbmRleC5qcz8/dnVlLWxvYWRlci1vcHRpb25zIS4vdGFiLWF0dGFjaG1lbnRzLnZ1ZT92dWUmdHlwZT1zY3JpcHQmbGFuZz1qcyZcIjsgZXhwb3J0IGRlZmF1bHQgbW9kOyBleHBvcnQgKiBmcm9tIFwiLSEuLi8uLi8uLi8uLi8uLi8uLi9ub2RlX21vZHVsZXMvYmFiZWwtbG9hZGVyL2xpYi9pbmRleC5qcz8/cmVmLS00LTAhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2luZGV4LmpzPz92dWUtbG9hZGVyLW9wdGlvbnMhLi90YWItYXR0YWNobWVudHMudnVlP3Z1ZSZ0eXBlPXNjcmlwdCZsYW5nPWpzJlwiIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=script&lang=js&\n");

/***/ }),

/***/ "./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=template&id=42c324a0&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=template&id=42c324a0& ***!
  \**********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tab_attachments_vue_vue_type_template_id_42c324a0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./tab-attachments.vue?vue&type=template&id=42c324a0& */ \"./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=template&id=42c324a0&\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tab_attachments_vue_vue_type_template_id_42c324a0___WEBPACK_IMPORTED_MODULE_0__[\"render\"]; });\n\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tab_attachments_vue_vue_type_template_id_42c324a0___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"]; });\n\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvdmlld3MvYmFjay9hcHAvdGFza3MvdGFiLWF0dGFjaG1lbnRzLnZ1ZT80OGQ2Il0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQSIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy92aWV3cy9iYWNrL2FwcC90YXNrcy90YWItYXR0YWNobWVudHMudnVlP3Z1ZSZ0eXBlPXRlbXBsYXRlJmlkPTQyYzMyNGEwJi5qcyIsInNvdXJjZXNDb250ZW50IjpbImV4cG9ydCAqIGZyb20gXCItIS4uLy4uLy4uLy4uLy4uLy4uL25vZGVfbW9kdWxlcy92dWUtbG9hZGVyL2xpYi9sb2FkZXJzL3RlbXBsYXRlTG9hZGVyLmpzPz92dWUtbG9hZGVyLW9wdGlvbnMhLi4vLi4vLi4vLi4vLi4vLi4vbm9kZV9tb2R1bGVzL3Z1ZS1sb2FkZXIvbGliL2luZGV4LmpzPz92dWUtbG9hZGVyLW9wdGlvbnMhLi90YWItYXR0YWNobWVudHMudnVlP3Z1ZSZ0eXBlPXRlbXBsYXRlJmlkPTQyYzMyNGEwJlwiIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/views/back/app/tasks/tab-attachments.vue?vue&type=template&id=42c324a0&\n");

/***/ })

}]);