# Diabetes Victoria Membership System (JavaScript-Only)

## Overview

The updated membership system now performs membership lookup directly from URL parameters passed by Salesforce using **JavaScript-only** logic. This eliminates the need for additional API calls and provides faster authentication with better user experience.

## How It Works

### 1. Salesforce Redirect with Membership Data
When users complete authentication with Salesforce, they are redirected back to WordPress with membership data directly in the URL:

```
https://dvicstg.wpenginepowered.com/members-hub?
  RecordTypeId=01290000000G5VKAA0
  &DA_Member_Type__c=Paid
  &DA_Membership_Type__c=Full
  &Membership_Expiry_Date__pc=18122027
  &DA_Expiry_after_grace_period__c=18012028
```

### 2. JavaScript Processing
The system uses JavaScript to:
- Extract membership data from URL parameters
- Validate the data format and values
- Store membership data in cookies and localStorage
- Determine membership tier based on data
- Redirect users to appropriate pages

### 3. Membership Data Parameters
The system processes these URL parameters:
- `RecordTypeId`: Member record type (e.g., "01290000000G5VKAA0")
- `DA_Member_Type__c`: Paid or Free
- `DA_Membership_Type__c`: Full, Family, Concession, Student, Senior
- `Membership_Expiry_Date__pc`: Expiry date (DDMMYYYY format or "NA")
- `DA_Expiry_after_grace_period__c`: Grace period expiry (DDMMYYYY format or "NA")

### 4. Membership Tiers
The system categorizes users into four tiers:
- **`full`**: Paid members with active membership
- **`free`**: Free members with active membership  
- **`expired`**: Members whose grace period has expired or "NA" dates
- **`none`**: Non-members or invalid data

### 5. Redirect Logic
Based on membership status, users are redirected to:
- **Full Members**: `/members-hub/` (access to all member content)
- **Free Members**: `/members-hub-free-test/` (limited access)
- **Expired Members**: `/renew-membership/` (renewal required)
- **Non-Members**: `/join-membership/` (join required)

## Security Features

### 1. Data Validation
- Validates all required parameters are present
- Checks member type against allowed values
- Validates membership type against allowed values
- Validates date format (DDMMYYYY)

### 2. Session Management
- Stores membership data in both session and encrypted cookies
- 30-day cookie expiration
- Automatic session cleanup on logout

### 3. Content Protection
- Server-side validation prevents unauthorized access
- Even if users bookmark protected pages, access is denied without valid membership
- Different access levels for different content types

## Usage Examples

### Protecting Content in Templates
```php
// Check if user can access full member content
if (dv_user_can_access_content('full')) {
    // Show full member content
}

// Check if user can access any member content
if (dv_user_can_access_content('any')) {
    // Show member content
}

// Redirect if no access
dv_redirect_if_no_access('full', 'current-page-slug');
```

### JavaScript Integration
The system automatically provides membership data to JavaScript:
```javascript
// Access membership tier
console.log(member_login_data.userMembershipTier); // 'full', 'free', 'expired', 'none'

// Access membership data
console.log(member_login_data.membershipData);
```

## Configuration

### Required ACF Fields
Ensure these fields are configured in ACF Options:
- `salesforce_client_id`
- `salesforce_callback_url`
- `salesforce_community_url`
- `member_login` (with `login_page` subfield)
- `member_logged_in` (with `member_page` subfield)

### Page Requirements
Create these pages for proper redirects:
- `/member-login/` - Login page
- `/members-hub/` - Full member hub
- `/members-hub-free-test/` - Free member hub
- `/renew-membership/` - Renewal page
- `/join-membership/` - Join page
- `/member-login-error/` - Error page

## Error Handling

### Invalid Membership Data
If membership data is invalid or missing:
- User is redirected to `/member-login-error/`
- Error page explains the issue
- Provides options to try again or contact support

### Expired Memberships
- Users are redirected to renewal page
- Grace period logic is applied
- Clear messaging about membership status

## Testing

### Test Scenarios
1. **Full Member**: Should access all member content
2. **Free Member**: Should only access free member content
3. **Expired Member**: Should be redirected to renewal
4. **Non-Member**: Should be redirected to join page
5. **Invalid Data**: Should see error page

### URL Testing
Test with different URL parameters:
```
// Full member
?code=123&sfdc_community_url=test&RecordTypeId=DA VIC Member&DA_Member_Type__c=Paid&DA_Membership_Type__c=Full&Membership_Expiry_Date__pc=18122027&DA_Expiry_after_grace_period__c=18012028

// Free member
?code=123&sfdc_community_url=test&RecordTypeId=DA VIC Member&DA_Member_Type__c=Free&DA_Membership_Type__c=Student&Membership_Expiry_Date__pc=18122027&DA_Expiry_after_grace_period__c=18012028

// Expired member
?code=123&sfdc_community_url=test&RecordTypeId=DA VIC Member&DA_Member_Type__c=Paid&DA_Membership_Type__c=Full&Membership_Expiry_Date__pc=01012020&DA_Expiry_after_grace_period__c=01012020
```

## Troubleshooting

### Common Issues
1. **Missing Parameters**: Check Salesforce configuration
2. **Invalid Dates**: Ensure DDMMYYYY format
3. **Cookie Issues**: Check browser settings and domain configuration
4. **Redirect Loops**: Verify page URLs exist

### Debug Mode
Add this to wp-config.php for debugging:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

Check `/wp-content/debug.log` for error messages.

## Migration Notes

### From Old System
- Old `sf_auth_code` cookie is still supported
- New `dv_membership_data` cookie stores additional data
- Both systems work together during transition

### Backward Compatibility
- Existing logged-in users continue to work
- New login flow uses enhanced system
- Gradual migration is supported
