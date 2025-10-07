!(function($){
	"use strict";

    // Accordion
    function DV_Accordion() {
        if($('.js-accordion').length == 0) {
            return;
        }

        var accordion = $('.js-accordion');
        var expandedClass = 'is-expanded';

        $.each(accordion, function () {

            var accordionItems = $(this).find('[data-binding="expand-accordion-item"]');

            $.each(accordionItems, function () {
                var $this = $(this);
                var triggerBtn = $this.find('[data-binding="expand-accordion-trigger"]');
                
                var setHeight = function (nV) {
                    var innerContent = nV.find('.accordion__content-inner')[0],
                        maxHeight = $(innerContent).outerHeight(),
                        content = nV.find('.accordion__content')[0];

                    if (!content.style.height || content.style.height === '0px') {
                        $(content).css('height', maxHeight);
                    } else {
                        $(content).css('height', '0px');
                    }
                };
                
                var toggleClasses = function (event) {
                    var clickedItem = event.currentTarget;
                    var currentItem = $(clickedItem).parent();
                    var clickedContent = $(currentItem).find('.accordion__content')
                    $(currentItem).toggleClass(expandedClass);
                    setHeight(currentItem);
                    
                    if ($(currentItem).hasClass('is-expanded')) {
                        $(clickedItem).attr('aria-selected', 'true');
                        $(clickedItem).attr('aria-expanded', 'true');
                        $(clickedContent).attr('aria-hidden', 'false');

                    } else {
                        $(clickedItem).attr('aria-selected', 'false');
                        $(clickedItem).attr('aria-expanded', 'false');
                        $(clickedContent).attr('aria-hidden', 'true');
                    }
                }
                
                triggerBtn.on('click', event, function (e) {
                    e.preventDefault();
                    toggleClasses(event);
                });

                $(triggerBtn).on('keydown', event, function (e) {
                    if (e.keyCode === 13 || e.keyCode === 32) {
                        e.preventDefault();
                        toggleClasses(event);
                    }
                });
            });

        });
    }

    // Carousel
    function DV_Carousel() {
        if($('.js-carousel').length == 0) {
            return;
        }

        var carousel = $('.js-carousel');

        $.each(carousel, function () {
            $(this).slick($(this).data('carousel'));
            $(this).show();
        });
    }

    // Carousel Dots Custom
    function DV_Carousel_Dots_Custom() {
        var carousel = $('.js-carousel');

        $.each(carousel, function () {
            var $dots = $(this).find('.slick-dots-custom li');
            var total = $dots.length;
            $dots.each(function(index){
                var pageNum = index + 1;
                $(this).find('button').html('<span>' + pageNum + ' of ' + total + '</span>');
            });
        });
    }

    // User Profile
    function DV_User_Profile() {
        if($('.user-profile-form').length == 0) {
            return;
        }

        $('.user-profile-form').submit(function(){
            var param_out = [],
                param_in = $(this).serialize().split('&');


            var param_ajax = {
                action: 'dv_user_profile_update',
            };

            param_ajax['user_fname'] = $(this).find('#user_fname').val();
            param_ajax['user_lname'] = $(this).find('#user_lname').val();
            param_ajax['user_email'] = $(this).find('#user_email').val();
            param_ajax['user_url'] = $(this).find('#user_url').val();
            param_ajax['user_desc'] = $(this).find('#user_desc').val();
        
            // console.log(param_ajax);

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: param_ajax,
                context: this,
                beforeSend: function(){
                  $('.user-profile-form').addClass('loading');
                },
                success: function(response) {
                  if(response.success) {
                    // console.log(response.data);
      
                    setTimeout(function() {
                        $('.user-profile-form').removeClass('loading');

                    }, 500);

                  } else {
                    console.log('error');
                  }
                },
                error: function( jqXHR, textStatus, errorThrown ){
                  console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            });

            return false;
        });
    }

    jQuery(document).ready(function ($) {
        DV_Accordion();
        DV_Carousel();
        DV_Carousel_Dots_Custom();
        DV_User_Profile();
    
    });

    jQuery(window).on('resize', function() {
        DV_Carousel_Dots_Custom();
    });

})(jQuery);
