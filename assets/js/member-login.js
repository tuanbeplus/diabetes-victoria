jQuery(document).ready(function ($) {
    // Prepare member login data
    const {
        isMemberContent,
        isSearchPage,
        memberHubLink,
        memberLoginLink,
        siteHomeUrl,
        postTypeName,
        contentForMemberType
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
                return memberHubLink;
            case 'free':
                return siteHomeUrl + '/members-hub-free-test/';
            case 'expired':
                return siteHomeUrl + '/renew-membership/';
            case 'none':
            default:
                return siteHomeUrl + '/join-membership/';
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
            
            // Determine membership tier and redirect
            const membershipTier = determineMembershipTier(memberData);
            const redirectUrl = determineRedirectUrl(membershipTier);
            
            // Redirect to appropriate page
            window.location.href = redirectUrl;
            return;
        }
        
        // Check membership access based on stored data
        let storedMembershipData = getStoredMembershipData();
        let hasStoredMembership = !!storedMembershipData;
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
                window.location.href = memberLoginLink;
                return;
            }
            // Logged in but tier invalid/none/expired
            if (currentMembershipTier === 'none' || currentMembershipTier === 'expired') {
                if (currentMembershipTier === 'expired') {
                    window.location.href = siteHomeUrl + '/renew-membership/';
                } else {
                    // Already logged in but no membership → join
                    window.location.href = siteHomeUrl + '/join-membership/';
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
                window.location.href = siteHomeUrl + '/members-hub-free-test/';
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
                window.location.href = memberLoginLink;
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
        let currentMembershipTier = hasStoredMembership ? determineMembershipTier(storedMembershipData) : 'none';
        
        // Not logged in yet → show Member Login
        if (!hasStoredMembership) {
            button.html('<span>Member Login</span>')
            button.attr('href', memberLoginLink)
        }
        // Exist Cookie and membership data
        else {
            // Show different text based on membership tier
            let buttonText = 'My Membership';
            let buttonUrl = memberHubLink;
            
            if (currentMembershipTier === 'none') {
                buttonText = 'Join Membership';
                buttonUrl = siteHomeUrl + '/join-membership/';
            } else 
            if (currentMembershipTier === 'expired') {
                buttonText = 'Renew Membership';
                buttonUrl = siteHomeUrl + '/renew-membership/';
            } else if (currentMembershipTier === 'free') {
                buttonText = 'Free Member Hub';
                buttonUrl = siteHomeUrl + '/members-hub-free-test/';
            } else if (currentMembershipTier === 'full') {
                buttonText = 'My Membership';
                buttonUrl = memberHubLink;
            }
            
            button.html('<span>' + buttonText + '</span>')
            button.attr('href', buttonUrl)
        }
    });
    
    // Show/hide button member logout
    $('.btn-member-logout').each(function() {
        let button = $(this)
        let hasMembership = !!getStoredMembershipData();
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