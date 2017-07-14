1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Community Resources](Community-Resources_31429530.html)

# How to Contribute

Are you ready to become a part of the eZ Community? There are several ways in which you can contribute, from spotting and reporting bugs to commenting on the documentation to discussing innovative uses on Slack to coding new bundles.

 

If you're looking to contribute code, whether in form of corrections or separate bundles with features, the open-source nature of eZ Platform lets you do this without any fuss using GitHub. Take a look at [GitHub 101](GitHub-101_31429590.html) and our [Development guidelines](Development-guidelines_31430575.html) to get started.

If you've noticed any improvement needed in the documentation, see how to [Contribute to Documentation](Contribute-to-Documentation_31429594.html).

If you'd just like to let us know of a bug you've encountered, see how to report it in [Report and follow issues: The bugtracker](31429592.html).

If you'd like to contribute to a translation of eZ Platform interface, see [Contributing translations](Contributing-translations_34079215.html).

If what you're looking for is simply discussing the way you use eZ Platform, drop by to the [community website](http://share.ez.no) or the [eZ Community Slack team](https://ezcommunity.slack.com/).

 

# GitHub 101

Contributing to the doc

This part of the documentation is still a WORK-IN-PROGRESS. Would you like to contribute to it?

If you have any thoughts or tips to share, let us know in the comments below, visit our [Slack channel](http://ez-community-on-slack.herokuapp.com/) or take a look at other ways to [Contribute to Documentation](https://doc.ez.no/display/DEVELOPER/Contribute+to+Documentation).

Related JIRA issue: [EZP-25590](https://jira.ez.no/browse/EZP-25590)

The eZ Platform Github repository is stored here: <https://github.com/ezsystems/ezplatform>

 

 
# Report and follow issues: The bugtracker

The development of eZ projects is organized using a bugtracker. It can be found here: <https://jira.ez.no>. Its role is to centralize references to all improvements, bug fixes and documentation being added to eZ projects.

The first thing you should do in order to be able to get involved and have feedback on what is happening on eZ projects is to create a JIRA account.

**Note:** The term "issue" is used to refer to a bugtracker item regardless of its type (bug, improvement, story, etc.)

Security issues

If you discover a security issue, please do not report it using regular channels, but instead take a look at <https://doc.ez.no/Security>.

# How to find an existing issue

When you have a great idea or if you have found a bug, you may want to create a new issue to let everyone know about it. Before doing that, you should make sure no one has made a similar report before.

In order to do that, you should use the search page available in the top menu (under **Issues/Search for issues**) or the search box in the top right corner. Using filters and keywords you should be able to search and maybe find an issue to update instead of creating a new one.

# How to improve existing issues

Existing issues need to be monitored, sorted and updated in order to be processed in the best way possible.

In case of bugs, trying to reproduce them, in order to confirm that they are (still) valid, is a great help for developers who will later troubleshoot and fix them. By doing that you can also provide extra information, if needed, such as:

-   Extra steps to reproduce
-   Context/environment-specific information
-   Links to duplicate or related issues

In case of improvements, you can add extra use cases and spot behaviors that might be tricky or misleading.

# How to follow an issue

Every issue has a "Start watching this issue" link. It lets you receive notifications each time the issue is updated.

This way you can get and provide feedback during the issue's life. You are also informed about ongoing development regarding the issue and can try out patches before they are integrated into the product.

# How to report an issue

If you cannot find an issue matching what you are about to report using the search page, you need to create a new one.
Click **Create** at the top of the bugtracker window and fill in the form:

-   **Project**: Select **eZ Publish/Platform** if your issue affects platform as a standalone project, or **eZ Platform Enterprise Edition** if it is needed in order to reproduce the issue.
-   **Issue type**: Choose **Bug** or **Improvement** depending on what you are reporting, do not use other issue types (they are for internal use only).
-   **Summary**: Write a short sentence describing what you are reporting.
-   **Security level**: Select security if you are reporting a security issue. It will make your issue visible only to you and the core dev team until it is fixed and distributed.
-   **Priority**: Select the priority you consider the issue to be. Please try to keep a cool head while selecting it. A 1 pixel alignment bug is not a "blocker" :)
-   **Component/s**: This is important, as it will make your issue appear on the radar (dashboards, filters) of people dealing with various parts of eZ projects.
-   **Affect version/s**: Add the versions of the application you experienced the issue on.
-   **Fix version/s**: Leave blank.
-   **Assignee**: Leave blank, unless you are willing to work on the issue yourself.
-   **Reporter**: Leave as is (yourself).
-   **Environment**: Enter specific information regarding your environment that could be relevant in the context of the issues.
-   **Description**: This is the most important part of the issue report. In case of a bug, it **must** contain explicit steps to reproduce to your issue. Anybody should be able to reproduce it at first try. In case of an improvement, it needs to contain use cases and detailed information regarding the expected behavior.
-   **Labels**: Leave blank.
-   **Epic Link**: Leave blank.
-   **Sprint**: Leave blank.

 
# Contribute to Documentation

While we are doing our best to make sure our documentation fulfills all your needs, there is always place for improvement. If you'd like to contribute to our docs, you can do the following:

-   **Add comments.** Whenever you notice a mistake or possible improvement in any of the topics, leave a comment or suggestion at the bottom of the page.
-   **Create a JIRA issue.** You can also report any omissions or inaccuracies you find by creating a JIRA issue. See [Report and follow issues: The bugtracker](31429592.html) on how to do this. Remember to add the "Documentation" component to your issue to make sure we don't lose track of it.
-   **Visit Slack.** The \#documentation-contrib channel on [eZ Community Slack team](http://ez-community-on-slack.herokuapp.com) is the place to drop your comments, suggestions, or proposals for things you'd like to see covered in documentation. (You can use the link to get an auto-invite to Slack).
-   **Contact the Doc Team.** If you'd like to add to any part of the documentation, you can also contact the Doc Team directly at <doc-team@ez.no.>


# Contributing translations

If you'd like to see eZ Platform in your language, you can contribute to the translations. Contributing is made easy by using Crowdin, which allows you to translate elements of the interface in context.

# How to translate the interface using Crowdin

If you wish to contribute to an existing translation of PlatformUI or start a new one, the best way is to start with in-context translation (but you can also [translate directly on the Crowdin website](#Contributingtranslations-Translatingoutsidein-context)).

## Preparing to use in-context

To start translating, you need an option to turn in-context translation on and off. To do this, set a browser cookie. There are several ways to do this, but we will highlight a couple here.

### Using bookmarks

You can easily create a bookmark to toggle in-context on/off.

Right-click your browser's bookmark bar, and create a new bookmark as shown in the screenshot below:

![Bookmark for toggling in-context translation](attachments/34079215/34079828.png "Bookmark for toggling in-context translation")

 

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<tbody>
<tr class="odd">
<td>Name</td>
<td>Toggle in-context</td>
</tr>
<tr class="even">
<td>URL</td>
<td><pre><code>javascript:function hasInContextCookie(){ return document.cookie.match(/^(.*;)?\s*ez_in_context_translation\s*=\s*[^;]+(.*)?$/);}(function () { document.cookie = hasInContextCookie() ? document.cookie = &#39;ez_in_context_translation=;expires=Mon, 05 Jul 2000 00:00:00 GMT;path=/;&#39;: document.cookie=&#39;ez_in_context_translation=1;path=/;&#39;; location.reload()})()</code></pre></td>
</tr>
</tbody>
</table>

 Clicking the bookmark while on PlatformUI will toggle in-context translation on/off.

### Using the debugging console

Another way is to open the development console and run this line:

``` brush:
function hasInContextCookie(){ return document.cookie.match(/^(.*;)?\s*ez_in_context_translation\s*=\s*[^;]+(.*)?$/);}(function () { document.cookie = hasInContextCookie() ? document.cookie = 'ez_in_context_translation=;expires=Mon, 05 Jul 2000 00:00:00 GMT;path=/;': document.cookie='ez_in_context_translation=1;path=/;'; location.reload()})()
```

## Using in-context translation

The first time you enable in-context, if you're not logged into Crowdin, it will ask you to log in or register an account. Once done, it will ask you which language you want to translate to, from the list of languages configured in Crowdin.

Choose your language and you can start translating right away. Strings in the interface that can be translated will be outlined in red (untranslated), blue (translated) or green (approved). When moving over them, an edit button will show up on the top left corner of the outline. Click on it, and edit the string in the window that shows up.

### ![ In-context translation of Platform UI](attachments/31429671/33554862.png " In-context translation of Platform UI")

#### Troubleshooting

Make sure you clear your browser's cache in addition to eZ Platform's. Some of the translation resources use aggressive HTTP cache.

## Translating outside in-context

If you prefer not to use in-context, simply visit [eZ Platform's Crowdin page](https://crowdin.com/project/ezplatform), choose a language and you will see a list of files containing strings. Here you can suggest your translations.

If the language you want to translate to is not available, you can ask for it to be added in the [Crowdin discussion forum for eZ Platform](https://crowdin.com/project/ezplatform/discussions).

# Install new translation package

To make use of the UI translations, you need to install the new translation package in your project.

## Translation packages per language

To allow users to install only what they need, we have split every language into a dedicated package.

All translation packages are published on [ezplatform-i18n organisation on github](https://github.com/ezplatform-i18n)

## Install a new language in your project

If you want to install a new language in your project, you just have to install the corresponding package.

For example, if you want to translate your application into French, you just have to run:

    composer require ezplatform-i18n/ezplatform-i18n-fr_fr

and then clear the cache.

Now you can reload your eZ Platform administration page which will be translated in French (if your browser is configured to fr\_FR.)

# Full translation workflow

You can read a full description of how new translations are prepared and distributed in [the documentation of GitHub](https://github.com/ezsystems/ezplatform/blob/1.8/doc/i18n/translation_workflow.md).

#### In this topic:

-   [How to translate the interface using Crowdin](#Contributingtranslations-HowtotranslatetheinterfaceusingCrowdin)
    -   [Preparing to use in-context](#Contributingtranslations-Preparingtousein-context)
        -   [Using bookmarks](#Contributingtranslations-Usingbookmarks)
        -   [Using the debugging console](#Contributingtranslations-Usingthedebuggingconsole)
    -   [Using in-context translation](#Contributingtranslations-Usingin-contexttranslation)
        -   [](#Contributingtranslations-)
    -   [Translating outside in-context](#Contributingtranslations-Translatingoutsidein-context)
-   [Install new translation package](#Contributingtranslations-Installnewtranslationpackage)
    -   [Translation packages per language](#Contributingtranslations-Translationpackagesperlanguage)
    -   [Install a new language in your project](#Contributingtranslations-Installanewlanguageinyourproject)
-   [Full translation workflow](#Contributingtranslations-Fulltranslationworkflow)

## Attachments:

![](images/icons/bullet_blue.gif) [toggle-in-context.png](attachments/34079215/34079828.png) (image/png)


# Development guidelines

These are the development/coding guidelines for eZ Platform kernel, they are the same if you intend to write Bundles, hack on eZ Platform itself or create new functionality for or on top of eZ Platform.

Like most development guidelines these aims to improve security, maintainability, performance and readability of our software. They follow industry standards but sometimes extend them to cater specifically to our needs for eZ Platform ecosystem. The next sections will cover all relevant technologies from a high level point of view.

 

## HTTP

eZ Platform is a web software that is reached via HTTP in most cases, out of the box in eZ Platform kernel this is specifically: web (usually HTML) or REST.

We aim to follow the [latest](http://trac.tools.ietf.org/wg/httpbis/trac/wiki#HTTP1.1Deliverables) stable HTTP specification, and industry best practice:

-   **Expose our data in a RESTful way**
    -   GET, HEAD, OPTIONS & TRACE methods are [safe](http://tools.ietf.org/html/draft-ietf-httpbis-p2-semantics-21#section-5.2.1) (otherwise known as [nullipotent](http://en.wiktionary.org/wiki/nullipotent)), as in: should never cause changes to resources (note: things like writing a line in a log file are not considered resource changes)
    -   PUT & DELETE methods are [idempotent](http://tools.ietf.org/html/draft-ietf-httpbis-p2-semantics-21#section-5.2.2), as in multiple identical requests should all have the same result as a single request
    -   GET & HEAD methods should be [cacheable](http://tools.ietf.org/html/draft-ietf-httpbis-p2-semantics-21#section-5.2.3) both on client side, server-side and proxies between, as further defined in the HTTP [specification](http://tools.ietf.org/html/draft-ietf-httpbis-p6-cache-21)
    -   As PUT is for replacing a resource, we should use [PATCH](http://tools.ietf.org/html/rfc5789) in cases where only partial replacement is intended
-   **Authenticated traffic**
    -   Should use HTTPS
-   **Session based traffic**
    -   Should follow recommendations for *Authenticated traffic*
    -   Should use a per user session [CSRF](http://en.wikipedia.org/wiki/Cross-site_request_forgery) token on all requests using un-safe HTTP methods (POST, PUT, DELETE, PATCH, ...)
    -   Should expire session id, session data and CSRF token on login, logout and session time out, except:
        -   On login session data from previous session id is moved to new session id, keeping for instance shopping basket on login
    -   Should avoid timing attacks by using a random amount of time for login operation
    -   Should never use Session id in URI's. And this feature ("SID") must always be disabled on production servers
-   **Sessions**
    -   Should not be used to store large amounts of data; store data in database and id's in session if needed
    -   Should not store critical data: if user deletes his cookies or closes his browser session data is lost
    -   Should use an ID generated with enough randomness to prevent prediction or brute-force attacks
-   **Cookies (especially session cookies)**
    -   Should never store sensitive data in cookies (only exception is session id in session cookie)
    -   Should always set *Full domain* to avoid [cross-subdomain cooking](http://en.wikipedia.org/wiki/Session_fixation#Attacks_using_cross-subdomain_cooking) when on shared domain.
    -   Should set *HttpOnly* flag to reduce risk of attacks such as [cross-site cooking](http://en.wikipedia.org/wiki/Session_fixation#Attacks_using_cross-site_cooking) and [cross-site scripting](http://en.wikipedia.org/wiki/Cross-site_scripting "Cross-site scripting")
    -   Should set *Secure flag* if HTTPS is used (as recommended above)
    -   Must never exceed 4kb
-   **Headers**
    -   Should never include input data from user input or data from database without sanitizing it
-   **Redirects**
    -   Should never take url from user input (example: POST parameter), instead allow identifiers instead that are understood by the backend
-   **User input**
    -   Should always be validated, sanitized, casted and filtered to avoid [XSS](http://en.wikipedia.org/wiki/Cross-site_scripting) & [clickjacking](http://en.wikipedia.org/wiki/Clickjacking)  attacks
        -   NB: this includes variables in the php supervariable `$_SERVER` as well (e.g. hostname should not be trusted)
-   **User file uploads**
    -   Should follow recommendations for "User input" to validate file name
    -   Should place uploaded files in a non public folder to avoid access to execute uploaded file or in case of assets white list the type
    -   Should be appropriately limited in size to avoid DOS attacks on disk space, cpu usage by antivirus tool etc...
-   **File downloads**
    -   Should not rely on user provided file path for non public files, instead use a synthetic id
-   **Admin operations**
    -   May be placed on a different (sub)domain then the front end website to avoid session stealing across front and backend.
-   **Fully support being placed behind a reverse proxy like [Varnish](https://www.varnish-cache.org/)**

## REST

For now see the living [REST v2 specification](https://github.com/ezsystems/ezp-next/blob/master/doc/specifications/rest/REST-API-V2.rst) in our git repository for further details.

## UI

eZ Platform is often used as a web content management software, so we always strive to use the HTML/CSS/EcmaScript specifications correctly, and keep new releases up to date on new revisions of those. We furthermore always try to make sure our software gracefully degrades making sure it is useful even on older or less capable web clients (browsers), the industry terms for this approach are:

-   [Progressive enhancement](http://en.wikipedia.org/wiki/Progressive_enhancement "Progressive enhancement")
-   [Unobtrusive JavaScript](http://en.wikipedia.org/wiki/Unobtrusive_JavaScript)
-   [Responsive Design](http://en.wikipedia.org/wiki/Responsive_Web_Design "Responsive Web Design")

All these terms in general recommends aiming for the minimum standard first, and enhance with additional features/styling if the client is capable of doing so. In essence this allows eZ Platform to be "Mobile first" if the design allows for it, which is recommended. But eZ Platform should always also be fully capable of having different sets of web presentations for different devices using one or several sets of SiteAccess matching rules for the domain, port or URI, so any kind of device detection can be used together with eZ Platform, making it fully possible to write for instance [WAP](http://en.wikipedia.org/wiki/Wireless_Application_Protocol) based websites and interfaces on top of eZ Platform.

### WEB Forms/Ajax

As stated in the HTTP section, all unsafe requests to the web server should have a CSRF token to protect against attacks; this includes web forms and ajax requests that don't use the GET http method. As also stated in the HTTP section and further defined in the PHP section, User input should always be validated to avoid XSS issues.

### HTML/Templates

All data that comes from backend and in return comes from user input should always be escaped, in case of Twig templates this done by default, but in case of PHP templates, Ajax and other not Twig based output this must be handled manually.

Output escaping must be properly executed according to the desired format, eg. javascript vs. html, but also taking into account the correct character set (see eg. output escaping fallacy when not specifying charset encoding in [htmlspecialchars](http://www.php.net/htmlspecialchars))

### Admin

Admin operations that can have a severe impact on the web applications should require providing password and require it again after some time has gone, normally 10 - 20 minutes, on all session based interfaces.

&lt;TODO: Add more coding guidelines for HTML (XHTML5), Javascript, CSS and templates&gt;

## PHP

For now see our comprehensive coding standard & guidelines [wiki page](https://github.com/ezsystems/ezpublish-kernel/wiki/codingstandards) on github.

eZ Coding Standards Tools

See also [eZ Coding Standards Tools](http://eZ%20Coding%20Standard%20tools) repository to get the configuration files for your favorite tools.

### Public API

The PHP Public API provided in eZ Platform is in most cases in charge of checking permissions to data for you, but some API's are not documented to throw UnauthorizedException, which means that it is the consumer of the API's who is responsible for checking permissions.

The following example shows how this is done in the case of loading users:

**loadUser()**

``` brush:
// Get a user
$userId = (int)$params['id'];
$userService = $repository->getUserService();
$user = $userService->loadUser( $userId );

// Now check that current user has access to read this user
if ( !$repository->canUser( 'content', 'read', $user ) )
{
    // Generates message: User does not have access to 'content' 'read' with id '10'
    throw new \eZ\Publish\Core\Base\Exceptions\UnauthorizedException( 'content', 'read', array( 'id' => $userId ) );
}
```

### Command line

Output must always be escaped when displaying data from the database.

*&lt;TODO: Expand on how best practice is to handle user input in eZ Platform to avoid XSS issues&gt;*

## Data & Databases

-   Values coming from variables should always be appropriately quoted or binded in SQL statements
-   The SQL statements used should never be created by hand with one version per supported database, as this increases both the maintenance load and the chances for security-related problems
-   Usage of temporary tables is discouraged, as their behaviour is very different on different databases. Subselects should be prefererred (esp. since recent mysql versions have much better support for them)
-   Full table locking is discouraged

*&lt;TODO: guidelines for how data should be stored for maximum portability (hint: XML & abstraction)&gt;*

### Sessions

-   Business logic should not depend on database connections being either persistent or not persistent
-   The connection to the database should always be opened as late as possible during page execution. Ideally, to improve scalability, a web page executing no queries should not connect to the db at all (note that closing the db connection as soon as possible is a tricky problem, as we expect to support persistent db connections as well for absolute best performances)
-   The same principle applies to configurations where a master/slave db setup is in use: the chance for a failure due to a database malfunction should not increase with the number of db servers at play, but actually decrease
-   It is recommended to avoid as much as possible statements which alter the current session, as they slow down the application, are brittle and hard to debug.
    Point in case; if a db session locks a table then is abruptly terminated, the table might stay locked for a long time

### Transactions

-   Transactions should always be used to wrap sql statements which affect data in multiple tables: either all data changes go through or none of them
-   Transactions are prone to locking issues, so the code executed within a transaction should be limited to the minimum necessary amount (ex. clearing caches should be done after the transaction is committed)
-   When using transactions, always consider side effects on external system, such as on-disk storage. F.e. is a transaction relative to creating an image variation is rolled back, the corresponding file should not be left on disk
-   Nested transactions are supported in the following way:
    -   a transaction within another one will not commit when requested, only the outhermost transaction will commit
    -   a transaction within another one will roll back all the way to the start of the outhermost transaction when requested
    -   as a result a transaction shall never be rolled back just as a means of cancelling its work - the side effect might be of cancelling other work which had just been done previously

### Limitations in the SQL dialect supported

Striving to support Mysql 5, PostgreSQL xx and Oracle 10, the following limitations apply:

-   Tables, columns and other db objects should not use names longer than 30 chars
-   Varchar columns with a definition of *default "" not null* are discouraged
-   For SELECTs, offset and limit have to be handled by the php layer, not hardcoded in the sql
-   Never treat a NULL varchar value as semantically different from an empty string value
-   The select list of a query cannot contain the same field multiple times
-   For GROUP BY statements, all fields in the group by clause should be in the select list as well
-   For SELECTs, usage of the AS token is allowed in the select list, but not in the list of tables
-   Do not put quotes around numeric values (use proper casting/escaping to avoid SQL injection)
-   *&lt;TODO: finish sql guidelines&gt;*

 
