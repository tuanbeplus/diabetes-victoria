<?php
/**
 * Template Name: Member Login Error
 * 
 * This template is displayed when there's an error with member login
 * or invalid membership data from Salesforce
 */

get_header(); ?>

<div class="container">
    <div class="member-login-error">
        <div class="error-content">
            <h1>Login Error</h1>
            <p>We encountered an issue with your member login. This could be due to:</p>
            <ul>
                <li>Invalid membership data received from our system</li>
                <li>Missing required membership information</li>
                <li>Expired or invalid authentication</li>
            </ul>
            <div class="error-actions">
                <a href="<?php echo home_url('/member-login/'); ?>" class="btn btn-primary">
                    Try Again
                </a>
                <a href="<?php echo home_url('/contact-us/'); ?>" class="btn btn-secondary">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
