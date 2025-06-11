---
description: Configure Fastly for use with Ibexa DXP.
month_change: false
---

# Configure and customize Fastly

You can configure Fastly by using API calls or through the Fastly Web Interface.
Fastly provides a [Fastly CLI](https://www.fastly.com/documentation/reference/cli/) for configuring Fastly through its API.

[[= product_name_cloud =]] is delivered with Fastly preconfigured.
It means that you don't have to do any changes to the Fastly configuration to make your site work.
The information provided here is only applicable if you want to change the default Fastly configuration on [[= product_name_cloud =]], or if you're not using [[= product_name_cloud =]] and want to configure Fastly to work with [[= product_name =]] on premise.

!!! note "The Fastly Web Interface isn't available for [[= product_name_cloud =]]"
    It's recommend for [[= product_name_cloud =]] customers to use the Fastly CLI instead of using the Fastly API directly with `curl`, or other alternatives.

!!! note "Disable Varnish when you use Fastly"
    Varnish is automatically provisioned on [[= product_name_cloud =]]. Varnish needs to be disabled on all environments that use
    Fastly. See [documentation on how to do that](https://docs.platform.sh/guides/ibexa/fastly.html).

## Prepare for using Fastly locally

These steps aren't needed when you use [[= product_name_cloud =]], because Fastly is preconfigured in it.

### Get Fastly credentials from [[= product_name_cloud =]] installation

To use Fastly CLI or Fastly API directly, you need to obtain the credentials for your site.
To obtain the credentials, connect to your Fastly-enabled environment (for example, production or staging) through SSH and run the following command:

``` bash
declare|grep FASTLY
FASTLY_KEY=...
FASTLY_SERVICE_ID=...
```

These credentials are different for your production and staging environments.
When you configure the Fastly CLI, use the credentials for the environment that you want to change.

!!! note "Different environment variable names between products"
    When you configure Fastly CLI, you use the `FASTLY_API_TOKEN` variable to store the token, while with [[= product_name =]] you use `FASTLY_KEY` for the same purpose.

### Quickly configure Fastly for use with [[= product_name =]]

Use the commands below to install VCL configuration required for running Fastly with [[= product_name =]].
You also need to set up domains, HTTPS and origin configuration (not covered here).
All commands are explained in detail [below](#view-and-modify-vcl-configuration):

``` bash
fastly vcl custom create --name=ez_main.vcl --version=active --autoclone --content=vendor/ibexa/fastly/fastly/ez_main.vcl --main
fastly vcl custom create --name=ez_user_hash.vcl --content=vendor/ibexa/fastly/fastly/ez_user_hash.vcl --version=latest
fastly vcl snippet create --name="Re-Enable shielding on restart" --version=latest --priority 100 --type recv --content=vendor/ibexa/fastly/fastly/snippet_re_enable_shielding.vcl
fastly service-version activate --version=latest
```

## Quick introduction to Fastly CLI

Fastly configuration is versioned, which means that when you alter the configuration, you create a new version
and activate it.
If needed, you can revert the configuration to one of previous versions at any point.

### List configuration versions

``` bash hl_lines="10"
fastly service-version list
NUMBER  ACTIVE  LAST EDITED (UTC)
1       false   2023-07-03 10:01
2       false   2023-07-03 10:35
3       false   2023-07-03 11:00
4       false   2023-07-03 11:28
5       false   2023-07-03 10:58
6       false   2023-07-03 11:59
7       false   2023-07-03 12:13
8       true    2023-07-03 12:13
```

In the example above, version 8 is used (ACTIVE=true).

### Create new configuration version

A version that is ACTIVE cannot be modified. To change the configuration, you need to create a new version:

Clone the current active version:

``` bash
fastly service-version clone --version=active
```

Clone a particular version:

``` bash
fastly service-version clone --version=4
```

Clone the newest version:

``` bash
fastly service-version clone --version=latest
```

!!! note "Command parameters"
    Most Fastly CLI commands have the `--version` parameter.
    In addition to a specific version number, the `--version` parameter always supports aliases like `active` and `latest`.

    Most Fastly CLI commands that alter the config also support the `--autoclone` parameter.
    With such commands, when you use the `--autoclone` parameter, calling `fastly service-version clone` is no longer needed.

### Activate version

Activate a version with this command:

``` bash
fastly service-version activate --version=latest
```

## View and modify VCL configuration

Fastly configuration is stored in Varnish Configuration Language (VCL) files.
You can change the behaviour of Fastly by [uploading custom VCL files](https://docs.fastly.com/en/guides/uploading-custom-vcl).
[[= product_name =]] ships with two VCL files that need to be enabled for Fastly to work correctly with the platform; `ez_main.vcl` and `ez_user_hash.vcl` (located in `vendor/ibexa/fastly/fastly/`)

### List custom `.vcl` files for specific version

``` bash
fastly vcl custom list --version 77
SERVICE ID              VERSION  NAME              MAIN
4SEKDky8P3wdrctwZCi1C1  77       ez_main.vcl       true
4SEKDky8P3wdrctwZCi1C1  77       ez_user_hash.vcl  false
```

### Get `ez_main.vcl` for specific version

``` bash
fastly vcl custom describe --name=ez_main.vcl --version=77

Service ID: 4SEKDky8P3wdrctwZCi1C1
Service Version: 77

Name: ez_main.vcl
Main: true
Content:

include "ez_user_hash.vcl"

sub vcl_recv {
(....)
```

### Provide description for specific version

For each version, you can provide a description that explains what changed in that version:

``` bash
fastly service-version update --version=52 --comment="Added support for basic-auth on the staging domain"
```

#### List descriptions for all versions

You can list the descriptions by adding the `--verbose` (`-v`) option to the `service-version list` command:

``` bash
fastly service-version list -v

Fastly API token provided via FASTLY_API_TOKEN
Fastly API endpoint: https://api.fastly.com
Service ID (via FASTLY_SERVICE_ID): KlUh0J1fnw1JY1aEQ0up

Versions: 8
        Version 1/8
                Number: 1
                Comment: Initial config
                Service ID: KlUh0J1fnw1JY1aEQ0up
                Active: false
                Locked: true
                Deployed: false
                Staging: false
                Testing: false
                Created (UTC): 2023-07-03 08:50
                Last edited (UTC): 2023-07-03 10:01
        Version 2/8
                Number: 2
                Comment: Fixed name of origin
                Service ID: KlUh0J1fnw1JY1aEQ0up
                Active: false
                Locked: true
                Deployed: false
                Staging: false
                Testing: false
                Created (UTC): 2023-07-03 10:01
                Last edited (UTC): 2023-07-03 10:35
        (...)
```

### Modify Fastly configuration

You can modify the existing Fastly configuration, for example, by uploading a modified `.vcl` file.

Create a new version based on the one that is currently active, and upload the file:

``` bash
fastly vcl custom update --name=ez_main.vcl --version=active --autoclone --content=vendor/ibexa/fastly/fastly/ez_main.vcl
```

Provide a description of the change in Fastly's version system:

``` bash
fastly service-version update --version=latest --comment="Added feature X"
```

Activate the new version:

``` bash
fastly service-version activate --version=latest
```

## Snippets

You can also add VCL code to the Fastly configuration without modifying the custom `.vcl` files directly.
You do it by creating [snippets](https://docs.fastly.com/en/guides/about-vcl-snippets).
it's recommended that you use snippets instead of changing the VCL files provided by [[= product_name =]] as much as possible, which makes it easier to upgrade the [[= product_name =]] VCL configuration later.

When you use snippets, the snippet code is injected into the VCL where the `#FASTLY ...` macros are placed.
For example, if you create a snippet for the `recv` subroutine, it's injected into the `ez_main.vcl` file, the
line where `#FASTLY recv` is found.

### List available snippets for specific version

``` bash
fastly vcl snippet list --version=active
SERVICE ID              VERSION  NAME                            DYNAMIC  SNIPPET ID
KlUh0J1fnw1JY1aEQ0up    8        Re-Enable shielding on restart  false    1iJWIfsPLNGxcphsjggq
```

!!! note
    As of version 3.3.24, 4.1.6 and 4.2.0, [[= product_name =]] also requires one snippet to be installed, in addition to the custom VCLs `ez_main.vcl` and `ez_user_hash.vcl`. That snippet is by default named `Re-Enable shielding on restart`.

### Get details of installed snippets

Use the `vcl snippet list` command with the `--verbose` option to get information such as: priority, which subroutine it's attached to (for example, `vcl_recv` or `vcl_fetch`) and the code itself.

``` bash
fastly vcl snippet list --version=active -v
Fastly API token provided via FASTLY_API_TOKEN
Fastly API endpoint: https://api.fastly.com
Service ID (via FASTLY_SERVICE_ID): [....]

Service Version: 8

Name: Re-Enable shielding on restart
ID: 1iJWIfsPLNGxcphsjggq
Priority: 100
Dynamic: false
Type: recv
Content:
// This code should be added as a snippet in your config:
//  Name: Re-Enable shielding on restart
//  Priority: 100
//  Type: recv
//
// Fastly CLI:
// - fastly vcl snippet create --name="Re-Enable shielding on restart" --version=active --autoclone --priority 100 --type recv --content=vendor/ibexa/fastly/fastly/snippet_re_enable_shielding.vcl
// - fastly service-version activate --version=latest


set var.fastly_req_do_shield = (req.restarts <= 2);

# set var.fastly_req_do_shield = (req.restarts > 0 && req.http.accept == "application/vnd.fos.user-context-hash");
set req.http.X-Snippet-Loaded = "v1";


Created at: 2022-06-23 10:55:34 +0000 UTC
Updated at: 2022-06-23 12:24:48 +0000 UTC
```

You can also get the same details for a particular snippet using the `vcl snippet describe` command.

### Get specific snippet

``` bash
fastly vcl snippet describe --name="Re-Enable shielding on restart" --version=latest
```

### Create snippet

``` bash
fastly vcl snippet create --name="Re-Enable shielding on restart" --version=active --autoclone --priority 100 --type recv --content=vendor/ibexa/fastly/fastly/snippet_re_enable_shielding.vcl
fastly service-version activate --version=latest
```

### Update existing snippet

``` bash
fastly vcl snippet update --name="Re-Enable shielding on restart" --version=active --autoclone --priority 100 --type recv --content=vendor/ibexa/fastly/fastly/snippet_re_enable_shielding.vcl
fastly service-version activate --version=latest
```

### Delete snippet

``` bash
fastly vcl snippet delete --name="Re-Enable shielding on restart" --version=active --autoclone
fastly service-version activate --version=latest
```

### Get diff between two versions

You can view the diff between two different versions by using the Fastly web interface.
Unfortunately, Fastly CLI doesn't support this functionality.
However, Fastly API and GNU diff can help you get an identical result.

Use the Fastly API to download the generated `.vcl` file. It includes the VCL configuration that Fastly generates
based on all the configuration settings (from all custom `.vcl` files, snippets, and origin configuration).

The example below extracts the generated VCL for version no. 11 of some service:

``` bash
curl -i "https://api.fastly.com/service/[FASTLY_SERVICE_ID]/version/11/generated_vcl" -H "Fastly-Key: [FASTLY_API_TOKEN]" -H "Accept: application/json" > generated_vcl_11_raw
cp generated_vcl_11_raw generated_vcl_11_json_only
```

Next, you need to edit `generated_vcl_11_json_only` in your favourite editor, remove anything before the json data and save.
Then, follow the same steps again for version no. 12 (or whatever version you want to diff version 11 against).

Then replace `\n` in the files to get human-readable diffs:

``` bash
cat generated_vcl_11_json_only |jq .content|perl -pe 's/\\n/\n/g' > generated_vcl_11_json_done
cat generated_vcl_12_json_only |jq .content|perl -pe 's/\\n/\n/g' > generated_vcl_12_json_done
```

Finally, you can use GNU diff to get a readable diff of the two versions:

``` bash
diff -ruN generated_vcl_11_json_done generated_vcl_12_json_done
```

## Enable basic-auth on Fastly

To enable basic-auth, use [Fastly documentation](https://www.fastly.com/documentation/solutions/examples/http-basic-auth/) as an example.

Follow the steps below.

Usernames and passwords can be stored inside the VCL file, but in this case credentials are stored in a [dictionary](https://docs.fastly.com/en/guides/working-with-dictionaries#working-with-dictionaries-using-vcl-snippets).

!!! note
    To make this example work, you must run [[= product_name =]] in version 3.3.16 or later, or 4.5.

### Create and activate dictionary

Fastly configuration includes a dictionary named `basicauth`.
Using a dictionary instead of storing usernames directly in a `.vcl` file is beneficial, because you can add or remove records without having to create and activate new configuration versions.

``` bash
fastly dictionary create --version=active --autoclone --name=basicauth
fastly service-version activate --version=latest
```

### Get dictionary ID

To add users to the dictionary, first get the dictionary ID.

``` bash hl_lines="5"
fastly dictionary list --version=active

Service ID: KlUh0J1fnw1JY1aEQ0up
Version: 3
ID: ltC6Rg4pqw4qaNKF5tEW
Name: basicauth
Write Only: false
Created (UTC): 2023-07-03 10:33
Last edited (UTC): 2023-07-03 10:33
```

In the example above, the ID is `ltC6Rg4pqw4qaNKF5tEW`.


### Create record in dictionary

Add username and password to the dictionary:

``` bash
fastly dictionary-entry create --dictionary-id=ltC6Rg4pqw4qaNKF5tEW --key=user1 --value=foobar1
```

### List dictionary records

You can list the records from a dictionary by using the following command:

``` bash
fastly dictionary-entry list --dictionary-id=ltC6Rg4pqw4qaNKF5tEW33
```

Now your dictionary stores new username and password. The next thing to do is to alter the Fastly VCL configuration
and add the basic-auth support.
This example uses [snippets](https://docs.fastly.com/en/guides/about-vcl-snippets), so that no changes are needed in the `.vcl` files that are shipped with [[= product_name =]].
You need two snippets, store these as files in your system:

In `snippet_basic_auth_error.vcl`:

``` bash
// This code should be added as a snippet in your config:
//  Name: BasicAuth error
//  Priority: 100
//  Type: error

// See snippet_basic_auth_recv.vcl for installation instructions
//


# If status code is a 401, a synthetic HTML page with this error is served to the user.
if (obj.status == 401) {
  set obj.http.Content-Type = "text/html; charset=utf-8";
  set obj.http.WWW-Authenticate = "Basic realm=MYREALM";
  synthetic {"
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
    <HTML>
    <HEAD>
      <TITLE>Error</TITLE>
      <META HTTP-EQUIV='Content-Type' CONTENT='text/html;'>
    </HEAD>
    <BODY><H1>401 Unauthorized (Fastly)</H1></BODY>
   </HTML>
  "};
  return (deliver);
}
```

In `snippet_basic_auth_recv.vcl`:

``` bash
// This code should be added as a snippet in your config:
//  Name: BasicAuth recv
//  Priority: 100
//  Type: recv
//
// Fastly CLI:
// - fastly vcl snippet create --name="BasicAuth recv" --version=active --autoclone --priority 100 --type recv --content=snippet_basic_auth_recv.vcl
// - fastly vcl snippet create --name="BasicAuth error" --version=latest --priority 100 --type error --content=snippet_basic_auth_error.vcl
// - fastly service-version activate --version=latest


declare local var.credential STRING;
declare local var.username STRING;
declare local var.password STRING;
declare local var.result STRING;

# Basic auth is checked on edge nodes only. The logic below makes sure that it's only run at the edge.
if (fastly.ff.visits_this_service == 0 && req.restarts == 0) {
  if (req.http.Authorization ~ "(?i)^Basic ([a-z0-9_=]+)$") {
    set var.credential = digest.base64_decode(re.group.1);
    set var.username = if(var.credential ~ "^(.+?):.+$", re.group.1, "");
    set var.password = if(var.credential ~ "^.+?:(.+)$", re.group.1, "");
    set var.result = table.lookup(basicauth, var.username, "NOTFOUND");

    if (var.result == "NOTFOUND") {
      error 401 "Restricted";
    } else if (var.result != var.password) {
      error 401 "Restricted";
    }
    # The Auth header is unset to avoid exposing it as a response header.
    unset req.http.Authorization;
    set req.http.Auth-User = var.username;
  } else {
    error 401 "Restricted";
  }
}

# Unsetting req.http.Authorization to avoid reaching "return(pass)" in vcl_recv for the first ESI request
if (req.is_esi_subreq) {
    unset req.http.Authorization;
}
```

To enable basic-auth for one domain only, alter `snippet_basic_auth_recv.vcl`:

``` diff
-if (fastly.ff.visits_this_service == 0 && req.restarts == 0 &&) {
+if (fastly.ff.visits_this_service == 0 && req.restarts == 0 && req.http.host == "example.com") {
```

Install the snippets with the following Fastly CLI command:

``` bash
fastly vcl snippet create --name="BasicAuth recv" --version=active --autoclone --priority 100 --type recv --content=snippet_basic_auth_recv.vcl
fastly vcl snippet create --name="BasicAuth error" --version=latest --priority 100 --type error --content=snippet_basic_auth_error.vcl
fastly service-version activate --version=latest
```
