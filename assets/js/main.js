jQuery(document).ready(function ($) {

    const ajaxUrl = ajax_object.ajax_url;

    // Call render TOCs
    dv_tocs_item_generation();

    // Call the function on page load
    dv_set_css_variable();

    // resize event
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
     * Change status of aria-expanded attr
     * 
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
     * 
     */
    function dv_tocs_item_generation() {
        let site_content = $('#content.site-content')
        let main_content = $('section.main-content')
        let tocs_wrapper = main_content.find('#tocs')
        let counter = 0;

        if (main_content.length > 0) {            
            all_h2_tags = site_content.find('h2')
            if (all_h2_tags.length > 0) {
                all_h2_tags.each(function(e) {
                    counter++
                    let h2_tag = $(this)
                    let toc_item = '<li><a href="#heading2-item-'+ counter +'">'+ h2_tag.text() +'</a></li>';

                    h2_tag.attr('id', 'heading2-item-'+counter) // Add ID to h2
                    tocs_wrapper.append(toc_item) // Add link to TOCs
                })
            }
            else {
                main_content.find('.on-this-page').remove()
            }
        }
    }

    /**
     * Set css variable to HTML tag
     * 
     */
    function dv_set_css_variable() {
        let header_height = $('header.site-header').height();
        if ($('body').hasClass('admin-bar')) {
            header_height = header_height + 32;
        }
        // Set the CSS variable --header-height
        $('html').css('--header-height', header_height + 'px');
    }

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

    // Ajax Load more search results
    $(document).on('click', '#btn-load-more-results', function(e){
        e.preventDefault()
        let btn = $(this)
        let formSearch = $('form.search-results-form')
        let page = btn.data('next-page')
        let keyWord = formSearch.find('input.search-field-input').val()
        let searchFoundPosts = $('input#search-found-posts').val()
        let searchOrderBy = $('input#search-orderby').val()
        let searchOrder = $('input#search-order').val()
        let countResults = formSearch.find('#number-results-count')
        let searchResults = $('#search-results')

        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data:{
                'action'         : 'dv_load_more_search_results',
                'key_word'       : keyWord,
                'page'           : page,
                'search_orderby' : searchOrderBy,
                'search_order'   : searchOrder,
            },
            beforeSend : function ( xhr ) {
                btn.addClass('loading')
            },
            success:function(response){
                searchResults.append(response)
                btn.data('next-page', page + 1);
                btn.removeClass('loading')
                let resultItem = $('#search-results article.result-item')
                countResults.text(resultItem.length)
                if (resultItem.length >= searchFoundPosts) {
                    btn.remove();
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
        donate_wrapper.slideToggle(200)
        dv_aria_expanded_status(this_btn);

        setTimeout(function() {
            input_field.focus();
        }, 200);
    });

    // Close donate popup
    $(document).on('click', '#btn-close-donate', function(e){
        e.preventDefault()
        $(this).addClass('active')
        let donate_popup = $('#donate-popup')
        let donate_wrapper = donate_popup.find('.donate-wrapper')

        donate_popup.removeClass('show')
        donate_wrapper.slideUp(200)
        $('#btn-donate').attr('aria-expanded', 'false');
    });
    // Close donate popup
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

})