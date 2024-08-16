<?php
/*
* Template Name: Members Login
*/

$sf_client_id = get_field('salesforce_client_id', 'option');
$sf_callback_url = get_field('salesforce_callback_url', 'option');
$sf_community_url = get_field('salesforce_community_url', 'option');
$code_challenge = dv_get_code_challenge_verifier()['code_challenge'] ?? '';
$code_verifier = dv_get_code_challenge_verifier()['code_verifier'] ?? '';

$login_url  = $sf_community_url .'/supporterportalauth/services/oauth2/authorize';
$login_url .= '?client_id='. $sf_client_id;
$login_url .= '&redirect_uri='. $sf_callback_url;
$login_url .= '&response_type=code';
$login_url .= '&code_challenge='. $code_challenge;
$login_url .= '&code_challenge_method=S256';
$login_url .= '&prompt=login';
?>
<script>
    if (localStorage) {
        localStorage.setItem('code_challenge', '<?php echo $code_challenge ?>');
        localStorage.setItem('code_verifier', '<?php echo $code_verifier ?>');
    }
</script>
<?php 
wp_redirect($login_url); 
exit;
?>