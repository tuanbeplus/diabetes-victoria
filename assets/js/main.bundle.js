/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/js/main.js":
/*!***************************!*\
  !*** ./assets/js/main.js ***!
  \***************************/
/***/ (() => {

jQuery(document).ready(function ($) {
  var ajaxUrl = ajax_object.ajax_url;

  // Call render TOCs
  dv_tocs_item_generation();

  // Call the function on page load
  dv_set_css_variable();

  // resize event
  $(window).on('resize', function () {
    dv_set_css_variable();
  });

  // Scroll event
  $(window).on('scroll', function () {
    // Call the scroll events function
    dv_apply_all_scroll_events();
  });

  // Load event
  $(window).on('load', function () {
    // Call the scroll events function
    dv_apply_all_scroll_events();
  });

  /**
   * Apply all scroll events on Site
   * 
   */
  function dv_apply_all_scroll_events() {
    // get Header height
    var header_height = $('header.site-header').height();
    // Sticky header
    // if ($(window).scrollTop() > 10) {
    //     $('header.site-header').addClass('sticky')
    //     $('.site-content').css('margin-top', header_height+'px')
    // }
    // else {
    //     $('header.site-header').removeClass('sticky')
    //     $('.site-content').css('margin-top', '0')
    // }

    // Show/hide scroll top button
    if ($(window).scrollTop() > 100) {
      $('#btn-scroll-top').addClass('show');
    } else {
      $('#btn-scroll-top').removeClass('show');
    }

    // Sticky sidebar
    if ($('#main-content-sidebar').length > 0) {
      var sibar_scroll_offset = $('#main-content-sidebar').offset().top - $('#content.site-content').offset().top;
      if ($(window).scrollTop() > sibar_scroll_offset) {
        $('#main-content-sidebar').addClass('sticky');
      } else {
        $('#main-content-sidebar').removeClass('sticky');
      }
    }
  }

  /**
   * Change status of aria-expanded attr
   * 
   */
  function dv_aria_expanded_status(element) {
    if (element.attr('aria-expanded') == 'false') {
      element.attr('aria-expanded', 'true');
    } else {
      element.attr('aria-expanded', 'false');
    }
  }

  /**
   * Sidebar: Table of contents item generation
   * 
   */
  function dv_tocs_item_generation() {
    var site_content = $('#content.site-content');
    var main_content = $('section.main-content');
    var tocs_wrapper = main_content.find('#tocs');
    var counter = 0;
    if (main_content.length > 0) {
      all_h2_tags = site_content.find('h2');
      if (all_h2_tags.length > 0) {
        all_h2_tags.each(function (e) {
          counter++;
          var h2_tag = $(this);
          var toc_item = '<li><a href="#heading2-item-' + counter + '">' + h2_tag.text() + '</a></li>';
          h2_tag.attr('id', 'heading2-item-' + counter); // Add ID to h2
          tocs_wrapper.append(toc_item); // Add link to TOCs
        });
      } else {
        main_content.find('.on-this-page').remove();
      }
    }
  }

  /**
   * Set css variable to HTML tag
   * 
   */
  function dv_set_css_variable() {
    var header_height = $('header.site-header').height();
    if ($('body').hasClass('admin-bar')) {
      header_height = header_height + 32;
    }
    // Set the CSS variable --header-height
    $('html').css('--header-height', header_height + 'px');
  }

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
    dv_aria_expanded_status($(this));
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
    btn_search.attr('aria-expanded', 'false');
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
    btn_search.attr('aria-expanded', 'false');
  });

  // Click overlay to close Search popup
  $(document).on('click', '.global-search-wrapper', function (e) {
    e.preventDefault();
    var btn_search = $('#btn-search');
    $(this).removeClass('active');
    btn_search.removeClass('active');
    btn_search.attr('aria-expanded', 'false');
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
        btn.addClass('loading');
      },
      success: function success(response) {
        searchResults.append(response);
        btn.data('next-page', page + 1);
        btn.removeClass('loading');
        var resultItem = $('#search-results article.result-item');
        countResults.text(resultItem.length);
        if (resultItem.length >= searchFoundPosts) {
          btn.remove();
        }
      }
    });
  });

  // Ajax Load more search results
  $(document).on('click', '.latest-posts .load-more-cta', function (e) {
    e.preventDefault();
    var btn = $(this);
    var sectionWrapper = btn.closest('.latest-posts');
    var paged = btn.data('next-page');
    var postType = sectionWrapper.find('input[name=post_type]').val();
    var numberPosts = sectionWrapper.find('input[name=number_posts]').val();
    var orderBy = sectionWrapper.find('input[name=order_by]').val();
    var maxPosts = sectionWrapper.find('input[name=max_posts]').val();
    var postList = sectionWrapper.find('ul.posts-list');
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: {
        'action': 'dv_load_more_latest_posts',
        'paged': paged,
        'post_type': postType,
        'number_posts': numberPosts,
        'order_by': orderBy
      },
      beforeSend: function beforeSend(xhr) {
        btn.addClass('loading');
      },
      success: function success(response) {
        postList.append(response);
        btn.data('next-page', paged + 1);
        btn.removeClass('loading');
        var currentPost = postList.find('.post').length;
        if (currentPost >= maxPosts) {
          btn.remove();
        }
      }
    });
  });

  // Show donate popup
  $(document).on('click', '#btn-donate', function (e) {
    e.preventDefault();
    var this_btn = $(this);
    this_btn.addClass('active');
    var wrapper_margin = this_btn.offset().top + this_btn.outerHeight();
    var donate_popup = $('#donate-popup');
    var donate_wrapper = donate_popup.find('.donate-wrapper');
    var input_field = donate_popup.find('input#other-amount');
    donate_popup.toggleClass('show');
    donate_wrapper.css('margin-top', wrapper_margin + 'px');
    donate_wrapper.slideToggle(200);
    dv_aria_expanded_status(this_btn);
    setTimeout(function () {
      input_field.focus();
    }, 200);
  });

  // Close donate popup
  $(document).on('click', '#btn-close-donate', function (e) {
    e.preventDefault();
    $(this).addClass('active');
    var donate_popup = $('#donate-popup');
    var donate_wrapper = donate_popup.find('.donate-wrapper');
    donate_popup.removeClass('show');
    donate_wrapper.slideUp(200);
    $('#btn-donate').attr('aria-expanded', 'false');
  });
  // Close donate popup
  $(document).on('blur', '#btn-close-donate', function (e) {
    e.preventDefault();
    $(this).addClass('active');
    var donate_popup = $('#donate-popup');
    var donate_wrapper = donate_popup.find('.donate-wrapper');
    donate_popup.removeClass('show');
    donate_wrapper.slideUp(200);
    $('#btn-donate').attr('aria-expanded', 'false');
  });

  // Show donate popup
  $(document).on('click', '#donate-popup .donate-wrapper', function (e) {
    e.stopPropagation();
  });

  // Close donate popup
  $(document).on('click', '#donate-popup', function (e) {
    e.preventDefault();
    $(this).removeClass('show');
    $(this).find('.donate-wrapper').slideUp(200);
    $('#btn-donate').attr('aria-expanded', 'false');
  });

  // Smooth scrolling to anchor links
  $(document).on('click', 'a[href^="#"]', function (e) {
    var target = $(this.getAttribute('href'));
    if (target.length) {
      e.preventDefault();
      var offset = $('header#masthead').outerHeight() + 40;
      $('html, body').stop().animate({
        scrollTop: target.offset().top - offset
      }, 300);
    }
  });

  // Select all <table> elements and wrap them with a <div>
  $('.main-content .content-wrapper table').each(function () {
    $(this).wrap('<div class="table-wrapper" role="region" tabindex="0"></div>');
  });
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
/******/ 	__webpack_require__.O(undefined, ["assets/css/main"], () => (__webpack_require__("./assets/js/main.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/main"], () => (__webpack_require__("./assets/scss/main.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;