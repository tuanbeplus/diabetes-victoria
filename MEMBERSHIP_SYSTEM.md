# Diabetes Victoria Membership System (JavaScript-only)

## Overview

The membership flow is entirely client-side. Salesforce redirects back to the site with membership data in URL parameters. JavaScript reads those parameters, validates and stores them in `localStorage`, determines the membership tier, and redirects accordingly. WordPress templates rely on the stored data to protect content on the client-side.

No PHP-based processing, sessions, or cookies are used for this feature.

## Flow

1) Salesforce redirects back with membership params in the URL.
2) JS extracts params, validates, stores to `localStorage` as `dv_membership_data`.
3) JS determines tier: `full`, `free`, `expired`, `none`.
4) If a pre-login target URL exists in `localStorage` (`dv_redirect_url`) and the user has permission, redirect to that URL; otherwise use default tier redirects.
5) On every page load, JS enforces access rules and updates the header button.

## URL Parameters

Required parameters passed by Salesforce in the redirect URL:
- `RecordTypeId`
- `DA_Member_Type__c` (Paid|Free)
- `DA_Membership_Type__c` (e.g. Full, Family, Concession, Student, Senior, Free Ongoing, etc.)
- `Membership_Expiry_Date__pc` (DDMMYYYY or "NA")
- `DA_Expiry_after_grace_period__c` (DDMMYYYY or "NA")

Notes:
- `DA_Membership_Type__c` is accepted as any non-empty string.
- Dates may be "NA"; these are treated as invalid/expired.

## LocalStorage

Data is stored under `dv_membership_data` as JSON:
```json
{
  "recordTypeId": "...",
  "memberType": "Paid|Free",
  "membershipType": "Full|Free Ongoing|...",
  "expiryDate": "DDMMYYYY|NA",
  "gracePeriodDate": "DDMMYYYY|NA"
}
```

When a non-logged-in user attempts to access member content, the intended URL is stored as `dv_redirect_url` and used post-login to return the user to the original page if permitted.

## Membership Tier Determination

Tier is computed client-side:
- `expired`: If `gracePeriodDate` is in the past, or any relevant date is "NA".
- `full`: `memberType` is `Paid` and not expired.
- `free`: `memberType` is `Free` and not expired.
- `none`: Anything else (missing/invalid data).

## Redirects After Login

On successful parsing of URL parameters:
- If `dv_redirect_url` exists and the user has permission, redirect there and clear the key.
- Otherwise, redirect by tier using ACF-configured URLs:
  - `full` → `members_hub`
  - `free` → `members_hub_free`
  - `expired` → `renew_membership`
  - `none` → `join_membership`

## Access Control (Client-side)

On page load, JS enforces access rules:
- If the page is member content (`member_content` meta true) or is a member post type:
  - If no stored membership → redirect to `members_login` and set `dv_redirect_url` to the current page.
  - If tier is `none` → redirect to `join_membership`.
  - If tier is `expired` → redirect to `renew_membership`.
  - If tier is `free` and the site-wide ACF option `content_for_member_type` is `full_member_only` → redirect to `members_hub_free`.

Additional allowances:
- Free members may access `member_recipes` and `resource` post types (still respecting the site-wide `content_for_member_type` option).

## ACF Configuration

All URLs and button texts come from ACF Options and are localized to JS (each with `{ text, url }`):
- `members_login`
- `members_sign_up`
- `members_hub`
- `members_hub_free`
- `renew_membership`
- `join_membership`

There is also a site-wide option:
- `content_for_member_type` with values `full_member_only` or `full_and_free_member` (default `full_and_free_member`).

## Header Button Logic (Client-side)

The header button (`.btn-member-login`) updates by tier:
- No stored membership: show `members_login.text`, link to `members_login.url`.
- Tier `none`: show `join_membership.text`, link to `join_membership.url`.
- Tier `expired`: show `renew_membership.text`, link to `renew_membership.url`.
- Tier `free`: show `members_hub_free.text`, link to `members_hub_free.url`.
- Tier `full`: show `members_hub.text`, link to `members_hub.url`.

The logout button (`.btn-member-logout`) is visible when membership data exists. Clicking it clears `dv_membership_data` and `dv_redirect_url`.

## Security Considerations

- Parameters are trusted to come from Salesforce but should ideally be verified with a signature/nonce. This has been acknowledged but is not implemented yet.
- All logic is client-side. Avoid exposing sensitive info in the URL beyond what is required.

## Testing

Example URLs:
```
// Full member
?RecordTypeId=01290000000G5VKAA0&DA_Member_Type__c=Paid&DA_Membership_Type__c=Full&Membership_Expiry_Date__pc=18122027&DA_Expiry_after_grace_period__c=18012028

// Free member (Free Ongoing)
?RecordTypeId=01290000000G5VKAA0&DA_Member_Type__c=Free&DA_Membership_Type__c=Free%20Ongoing&Membership_Expiry_Date__pc=10112027&DA_Expiry_after_grace_period__c=10112027

// Expired
?RecordTypeId=01290000000G5VKAA0&DA_Member_Type__c=Paid&DA_Membership_Type__c=Full&Membership_Expiry_Date__pc=01012020&DA_Expiry_after_grace_period__c=01012020

// None (invalid/missing params)
?RecordTypeId=&DA_Member_Type__c=&DA_Membership_Type__c=&Membership_Expiry_Date__pc=NA&DA_Expiry_after_grace_period__c=NA
```

Scenarios to verify:
1) Redirect-back: visit protected page while not logged in → login → return to original URL if permitted.
2) Free vs full: free users blocked only when `content_for_member_type` is `full_member_only`.
3) Post types: free users can access `member_recipes` and `resource`.
4) Expired users always sent to `renew_membership`.
5) None users sent to `join_membership`; header shows Join Membership.

## Troubleshooting

- No redirect-back: ensure `dv_redirect_url` is set when redirecting unauthenticated users to login.
- Free user blocked unexpectedly: check `content_for_member_type` ACF option.
- Incorrect redirects: verify the ACF URL fields are populated and localized to JS.
- Date parsing: confirm DDMMYYYY format; "NA" will mark the membership as expired.
