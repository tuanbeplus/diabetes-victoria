jQuery(document).ready(function ($) {
    // Prepare member login data
    const {
        isMemberContent,
        isSearchPage,
        memberHubLink,
        memberLoginLink,
        sfCommunityUrl,
        siteHomeUrl,
        postTypeName
    } = member_login_data;

    // Function to set a cookie
    function setCookie(name, value, days) {
        // If the value is an empty string or not a string -> do not set the cookie
        if (typeof value !== 'string' || value.trim() === '') {
            return false;
        }
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        // Set the cookie
        document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
        // Verify if the cookie was successfully set
        return document.cookie.indexOf(name + "=" + encodeURIComponent(value)) !== -1;
    }

    // Function to get a cookie value by name
    function getCookie(name) {
        var nameEQ = name + "=";
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1);
            }
            if (cookie.indexOf(nameEQ) === 0) {
                return cookie.substring(nameEQ.length, cookie.length);
            }
        }
        return null;
    }

    // Function to reset (delete) a cookie
    function resetCookie(name) {
        // Set the cookie with a past expiration date to delete it
        document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/;";
        // Verify if the cookie was successfully deleted
        return document.cookie.indexOf(name + "=") === -1;
    }

    // Function to get a URL parameter by name
    function getUrlParameter(name) {
        var regex = new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)');
        var results = regex.exec(window.location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    $(function() {
        // Get params on URL
        let searchKey = getUrlParameter("s") 
        let errorName = getUrlParameter("error")
        let errorDesc = getUrlParameter("error_description")
        let responseCode = getUrlParameter("code")
        let communityUrl = getUrlParameter("sfdc_community_url")
        let overlay = $('.member-login-overlay')

        // Handle Errors
        if (errorName && errorDesc) {
            // Show the loading overlay
            overlay.show()
            if (confirm('Error: Unable to login. Please try again.')) {
                window.location.href = memberLoginLink;
                return;
            }
            else {
                window.location.href = siteHomeUrl;
                return;
            }
        }

        if (responseCode && communityUrl) {
            // Show the loading overlay
            overlay.show()
            // Set member cookie
            let isCookieSet = setCookie('sf_auth_code', responseCode, 1);
            if (isCookieSet) {
                // Redirect to pre page 
                window.location.href = localStorage.dv_redirect_url ? localStorage.dv_redirect_url : siteHomeUrl;
                return;
            }
        }

        // Redirect to Sign In page if not member logged in
        let authCodeCookie = getCookie("sf_auth_code");
        if (isMemberContent == true || postTypeName == 'resource' || postTypeName == 'member_recipes') {
            // Return if is seach page
            if (isSearchPage || searchKey) {
                overlay.hide()
                return;
            }
            // Not exist Cookie
            if (!authCodeCookie || authCodeCookie.trim() === '') {
                window.location.href = memberLoginLink;
                return;
            }
            // Exist Cookie
            else {
                if (responseCode && communityUrl) {
                    overlay.show()
                }
                else {
                    overlay.hide()
                }
            }
        }
        else {
            overlay.hide()
        }
    });

    // Show/hide button member login, membership
    $('.btn-member-login').each(function() {
        let button = $(this)
        let authCode = getCookie("sf_auth_code");
        
        // Not exist Cookie
        if (!authCode || authCode.trim() === '') {
            button.html('<span>Member Login<span>')
            button.attr('href', memberLoginLink)
        }
        // Exist Cookie
        else {
            button.html('<span>My Membership<span>')
            button.attr('href', memberHubLink)
        }
    });
    
    // Show/hide button member logout
    $('.btn-member-logout').each(function() {
        let button = $(this)
        let authCode = getCookie("sf_auth_code");
        
        // Not exist Cookie
        if (!authCode || authCode.trim() === '') {
            button.hide()
        }
        // Exist Cookie
        else {
            button.show()
        }
    });

    // Click to member logout button
    $(document).on('click', '.btn-member-logout', function(e) {
        e.preventDefault()
        if (confirm('Are you sure you want to log out?')) {
            // Delete member cookie
            let isCookieDeleted = resetCookie("sf_auth_code");
            if (isCookieDeleted) {
                // Redirect to home page
                window.location.href = siteHomeUrl;
                return;
            }
            else {
                alert('Error: Unable to log out. Please try again.');
            }
        }
    });        

});