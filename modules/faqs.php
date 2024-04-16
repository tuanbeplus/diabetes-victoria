<?php
/**
 * The template for displaying FAQs module
 *
 */

if( get_row_layout() == 'faqs' ):
    $faqs = get_sub_field('faqs');
    
    if (!empty($faqs)):
        ?>
        <section class="faqs-wrapper accordion" role="tablist" aria-live="polite" data-behavior="accordion">
            <article class="accordion__item js-show-item-default" data-binding="expand-accordion-item">
                <div id="tab5" tabindex="0" class="accordion__title" aria-controls="panel5" role="tab" aria-selected="false" aria-expanded="false" data-binding="expand-accordion-trigger">
                <h5>Heading 1</h5>
                </div>

                <div id="panel5" class="accordion__content" role="tabpanel" aria-hidden="true" aria-labelledby="tab5" data-binding="expand-accordion-container">
                <div class="accordion__content-inner">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                </div>

            </article>

            <article class="accordion__item js-show-item-default" data-binding="expand-accordion-item">
                <div id="tab6" tabindex="0" class="accordion__title" aria-controls="panel6" role="tab" aria-selected="false" aria-expanded="false" data-binding="expand-accordion-trigger">
                <h5>Heading 2</h5>
                </div>

                <div id="panel6" class="accordion__content" role="tabpanel" aria-hidden="true" aria-labelledby="tab6" data-binding="expand-accordion-container">
                <div class="accordion__content-inner">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                </div>
            </article>
        </section>

        <script>
            jQuery(document).ready(function(){
                var accordion = $('body').find('[data-behavior="accordion"]');
                var expandedClass = 'is-expanded';

                $.each(accordion, function () { // loop through all accordions on the page

                    var accordionItems = $(this).find('[data-binding="expand-accordion-item"]');

                    $.each(accordionItems, function () { // loop through all accordion items of each accordion
                        var $this = $(this);
                        var triggerBtn = $this.find('[data-binding="expand-accordion-trigger"]');
                        
                        var setHeight = function (nV) {
                        // set height of inner content for smooth animation
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

                        // open tabs if the spacebar or enter button is clicked whilst they are in focus
                        $(triggerBtn).on('keydown', event, function (e) {
                        if (e.keyCode === 13 || e.keyCode === 32) {
                            e.preventDefault();
                            toggleClasses(event);
                        }
                        });
                    });

                });
            });
        </script>
        <?php
    endif;
endif;