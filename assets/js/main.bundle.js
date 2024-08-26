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

  // Resize event
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

  // Event listener for resize, scroll, and load events on the window
  $(window).on('resize scroll load', function () {
    // Function to activate elements in the viewport
    function dv_activate_section_in_view(selector) {
      $(selector).each(function () {
        if ($(this).dv_is_element_in_viewport()) {
          $(this).addClass('active');
        }
      });
    }

    // Activate content promo when scrolled into view
    dv_activate_section_in_view("section.content-promo .carousel-wrapper");

    // Activate icon promo carousel when scrolled into view
    dv_activate_section_in_view(".ipro-carousel-section .slick-list");

    // Activate bespoke carousel when scrolled into view
    dv_activate_section_in_view(".bespoke-slider-section .slick-list");

    // Activate media slider when scrolled into view
    dv_activate_section_in_view(".media-slider-section .slick-list");

    // Activate footer banner when scrolled into view
    dv_activate_section_in_view("footer .footer-banner");
    dv_set_css_variable();
  });

  /**
   * Apply all scroll events on Site
   */
  function dv_apply_all_scroll_events() {
    // get Header height
    var header_height = $('header.site-header').height();
    // Sticky header
    if ($(window).scrollTop() > 10) {
      $('header.site-header').addClass('sticky');
      $('.site-content').css('margin-top', header_height + 'px');
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

    // Sticky sidebar
    if ($('#main-content-sidebar').length > 0) {
      // get Header height
      var offset_top = $('header.site-header').outerHeight();
      var admin_bar = $('#wpadminbar');
      if (admin_bar.length > 0) {
        offset_top = offset_top + admin_bar.outerHeight();
      }
      var sibar_scroll_offset = $('#main-content-sidebar').offset().top - $('#content.site-content').offset().top;
      if ($(window).scrollTop() > sibar_scroll_offset) {
        $('#main-content-sidebar').addClass('sticky');
        $('#main-content-sidebar .sidebar-inner').css('top', offset_top + 'px');
      } else {
        $('#main-content-sidebar').removeClass('sticky');
        $('#main-content-sidebar .sidebar-inner').css('top', 'unset');
      }
    }
  }

  /**
   * Check the element in viewport
   */
  $.fn.dv_is_element_in_viewport = function () {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
  };

  /**
   * Change status of aria-expanded attr
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
   */
  function dv_tocs_item_generation() {
    // Select the site content and main content sections
    var site_content = $('#content.site-content');
    var main_content = $('section.main-content');
    // Select the TOC wrapper inside the main content
    var tocs_wrapper = main_content.find('#tocs');
    var counter = 0;

    // Check if TOC is exist
    if (tocs_wrapper.length > 0) {
      // Find all <h2> tags within the site content, excluding those inside #main-content-sidebar
      var all_heading_tags = site_content.find('h2').not('#main-content-sidebar h2');
      var key_cards = site_content.find('.key-cards .card').not('.key-cards.hide_in_TOC .card');
      if (key_cards.length > 0) {
        key_cards.each(function () {
          var card = $(this);
          var landing_page = card.find('h3.landing-page');
          var card_title = card.find('h3.card-title');
          if (landing_page.length > 0 && card_title.length > 0) {
            all_heading_tags = all_heading_tags.add(landing_page);
          } else if (landing_page.length > 0) {
            all_heading_tags = all_heading_tags.add(landing_page);
          } else {
            all_heading_tags = all_heading_tags.add(card_title);
          }
        });
      }
      // Check if there are any <h2> tags
      if (all_heading_tags.length > 0) {
        // Iterate over each <h2> tag
        all_heading_tags.each(function () {
          counter++;
          var heading = $(this);
          // Create a TOC item with a link to the corresponding <h2> tag
          var toc_item = '<li><a href="#heading2-item-' + counter + '">' + heading.text() + '</a></li>';
          // Add an ID to the <h2> tag
          heading.attr('id', 'heading2-item-' + counter);
          // Append the TOC item to the TOC wrapper
          tocs_wrapper.append(toc_item);
        });
      }
    }
  }

  /**
   * Set css variable to HTML tag
   */
  function dv_set_css_variable() {
    var viewport_height = $(window).height();
    var header_height = $('header.site-header').outerHeight();
    var breadcrumb_height = 0;
    var breadcrumb = $('header nav.breadcrumb');
    if (breadcrumb.length > 0) {
      breadcrumb_height = breadcrumb.outerHeight();
    }
    // Set the CSS variable --header-height
    $('html').css('--viewport-height', viewport_height + 'px');
    $('html').css('--header-height', header_height + 'px');
    $('html').css('--breadcrumb-height', breadcrumb_height + 'px');
  }

  /**
   * Set max height to all Icon Promo Carousel items
   */
  function dv_set_height_all_carousel_items() {
    // Find all elements with the class 'ipro-item--content'
    var item_content = $('.ipro-carousel-section .ipro-item--content');
    var wrapper = item_content.closest('.ipro-carousel-section');
    var elements = wrapper.find('.ipro-item--content');

    // Iterate through these elements to find the maximum height
    var maxHeight = 0;
    elements.each(function () {
      var currentHeight = $(this).outerHeight();
      if (currentHeight > maxHeight) {
        maxHeight = currentHeight;
      }
    });
    // Set that maximum height to all elements
    elements.height(maxHeight);
  }
  setTimeout(dv_set_height_all_carousel_items, 500);

  /**
   * Update the param 's' in URL when search 
   */
  function dv_update_search_keyword_param_url(button) {
    var form = button.closest('form');
    var searchInput = form.find('input[type=search]').val(); // Get the search input value
    var currentUrl = new URL(window.location.href); // Get the current URL

    currentUrl.searchParams.set('s', searchInput); // Set or update the 's' parameter

    history.pushState(null, '', currentUrl); // Update the URL without reloading the page

    var breadcrumb_current = $('.breadcrumb li[aria-current=page] span');
    if (breadcrumb_current.length > 0) {
      breadcrumb_current.text('Search result for: ' + searchInput);
    }
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

  // ------------------ Search Popup ------------------
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
  // ------------------ /Search Popup ------------------

  // Open Nav mobile
  $(document).on('click', '#btn-nav-bar', function (e) {
    e.preventDefault();
    var siteBody = $('body');
    var nav_mobile = $('header nav#site-navigation');
    var site_tools = $('#pojo-a11y-toolbar');
    var btnScrollTop = $('#btn-scroll-top');
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      site_tools.show();
    } else {
      $(this).addClass('active');
      site_tools.hide();
    }
    nav_mobile.toggleClass('active');
    siteBody.toggleClass('hidden');
    btnScrollTop.removeClass('show');
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

  // Attach click event to the document
  $(document).on('click', function (e) {
    // Check if the click is outside the .sort-options element
    if (!$(e.target).closest('.results-sort').length) {
      $('#btn-open-sort').removeClass('active');
      $('.results-sort .sort-options').slideUp(200);
    }
  });
  // Prevent the popup from closing when clicking inside it
  $(document).on('click', '.results-sort', function (e) {
    e.stopPropagation();
  });

  // Ajax show search results
  $(document).on('click', '#btn-show-search-results', function (e) {
    e.stopPropagation();
    var btnLoadMore = $('#btn-load-more-results');
    var formSearch = $('form.search-results-form');
    var page = 1;
    var keyWord = formSearch.find('input.search-field-input').val();
    var searchOrderBy = formSearch.find('input[type=radio][name=orderby]:checked').val();
    var searchOrder = formSearch.find('input[type=radio][name=order]:checked').val();
    var countResults = formSearch.find('#number-results-count');
    var numberAllResults = formSearch.find('#number-all-results');
    var searchResults = $('#search-results');

    // Update search keyword to param 's' on URL
    dv_update_search_keyword_param_url($(this));
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: {
        'action': 'dv_query_search_results',
        'key_word': keyWord,
        'page': page,
        'search_orderby': searchOrderBy,
        'search_order': searchOrder
      },
      beforeSend: function beforeSend(xhr) {
        searchResults.addClass('loading');
      },
      success: function success(response) {
        searchResults.removeClass('loading');
        btnLoadMore.show();
        if (response.search_result && response.found_posts > 0) {
          var results_html = '<div class="loading-wrapper"><p class="mess">Loading...</p><div class="dv-spinner"></div></div>';
          results_html += response.search_result;
          searchResults.html(results_html);
          btnLoadMore.data('next-page', 2);
        } else {
          searchResults.html('<h3 style="text-align:center;">No results found.</h3>');
        }
        var resultItem = $('#search-results article.result-item');
        countResults.text(resultItem.length);
        numberAllResults.text(response.found_posts);
        if (resultItem.length >= response.found_posts) {
          btnLoadMore.hide();
        }
      }
    });
  });

  // Ajax show search results
  $(document).on('click', '#btn-apply-sort', function (e) {
    e.preventDefault();
    $('#btn-show-search-results').click();
  });

  // Ajax Load more search results
  $(document).on('click', '#btn-load-more-results', function (e) {
    e.preventDefault();
    var btn = $(this);
    btn.show();
    var formSearch = $('form.search-results-form');
    var page = btn.data('next-page');
    var keyWord = formSearch.find('input.search-field-input').val();
    var searchOrderBy = formSearch.find('input[type=radio][name=orderby]:checked').val();
    var searchOrder = formSearch.find('input[type=radio][name=order]:checked').val();
    var countResults = formSearch.find('#number-results-count');
    var searchResults = $('#search-results');
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: {
        'action': 'dv_query_search_results',
        'key_word': keyWord,
        'page': page,
        'search_orderby': searchOrderBy,
        'search_order': searchOrder
      },
      beforeSend: function beforeSend(xhr) {
        btn.addClass('loading');
      },
      success: function success(response) {
        searchResults.append(response.search_result);
        btn.data('next-page', page + 1);
        btn.removeClass('loading');
        var resultItem = $('#search-results article.result-item');
        countResults.text(resultItem.length);
        if (resultItem.length >= response.found_posts) {
          btn.hide();
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
    var postCats = sectionWrapper.find('input[name=categories]').val();
    var postTags = sectionWrapper.find('input[name=tags]').val();
    var maxPosts = sectionWrapper.find('input[name=max_posts]').val();
    var hasPostMeta = sectionWrapper.find('input[name=has_post_meta]').val();
    var postList = sectionWrapper.find('ul.posts-list');

    // Parse categories and tags, ensuring they are always arrays
    postCats = JSON.parse(postCats || '[]');
    if (!Array.isArray(postCats)) {
      postCats = [];
    }
    postTags = JSON.parse(postTags || '[]');
    if (!Array.isArray(postTags)) {
      postTags = [];
    }
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: {
        'action': 'dv_load_more_latest_posts',
        'paged': paged,
        'post_type': postType,
        'number_posts': numberPosts,
        'order_by': orderBy,
        'categories': postCats,
        'tags': postTags,
        'has_post_meta': hasPostMeta
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

  // ------------------ Donate Popup ------------------
  // Show donate popup
  $(document).on('click', '#btn-donate', function (e) {
    e.preventDefault();
    var this_btn = $(this);
    window.location.href = this_btn.attr('href');
    return;
    this_btn.addClass('active');
    var adminBar = $('#wpadminbar');
    var wrapper_margin = this_btn.outerHeight();
    if (adminBar.length > 0) {
      wrapper_margin = wrapper_margin + adminBar.outerHeight();
    }
    var donate_popup = $('#donate-popup');
    var donate_wrapper = donate_popup.find('.donate-wrapper');
    var input_field = donate_popup.find('input#other-amount');
    donate_popup.toggleClass('show');
    donate_wrapper.css('margin-top', wrapper_margin + 'px');
    donate_wrapper.slideDown(200);
    dv_aria_expanded_status(this_btn);
    setTimeout(function () {
      input_field.focus();
    }, 200);
  });
  // Click & Focus-out to Close Donate popup
  $(document).on('click blur', '#btn-close-donate', function (e) {
    e.preventDefault();
    dv_close_donate_popup();
  });
  // Click outside to close Donate popup
  $(document).on('click', '#donate-popup', function (e) {
    e.preventDefault();
    dv_close_donate_popup();
  });
  // Stop propagation for Donate wrapper
  $(document).on('click', '#donate-popup .donate-wrapper', function (e) {
    e.stopPropagation();
  });
  // Checked or un-checked amount radio button
  $(document).on('click', '#donate-popup input[type=radio][name=amount]', function (e) {
    var btn_radio = $(this);
    if (btn_radio.data('checked')) {
      btn_radio.prop('checked', false);
      btn_radio.data('checked', false);
    } else {
      $('#donate-popup input[type=radio][name=amount]').data('checked', false); // Uncheck all
      btn_radio.data('checked', true); // Check the clicked one
    }
  });
  // Disable options amount or custom amount
  $(document).on('click', '#donate-popup #btn-continue-donate', function (e) {
    var custom_amount = $('#donate-popup input#other-amount');
    if (custom_amount.val() === '') {
      // Disable custom amount
      custom_amount.prop('disabled', true);
    } else {
      // Disable all amount radio button
      $('#donate-popup input[type=radio][name=amount]').prop('disabled', true);
    }
  });
  /**
   * Close the Donate Popup
   */
  function dv_close_donate_popup() {
    var donate_popup = $('#donate-popup');
    var donate_wrapper = donate_popup.find('.donate-wrapper');
    donate_popup.addClass('closing');
    donate_wrapper.slideUp(200);
    setTimeout(function () {
      donate_popup.removeClass('show');
      $('#btn-donate').attr('aria-expanded', 'false');
      donate_popup.removeClass('closing');
    }, 200);
  }
  // ------------------ /Donate Popup ------------------

  // ------------------ Members Login Popup ------------------
  // Click to show Members Login Area
  $(document).on('click', '#btn-member-login', function (e) {
    e.preventDefault();
    var this_btn = $(this);
    if (this_btn.hasClass('is_logged_in')) {
      window.location.href = this_btn.attr('href');
      return;
    }
    var adminBar = $('#wpadminbar');
    var wrapper_margin = this_btn.outerHeight();
    if (adminBar.length > 0) {
      wrapper_margin = wrapper_margin + adminBar.outerHeight();
    }
    var login_popup = $('#members-login-area');
    var login_wrapper = login_popup.find('.login-wrapper');
    var input_field = login_popup.find('input#user_login');
    login_popup.addClass('show');
    login_wrapper.css('margin-top', wrapper_margin + 'px');
    login_wrapper.slideDown(300);
    dv_aria_expanded_status(this_btn);
    setTimeout(function () {
      input_field.focus();
    }, 200);
  });
  // Click & Focus-out to Close Members Login Area
  $(document).on('click blur', '#btn-close-login-popup', function (e) {
    e.preventDefault();
    dv_close_members_login_popup();
  });
  // Click outside to close Members Login Area
  $(document).on('click', '#members-login-area', function (e) {
    e.preventDefault();
    dv_close_members_login_popup();
  });
  // Stop propagation login wrapper
  $(document).on('click', '#members-login-area .login-wrapper', function (e) {
    e.stopPropagation();
  });
  /**
   * Close Members Login Area Popup
   */
  function dv_close_members_login_popup() {
    var login_popup = $('#members-login-area');
    var login_wrapper = login_popup.find('.login-wrapper');
    login_popup.addClass('closing');
    login_wrapper.slideUp(200);
    setTimeout(function () {
      login_popup.removeClass('show');
      $('#btn-member-login').attr('aria-expanded', 'false');
      login_popup.removeClass('closing');
    }, 200);
  }
  // Handle WP Members Login Ajax
  $(document).on('click', 'form#member_login_form button[type=submit]', function (e) {
    var form = $(this).closest('form#member_login_form');
    var userLogin = form.find('#user_login').val();
    var userPass = form.find('#user_pass').val();
    var security = form.find('#security').val();
    var spinner = form.find('.dv-spinner');
    var message = $('#login-message');
    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      data: {
        'action': 'dv_member_login_ajax',
        'log': userLogin,
        'pwd': userPass,
        'security': security
      },
      beforeSend: function beforeSend(xhr) {
        message.removeClass();
        spinner.show();
      },
      success: function success(response) {
        spinner.hide();
        message.css('opacity', '0').css('opacity', '1').addClass(response.status).html(response.message);
        if (response.status == 'success') {
          window.location.href = '/';
        }
      }
    });
  });
  // Members Confirm Logout
  $(document).on('click', '.members-logout-link', function (event) {
    if (!confirm('Are you sure you want to log out?')) {
      event.preventDefault();
    }
  });
  // ------------------ /Members Login Popup ------------------

  // ------------------ Contact Phones Popup ------------------
  // Click to show Contact Phones Area
  $(document).on('click', '#btn-phone', function (e) {
    e.preventDefault();
    var this_btn = $(this);
    var adminBar = $('#wpadminbar');
    var wrapper_margin = this_btn.outerHeight();
    if (adminBar.length > 0) {
      wrapper_margin = wrapper_margin + adminBar.outerHeight();
    }
    var contacts_popup = $('#contact-phones-area');
    var contacts_wrapper = contacts_popup.find('.contact-phones-wrapper');
    var first_contact = contacts_wrapper.find('.contacts-list a').first();
    contacts_popup.addClass('show');
    contacts_wrapper.css('margin-top', wrapper_margin + 'px');
    contacts_wrapper.slideDown(300);
    dv_aria_expanded_status(this_btn);
    setTimeout(function () {
      first_contact.focus();
    }, 200);
  });
  // Click & Focus-out to Close  Contact Phones Area
  $(document).on('click blur', '#btn-close-contacts-popup', function (e) {
    e.preventDefault();
    dv_close_contact_phones_popup();
  });
  // Click outside to close Contact Phones Area
  $(document).on('click', '#contact-phones-area', function (e) {
    e.preventDefault();
    dv_close_contact_phones_popup();
  });
  // Stop propagation login wrapper
  $(document).on('click', '#contact-phones-area .contact-phones-wrapper', function (e) {
    e.stopPropagation();
  });
  /**
   * Close Contact Phones Area Popup
   */
  function dv_close_contact_phones_popup() {
    var contacts_popup = $('#contact-phones-area');
    var contacts_wrapper = contacts_popup.find('.contact-phones-wrapper');
    contacts_popup.addClass('closing');
    contacts_wrapper.slideUp(200);
    setTimeout(function () {
      contacts_popup.removeClass('show');
      $('#btn-phone').attr('aria-expanded', 'false');
      contacts_popup.removeClass('closing');
    }, 200);
  }
  // ------------------ /Contact Phones Popup ------------------

  // Smooth scrolling to anchor links
  $(document).on('click', 'a[href^="#"]', function (e) {
    var target = $(this.getAttribute('href'));
    if (target.length) {
      e.preventDefault();
      var offset = $('header#masthead').outerHeight() + 24;
      var admin_bar = $('#wpadminbar');
      if (admin_bar.length > 0) {
        offset = offset + admin_bar.outerHeight();
      }
      $('html, body').stop().animate({
        scrollTop: target.offset().top - offset
      }, 300);
    }
  });

  // Select all <table> elements and wrap them with a <div>
  $('.main-content .content-wrapper table, .accordion__content-inner table, .dv-editor-content table').each(function () {
    if (!$(this).parent().hasClass('table-wrapper')) {
      $(this).wrap('<div class="table-wrapper" role="region" tabindex="0"></div>');
    }
  });

  // Toggle Categories list at Sidebar
  $(document).on('click', '.sidebar #btn-toggle-categories', function (e) {
    e.preventDefault();
    var sidebar = $(this).closest('.sidebar');
    var catsList = sidebar.find('ul.categories-list');
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      catsList.slideUp(200);
    } else {
      $(this).addClass('active');
      catsList.slideDown(200);
    }
  });

  // Toggle Sub menu of the menu item
  $(document).on('click', 'nav#site-navigation ul li.menu-item-has-children', function (e) {
    e.preventDefault();
    $(this).toggleClass('active');
  });
  $(document).on('click', 'nav#site-navigation ul li a', function (e) {
    e.stopPropagation();
  });
  $(document).on('click', 'nav#site-navigation ul li .sub-menu', function (e) {
    e.stopPropagation();
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