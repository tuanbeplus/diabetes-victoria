<?php
/**
 * Displays the site top menu.
 *
 * @package WordPress
 */

$useful_links = get_field('useful_links', 'option');
$phone_number = get_field('phone_number', 'option');
$member_login = get_field('member_login', 'option');
$donate       = get_field('donate', 'option');
$languages    = get_field('languages', 'option');
?>

<div id="top-menu">
    <div class="container">
        <ul class="top-menu-list">
            <?php if (!empty($useful_links)): ?>
                <div class="useful-links-list col-left">
                <?php foreach ($useful_links as $item): ?>
                    <li>
                        <a href="<?php echo $item['item_link']; ?>"><?php echo $item['item_text']; ?></a>
                    </li>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="col-right">
                <li class="phone">
                    <a id="btn-phone" href="tel:<?php echo $phone_number ?? ''; ?>" 
                        title="Contact Phone" aria-label="Contact Phone" role="button">
                        <?php echo dv_get_icon_svg('icon-phone-solid'); ?>
                    </a>
                </li>
                <li class="member-login">
                    <button id="btn-member-login" role="button">
                        <span><?php echo $member_login['button_text'] ?? ''; ?></span>
                    </button>
                </li>
                <li class="search">
                    <button id="btn-search" title="Search" aria-label="Search"
                            aria-expanded="false" aria-controls="global-search-wrapper">
                        <?php echo dv_get_icon_svg('icon-search'); ?>
                    </button>
                </li>
                <li class="donate">
                    <button id="btn-donate" aria-expanded="false" aria-controls="donate-popup">
                        <span><?php echo $donate['button_text'] ?? ''; ?></span>
                    </button>
                </li>
                <li class="languages">
                    <a id="btn-languages" href="<?php echo $languages['languages_page'] ?? ''; ?>" role="button">
                        <span><?php echo $languages['button_text'] ?? ''; ?></span>
                        <?php echo dv_get_icon_svg('icon-languages'); ?>
                    </a>
                </li>
            </div>
        </ul>
    </div>
</div>

