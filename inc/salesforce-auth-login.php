<?php

function dv_base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function generateCodeVerifier() {
    return dv_base64url_encode(random_bytes(64)); // Example with a 64-byte random string
}

function generateCodeChallenge($code_verifier) {
    return dv_base64url_encode(hash('sha256', $code_verifier, true));
}

// Get the Code Verifier and Code Challenge
function dv_get_code_challenge_verifier() {
    $code_challenge_verifier = array();
    $codeVerifier = generateCodeVerifier(128);
    $codeChallenge = generateCodeChallenge($codeVerifier);

    $code_challenge_verifier['code_challenge'] = htmlspecialchars($codeChallenge, ENT_QUOTES, 'UTF-8');
    $code_challenge_verifier['code_verifier'] = htmlspecialchars($codeVerifier, ENT_QUOTES, 'UTF-8');

    return $code_challenge_verifier;
}


function dv_get_salesforce_user_access_token($authorization_code) {
    $sf_client_id = get_field('salesforce_client_id', 'option');
    $sf_client_secret = get_field('salesforce_client_secret', 'option');
    $sf_callback_url = get_field('salesforce_callback_url', 'option');
    $sf_community_url = get_field('salesforce_community_url', 'option');
    $code_verifier = dv_get_code_challenge_verifier()['code_verifier'] ?? '';
    // Salesforce Token URL
    $token_url = $sf_community_url .'/forms/services/oauth2/token';

    // Setup the request body
    $body = array(
        'grant_type'    => 'authorization_code',
        'client_id'     => $sf_client_id,
        'client_secret' => $sf_client_secret,
        'redirect_uri'  => $sf_callback_url,
        'code'          => $authorization_code,
        'code_verifier' => $code_verifier,
    );

    // Make the POST request to Salesforce to exchange the authorization code for an access token
    $response = wp_remote_post($token_url, array(
        'body' => $body,
    ));

    // Check for errors
    if (is_wp_error($response)) {
        return 'Request failed: ' . $response->get_error_message();
    }

    // Retrieve and decode the response body
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return $data;
}

// Logging functions for member login history
function dv_ensure_members_login_directory() {
    $upload_dir = wp_upload_dir();
    $members_login_dir = $upload_dir['basedir'] . '/members-login/';
    
    if (!file_exists($members_login_dir)) {
        wp_mkdir_p($members_login_dir);
    }
    
    return $members_login_dir;
}

function dv_log_member_login($login_params, $login_status = 'success') {
    try {
        $members_login_dir = dv_ensure_members_login_directory();
        
        // Create filename with current month and year (m-Y format)
        $filename = 'members-login-' . date('m-Y') . '.log';
        $log_file = $members_login_dir . $filename;
        
        // Prepare log entry
        $timestamp = date('d-m-Y H:i:s');
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        // Format the log entry with params before IP
        $log_entry = sprintf(
            "[%s] Status: %s | Params: %s | IP: %s | User-Agent: %s\n",
            $timestamp,
            $login_status,
            json_encode($login_params, JSON_UNESCAPED_SLASHES),
            $ip_address,
            $user_agent
        );
        
        // Write to log file
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
        
        return true;
    } catch (Exception $e) {
        error_log('Failed to log member login: ' . $e->getMessage());
        return false;
    }
}

function dv_extract_and_log_membership_params($login_status = 'success') {
    // Extract membership parameters from URL
    $membership_params = array(
        'RecordTypeId' => $_GET['RecordTypeId'] ?? '',
        'DA_Member_Type__c' => $_GET['DA_Member_Type__c'] ?? '',
        'DA_Membership_Type__c' => $_GET['DA_Membership_Type__c'] ?? '',
        'Membership_Expiry_Date__pc' => $_GET['Membership_Expiry_Date__pc'] ?? '',
        'DA_Expiry_after_grace_period__c' => $_GET['DA_Expiry_after_grace_period__c'] ?? '',
        'current_url' => $_SERVER['REQUEST_URI'] ?? '',
        'referrer' => $_SERVER['HTTP_REFERER'] ?? ''
    );
    
    // Only log if we have membership parameters
    if (!empty($membership_params['RecordTypeId']) || 
        !empty($membership_params['DA_Member_Type__c']) || 
        !empty($membership_params['DA_Membership_Type__c'])) {
        
        dv_log_member_login($membership_params, $login_status);
    }
    
    return $membership_params;
}

// Hook to automatically log membership parameters when they're present in the URL
add_action('init', function() {
    // Only log on frontend and if membership parameters are present
    if (!is_admin() && (
        !empty($_GET['RecordTypeId']) || 
        !empty($_GET['DA_Member_Type__c']) || 
        !empty($_GET['DA_Membership_Type__c'])
    )) {
        dv_extract_and_log_membership_params();
    }
});
