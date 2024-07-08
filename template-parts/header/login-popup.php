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
            <h2>Member Area Login</h2>
            <p>Please login to enjoy your exclusive member area!</p>
            <?php wp_login_form( $form_args ); ?>
            <p>
                <a class="forgot-password" href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Forgot your password?</a>
                &nbsp;
                <a href="#">First time logging in?</a>
            </p>
            <p>Not a member? <a href="#">JOIN NOW</a> to access exclusive member benefits!</p>
            <p>Having trouble? Visit our <a href="#">Online Help</a> section</p>
        </div>
        <button id="btn-close-login-popup">
            <span>Close</span>
            <span class="close-icon"><i class="fa-solid fa-xmark"></i></span>
        </button>
    </div>
</div>
