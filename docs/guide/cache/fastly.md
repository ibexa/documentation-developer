# Configure and customize Fastly

You can configure Fastly by using API calls or through the Fastly Web Interface. 
Fastly provides a [Fastly CLI](https://developer.fastly.com/reference/cli/) for configuring Fastly through its API.

Ibexa Cloud is delivered with Fastly preconfigured. 
It means that you don't have to do any changes to the Fastly configuration in order to make your site work. 
The information provided here is only applicable if you want to change the default Fastly configuration on Ibexa Cloud, 
or if you are not using Ibexa Cloud and want to configure Fastly to work with [[= product_name =]] on premise.

!!! note "The Fastly Web Interface is not available for Ibexa Cloud"
    It's recommend for Ibexa Cloud customers to use the Fastly CLI instead of using the Fastly API directly with `curl`, and so on.


## Getting Fastly credentials from Ibexa Cloud installation

In order to use Fastly CLI or Fastly API directly, you need to obtain the credentials for your site.
To obtain the cridentials connect via SSH to your Fastly-enabled environment (for example, production or staging) and
type the command:

```bash
declare|grep FASTLY
FASTLY_KEY=...
FASTLY_SERVICE_ID=...
```

Note that these credentials will be different for your production and staging environments. When configuring the
Fastly CLI, use the credentials for the environment you want to change.

You may also notice difference in environment variable names.
[[= product_name =]] uses the `FASTLY_SERVICE_ID` and `FASTLY_KEY` variables but you may ecounter `FASTLY_SERVICE_ID` and `FASTLY_API_TOKEN` in your configuration.

!!! note "Varnish needs to be disabled when using Fastly"
    Varnish is automatically provisioned on Ibexa Cloud. Varnish needs to be disabled on all environments which use
    Fastly. See [documentation on how to do that](https://docs.platform.sh/guides/ibexa/fastly.html).

## Quick setup of Fastly to use with [[= product_name =]]

Use commands below to install VCL configurtion required for running Fastly with [[= product_name =]].
You also need to set up domains, https and origin configuration (not covered here).
All commands are explained in detail later on this page:

```
fastly vcl custom create --name "ez_main.vcl" --version=active --autoclone --content=vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ --version=latest --main
fastly vcl custom create --name "ez_user_hash.vcl" --content=vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_user_hash.vcl --version=latest
fastly vcl snippet create --name="Re-Enable shielding on restart" --version=latest --priority 100 --type recv --content=vendor/ezsystems/ezplatform-http-cache-fastly/fastly/snippet_re_enable_shielding.vcl
fastly service-version activate --version=latest
```

!!! note "None of the steps above are needed when using Ibexa Cloud as this is then preconfigured for you"

## Quick introduction to the Fastly CLI

The Fastly configuration is versioned, it means that when you want to alter the configuration, you'll create a new version
and activate it. You may then at any point revert back to the previous version if needed.

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

### Create a new configuration version

A version that is ACTIVE cannot be modified. In order to change the configuration, you need to create a new version:

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
    `fastly service-version clone` is often not needed if the `--autoclone` parameter is prefered.

### Activate version:

Activate a version with this command:

```
fastly service-version activate --version=latest
```

## Viewing and modifying the VCL configuration

The Fastly configuration is stored in [Varnish Configuration Language (VCL)](https://docs.fastly.com/en/guides/uploading-custom-vcl). By uploading custom VCL files
you can change the behaviour of Fastly.
[[= product_name =]] ships with two VCL files that need to be enabled in order for Fastly to work correctly with the platform; `ez_main.vcl` and `ez_user_hash.vcl` (located in `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/`)

### List the custom VCLs for a particular version

```
$ fastly vcl custom list --version 77
SERVICE ID              VERSION  NAME              MAIN
4SEKDky8P3wdrctwZCi1C1  77       ez_main.vcl       true
4SEKDky8P3wdrctwZCi1C1  77       ez_user_hash.vcl  false
```

### Get the VCL `ez_main.vcl` for a particular version

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

#### Show description for every version

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

### Change Fastly configuration

- You can change the configuration, for example, by uploading a modified `.vcl` file. 

Make a new version based on the current active one, and upload the new VCL:
  ```
    $ fastly vcl custom update --name=ez_main.vcl --version=active --autoclone --content=vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_main.vcl
  ```
- Make a description of the change in Fastly's version system:
  ```
    $ fastly service-version update --version=latest --comment="Added feature X"
  ```
- Activate the new version:
  ```
    fastly service-version activate --version=latest
  ```

## Snippets

You may also add VCL code to the Fastly configuration without modifying the custom VCLs directly. Do that by creating
[snippets](https://docs.fastly.com/en/guides/about-vcl-snippets). It is recommended to use snippets instead of changing
the VCL files provided by [[= product_name =]] as much as possible, making it easier to later upgrade the [[= product_name =]] VCLs.

When you use snippets, the snippet code is injected into the VCL where the `#FASTLY ...` macros are placed.
For example, if you create a snippet for the `recv` subroutine, it will be injected into the `ez_main.vcl` file on the
line where `#FASTLY recv` is found.

### List available snippets for a particular version

```
$ fastly vcl snippet list --version=active
SERVICE ID              VERSION  NAME                            DYNAMIC  SNIPPET ID
KlUh0J1fnw1JY1aEQ0up    8        Re-Enable shielding on restart  false    1iJWIfsPLNGxcphsjggq

```

!!! note
    As of version 3.3.24, 4.1.6 and 4.2.0, [[= product_name =]] also requires one snippet to be installed, in addition to the custom VCLs `ez_main.vcl` and `ez_user_hash.vcl`. That snippet is by default named `Re-Enable shielding on restart`.

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

You can also get the same details for a particular snippet using the `vcl snippet describe` command:

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

Use the Fastly API to download the generated VCL. This generated VCL is the vcl config that Fastly generates based on all the configuration settings (so it includes all custom .vcls, snippets, origin config).

The example below extracts the generated VCL for version no. 11 of some service:
```
curl -i  "https://api.fastly.com/service/[FASTLY_SERVICE_ID]/version/11/generated_vcl" -H "Fastly-Key: [FASTLY_API_TOKEN]" -H "Accept: application/json" > generated_vcl_11_raw
cp generated_vcl_11_raw generated_vcl_11_json_only
```

Next, you need to edit `generated_vcl_11_json_only` in your favourite editor, remove anything before the json data and save.
Then, follow the same steps again for version no. 12 (or whatever version you want to diff version 11 against).

Then replace `\n` in the files to get human-readable diffs:

```
cat generated_vcl_11_json_only |jq .content|perl -pe 's/\\n/\n/g' > generated_vcl_11_json_done
cat generated_vcl_12_json_only |jq .content|perl -pe 's/\\n/\n/g' > generated_vcl_12_json_done
```

Finally, you can use GNU diff to get a readable diff of the two versions:

```
diff -ruN generated_vcl_11_json_done generated_vcl_12_json_done
```

## Enabling basic-auth on Fastly.

To enable basic-auth, use [Fastly documentation](https://developer.fastly.com/solutions/examples/http-basic-auth) as an example.

Follow the steps below.

Usernames and passwords can be stored inside the VCL file, but in this case credentials are stored in a [dictionary](https://docs.fastly.com/en/guides/working-with-dictionaries-using-the-web-interface#working-with-dictionaries-using-vcl-snippets).

!!! note
    In order to make this example work, you must run Ibexa DXP 3.3.16 or later, or 4.5.

### Create the dictionary and activate the change:

```
fastly dictionary create --version=active --autoclone --name=basicauth
fastly service-version activate --version=latest
```

The Fastly configuration has a dictionary named `basicauth`. The benefit of using a dictionary insted of storing
the usernames directly in VCL file is that we can add or remove records without creating and activating new versions of the configuration.

### Get the dictionary ID

To add users to the dictionary, first get the dictionary ID.

```hl_lines="5"
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


### Create a record in the dictionary

Add user's name and password to the dictionary:

```
fastly dictionary-item create --dictionary-id=ltC6Rg4pqw4qaNKF5tEW --key=user1 --value=foobar1
```

### List dictionary records

You may see the records from a dictionary using:

```
fastly dictionary-item list --dictionary-id=ltC6Rg4pqw4qaNKF5tEW33
```

Now your dictionary stores new user name and password. The next thing to do is to alter the Fastly VCL configration
and add the basic-auth support. 
In this example, do that using snippets (https://docs.fastly.com/en/guides/about-vcl-snippets ) so that no changes
are need in the .vcl files shipped by [[= product_name =]] You need two snippets, store these as files in your system:

In `snippet_basic_auth_error.vcl`:

```
// This code should be added a snippet in your config:
//  Name : BasicAuth error
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

Install the snippets with the following Fastly CLI command:

```
fastly vcl snippet create --name="BasicAuth recv" --version=active --autoclone --priority 100 --type recv --content=snippet_basic_auth_recv.vcl
fastly vcl snippet create --name="BasicAuth error" --version=latest --priority 100 --type error --content=snippet_basic_auth_error.vcl
fastly service-version activate --version=latest
```

 
