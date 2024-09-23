<?php
/**
 * Displays the site top menu.
 *
 * @package WordPress
 */

$useful_links       = get_field('useful_links', 'option');
$phone_number       = get_field('phone_number', 'option');
$member_login       = get_field('member_login', 'option');
$login_page         = $member_login['login_page'] ?? '/member-login';
$member_logged_in   = get_field('member_logged_in', 'option');
$donate             = get_field('donate', 'option');
$donate_page        = $donate['donate_page'] ?? '/';
$languages          = get_field('languages', 'option');
?>

<div id="top-menu">
    <div class="container">
        <div class="top-menu-list">
            <?php if (!empty($useful_links)): ?>
                <ul class="useful-links-list col-left">
                <?php foreach ($useful_links as $item): ?>
                    <li>
                        <a href="<?php echo $item['item_link']; ?>"><?php echo $item['item_text']; ?></a>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <ul class="col-right">
                <li class="phone">
                    <button id="btn-phone" title="Contact Phones" aria-label="Contact Phones"
                        aria-expanded="false" aria-controls="contact-phones-area">
                        <?php echo dv_get_icon_svg('icon-phone-solid'); ?>
                    </button>
                </li>
                <li class="member-login">
                    <a id="btn-member-login" href="<?php echo $login_page ?>" 
                        class="btn-member-login is_logged_in" role="button">
                        <span><?php echo $member_login['button_text'] ?? 'Member Login'; ?></span>
                    </a>
                </li>
                <li class="search">
                    <button id="btn-search" title="Search" aria-label="Search"
                            aria-expanded="false" aria-controls="global-search-wrapper">
                        <?php echo dv_get_icon_svg('icon-search'); ?>
                    </button>
                </li>
                <li class="donate">
                    <button id="btn-donate" aria-expanded="false" aria-controls="donate-popup">
                        <span><?php echo $donate['button_text'] ?? 'Donate'; ?></span>
                    </button>
                    <a id="btn-donate" role="button" href="<?php echo esc_url( $donate_page ) ?>" style="display:none;">
                        <span><?php echo $donate['button_text'] ?? 'Donate'; ?></span>
                    </a>
                </li>
                <li class="languages">
                    <a id="btn-languages" href="<?php echo $languages['languages_page'] ?? ''; ?>" role="button">
                        <span><?php echo $languages['button_text'] ?? 'Languages'; ?></span>
                        <?php echo dv_get_icon_svg('icon-languages'); ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

