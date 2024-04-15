jQuery(document).ready(function ($) {

    const ajaxUrl = ajax_object.ajax_url;

    // Scroll event
    $(window).scroll(function() {  
        // get Header height
        var header_height = $('header.site-header').height() + 'px';
        // Sticky header
        if ($(window).scrollTop() > 10) {
            $('header.site-header').addClass('sticky')
            $('.site-content').css('margin-top', header_height)
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
    })

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
    });

    // Click overlay to close Search popup
    $(document).on('click', '.global-search-wrapper', function(e){
        e.preventDefault();
        let btn_search = $('#btn-search')

        $(this).removeClass('active')
        btn_search.removeClass('active')
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
        let spinner = $('#ajax-loading-spinner')

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
                spinner.show();
            },
            success:function(response){
                spinner.hide();
                searchResults.append(response)
                btn.data('next-page', page + 1);
                let resultItem = $('#search-results article.result-item')
                countResults.text(resultItem.length)

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

})