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
            $(this).find('.slick-dots-custom li').each(function(){
                $(this).find('button').html('<span>' + $(this).find('button').attr('aria-label') + '</span>');
            });
        });
    }

    jQuery(document).ready(function ($) {
        DV_Accordion();
        DV_Carousel();
        DV_Carousel_Dots_Custom();
    
    });

    jQuery(window).on('resize', function() {
        DV_Carousel_Dots_Custom();
    });

})(jQuery);
