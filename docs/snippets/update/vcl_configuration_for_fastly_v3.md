If you use Fastly, deploy the most up-to-date VCL configuration.

Locate the `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_main.vcl` file, make sure that it has been updated with the following changes, and upload it to your Fastly:

- Add the following lines:

``` vcl
if (req.restarts == 0 && resp.status == 301 && req.http.x-fos-original-url) {
    set resp.http.location = regsub(resp.http.location, "/_fos_user_context_hash", req.http.x-fos-original-url);
}
```

- Move the `#FASTLY recv` macro call to a new location, right after the `Preserve X-Forwarded-For in all requests` section.
