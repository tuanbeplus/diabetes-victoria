<?php
/**
 * Displays the site top menu.
 *
 * @package WordPress
 */

$useful_links       = get_field('useful_links', 'option');
$phone_number       = get_field('phone_number', 'option');
$member_login       = get_field('member_login', 'option');
$member_logged_in   = get_field('member_logged_in', 'option');
$donate             = get_field('donate', 'option');
$languages          = get_field('languages', 'option');
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
                    <button id="btn-phone" title="Contact Phones" aria-label="Contact Phones"
                        aria-expanded="false" aria-controls="contact-phones-area">
                        <?php echo dv_get_icon_svg('icon-phone-solid'); ?>
                    </button>
                </li>
                <li class="member-login">
                    <?php if ( is_user_logged_in() ): ?>
                        <a id="btn-member-login" href="<?php echo $member_logged_in['member_page'] ?? '/'; ?>" 
                            class="is_logged_in" role="button">
                            <span><?php echo $member_logged_in['button_text'] ?? 'My Membership'; ?></span>
                        </a>
                    <?php else: ?>
                        <button id="btn-member-login" aria-expanded="false" aria-controls="members-login-area">
                            <span><?php echo $member_login['button_text'] ?? 'Member Login'; ?></span>
                        </button>
                    <?php endif; ?>
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
                </li>
                <li class="languages">
                    <a id="btn-languages" href="<?php echo $languages['languages_page'] ?? ''; ?>" role="button">
                        <span><?php echo $languages['button_text'] ?? 'Languages'; ?></span>
                        <?php echo dv_get_icon_svg('icon-languages'); ?>
                    </a>
                </li>
            </div>
        </ul>
    </div>
</div>

