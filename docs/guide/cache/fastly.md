# Configuring and Customizing Fastly

Fastly can be configured using API calls or via the Fastly Web Interface. Fastly provides a [Fastly CLI](https://developer.fastly.com/reference/cli/) for configuring Fastly via it's API.

!!! note "The Fastly Web Interface is not available for Ibexa Cloud"
    We recommend Ibexa Cloud customers to use the Fastly CLI instead of using the Fastly API directly using `curl` etc.


## Getting the Fastly Credentials from an Ibexa Cloud installation

In order to use the Fastly CLI or the Fastly API directly, you'll need to obtain the credentials for your site. The
credentials can be obtained by ssh'ing into your Fastly-enabled environment ( for instance Production or Staging ) and
type the command:

```
declare|grep FASTLY
FASTLY_KEY=...
FASTLY_SERVICE_ID=...
```

Note that these credentials will be different for your production and staging environments. When configuring the
Fastly CLI, use the credentials for the environment you want to change).

!!! note "Difference in environment variable names"
    When configuring the Fastly CLI, you may use the environment variables `FASTLY_SERVICE_ID` and `FASTLY_API_TOKEN`, while
    Ibexa DXP uses the variables `FASTLY_SERVICE_ID` and `FASTLY_KEY`.

!!! note "Ibexa Cloud is delivered with Fastly already preconfigured"
    Ibexa Cloud is delivered with Fastly preconfigured. That means that you don't have to do any changes to the Fastly
    configuration in order to make your site work. The information provided here is only applicable if you want to change
    the default Fastly configuration on Ibexa Cloud, or if you are not using Ibexa Cloud and wants to configure Fastly
    to work with Ibexa DXP on premise.

!!! note "Varnish needs to be disabled when using Fastly"
    Varnish is automatically provisioned on Ibexa Cloud. Varnish needs to be disabled on all environments that is using
    Fastly. See [documentation on how to do that](https://docs.platform.sh/guides/ibexa/fastly.html)

## Quick introduction to the Fastly CLI

The Fastly configuration is versioned. That means that when you want to alter the configuration, you'll create a new version
and activate it. You then may at any point revert back to a previous version if needed.

### List configuration versions

```
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

In the example above, version 8 is the current version being used (ACTIVE=true).

### Create a new configuration version

A version that is ACTIVE cannot be modified. In order to change some configuration, you'll need to create a new version:

Clone the current active version:

```
fastly service-version clone --version=active
```

Clone a particular version:

```
fastly service-version clone --version=4
```

Clone the newest version:

```
fastly service-version clone --version=latest
```

!!! note "The --version parameter"
Most Fastly CLI commands have the `--version` parameter. The `--version` parameter always supports aliases like `active`
and `latest` in additional to a specific version number.

!!! note "The --autoclone parameter"
Most Fastly CLI commands that alter the config also supports the `--autoclone` parameter so that explicitly calling
`fastly service-version clone` is often not needed if the using the `--autoclone` parameter is prefered.

### Activate a version:

You activate a version using the command:

```
fastly service-version activate --version=latest activate
```

## Viewing and modifying the VCL configuration

The Fastly configuration is stored in [Varnish Configuration Language (VCL)](https://docs.fastly.com/en/guides/uploading-custom-vcl). By uploading custom VCL files
you can change the behaviour of Fastly.
Ibexa DXP ships with two VCL files that needs to be enabled in order for Fastly to work correctly with Ibexa DXP; `ez_main.vcl` and `ez_user_hash.vcl` (located in `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/fastly/`)

### List the custom VCLs for a particular version

```
$ fastly vcl custom list --version 77
SERVICE ID              VERSION  NAME              MAIN
4SEKDky8P3wdrctwZCi1C1  77       ez_main.vcl       true
4SEKDky8P3wdrctwZCi1C1  77       ez_user_hash.vcl  false
```

### Get the vcl ez_main.vcl for a particular version

```
$ fastly vcl custom describe --name=ez_main.vcl --version=77

Service ID: 4SEKDky8P3wdrctwZCi1C1
Service Version: 77

Name: ez_main.vcl
Main: true
Content:

include "ez_user_hash.vcl"

sub vcl_recv {
(....)
```

### Make a description for a particular version:

You may provide a description on every version, explaining what changed in that particular version:

```
$ fastly service-version update --version=52 --comment="Added support for basic-auth on the staging domain"
```

#### Showing the description for every version

You may see the descriptions by adding the `--verbose` (`-v`) option to the `service-version list` command:

```
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

### Change Fastly configuration ( for instance upload a modified .vcl)

- Make a new version based on the current active one, and upload the new vcl
  ```
    $ fastly vcl custom update --name=ez_main.vcl --version=latest --autoclone --content=vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_main.vcl
  ```
- Make a description of the change in Fastly's version system
  ```
    $ fastly service-version update --version=latest --comment="Added feature X"
  ```
- Activate the new version
  ```
    fastly service-version activate --version=latest
  ```

## Snippets

You may also add VCL code to the Fastly configuration without modifying the custom VCLs directly. You may do that by creating
[snippets](https://docs.fastly.com/en/guides/about-vcl-snippets). It is recommended to use snippets instead of changing
the VCL files provided by Ibexa DXP as much as possible, making it easier to later upgrade the Ibexa DXP VCLs.
When you use snippets, the snippet code is injected into the VCL where the `#FASTLY ...` macros are placed.
For instance, if you create a snippet for the `recv` subroutine, it will be injected into the `ez_main.vcl` file on the
line where `#FASTLY recv` is found.

### List available snippets for a particular version

```
$ fastly vcl snippet list --version=active
SERVICE ID              VERSION  NAME                            DYNAMIC  SNIPPET ID
KlUh0J1fnw1JY1aEQ0up    8        Re-Enable shielding on restart  false    1iJWIfsPLNGxcphsjggq

```

!!! note "As of version 3.3.24, 4.1.6 and 4.2.0, Ibexa DXP also requires one snippet installed, in addition to the custom vcls `ez_main.vcl` and `ez_user_hash.vcl`. That snippet is by default named `Re-Enable shielding on restart`"

### Get the details of installed snippets

You can get more information, like priority, which subroutine it is attached to (`vcl_recv`, `vcl_fetch` etc. ) and the code itself using the `--verbose` option when using the `vcl snippet list` command:

```
$ fastly vcl snippet list --version=active -v
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
// This code should be added a snipped in your config:
//  Name : Re-Enable shielding on restart
//  Priority: 100
//  Type: recv
//
// Fastly CLI :
// - fastly vcl snippet create --name="Re-Enable shielding on restart" --version=active --autoclone --priority 100 --type recv --content=vendor/ezsystems/ezplatform-http-cache-fastly/fastly/snipped_re_enable_shielding.vcl
// - fastly service-version activate --version=latest


set var.fastly_req_do_shield = (req.restarts <= 2);

# set var.fastly_req_do_shield = (req.restarts > 0 && req.http.accept == "application/vnd.fos.user-context-hash");
set req.http.X-Snippet-Loaded = "v1";


Created at: 2022-06-23 10:55:34 +0000 UTC
Updated at: 2022-06-23 12:24:48 +0000 UTC

```

You may also get the same details for a particular snippet using the `vcl snippet describe` command :

```
fastly vcl snippet describe --version=active "--name=Re-Enable shielding on restart"
```

### Create a snippet

```
fastly vcl snippet create --name="Re-Enable shielding on restart" --version=active --autoclone --priority 100 --type recv --content=vendor/ezsystems/ezplatform-http-cache-fastly/fastly/snippet_re_enable_shielding.vcl
fastly service-version activate --version=latest
```

### Delete a snippet

```
fastly vcl snippet delete --name="Re-Enable shielding on restart" --version=active --autoclone
fastly service-version activate --version=latest
```

### Update an existing snippet

```
fastly vcl snippet update --name="Re-Enable shielding on restart" --version=active --autoclone --priority 100 --type recv --content=vendor/ezsystems/ezplatform-http-cache-fastly/fastly/snippet_re_enable_shielding.vcl
fastly service-version activate --version=latest
```

### Get the diff between two versions

Using the Fastly web interface you can easily see the diff between two different versions. Unfortunately, this is not supported by the Fastly CLI. However, it is possible with the help of the Fastly API and GNU diff.

You use the Fastly API to download the generated VCL. This generated VCL is the vcl config that Fastly generates based on all the configuration settings ( so it includes all custom .vcls, snippets, origin config, just everything).

The example below extracts the generated vcl for version no. 11 of some service
```
curl -i  "https://api.fastly.com/service/[FASTLY_SERVICE_ID]/version/11/generated_vcl" -H "Fastly-Key: [FASTLY_API_TOKEN]" -H "Accept: application/json" > generated_vcl_11_raw
cp generated_vcl_11_raw generated_vcl_11_json_only
```

Next, you need to edit generated_vcl_11_json_only in your favourite editor, remove anything before the json data and save.
Then, do the same steps again for version no. 12 (or whatever version you want to diff version 11 against)

Then replace \n in the files in order to give human-readable diffs:

```
cat generated_vcl_11_json_only |jq .content|perl -pe 's/\\n/\n/g' > generated_vcl_11_json_done
cat generated_vcl_12_json_only |jq .content|perl -pe 's/\\n/\n/g' > generated_vcl_12_json_done
```

Finally, you can use GNU diff to and get a readable diff of the two versions:

```
diff -ruN generated_vcl_11_json_done generated_vcl_12_json_done
```

## Enabling Basic-Auth on Fastly.

In order to enable basic-auth, you can use https://developer.fastly.com/solutions/examples/http-basic-auth as an example.

Here is a step-by-step guide on how to make that work.

Usernames and password can be stored inside vcl, but we'll instead store them in a [dictionary](https://docs.fastly.com/en/guides/working-with-dictionaries-using-the-web-interface#working-with-dictionaries-using-vcl-snippets)

!!! note "In order to make this example work, you must run Ibexa DXP 3.3.16 or later, or 4.5."

### Create the dictionary and activate the change:

```
fastly dictionary create --version=active --autoclone --name=basicauth
fastly service-version activate --version=latest
```

From now on, our Fastly configuration has a dictionary named `basicauth`. The benefit of using a dictionary vs storing
the usernames directly in vcl is that we can add/remove records to it without creating and activating new versions of our configuration.

### Obtain the dictionary ID

In order to add users to the dictionary, we first need to get the dictionary ID.

```
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


### Create a record in the dictionary ( user name and password )

```
fastly dictionary-item create --dictionary-id=ltC6Rg4pqw4qaNKF5tEW --key=user1 --value=foobar1
```

### List dictionary records

You may see the records of a dictionary using:

```
fastly dictionary-item list --dictionary-id=ltC6Rg4pqw4qaNKF5tEW33
```

Now we have a dictionary storing a user name and password. The next thing to do is to alter the Fastly .vcl configration.
and add the basic-auth support. 
In this example, we'll do that using snippets (https://docs.fastly.com/en/guides/about-vcl-snippets ) so that no changes
are need in the .vcl files shipped by Ibexa DXP. You need two snippets, store these as files on your system:

In `snippet_basic_auth_error.vcl`:

```
// This code should be added a snippet in your config:
//  Name : BasicAuth recv
//  Priority: 100
//  Type:error

// This code should be added a snippet in your config:
//
// See snippet_basic_auth_recv.vcl for instructions on how to install
//


#If the status code is a 401, we serve a synthetic HTML page which displays this error to the user.
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
```
// This code should be added a snippet in your config:
//  Name : BasicAuth recv
//  Priority: 100
//  Type: recv
//
// Fastly CLI :
// - fastly vcl snippet create --name="BasicAuth recv" --version=active --autoclone --priority 100 --type recv --content=snippet_basic_auth_recv.vcl
// - fastly vcl snippet create --name="BasicAuth error" --version=latest --priority 100 --type error --content=snippet_basic_auth_error.vcl
// - fastly service-version activate --version=latest


declare local var.credential STRING;
declare local var.username STRING;
declare local var.password STRING;
declare local var.result STRING;

# We only check basic auth on edge nodes. This below logic makes sure this is only run at the edge.
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
    #We unset the Auth header to avoid exposing this as a response header.
    unset req.http.Authorization;
    set req.http.Auth-User = var.username;
  } else {
    error 401 "Restricted";
  }
}
```

If you want basic-auth to be enabled only for one domain, you may alter `snippet_basic_auth_recv.vcl`
```diff
-if (fastly.ff.visits_this_service == 0 && req.restarts == 0 &&) {
+if (fastly.ff.visits_this_service == 0 && req.restarts == 0 && req.http.host == "example.com") {
```

You install the snippets using the Fastly CLI like this:

```
fastly vcl snippet create --name="BasicAuth recv" --version=active --autoclone --priority 100 --type recv --content=snippet_basic_auth_recv.vcl
fastly vcl snippet create --name="BasicAuth error" --version=latest --priority 100 --type error --content=snippet_basic_auth_error.vcl
fastly service-version activate --version=latest
```

 
