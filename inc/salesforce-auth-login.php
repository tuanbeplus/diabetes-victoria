<?php
// ------------------------------
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
