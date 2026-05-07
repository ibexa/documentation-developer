---
description: Recommendations for validating Fastly across development, update, and production.
month_change: yes
---

# Best practices for testing and updating Fastly

You can use Fastly in caching, performance, and request handling in [[= product_name =]] on-premise environments.
However, it also introduces a dependency layer that can surface issues that impact authentication and caching behavior only in environments where it is enabled.

Usually, Fastly isn't used during development, which means configuration or behavior mismatches are often discovered during staging or production rollout.
To avoid production issues, ensure Fastly is included in development and staging workflows, and validate configuration changes thoroughly before moving to production.

This guide explains how to:

- Use Fastly safely during development and testing
- Upgrade Fastly configuration for [[= product_name =]] v5.0
- Identify and avoid common pitfalls
- Validate your setup before going to production

For detailed configuration steps, VCL structure, and CLI usage, [Configure and customize Fastly](https://doc.ibexa.co/en/5.0/infrastructure_and_maintenance/cache/http_cache/fastly/#configure-and-customize-fastly).

## Use Fastly during development and testing

Fastly behaves as an application layer in front of [[= product_name =]].
Because of this, caching rules, cookie handling, authentication flows may behave differently compared to a direct origin setup.

Introducing Fastly only in production may cause issues to surface at a late stage.

### Recommended testing approaches

Depending on your infrastructure, you can:

- Use a dedicated Fastly service for non-production environments
- Connect staging environments to a controlled Fastly configuration
- Use DDEV-based setups when applicable

For DDEV integration setup details, see [Fastly integration with DDEV environments](https://doc.ibexa.co/en/5.0/infrastructure_and_maintenance/clustering/clustering_with_ddev/#fastly).

#### What to validate early

When you enable Fastly in non-production environments, focus on testing the core authentication and caching behaviors, as outlined in the [Pre-production checklist](#preproduction-checklist) to identify configuration mismatches before they reach the staging phase.

### Simulate Fastly in deployment

Because Fastly can't be fully reproduced locally, you could use a simulation strategy to catch configuration mismatches early:

#### Stage 1: Local smoke testing with DDEV & Varnish

Fastly is built on Varnish, therefore you could use the DDEV Varnish integration to catch raw VCL, caching header, and session cookie issues locally:

1. Enable the Varnish service in DDEV:

    `ddev get ddev/ddev-varnish`

1. Use the [[= product_name =]] v5.0 Varnish VCL [base configuration](https://github.com/ibexa/http-cache/blob/v[[= latest_tag_5_0 =]]/docs/varnish/vcl/varnish7.vcl) as your local proxy.
1. Test authentication, back office operations, and session persistence.

This stage helps identify low-level caching and cookie handling issues early.

#### Stage 2: Staging with temporary Fastly domains

Before you move on to production, clone your production Fastly service to validate the infrastructure layer safely:

1. Clone the service: In the Fastly UI, clone your active production service to create a temporary, test version.
1. Reconfigure origins: Point the backend to your staging environment instead of production.
1. Configure temporary domains: Use a temporary Fastly-provided domain, for example, `staging-yourdomain.global.ssl.fastly.net`, or a dedicated test subdomain.
1. Run validation: Access the staging site through the Fastly URL and verify header handling, cookie behavior, session persistence and back office functionality.

This stage allows you to test real Fastly behavior safely before moving to production.

## Update Fastly configuration safely

When you upgrade [[= product_name =]], do not reuse legacy VCL files.
Always start from the new default Fastly configuration for the target version, and carefully review your Fastly configuration customizations as you reapply them, because changes between versions may affect authentication and caching behavior.

Focus on session and authentication handling, cookie-based logic, cache bypass rules, and header manipulation rules. Even small changes in these areas can affect login behavior or cache correctness.

## Common Fastly issues during update

The following issues may appear when Fastly is used as the view cache for [[= product_name =]] and you perform an update.

| Issue | Symptoms | Common causes | Recommendation areas |
|------|----------|---------------|-------|
| Authentication and session issues | - Back office login fails<br>- Users are logged out unexpectedly<br>- Sessions are not persistent | - Session cookie name prefix changes break VCL rules<br>- VCL still references outdated cookie identifiers<br>- Cookie filtering removes required authentication cookies | Cookie and session handling |
| Incorrect caching behavior | - Logged-in users see cached anonymous content<br>- Personalized content leaks between users | - Missing cache bypass rules for authenticated requests<br>- Incorrect cache key variation<br>- Cookies not properly considered in cache logic | Caching strategy + Cookie and session handling |
| Over-aggressive cache bypass | - Low cache hit ratio<br>- Unexpected cache misses | - Too many cookies forwarded to backend<br>- Broad “pass” rules triggered too often | Caching strategy |
| Environment mismatch issues | - Works in dev, fails in staging/production<br>- Issues only appear when Fastly is enabled | - Fastly not part of development setup<br>- Differences in configuration between environments | Configuration strategy |

To mitigate these issues, follow these recommendations and best practices:

#### Cookie and session handling

The session cookie name prefix changed from `eZSESSID{...}` in earlier versions to `IBX_SESSION_ID{...}` in v5.0, while remaining SiteAccess-specific.
This change can break VCL rules that rely on fixed cookie name patterns.

- Ensure required authentication cookies are not stripped.
- Validate that session cookies correctly trigger cache bypass where needed.
- Review all cookie-based conditions in VCL and update outdated cookie references.
- Avoid relying on exact cookie names. Use pattern matching where possible to reduce the impact of cookie naming changes.
- Consider temporary support for both old and new cookie identifiers during transition.

For example:

```vcl
# Old logic (hardcoded full cookie name or outdated prefix)
if (req.http.Cookie ~ "eZSESSID") {
    return(pass);
}

# New logic (broader session detection pattern)
if (req.http.Cookie ~ "(IBX_SESSION_ID|eZSESSID)") {
    return(pass);
}
```

#### Caching strategy

- Clearly separate anonymous cacheable content and authenticated/non-cacheable content.
- Keep caching rules explicit and minimal.
- Avoid unintended caching of personalized responses.

#### Configuration strategy

- Always base configuration on official defaults.
- Do not carry forward legacy VCL unchanged.
- Ensure Fastly is included in a non-production environment. 

For more information about configuration management, see [List and manage Fastly configuration versions](fastly.md#list-configuration-versions).

## Pre–production checklist

Before you deploy [[= product_name =]] with Fastly enabled in production, verify the following:

- Environment validation:
    - Fastly is enabled in staging/pre-production.
    - No Fastly-related errors appear in logs.

- Fastly configuration:
    - Configuration is based on v5.0 defaults.
    - All customizations have been reviewed and reapplied.
    - No outdated VCL logic remains.

- Authentication and sessions:
    - Back office login works through Fastly.
    - Session persistence behaves correctly.
    - Logout invalidates sessions properly.

- Caching behavior:
    - Anonymous pages are cached correctly.
    - Authenticated users bypass cache where required.
    - No cross-user content leakage occurs.

- Functional validation:
    - Key user journeys are tested with Fastly enabled.
    - Behavior matches origin-only setup where expected.
