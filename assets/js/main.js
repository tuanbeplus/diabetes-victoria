jQuery(document).ready(function ($) {

    const ajaxUrl = ajax_object.ajax_url;

    // Call render TOCs
    dv_tocs_item_generation();

    // Call the function on page load
    dv_set_css_variable();

    // Resize event
    $(window).on('resize', function() {
        dv_set_css_variable();
    });

    // Scroll event
    $(window).on('scroll', function() {  
        // Call the scroll events function
        dv_apply_all_scroll_events();
    })

    // Load event
    $(window).on('load', function() {
        // Call the scroll events function
        dv_apply_all_scroll_events();
    });

    // Event listener for resize, scroll, and load events on the window
    $(window).on('resize scroll load', function() {
        // Function to activate elements in the viewport
        function dv_activate_section_in_view(selector) {
            $(selector).each(function() {
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
    });

    /**
     * Apply all scroll events on Site
     */
    function dv_apply_all_scroll_events() {
        // get Header height
        var header_height = $('header.site-header').height();
        // Sticky header
        if ($(window).scrollTop() > 10) {
            $('header.site-header').addClass('sticky')
            $('.site-content').css('margin-top', header_height+'px')
        }
        else {
            $('header.site-header').removeClass('sticky')
            $('.site-content').css('margin-top', '0')
        }

        // Show/hide scroll top button
        if ($(window).scrollTop() > 100) {
            $('#btn-scroll-top').addClass('show')
        }
        else {
            $('#btn-scroll-top').removeClass('show')
        }

        // Sticky sidebar
        if ($('#main-content-sidebar').length > 0) {
            var sibar_scroll_offset = $('#main-content-sidebar').offset().top - $('#content.site-content').offset().top;
            if ($(window).scrollTop() > sibar_scroll_offset) {
                $('#main-content-sidebar').addClass('sticky')
            }
            else {
                $('#main-content-sidebar').removeClass('sticky')
            }
        }
    }

    /**
     * Check the element in viewport
     */
    $.fn.dv_is_element_in_viewport = function() {
        let elementTop = $(this).offset().top;
        let elementBottom = elementTop + $(this).outerHeight();
    
        let viewportTop = $(window).scrollTop();
        let viewportBottom = viewportTop + $(window).height();
    
        return elementBottom > viewportTop && elementTop < viewportBottom;
    };

    /**
     * Change status of aria-expanded attr
     */
    function dv_aria_expanded_status(element) {
        if (element.attr('aria-expanded') == 'false') {
            element.attr('aria-expanded', 'true')
        }
        else {
            element.attr('aria-expanded', 'false')
        }
    }

    /**
     * Sidebar: Table of contents item generation
     */
    function dv_tocs_item_generation() {
        // Select the site content and main content sections
        let site_content = $('#content.site-content');
        let main_content = $('section.main-content');
        // Select the TOC wrapper inside the main content
        let tocs_wrapper = main_content.find('#tocs');
        let counter = 0;

        // Check if main content exists
        if (main_content.length > 0) {
            // Find all <h2> tags within the site content, excluding those inside #main-content-sidebar
            let all_h2_tags = site_content.find('h2').not('#main-content-sidebar h2');
            // Check if there are any <h2> tags
            if (all_h2_tags.length > 0) {
                // Iterate over each <h2> tag
                all_h2_tags.each(function() {
                    counter++;
                    let h2_tag = $(this);
                    // Create a TOC item with a link to the corresponding <h2> tag
                    let toc_item = '<li><a href="#heading2-item-' + counter + '">' + h2_tag.text() + '</a></li>';
                    // Add an ID to the <h2> tag
                    h2_tag.attr('id', 'heading2-item-' + counter);
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
        let header_height = $('header.site-header').height();
        if ($('body').hasClass('admin-bar')) {
            header_height = header_height + 32;
        }
        // Set the CSS variable --header-height
        $('html').css('--header-height', header_height + 'px');
    }

    /**
     * Set max height to all Icon Promo Carousel items
     */
    function dv_set_height_all_carousel_items() {
        // Find all elements with the class 'ipro-item--content'
        let item_content = $('.ipro-carousel-section .ipro-item--content');
        let wrapper = item_content.closest('.ipro-carousel-section');
        let elements = wrapper.find('.ipro-item--content');
        
        // Iterate through these elements to find the maximum height
        var maxHeight = 0;
        elements.each(function() {
            var currentHeight = $(this).outerHeight();
            if (currentHeight > maxHeight) {
                maxHeight = currentHeight;
            }
        });
        // Set that maximum height to all elements
        elements.height(maxHeight);
    }
    setTimeout(dv_set_height_all_carousel_items, 500);

    // Click to hide accessibility options
    $(document).on('click', '#pojo-a11y-toolbar .background-overlay', function(e){
        e.preventDefault()
        let pojo_toolbar = $('nav#pojo-a11y-toolbar');

        pojo_toolbar.removeClass('pojo-a11y-toolbar-open');
    });
    
    // Click to hide accessibility tools
    $(document).on('click', '#btn-close-accessibility-toolbar', function(e){
        e.preventDefault()
        let pojo_toolbar = $('nav#pojo-a11y-toolbar');

        pojo_toolbar.removeClass('pojo-a11y-toolbar-open');
    });

    // Click to show socials share options
    $(document).on('click', '#btn-socials-share', function(e){
        e.preventDefault()
        let share_content = $(this).closest('.socials-share-wrapper').find('.share-content')
        // Scroll to the top of the document with smooth animation
        share_content.slideToggle(200);
    });

    // Click to hide socials share options
    $(document).on('click', '#btn-close-share', function(e){
        e.preventDefault()
        let share_content = $(this).closest('.socials-share-wrapper').find('.share-content')
        // Scroll to the top of the document with smooth animation
        share_content.slideUp(200);
    });

    // Click to scroll to top
    $(document).on('click', '#btn-scroll-top', function(e){
        e.preventDefault()
        // Scroll to the top of the document with smooth animation
        window.scrollTo({top: 0, behavior: 'smooth'});
    });

    // Click to open Search popup
    $(document).on('click', '#btn-search', function(e){
        e.preventDefault()
        let search_wrapper = $('.global-search-wrapper')
        let search_overlay = $('.search-overlay')
        let input_field = search_wrapper.find('form input.search-field-input')

        $(this).toggleClass('active')
        search_wrapper.toggleClass('active')
        search_overlay.toggleClass('active')
        dv_aria_expanded_status($(this));
        
        setTimeout(function() {
            input_field.focus();
        }, 200);
    });

    // Click button to close Search popup
    $(document).on('click', '#btn-close-search', function(e){
        e.preventDefault()
        let btn_search = $('#btn-search')
        let search_wrapper = $('.global-search-wrapper')
        let search_overlay = $('.search-overlay')

        btn_search.removeClass('active')
        search_wrapper.removeClass('active')
        search_overlay.removeClass('active')
        btn_search.attr('aria-expanded', 'false');
    });

    // Focus out to close Search popup
    $(document).on('blur', '#btn-close-search', function(e){
        e.preventDefault()
        let btn_search = $('#btn-search')
        let search_wrapper = $('.global-search-wrapper')
        let search_overlay = $('.search-overlay')

        btn_search.removeClass('active')
        search_wrapper.removeClass('active')
        search_overlay.removeClass('active')
        btn_search.attr('aria-expanded', 'false');
    });

    // Click overlay to close Search popup
    $(document).on('click', '.global-search-wrapper', function(e){
        e.preventDefault();
        let btn_search = $('#btn-search')

        $(this).removeClass('active')
        btn_search.removeClass('active')
        btn_search.attr('aria-expanded', 'false');
    });
    $(document).on('click', '.global-search-wrapper form', function(e){
        e.stopPropagation();
    });

    // Open Nav mobile
    $(document).on('click', '#btn-nav-bar', function(e){
        e.preventDefault()
        let nav_mobile = $('header nav#site-navigation')
        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
        }
        else {
            $(this).addClass('active')
        }
        nav_mobile.toggleClass('active')
    });

    // Open sort options
    $(document).on('click', '#btn-open-sort', function(e){
        e.preventDefault()
        let wrapper = $(this).closest('.results-sort')
        let sort_options = wrapper.find('.sort-options')

        $(this).toggleClass('active')
        sort_options.slideToggle(200);
    });

    // Close sort options
    $(document).on('click', '#btn-close-sort-opts', function(e){
        e.preventDefault()
        let wrapper = $(this).closest('.results-sort')
        let sort_options = wrapper.find('.sort-options')
        let btn_open = wrapper.find('#btn-open-sort')

        btn_open.removeClass('active')
        sort_options.slideUp(200);
    });

    // Ajax show search results
    $(document).on('click', '#btn-show-search-results', function(e){
        e.preventDefault()
        let btnLoadMore = $('#btn-load-more-results')
        let formSearch = $('form.search-results-form')
        let page = 1;
        let keyWord = formSearch.find('input.search-field-input').val()
        let searchOrderBy = formSearch.find('input[type=radio][name=orderby]:checked').val()
        let searchOrder = formSearch.find('input[type=radio][name=order]:checked').val()
        let countResults = formSearch.find('#number-results-count')
        let numberAllResults = formSearch.find('#number-all-results')
        let searchResults = $('#search-results')

        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data:{
                'action'         : 'dv_query_search_results',
                'key_word'       : keyWord,
                'page'           : page,
                'search_orderby' : searchOrderBy,
                'search_order'   : searchOrder,
            },
            beforeSend : function ( xhr ) {
                searchResults.addClass('loading')
            },
            success:function(response){
                searchResults.removeClass('loading')
                btnLoadMore.show();
                
                if (response.search_result && response.found_posts > 0) {
                    let results_html = '<div class="loading-wrapper"><div class="dv-spinner"></div></div>';
                    results_html += response.search_result;
                    searchResults.html(results_html);
                    btnLoadMore.data('next-page', 2);
                }
                else {
                    searchResults.html('<h3 style="text-align:center;">Results not found.</h3>');
                }

                let resultItem = $('#search-results article.result-item')

                countResults.text(resultItem.length)
                numberAllResults.text(response.found_posts)

                if (resultItem.length >= response.found_posts) {
                    btnLoadMore.hide();
                }
            }
        });
    });
    // Ajax show search results
    $(document).on('click', '#btn-apply-sort', function(e){
        e.preventDefault()
        $('#btn-show-search-results').click();
    });

    // Ajax Load more search results
    $(document).on('click', '#btn-load-more-results', function(e){
        e.preventDefault()
        let btn = $(this)
        btn.show();
        let formSearch = $('form.search-results-form')
        let page = btn.data('next-page')
        let keyWord = formSearch.find('input.search-field-input').val()
        let searchOrderBy = formSearch.find('input[type=radio][name=orderby]:checked').val()
        let searchOrder = formSearch.find('input[type=radio][name=order]:checked').val()
        let countResults = formSearch.find('#number-results-count')
        let searchResults = $('#search-results')

        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data:{
                'action'         : 'dv_query_search_results',
                'key_word'       : keyWord,
                'page'           : page,
                'search_orderby' : searchOrderBy,
                'search_order'   : searchOrder,
            },
            beforeSend : function ( xhr ) {
                btn.addClass('loading')
            },
            success:function(response){
                searchResults.append(response.search_result)
                btn.data('next-page', page + 1);
                btn.removeClass('loading')
                let resultItem = $('#search-results article.result-item')

                countResults.text(resultItem.length)

                if (resultItem.length >= response.found_posts) {
                    btn.hide();
                }
            }
        });
    });

    // Ajax Load more search results
    $(document).on('click', '.latest-posts .load-more-cta', function(e){
        e.preventDefault()
        let btn = $(this)
        let sectionWrapper = btn.closest('.latest-posts')
        let paged = btn.data('next-page')
        let postType = sectionWrapper.find('input[name=post_type]').val()
        let numberPosts = sectionWrapper.find('input[name=number_posts]').val()
        let orderBy = sectionWrapper.find('input[name=order_by]').val()
        let maxPosts = sectionWrapper.find('input[name=max_posts]').val()
        let postList = sectionWrapper.find('ul.posts-list')

        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data:{
                'action'         : 'dv_load_more_latest_posts',
                'paged'          : paged,
                'post_type'      : postType,
                'number_posts'   : numberPosts,
                'order_by'       : orderBy,
            },
            beforeSend : function ( xhr ) {
                btn.addClass('loading')
            },
            success:function(response){
                postList.append(response)
                btn.data('next-page', paged + 1);
                btn.removeClass('loading')
                let currentPost = postList.find('.post').length
                if (currentPost >= maxPosts) {
                    btn.remove()
                }
            }
        });
    });

    // Show donate popup
    $(document).on('click', '#btn-donate', function(e){
        e.preventDefault()
        let this_btn = $(this) 
        this_btn.addClass('active')
        let wrapper_margin = this_btn.offset().top + this_btn.outerHeight();
        let donate_popup = $('#donate-popup')
        let donate_wrapper = donate_popup.find('.donate-wrapper')
        let input_field = donate_popup.find('input#other-amount')

        donate_popup.toggleClass('show')
        donate_wrapper.css('margin-top', wrapper_margin +'px')
        donate_wrapper.slideDown(200)
        dv_aria_expanded_status(this_btn);

        setTimeout(function() {
            input_field.focus();
        }, 200);
    });
    // Click to Close donate popup
    $(document).on('click', '#btn-close-donate', function(e){
        e.preventDefault()
        $(this).addClass('active')
        let donate_popup = $('#donate-popup')
        let donate_wrapper = donate_popup.find('.donate-wrapper')

        donate_popup.removeClass('show')
        donate_wrapper.slideUp(200)
        $('#btn-donate').attr('aria-expanded', 'false');
    });
    // Focus-out to Close donate popup
    $(document).on('blur', '#btn-close-donate', function(e){
        e.preventDefault()
        $(this).addClass('active')
        let donate_popup = $('#donate-popup')
        let donate_wrapper = donate_popup.find('.donate-wrapper')

        donate_popup.removeClass('show')
        donate_wrapper.slideUp(200)
        $('#btn-donate').attr('aria-expanded', 'false');
    });
    // Show donate popup
    $(document).on('click', '#donate-popup .donate-wrapper', function(e){
        e.stopPropagation()
    });
    // Close donate popup
    $(document).on('click', '#donate-popup', function(e){
        e.preventDefault()
        $(this).removeClass('show')
        $(this).find('.donate-wrapper').slideUp(200)
        $('#btn-donate').attr('aria-expanded', 'false');
    });
    // Checked or un-checked amount radio button
    $(document).on('click', '#donate-popup input[type=radio][name=amount]', function(e) {
        let btn_radio = $(this);
        if (btn_radio.data('checked')) {
            btn_radio.prop('checked', false);
            btn_radio.data('checked', false);
        } else {
            $('#donate-popup input[type=radio][name=amount]').data('checked', false); // Uncheck all
            btn_radio.data('checked', true); // Check the clicked one
        }
    });
    // Disable options amount or custom amount
    $(document).on('click', '#donate-popup #btn-continue-donate', function(e) {
        let custom_amount = $('#donate-popup input#other-amount')
        if (custom_amount.val() === '') {
            // Disable custom amount
            custom_amount.prop('disabled', true);
        }
        else {
            // Disable all amount radio button
            $('#donate-popup input[type=radio][name=amount]').prop('disabled', true);
        }
    });

    // Smooth scrolling to anchor links
    $(document).on('click', 'a[href^="#"]', function(e) {
        let target = $(this.getAttribute('href'));
        if( target.length ) {
            e.preventDefault();
            let offset = ($('header#masthead').outerHeight()) + 40; 
            $('html, body').stop().animate({
                scrollTop: target.offset().top - offset
            }, 300);
        }
    });

    // Select all <table> elements and wrap them with a <div>
    $('.main-content .content-wrapper table').each(function() {
        $(this).wrap('<div class="table-wrapper" role="region" tabindex="0"></div>');
    });

    // 
    $(document).on('focus', '#site-navigation li.menu-item a', function(e) {
        let menuItem = $(this).closest('li.menu-item')
        let subMenu = menuItem.find('.sub-menu')
        subMenu.slideDown(200)
    });

    $(document).on('blur', '#site-navigation li.menu-item a', function(e) {
        let menuItem = $(this).closest('ul#primary-menu-list > li.menu-item')
        let subMenu = menuItem.find('.sub-menu')
        // Check if sub-menu is the last sub-menu
        let lastSubMenu = menuItem.find('.sub-menu').last();
        let isLastSubMenu = subMenu.is(lastSubMenu);
        // Check if $(this) is the last child of the last sub-menu
        let isLastChild = $(this).is(lastSubMenu.find('a').last());

        if (isLastSubMenu && isLastChild) {
            // Find all sub menu
            let allSubMenu = menuItem.find('.sub-menu')
            allSubMenu.each(function(e) {
                $(this).slideUp(200)
            })
        }
    });

})
