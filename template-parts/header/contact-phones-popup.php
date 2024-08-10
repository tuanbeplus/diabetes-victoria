<?php
/**
 * Displays the Contact Phones Area
 *
 */

$contact_phones = get_field('contact_phones', 'options');
$title = $contact_phones['title'] ?? 'Call';
$contacts_list = $contact_phones['contacts_list'] ?? array();
?>
<!-- Contact phones popup -->
<div id="contact-phones-area" class="contact-phones-popup">
    <div class="contact-phones-wrapper">
        <div class="inner">
            <h2><?php echo $title ?></h2>
            <?php if (!empty($contacts_list)): ?>
                <ul class="contacts-list">
                <?php foreach ($contacts_list as $contact): ?>
                    <li>
                        <p class="contact-name">
                            <?php echo $contact['contact_name'] ?? '' ?>
                        </p>
                        <p class="contact-phone">
                            <a href="tel:<?php echo $contact['contact_phone'] ?? '' ?>">
                                <?php echo $contact['contact_phone'] ?? '' ?>
                            </a>
                        </p>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <button id="btn-close-contacts-popup">
            <span>Close</span>
            <span class="close-icon"><i class="fa-solid fa-xmark"></i></span>
        </button>
    </div>
</div><!-- .Contact phones popup -->
