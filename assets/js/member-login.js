jQuery(document).ready(function ($) {
    // Prepare member login data
    const {
        isMemberContent,
        isSearchPage,
        siteHomeUrl,
        postTypeName,
        contentForMemberType,
        // New ACF field data
        membersLogin,
        membersSignUp,
        membersHub,
        membersHubFree,
        renewMembership,
        joinMembership,
        // Fallback URLs for backward compatibility
        memberHubLink,
        memberLoginLink,
        memberHubFreeLink,
        renewMembershipLink,
        joinMembershipLink
    } = member_login_data;

    // Function to validate membership data from URL
    function validateMembershipData(memberData) {
        if (!memberData.recordTypeId || !memberData.memberType || !memberData.membershipType) {
            return false;
        }
        // Check if dates are valid (not "NA")
        if (memberData.expiryDate === "NA" || memberData.gracePeriodDate === "NA") {
            return false;
        }
        // Validate member type
        const validMemberTypes = ['Paid', 'Free'];
        if (!validMemberTypes.includes(memberData.memberType)) {
            return false;
        }
        // Validate membership type: accept any non-empty string (e.g. "Free Ongoing")
        if (typeof memberData.membershipType !== 'string' || memberData.membershipType.trim() === '') {
            return false;
        }
        return true;
    }

    // Function to determine membership tier
    function determineMembershipTier(memberData) {
        if (!memberData || !validateMembershipData(memberData)) {
            return 'none';
        }
        // Check if membership is expired
        if (isMembershipExpired(memberData.expiryDate, memberData.gracePeriodDate)) {
            return 'expired';
        }
        // Return tier based on member type
        return memberData.memberType === 'Paid' ? 'full' : 'free';
    }

    // Function to check if membership is expired
    function isMembershipExpired(expiryDate, gracePeriodDate) {
        if (expiryDate === "NA" || gracePeriodDate === "NA") {
            return true; // Consider NA as expired
        }
        const currentDate = new Date();
        const gracePeriodTimestamp = convertDateToTimestamp(gracePeriodDate);
        
        return currentDate.getTime() > gracePeriodTimestamp;
    }

    // Function to convert DDMMYYYY date to timestamp
    function convertDateToTimestamp(dateStr) {
        if (dateStr.length !== 8) {
            return 0;
        }
        const day = parseInt(dateStr.substring(0, 2));
        const month = parseInt(dateStr.substring(2, 4)) - 1; // Month is 0-indexed
        const year = parseInt(dateStr.substring(4, 8));
        
        return new Date(year, month, day).getTime();
    }

    // Function to store membership data
    function storeMembershipData(memberData) {
        const membershipData = {
            recordTypeId: memberData.recordTypeId,
            memberType: memberData.memberType,
            membershipType: memberData.membershipType,
            expiryDate: memberData.expiryDate,
            gracePeriodDate: memberData.gracePeriodDate,
            timestamp: Date.now()
        };
        
        // Store in localStorage
        if (localStorage) {
            localStorage.setItem('dv_membership_data', JSON.stringify(membershipData));
        }
    }

    // Function to check if session has expired (1 day = 24 hours)
    function isSessionExpired(timestamp) {
        if (!timestamp) {
            return true;
        }
        const oneDayInMs = 24 * 60 * 60 * 1000; // 24 hours in milliseconds
        const currentTime = Date.now();
        return (currentTime - timestamp) > oneDayInMs;
    }

    // Function to clear expired session data
    function clearExpiredSession() {
        if (localStorage) {
            localStorage.removeItem('dv_membership_data');
            localStorage.removeItem('dv_redirect_url');
        }
    }

    // Function to get stored membership data
    function getStoredMembershipData() {
        if (localStorage) {
            try {
                const stored = localStorage.getItem('dv_membership_data');
                if (stored) {
                    return JSON.parse(stored);
                }
            } catch (e) {
                console.error('Error parsing membership data from localStorage:', e);
            }
        }
        return null;
    }

    // Function to determine redirect URL based on membership tier
    function determineRedirectUrl(membershipTier) {
        switch (membershipTier) {
            case 'full':
                return getAcfUrl(membersHub, memberHubLink);
            case 'free':
                return getAcfUrl(membersHubFree, memberHubFreeLink);
            case 'expired':
                return getAcfUrl(renewMembership, renewMembershipLink);
            case 'none':
            default:
                return getAcfUrl(joinMembership, joinMembershipLink);
        }
    }

    // Helper functions to get ACF field data
    function getAcfUrl(field, fallback) {
        return (field && field.url) ? field.url : fallback;
    }
    
    function getAcfText(field, fallback) {
        return (field && field.text) ? field.text : fallback;
    }

    // Function to check if user can access content based on membership tier and URL
    function canAccessContent(membershipTier, targetUrl) {
        // If no membership, can't access any member content
        if (membershipTier === 'none' || membershipTier === 'expired') {
            return false;
        }
        
        // Parse the target URL to check what type of content it is
        try {
            const url = new URL(targetUrl, window.location.origin);
            const pathname = url.pathname;
            
            // Check if it's a member content page based on URL patterns
            const isMemberContentPage = pathname.includes('/members-hub') || 
                pathname.includes('/member-') ||
                pathname.includes('/resource') ||
                pathname.includes('/member-recipes');
            
            if (!isMemberContentPage) {
                // Not a member content page, allow access
                return true;
            }
            
            // For member content pages, check tier restrictions
            if (membershipTier === 'free') {
                // Free members can access most content
                // The page-level access control will handle specific restrictions
                return true;
            } else if (membershipTier === 'full') {
                // Full members can access all content
                return true;
            }
            
            return false;
        } catch (e) {
            // If URL parsing fails, be conservative and deny access
            return false;
        }
    }

    // Function to get a URL parameter by name
    function getUrlParameter(name) {
        var regex = new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)');
        var results = regex.exec(window.location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    $(function() {
        // Get params on URL
        let searchKey = getUrlParameter("s");
        let errorName = getUrlParameter("error");
        let errorDesc = getUrlParameter("error_description");
        
        // New membership parameters
        let recordTypeId = getUrlParameter("RecordTypeId");
        let memberType = getUrlParameter("DA_Member_Type__c");
        let membershipType = getUrlParameter("DA_Membership_Type__c");
        let expiryDate = getUrlParameter("Membership_Expiry_Date__pc");
        let gracePeriodDate = getUrlParameter("DA_Expiry_after_grace_period__c");
        
        let overlay = $('.member-login-overlay');
        let redirectUrl = localStorage.getItem('dv_redirect_url');
        
        // Process membership data from URL if present
        if (recordTypeId && memberType && membershipType) {
            const memberData = {
                recordTypeId: recordTypeId,
                memberType: memberType,
                membershipType: membershipType,
                expiryDate: expiryDate,
                gracePeriodDate: gracePeriodDate
            };
            
            // Store membership data
            storeMembershipData(memberData);
            
            // Determine membership tier
            const membershipTier = determineMembershipTier(memberData);
            
            // Check if user has access to the originally intended content
            const originalUrl = localStorage.getItem('dv_redirect_url');
            if (originalUrl && canAccessContent(membershipTier, originalUrl)) {
                // User has permission, redirect to original content
                localStorage.removeItem('dv_redirect_url');
                window.location.href = originalUrl;
                return;
            } else {
                // No original URL or no permission, use standard redirect
                const redirectUrl = determineRedirectUrl(membershipTier);
                window.location.href = redirectUrl;
                return;
            }
        }
        
        // Check membership access based on stored data
        let storedMembershipData = getStoredMembershipData();
        let hasStoredMembership = !!storedMembershipData;
        
        // Check if session has expired (1 day)
        if (hasStoredMembership && storedMembershipData.timestamp) {
            if (isSessionExpired(storedMembershipData.timestamp)) {
                // Session expired, clear data and treat as not logged in
                clearExpiredSession();
                hasStoredMembership = false;
                storedMembershipData = null;
            }
        }
        
        let currentMembershipTier = hasStoredMembership ? determineMembershipTier(storedMembershipData) : 'none';
        let requiresMemberAccess = isMemberContent == true || postTypeName == 'resource' || postTypeName == 'member_recipes';
        
        if (requiresMemberAccess) {
            if (!isSearchPage && localStorage) {
                localStorage.setItem('dv_redirect_url', window.location.href);
            }
            
            // Return if is search page
            if (isSearchPage || searchKey) {
                overlay.hide()
                return;
            }
            
            // Check if user has membership session
            if (!hasStoredMembership) {
                // Not logged in yet → go to login page
                window.location.href = getAcfUrl(membersLogin, memberLoginLink);
                return;
            }
            // Logged in but tier invalid/none/expired
            if (currentMembershipTier === 'none' || currentMembershipTier === 'expired') {
                if (currentMembershipTier === 'expired') {
                    window.location.href = getAcfUrl(renewMembership, renewMembershipLink);
                } else {
                    // Already logged in but no membership → join
                    window.location.href = getAcfUrl(joinMembership, joinMembershipLink);
                }
                return;
            } 
            // Enforce ACF option for member-only pages
            else if (
                isMemberContent == true &&
                contentForMemberType === 'full_member_only' &&
                currentMembershipTier === 'free'
            ) {
                // Free members cannot access full-only content
                window.location.href = getAcfUrl(membersHubFree, memberHubFreeLink);
                return;
            } else {
                // Valid membership, hide overlay
                overlay.hide()
            }
        } else if (window.location.pathname === '/member-login/') {
            overlay.hide()
        } else {
            localStorage.removeItem('dv_redirect_url');
            overlay.hide()
        }
        // Handle Errors
        if (errorName && errorDesc) {
            // Show the loading overlay
            overlay.show()
            if (confirm('Error: Unable to login. Please try again.')) {
                window.location.href = getAcfUrl(membersLogin, memberLoginLink);
                return;
            }
            else {
                window.location.href = siteHomeUrl;
                return;
            }
        }

        // Note: OAuth "code" flow no longer used; URL carries membership params directly
    });

    // Show/hide button member login, membership
    $('.btn-member-login').each(function() {
        let button = $(this)
        let storedMembershipData = getStoredMembershipData();
        let hasStoredMembership = !!storedMembershipData;
        
        // Check if session has expired (1 day)
        if (hasStoredMembership && storedMembershipData.timestamp) {
            if (isSessionExpired(storedMembershipData.timestamp)) {
                // Session expired, clear data and treat as not logged in
                clearExpiredSession();
                hasStoredMembership = false;
                storedMembershipData = null;
            }
        }
        
        let currentMembershipTier = hasStoredMembership ? determineMembershipTier(storedMembershipData) : 'none';
        
        // Not logged in yet → show Member Login
        if (!hasStoredMembership) {
            const loginText = getAcfText(membersLogin, 'Member Login');
            const loginUrl = getAcfUrl(membersLogin, memberLoginLink);
            button.html('<span>' + loginText + '</span>')
            button.attr('href', loginUrl)
        }
        // Exist Cookie and membership data
        else {
            // Show different text based on membership tier
            let buttonText = getAcfText(membersHub, 'My Membership');
            let buttonUrl = getAcfUrl(membersHub, memberHubLink);
            
            if (currentMembershipTier === 'none') {
                buttonText = getAcfText(joinMembership, 'Join Membership');
                buttonUrl = getAcfUrl(joinMembership, joinMembershipLink);
            } else 
            if (currentMembershipTier === 'expired') {
                buttonText = getAcfText(renewMembership, 'Renew Membership');
                buttonUrl = getAcfUrl(renewMembership, renewMembershipLink);
            } else if (currentMembershipTier === 'free') {
                buttonText = getAcfText(membersHubFree, 'Free Member Hub');
                buttonUrl = getAcfUrl(membersHubFree, memberHubFreeLink);
            } else if (currentMembershipTier === 'full') {
                buttonText = getAcfText(membersHub, 'My Membership');
                buttonUrl = getAcfUrl(membersHub, memberHubLink);
            }
            
            button.html('<span>' + buttonText + '</span>')
            button.attr('href', buttonUrl)
        }
    });
    
    // Show/hide button member logout
    $('.btn-member-logout').each(function() {
        let button = $(this)
        let storedMembershipData = getStoredMembershipData();
        let hasMembership = !!storedMembershipData;
        
        // Check if session has expired (1 day)
        if (hasMembership && storedMembershipData.timestamp) {
            if (isSessionExpired(storedMembershipData.timestamp)) {
                // Session expired, clear data and treat as not logged in
                clearExpiredSession();
                hasMembership = false;
            }
        }
        
        if (!hasMembership) {
            button.hide()
        } else {
            button.show()
        }
    });

    // Click to member logout button
    $(document).on('click', '.btn-member-logout', function(e) {
        e.preventDefault()
        if (confirm('Are you sure you want to log out?')) {
            // Clear localStorage only
            if (localStorage) {
                localStorage.removeItem('dv_redirect_url');
                localStorage.removeItem('dv_membership_data');
            }
            // Redirect to home page
            window.location.href = siteHomeUrl;
            return;
        }
    });        

});