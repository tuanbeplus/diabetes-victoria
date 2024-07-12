<?php
/**
 * Displays the Member Login Area
 *
 */

$form_args = array(
    'echo'           => true,
    'form_id'        => 'member_login_form',
    'redirect'       => home_url('/?action=member-login'), 
    'remember'       => false,
);
?>
<div id="members-login-area" class="login-popup">
    <div class="login-wrapper">
        <div class="login-form">
            <?php if ( is_user_logged_in() ): ?>
                <h2>My Membership</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <?php else: ?>
                <h2>Member Area Login</h2>
                <p id="login-message">Please login to enjoy your exclusive member area!</p>
                <!-- WP Login Form -->
                <form id="member_login_form" onsubmit="return false" method="POST">
                    <p class="login-user">
                        <label for="user_login">Username or Email Address</label>
                        <input type="text" name="log" id="user_login" class="input" value=""/>
                    </p>
                    <p class="login-password">
                        <label for="user_pass">Password</label>
                        <input type="password" name="pwd" id="user_pass" class="input" value=""/>
                    </p>
                    <p class="login-submit">
                        <button type="submit" id="wp-member-login">
                            Log In
                            <div class="dv-spinner"></div>
                        </button>                        
                    </p>
                    <input type="hidden" name="action" value="dv_member_login_ajax">
                    <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
                </form>
                <!-- /WP Login Form -->
                <p>
                    <a class="forgot-password" href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Forgot your password?</a>
                    &nbsp;
                    <a href="#">First time logging in?</a>
                </p>
                <p>Not a member? <a href="#">JOIN NOW</a> to access exclusive member benefits!</p>
                <p>Having trouble? Visit our <a href="#">Online Help</a> section</p>
            <?php endif; ?>
        </div>
        <button id="btn-close-login-popup">
            <span>Close</span>
            <span class="close-icon"><i class="fa-solid fa-xmark"></i></span>
        </button>
    </div>
</div>
