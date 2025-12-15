jQuery(document).ready(function ($) {

    const ajaxUrl = ajax_object.ajax_url;

    // Call render TOCs
    dv_tocs_item_generation();

    // Call the function on page load
    dv_set_css_variable();

    // Set search form values from URL params on page load
    dv_set_search_params_from_url();

    // Resize event
    $(window).on('resize', function () {
        dv_set_css_variable();
    });

    // Scroll event
    $(window).on('scroll', function () {
        // Call the scroll events function
        dv_apply_all_scroll_events();
    })

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
            $('header.site-header').addClass('sticky')
            $('.site-content').css('margin-top', header_height + 'px')
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
            // get Header height
            let offset_top = $('header.site-header').outerHeight();
            let admin_bar = $('#wpadminbar');
            if (admin_bar.length > 0) {
                offset_top = offset_top + admin_bar.outerHeight();
            }
            let sibar_scroll_offset = $('#main-content-sidebar').offset().top - $('#content.site-content').offset().top;
            if ($(window).scrollTop() > sibar_scroll_offset) {
                $('#main-content-sidebar').addClass('sticky')
                $('#main-content-sidebar .sidebar-inner').css('top', offset_top + 'px')
            }
            else {
                $('#main-content-sidebar').removeClass('sticky')
                $('#main-content-sidebar .sidebar-inner').css('top', 'unset')
            }
        }
    }

    /**
     * Check the element in viewport
     */
    $.fn.dv_is_element_in_viewport = function () {
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

        // Check if TOC is exist
        if (tocs_wrapper.length > 0) {
            // Find all <h2> tags within the site content, excluding those inside #main-content-sidebar
            let all_heading_tags = site_content.find('h2').not('#main-content-sidebar h2');
            let key_cards = site_content.find('.key-cards .card').not('.key-cards.hide_in_TOC .card');

            if (key_cards.length > 0) {
                key_cards.each(function () {
                    let card = $(this)
                    let landing_page = card.find('h3.landing-page')
                    let card_title = card.find('h3.card-title')

                    if (landing_page.length > 0 && card_title.length > 0) {
                        all_heading_tags = all_heading_tags.add(landing_page);
                    }
                    else if (landing_page.length > 0) {
                        all_heading_tags = all_heading_tags.add(landing_page);
                    }
                    else {
                        all_heading_tags = all_heading_tags.add(card_title);
                    }
                })
            }
            // Check if there are any <h2> tags
            if (all_heading_tags.length > 0) {
                // Iterate over each <h2> tag
                all_heading_tags.each(function () {
                    counter++;
                    let heading = $(this);
                    // Create a TOC item with a link to the corresponding <h2> tag
                    let toc_item = '<li><a href="#heading2-item-' + counter + '">' + heading.text() + '</a></li>';
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
        let header_height = $('header.site-header').outerHeight();
        let breadcrumb_height = 0;
        let breadcrumb = $('header nav.breadcrumb');
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
        let item_content = $('.ipro-carousel-section .ipro-item--content');
        let wrapper = item_content.closest('.ipro-carousel-section');
        let elements = wrapper.find('.ipro-item--content');

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
     * Update all search params (s, orderby, order) in URL
     */
    function dv_update_search_params_url(button) {

        let form = button.closest('form')

        let searchInput = form.find('input[type=search]').val(); // Get the search input value
        let searchOrderBy = form.find('input[type=radio][name=orderby]:checked').val(); // Get orderby value
        let searchOrder = form.find('input[type=radio][name=order]:checked').val(); // Get order value
        let currentUrl = new URL(window.location.href); // Get the current URL

        // Set or update the search parameters
        currentUrl.searchParams.set('s', searchInput);
        currentUrl.searchParams.set('orderby', searchOrderBy);
        currentUrl.searchParams.set('order', searchOrder);

        history.pushState(null, '', currentUrl); // Update the URL without reloading the page

        let breadcrumb_current = $('.breadcrumb li[aria-current=page] span')
        if (breadcrumb_current.length > 0) {
            breadcrumb_current.text('Search result for: ' + searchInput);
        }
    }

    /**
     * Read URL params and set form values on page load
     */
    function dv_set_search_params_from_url() {
        let currentUrl = new URL(window.location.href);
        let formSearch = $('form.search-results-form');

        if (formSearch.length > 0) {
            // Get parameters from URL
            let orderby = currentUrl.searchParams.get('orderby');
            let order = currentUrl.searchParams.get('order');

            // Set orderby radio button if parameter exists
            if (orderby) {
                formSearch.find('input[type=radio][name=orderby][value=' + orderby + ']').prop('checked', true);
            }

            // Set order radio button if parameter exists
            if (order) {
                formSearch.find('input[type=radio][name=order][value=' + order + ']').prop('checked', true);
            }
        }
    }

    // Click to hide accessibility options
    $(document).on('click', '#pojo-a11y-toolbar .background-overlay', function (e) {
        e.preventDefault()
        let pojo_toolbar = $('nav#pojo-a11y-toolbar');

        pojo_toolbar.removeClass('pojo-a11y-toolbar-open');
    });

    // Click to hide accessibility tools
    $(document).on('click', '#btn-close-accessibility-toolbar', function (e) {
        e.preventDefault()
        let pojo_toolbar = $('nav#pojo-a11y-toolbar');

        pojo_toolbar.removeClass('pojo-a11y-toolbar-open');
    });

    // Click to show socials share options
    $(document).on('click', '#btn-socials-share', function (e) {
        e.preventDefault()
        let share_content = $(this).closest('.socials-share-wrapper').find('.share-content')
        // Scroll to the top of the document with smooth animation
        share_content.slideToggle(200);
    });

    // Click to hide socials share options
    $(document).on('click', '#btn-close-share', function (e) {
        e.preventDefault()
        let share_content = $(this).closest('.socials-share-wrapper').find('.share-content')
        // Scroll to the top of the document with smooth animation
        share_content.slideUp(200);
    });

    // Click to scroll to top
    $(document).on('click', '#btn-scroll-top', function (e) {
        e.preventDefault()
        // Scroll to the top of the document with smooth animation
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // ------------------ Search Popup ------------------
    // Click to open Search popup
    $(document).on('click', '#btn-search', function (e) {
        e.preventDefault()
        let search_wrapper = $('.global-search-wrapper')
        let search_overlay = $('.search-overlay')
        let input_field = search_wrapper.find('form input.search-field-input')

        $(this).toggleClass('active')
        search_wrapper.toggleClass('active')
        search_overlay.toggleClass('active')
        dv_aria_expanded_status($(this));

        setTimeout(function () {
            input_field.focus();
        }, 200);
    });

    // Click button to close Search popup
    $(document).on('click', '#btn-close-search', function (e) {
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
    $(document).on('blur', '#btn-close-search', function (e) {
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
    $(document).on('click', '.global-search-wrapper', function (e) {
        e.preventDefault();
        let btn_search = $('#btn-search')

        $(this).removeClass('active')
        btn_search.removeClass('active')
        btn_search.attr('aria-expanded', 'false');
    });
    $(document).on('click', '.global-search-wrapper form', function (e) {
        e.stopPropagation();
    });
    // ------------------ /Search Popup ------------------

    // Open Nav mobile
    $(document).on('click', '#btn-nav-bar', function (e) {
        e.preventDefault()
        let siteBody = $('body')
        let nav_mobile = $('header nav#site-navigation')
        let site_tools = $('#pojo-a11y-toolbar')
        let btnScrollTop = $('#btn-scroll-top')
        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
            site_tools.show()
        }
        else {
            $(this).addClass('active')
            site_tools.hide()
        }
        nav_mobile.toggleClass('active')
        siteBody.toggleClass('hidden')
        btnScrollTop.removeClass('show')
        dv_aria_expanded_status($(this));
    });

    // Open sort options
    $(document).on('click', '#btn-open-sort', function (e) {
        e.preventDefault()
        let wrapper = $(this).closest('.results-sort')
        let sort_options = wrapper.find('.sort-options')

        $(this).toggleClass('active')
        sort_options.slideToggle(200);
    });

    // Close sort options
    $(document).on('click', '#btn-close-sort-opts', function (e) {
        e.preventDefault()
        let wrapper = $(this).closest('.results-sort')
        let sort_options = wrapper.find('.sort-options')
        let btn_open = wrapper.find('#btn-open-sort')

        btn_open.removeClass('active')
        sort_options.slideUp(200);
    });

    // Attach click event to the document
    $(document).on('click', function (e) {
        // Check if the click is outside the .sort-options element
        if (!$(e.target).closest('.results-sort').length) {
            $('#btn-open-sort').removeClass('active')
            $('.results-sort .sort-options').slideUp(200);
        }
    });
    // Prevent the popup from closing when clicking inside it
    $(document).on('click', '.results-sort', function (e) {
        e.stopPropagation();
    });

    // Ajax show search results
    $(document).on('click', '#btn-show-search-results', function (e) {
        e.stopPropagation()
        let btnLoadMore = $('#btn-load-more-results')
        let formSearch = $('form.search-results-form')
        let page = 1;
        let keyWord = formSearch.find('input.search-field-input').val()
        let searchOrderBy = formSearch.find('input[type=radio][name=orderby]:checked').val()
        let searchOrder = formSearch.find('input[type=radio][name=order]:checked').val()
        let countResults = formSearch.find('#number-results-count')
        let numberAllResults = formSearch.find('#number-all-results')
        let searchResults = $('#search-results')

        // Update all search params (s, orderby, order) to URL
        dv_update_search_params_url($(this));

        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'action': 'dv_query_search_results',
                'key_word': keyWord,
                'page': page,
                'search_orderby': searchOrderBy,
                'search_order': searchOrder,
            },
            beforeSend: function (xhr) {
                searchResults.addClass('loading')
            },
            success: function (response) {
                searchResults.removeClass('loading')
                btnLoadMore.show();

                if (response.search_result && response.found_posts > 0) {
                    let results_html = '<div class="loading-wrapper"><p class="mess">Loading...</p><div class="dv-spinner"></div></div>';
                    results_html += response.search_result;
                    searchResults.html(results_html);
                    btnLoadMore.data('next-page', 2);
                }
                else {
                    searchResults.html('<h3 style="text-align:center;">No results found.</h3>');
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

    // Auto-trigger search when sort options are changed
    $(document).on('click', '.search-results-form input[type=radio][name=orderby], .search-results-form input[type=radio][name=order]', function (e) {
        // Trigger search automatically when radio button is clicked
        $('#btn-show-search-results').click();
    });

    // Ajax show search results
    $(document).on('click', '#btn-apply-sort', function (e) {
        e.preventDefault()
        $('#btn-show-search-results').click();
    });

    // Ajax Load more search results
    $(document).on('click', '#btn-load-more-results', function (e) {
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
            data: {
                'action': 'dv_query_search_results',
                'key_word': keyWord,
                'page': page,
                'search_orderby': searchOrderBy,
                'search_order': searchOrder,
            },
            beforeSend: function (xhr) {
                btn.addClass('loading')
            },
            success: function (response) {
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
    $(document).on('click', '.latest-posts .load-more-cta', function (e) {
        e.preventDefault()
        let btn = $(this)
        let sectionWrapper = btn.closest('.latest-posts')
        let paged = btn.data('next-page')
        let postType = sectionWrapper.find('input[name=post_type]').val()
        let numberPosts = sectionWrapper.find('input[name=number_posts]').val()
        let orderBy = sectionWrapper.find('input[name=order_by]').val()
        let postCats = sectionWrapper.find('input[name=categories]').val()
        let postTags = sectionWrapper.find('input[name=tags]').val()
        let maxPosts = sectionWrapper.find('input[name=max_posts]').val()
        let hasPostMeta = sectionWrapper.find('input[name=has_post_meta]').val()
        let postList = sectionWrapper.find('ul.posts-list')

        // Parse categories and tags, ensuring they are always arrays
        postCats = JSON.parse(postCats || '[]')
        if (!Array.isArray(postCats)) {
            postCats = [];
        }
        postTags = JSON.parse(postTags || '[]')
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
                'has_post_meta': hasPostMeta,
            },
            beforeSend: function (xhr) {
                btn.addClass('loading')
            },
            success: function (response) {
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

    // ------------------ Donate Popup ------------------
    // Show donate popup
    $(document).on('click', '#btn-donate', function (e) {
        e.preventDefault()
        let this_btn = $(this)
        // window.location.href = this_btn.attr('href')
        // return
        this_btn.addClass('active')
        let adminBar = $('#wpadminbar')
        let wrapper_margin = this_btn.outerHeight();
        if (adminBar.length > 0) {
            wrapper_margin = wrapper_margin + adminBar.outerHeight();
        }
        let donate_popup = $('#donate-popup')
        let donate_wrapper = donate_popup.find('.donate-wrapper')
        let input_field = donate_popup.find('input#other-amount')

        donate_popup.toggleClass('show')
        donate_wrapper.css('margin-top', wrapper_margin + 'px')
        donate_wrapper.slideDown(200)
        dv_aria_expanded_status(this_btn);

        setTimeout(function () {
            input_field.focus();
        }, 200);
    });
    // Click & Focus-out to Close Donate popup
    $(document).on('click blur', '#btn-close-donate', function (e) {
        e.preventDefault()
        dv_close_donate_popup()
    });
    // Click outside to close Donate popup
    $(document).on('click', '#donate-popup', function (e) {
        e.preventDefault()
        dv_close_donate_popup()
    });
    // Stop propagation for Donate wrapper
    $(document).on('click', '#donate-popup .donate-wrapper', function (e) {
        e.stopPropagation()
    });
    // Checked or un-checked amount radio button
    $(document).on('click', '#donate-popup input[type=radio][name=amount]', function (e) {
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
    $(document).on('click', '#donate-popup #btn-continue-donate', function (e) {
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
    /**
     * Close the Donate Popup
     */
    function dv_close_donate_popup() {
        let donate_popup = $('#donate-popup')
        let donate_wrapper = donate_popup.find('.donate-wrapper')
        donate_popup.addClass('closing')
        donate_wrapper.slideUp(200)
        setTimeout(function () {
            donate_popup.removeClass('show')
            $('#btn-donate').attr('aria-expanded', 'false');
            donate_popup.removeClass('closing')
        }, 200);
    }
    // ------------------ /Donate Popup ------------------

    // ------------------ Members Login Popup ------------------
    // Click to show Members Login Area
    $(document).on('click', '#btn-member-login', function (e) {
        e.preventDefault()
        let this_btn = $(this)
        if (this_btn.hasClass('is_logged_in')) {
            window.location.href = this_btn.attr('href')
            return
        }
        let adminBar = $('#wpadminbar')
        let wrapper_margin = this_btn.outerHeight();
        if (adminBar.length > 0) {
            wrapper_margin = wrapper_margin + adminBar.outerHeight();
        }
        let login_popup = $('#members-login-area')
        let login_wrapper = login_popup.find('.login-wrapper')
        let input_field = login_popup.find('input#user_login')

        login_popup.addClass('show')
        login_wrapper.css('margin-top', wrapper_margin + 'px')
        login_wrapper.slideDown(300)
        dv_aria_expanded_status(this_btn);
        setTimeout(function () {
            input_field.focus();
        }, 200);
    });
    // Click & Focus-out to Close Members Login Area
    $(document).on('click blur', '#btn-close-login-popup', function (e) {
        e.preventDefault()
        dv_close_members_login_popup()
    });
    // Click outside to close Members Login Area
    $(document).on('click', '#members-login-area', function (e) {
        e.preventDefault()
        dv_close_members_login_popup()
    });
    // Stop propagation login wrapper
    $(document).on('click', '#members-login-area .login-wrapper', function (e) {
        e.stopPropagation()
    });
    /**
     * Close Members Login Area Popup
     */
    function dv_close_members_login_popup() {
        let login_popup = $('#members-login-area')
        let login_wrapper = login_popup.find('.login-wrapper')
        login_popup.addClass('closing')
        login_wrapper.slideUp(200)
        setTimeout(function () {
            login_popup.removeClass('show')
            $('#btn-member-login').attr('aria-expanded', 'false');
            login_popup.removeClass('closing')
        }, 200);
    }
    // Handle WP Members Login Ajax
    $(document).on('click', 'form#member_login_form button[type=submit]', function (e) {
        let form = $(this).closest('form#member_login_form')
        let userLogin = form.find('#user_login').val()
        let userPass = form.find('#user_pass').val()
        let security = form.find('#security').val()
        let spinner = form.find('.dv-spinner')
        let message = $('#login-message')
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'action': 'dv_member_login_ajax',
                'log': userLogin,
                'pwd': userPass,
                'security': security
            },
            beforeSend: function (xhr) {
                message.removeClass()
                spinner.show()
            },
            success: function (response) {
                spinner.hide()
                message.css('opacity', '0')
                    .css('opacity', '1')
                    .addClass(response.status)
                    .html(response.message);
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
        e.preventDefault()
        let this_btn = $(this)
        let adminBar = $('#wpadminbar')
        let wrapper_margin = this_btn.outerHeight();
        if (adminBar.length > 0) {
            wrapper_margin = wrapper_margin + adminBar.outerHeight();
        }
        let contacts_popup = $('#contact-phones-area')
        let contacts_wrapper = contacts_popup.find('.contact-phones-wrapper')
        let first_contact = contacts_wrapper.find('.contacts-list a').first()

        contacts_popup.addClass('show')
        contacts_wrapper.css('margin-top', wrapper_margin + 'px')
        contacts_wrapper.slideDown(300)
        dv_aria_expanded_status(this_btn);
        setTimeout(function () {
            first_contact.focus();
        }, 200);
    });
    // Click & Focus-out to Close  Contact Phones Area
    $(document).on('click blur', '#btn-close-contacts-popup', function (e) {
        e.preventDefault()
        dv_close_contact_phones_popup()
    });
    // Click outside to close Contact Phones Area
    $(document).on('click', '#contact-phones-area', function (e) {
        e.preventDefault()
        dv_close_contact_phones_popup()
    });
    // Stop propagation login wrapper
    $(document).on('click', '#contact-phones-area .contact-phones-wrapper', function (e) {
        e.stopPropagation()
    });
    /**
     * Close Contact Phones Area Popup
     */
    function dv_close_contact_phones_popup() {
        let contacts_popup = $('#contact-phones-area')
        let contacts_wrapper = contacts_popup.find('.contact-phones-wrapper')
        contacts_popup.addClass('closing')
        contacts_wrapper.slideUp(200)
        setTimeout(function () {
            contacts_popup.removeClass('show')
            $('#btn-phone').attr('aria-expanded', 'false');
            contacts_popup.removeClass('closing')
        }, 200);
    }
    // ------------------ /Contact Phones Popup ------------------

    // Smooth scrolling to anchor links
    $(document).on('click', 'a[href^="#"]', function (e) {
        let target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            let offset = ($('header#masthead').outerHeight()) + 24;
            let admin_bar = $('#wpadminbar');
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
        e.preventDefault()
        let sidebar = $(this).closest('.sidebar')
        let catsList = sidebar.find('ul.categories-list')
        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
            catsList.slideUp(200)
        }
        else {
            $(this).addClass('active')
            catsList.slideDown(200)
        }
    });

    // Toggle Sub menu of the menu item
    $(document).on('click', 'nav#site-navigation ul li.menu-item-has-children', function (e) {
        e.preventDefault()
        $(this).toggleClass('active')
    });
    $(document).on('click', 'nav#site-navigation ul li a', function (e) {
        e.stopPropagation()
    });
    $(document).on('click', 'nav#site-navigation ul li .sub-menu', function (e) {
        e.stopPropagation()
    });

    $(document).on('click', '.sharedaddy .share-print.sd-button', function (e) {
        e.preventDefault();
        // Instantly scroll to the top of the page
        window.scrollTo(0, 0);
        // Wait 100ms, then trigger the print dialog
        setTimeout(function () {
            window.print();
        }, 100);
    });

})
