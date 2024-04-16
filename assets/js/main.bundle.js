/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/js/main.js":
/*!***************************!*\
  !*** ./assets/js/main.js ***!
  \***************************/
/***/ (() => {

jQuery(document).ready(function ($) {
  var ajaxUrl = ajax_object.ajax_url;

  // Scroll event
  $(window).scroll(function () {
    // get Header height
    var header_height = $('header.site-header').height() + 'px';
    // Sticky header
    if ($(window).scrollTop() > 10) {
      $('header.site-header').addClass('sticky');
      $('.site-content').css('margin-top', header_height);
    } else {
      $('header.site-header').removeClass('sticky');
      $('.site-content').css('margin-top', '0');
    }

    // Show/hide scroll top button
    if ($(window).scrollTop() > 100) {
      $('#btn-scroll-top').addClass('show');
    } else {
      $('#btn-scroll-top').removeClass('show');
    }
  });

  // Click to hide accessibility options
  $(document).on('click', '#pojo-a11y-toolbar .background-overlay', function (e) {
    e.preventDefault();
    var pojo_toolbar = $('nav#pojo-a11y-toolbar');
    pojo_toolbar.removeClass('pojo-a11y-toolbar-open');
  });

  // Click to hide accessibility tools
  $(document).on('click', '#btn-close-accessibility-toolbar', function (e) {
    e.preventDefault();
    var pojo_toolbar = $('nav#pojo-a11y-toolbar');
    pojo_toolbar.removeClass('pojo-a11y-toolbar-open');
  });

  // Click to show socials share options
  $(document).on('click', '#btn-socials-share', function (e) {
    e.preventDefault();
    var share_content = $(this).closest('.socials-share-wrapper').find('.share-content');
    // Scroll to the top of the document with smooth animation
    share_content.slideToggle(200);
  });

  // Click to hide socials share options
  $(document).on('click', '#btn-close-share', function (e) {
    e.preventDefault();
    var share_content = $(this).closest('.socials-share-wrapper').find('.share-content');
    // Scroll to the top of the document with smooth animation
    share_content.slideUp(200);
  });

  // Click to scroll to top
  $(document).on('click', '#btn-scroll-top', function (e) {
    e.preventDefault();
    // Scroll to the top of the document with smooth animation
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  // Click to open Search popup
  $(document).on('click', '#btn-search', function (e) {
    e.preventDefault();
    var search_wrapper = $('.global-search-wrapper');
    var search_overlay = $('.search-overlay');
    var input_field = search_wrapper.find('form input.search-field-input');
    $(this).toggleClass('active');
    search_wrapper.toggleClass('active');
    search_overlay.toggleClass('active');
    setTimeout(function () {
      input_field.focus();
    }, 200);
  });

  // Click button to close Search popup
  $(document).on('click', '#btn-close-search', function (e) {
    e.preventDefault();
    var btn_search = $('#btn-search');
    var search_wrapper = $('.global-search-wrapper');
    var search_overlay = $('.search-overlay');
    btn_search.removeClass('active');
    search_wrapper.removeClass('active');
    search_overlay.removeClass('active');
  });

  // Focus out to close Search popup
  $(document).on('blur', '#btn-close-search', function (e) {
    e.preventDefault();
    var btn_search = $('#btn-search');
    var search_wrapper = $('.global-search-wrapper');
    var search_overlay = $('.search-overlay');
    btn_search.removeClass('active');
    search_wrapper.removeClass('active');
    search_overlay.removeClass('active');
  });

  // Click overlay to close Search popup
  $(document).on('click', '.global-search-wrapper', function (e) {
    e.preventDefault();
    var btn_search = $('#btn-search');
    $(this).removeClass('active');
    btn_search.removeClass('active');
  });
  $(document).on('click', '.global-search-wrapper form', function (e) {
    e.stopPropagation();
  });

  // Open Nav mobile
  $(document).on('click', '#btn-nav-bar', function (e) {
    e.preventDefault();
    var nav_mobile = $('header nav#site-navigation');
    nav_mobile.toggleClass('active');
  });

  // Open sort options
  $(document).on('click', '#btn-open-sort', function (e) {
    e.preventDefault();
    var wrapper = $(this).closest('.results-sort');
    var sort_options = wrapper.find('.sort-options');
    $(this).toggleClass('active');
    sort_options.slideToggle(200);
  });

  // Close sort options
  $(document).on('click', '#btn-close-sort-opts', function (e) {
    e.preventDefault();
    var wrapper = $(this).closest('.results-sort');
    var sort_options = wrapper.find('.sort-options');
    var btn_open = wrapper.find('#btn-open-sort');
    btn_open.removeClass('active');
    sort_options.slideUp(200);
  });

  // Ajax Load more search results
  $(document).on('click', '#btn-load-more-results', function (e) {
    e.preventDefault();
    var btn = $(this);
    var formSearch = $('form.search-results-form');
    var page = btn.data('next-page');
    var keyWord = formSearch.find('input.search-field-input').val();
    var searchFoundPosts = $('input#search-found-posts').val();
    var searchOrderBy = $('input#search-orderby').val();
    var searchOrder = $('input#search-order').val();
    var countResults = formSearch.find('#number-results-count');
    var searchResults = $('#search-results');
    var spinner = $('#ajax-loading-spinner');
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: {
        'action': 'dv_load_more_search_results',
        'key_word': keyWord,
        'page': page,
        'search_orderby': searchOrderBy,
        'search_order': searchOrder
      },
      beforeSend: function beforeSend(xhr) {
        spinner.show();
      },
      success: function success(response) {
        spinner.hide();
        searchResults.append(response);
        btn.data('next-page', page + 1);
        var resultItem = $('#search-results article.result-item');
        countResults.text(resultItem.length);
        if (resultItem.length == searchFoundPosts) {
          btn.remove();
        }
      }
    });
  });

  //---Start Fix Tab Keyboard---//
  // var is_tab_slide = false;
  // var is_tab_keyboard = false;
  // jQuery(document).on('keydown', function( e ) {
  //     // Get the focused element:
  //     e.preventDefault;
  //     is_tab_keyboard = true;

  //     if(e.shiftKey && e.keyCode == 9) {
  //         //console.log('prev!!!');
  //         var $focused_current = $(':focus');
  //         var $templ   = $focused_current.closest('.owl-carousel');
  //         setTimeout(triggerPrevSlide,100);
  //         //Check prev tab
  //         if($templ.length){
  //           var $total_items = $templ.find('.owl-item').length;
  //           var $item_index = $templ.find('.owl-item.active').index();
  //           $item_index = !$item_index ? 1 : parseInt($item_index) + 1;
  //           //console.log($total_items,$item_index);
  //           if($item_index != 1) return false;
  //         }
  //     }else{
  //       if ( e.keyCode == 9 ) {
  //           //console.log('next!!!');
  //           var $focused_current = $(':focus');
  //           var $templ   = $focused_current.closest('.owl-carousel');
  //           setTimeout(triggerNextSlide,100);
  //           //check next tab
  //           if($templ.length){
  //             var $total_items = $templ.find('.owl-item').length;
  //             var $item_index = $templ.find('.owl-item.active').index();
  //             $item_index = !$item_index ? 1 : parseInt($item_index) + 1;
  //             //console.log($total_items,$item_index);
  //             if($item_index < $total_items) return false;
  //           }
  //       }
  //     }
  // });

  // jQuery('.owl-carousel .secondary-cta').focus(function( e ) {

  //     if(!is_tab_keyboard){
  //         is_tab_slide = true;
  //     }
  //     if(e.keyCode != 9){
  //       is_tab_keyboard = false;
  //     }

  // });

  // function triggerNextSlide(){
  //   var $focused = $(':focus');
  //   var $templ   = $focused.closest('.owl-carousel');
  //   if($templ.length > 0){
  //     if(is_tab_slide)
  //       $templ.find('.owl-next').click();
  //     //Focus button current
  //     setTimeout(function(){ $templ.find('.owl-item.active .primary-cta').focus(); },100);
  //     is_tab_slide = true;
  //   }else{
  //     is_tab_slide = false;
  //   }
  // }

  // function triggerPrevSlide(){
  //   var $focused = $(':focus');
  //   var $templ   = $focused.closest('.owl-carousel');
  //   if($templ.length > 0){
  //     if(is_tab_slide)
  //       $templ.find('.owl-prev').click();
  //     //Focus button current
  //     setTimeout(function(){ $templ.find('.owl-item.active .primary-cta').focus(); },100);
  //     is_tab_slide = true;
  //   }else{
  //     is_tab_slide = false;
  //   }
  // }
  //---End Fix Tab Keyboard---//
});

/***/ }),

/***/ "./assets/scss/main.scss":
/*!*******************************!*\
  !*** ./assets/scss/main.scss ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/scss/custom.scss":
/*!*********************************!*\
  !*** ./assets/scss/custom.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/js/main.bundle": 0,
/******/ 			"assets/css/custom": 0,
/******/ 			"assets/css/main": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkdiabetes_victoria"] = self["webpackChunkdiabetes_victoria"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/css/custom","assets/css/main"], () => (__webpack_require__("./assets/js/main.js")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/custom","assets/css/main"], () => (__webpack_require__("./assets/scss/main.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/custom","assets/css/main"], () => (__webpack_require__("./assets/scss/custom.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;