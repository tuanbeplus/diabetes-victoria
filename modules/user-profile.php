<?php
/**
 * The template for displaying User Profile module
 *
 */

if( get_row_layout() != 'user_profile') {
    return;
}

$user_id = get_current_user_id();
$first_name = get_user_meta( $user_id, 'first_name', true );
$last_name = get_user_meta( $user_id, 'last_name', true );
$display_name = esc_html($first_name).' '.esc_html($last_name);
$description = get_user_meta( $user_id, 'description', true );
$user = get_userdata( $user_id );

$section_id = rand(0, 999);
$heading = get_sub_field('heading');
$content = get_sub_field('content');

?>
<!-- User Profile section -->
<section id="user-profile-section-<?php echo $section_id; ?>" class="user-profile-section">
    <div class="container">
        <?php if( is_user_logged_in() ) { ?>
            <div class="user-info">
                <h2>
                    <?php echo str_replace('{display_name}', $display_name, $heading); ?>
                </h2>

                <?php echo $content; ?>
            </div>

            <div class="user-profile">
                <form class="user-profile-form" action="" method="post">
                    <div class="loading-wrapper">
                        <div class="dv-spinner"></div>
                    </div>
                    <div class="form-field fname">
                        <label>First name *</label>
                        <input type="text" id="user_fname" name="user_fname" value="<?php echo esc_attr($first_name); ?>" required>
                    </div>

                    <div class="form-field lname">
                        <label>Last name *</label>
                        <input type="text" id="user_lname" name="user_lname" value="<?php echo esc_attr($last_name); ?>" required>
                    </div>

                    <div class="form-field email">
                        <label>Email *</label>
                        <input type="text" id="user_email" name="user_email" value="<?php echo esc_attr($user->user_email); ?>" required>
                    </div>

                    <div class="form-field url" style="display:none;">
                        <label>Website</label>
                        <input type="text" id="user_url" name="user_url" value="<?php echo esc_attr($user->user_url); ?>">
                    </div>

                    <div class="form-field desc">
                        <label>Description</label>
                        <textarea id="user_desc" name="user_desc" rows="4"><?php echo $description; ?></textarea>
                    </div>
                    
                    
                    <div class="form-field submit">
                        <input type="submit" value="Save all changes">
                    </div>
                </form>
            </div>
        <?php } else { ?>
            <div class="user-message">
                <h3>Member Area Login</h3>
                <p>Please login to enjoy your exclusive member area!</p>
                <button id="btn-member-login" aria-expanded="false" aria-controls="members-login-area">
                    <span>Member Login</span>
                </button>
            </div>
        <?php } ?>
    </div>
</section><!-- .User Profile section -->

<?php 
$bg_color = get_sub_field('background_color');
$bg_color = !empty($bg_color) ? $bg_color : '#fff';
$pd_top = get_sub_field('padding_top');
$pd_top = (isset($pd_top) && $pd_top !== '') ? $pd_top . 'px' : '60px';
$pd_bottom = get_sub_field('padding_bottom');
$pd_bottom = (isset($pd_bottom) && $pd_bottom !== '') ? $pd_bottom . 'px' : '60px';

echo '<style>
        #user-profile-section-'. $section_id .' {
            --s-bg-color: ' . $bg_color . ';
            --s-pd-top: ' . $pd_top . ';
            --s-pd-bottom: ' . $pd_bottom . ';
        }
    </style>';