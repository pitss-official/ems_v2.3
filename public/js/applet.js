/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/dependent/applet.js":
/*!******************************************!*\
  !*** ./resources/js/dependent/applet.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  "use strict";

  $(function () {
    $(".preloader").fadeOut();
  });
  jQuery(document).on('click', '.mega-dropdown', function (e) {
    e.stopPropagation();
  }); // ==============================================================
  // This is for the top header part and sidebar part
  // ==============================================================

  var set = function set() {
    var width = window.innerWidth > 0 ? window.innerWidth : this.screen.width;
    var topOffset = 70;

    if (width < 1170) {
      $("body").addClass("mini-sidebar");
      $('.navbar-brand span').hide();
      $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
      $(".sidebartoggler i").addClass("ti-menu");
    } else {
      $("body").removeClass("mini-sidebar");
      $('.navbar-brand span').show(); //$(".sidebartoggler i").removeClass("ti-menu");
    }

    var height = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 1;
    height = height - topOffset;
    if (height < 1) height = 1;

    if (height > topOffset) {
      $(".page-wrapper").css("min-height", height + "px");
    }
  };

  $(window).ready(set);
  $(window).on("resize", set); // ==============================================================
  // Theme options
  // ==============================================================

  $(".sidebartoggler").on('click', function () {
    if ($("body").hasClass("mini-sidebar")) {
      $("body").trigger("resize");
      $(".scroll-sidebar, .slimScrollDiv").css("overflow", "hidden").parent().css("overflow", "visible");
      $("body").removeClass("mini-sidebar");
      $('.navbar-brand span').show(); //$(".sidebartoggler i").addClass("ti-menu");
    } else {
      $("body").trigger("resize");
      $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
      $("body").addClass("mini-sidebar");
      $('.navbar-brand span').hide(); //$(".sidebartoggler i").removeClass("ti-menu");
    }
  }); // topbar stickey on scroll

  $(".fix-header .topbar").stick_in_parent({}); // this is for close icon when navigation open in mobile view

  $(".nav-toggler").click(function () {
    $("body").toggleClass("show-sidebar");
    $(".nav-toggler i").toggleClass("ti-menu");
    $(".nav-toggler i").addClass("ti-close");
  });
  $(".sidebartoggler").on('click', function () {//$(".sidebartoggler i").toggleClass("ti-menu");
  });
  $(".search-box a, .search-box .app-search .srh-btn").on('click', function () {
    $(".app-search").toggle(200);
  }); // ==============================================================
  // Right sidebar options
  // ==============================================================

  $(".right-side-toggle").click(function () {
    $(".right-sidebar").slideDown(50);
    $(".right-sidebar").toggleClass("shw-rside");
  });
  $('.floating-labels .form-control').on('focus blur', function (e) {
    $(this).parents('.form-group').toggleClass('focused', e.type === 'focus' || this.value.length > 0);
  }).trigger('blur'); // ==============================================================
  // Auto select left navbar
  // ==============================================================

  $(function () {
    var url = window.location;
    var element = $('ul#sidebarnav a').filter(function () {
      return this.href == url;
    }).addClass('active').parent().addClass('active');

    while (true) {
      if (element.is('li')) {
        element = element.parent().addClass('in').parent().addClass('active');
      } else {
        break;
      }
    }
  }); // ==============================================================
  //tooltip
  // ==============================================================

  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  }); // ==============================================================
  //Popover
  // ==============================================================

  $(function () {
    $('[data-toggle="popover"]').popover();
  }); // ==============================================================
  // Sidebarmenu
  // ==============================================================

  $(function () {
    $('#sidebarnav').metisMenu();
  }); // ==============================================================
  // Slimscrollbars
  // ==============================================================

  $('.scroll-sidebar').slimScroll({
    position: 'left',
    size: "5px",
    height: '100%',
    color: '#dcdcdc'
  });
  $('.message-center').slimScroll({
    position: 'right',
    size: "5px",
    color: '#dcdcdc'
  });
  $('.aboutscroll').slimScroll({
    position: 'right',
    size: "5px",
    height: '80',
    color: '#dcdcdc'
  });
  $('.message-scroll').slimScroll({
    position: 'right',
    size: "5px",
    height: '570',
    color: '#dcdcdc'
  });
  $('.chat-box').slimScroll({
    position: 'right',
    size: "5px",
    height: '470',
    color: '#dcdcdc'
  });
  $('.slimscrollright').slimScroll({
    height: '100%',
    position: 'right',
    size: "5px",
    color: '#dcdcdc'
  }); // ==============================================================
  // Resize all elements
  // ==============================================================

  $("body").trigger("resize"); // ==============================================================
  // To do list
  // ==============================================================

  $(".list-task li label").click(function () {
    $(this).toggleClass("task-done");
  }); // ==============================================================
  // Login and Recover Password
  // ==============================================================

  $('#to-recover').on("click", function () {
    $("#loginform").slideUp();
    $("#recoverform").fadeIn();
  }); // ==============================================================
  // Collapsable cards
  // ==============================================================

  $('a[data-action="collapse"]').on('click', function (e) {
    e.preventDefault();
    $(this).closest('.card').find('[data-action="collapse"] i').toggleClass('ti-minus ti-plus');
    $(this).closest('.card').children('.card-body').collapse('toggle');
  }); // Toggle fullscreen

  $('a[data-action="expand"]').on('click', function (e) {
    e.preventDefault();
    $(this).closest('.card').find('[data-action="expand"] i').toggleClass('mdi-arrow-expand mdi-arrow-compress');
    $(this).closest('.card').toggleClass('card-fullscreen');
  }); // Close Card

  $('a[data-action="close"]').on('click', function () {
    $(this).closest('.card').removeClass().slideUp('fast');
  }); // ==============================================================
  // This is for the sparkline charts which is coming in the bradcrumb section
  // ==============================================================

  $('#monthchart').sparkline([5, 6, 2, 9, 4, 7, 10, 12], {
    type: 'bar',
    height: '35',
    barWidth: '4',
    resize: true,
    barSpacing: '4',
    barColor: '#1e88e5'
  });
  $('#lastmonthchart').sparkline([5, 6, 2, 9, 4, 7, 10, 12], {
    type: 'bar',
    height: '35',
    barWidth: '4',
    resize: true,
    barSpacing: '4',
    barColor: '#7460ee'
  });
  var sparkResize;
});

/***/ }),

/***/ 6:
/*!************************************************!*\
  !*** multi ./resources/js/dependent/applet.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\EMS_V2.1\EMS\resources\js\dependent\applet.js */"./resources/js/dependent/applet.js");


/***/ })

/******/ });