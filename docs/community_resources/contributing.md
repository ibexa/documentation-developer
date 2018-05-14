# How to Contribute

Are you ready to become a part of the eZ Community? There are several ways in which you can contribute, from spotting and reporting bugs to committing to the documentation to discussing innovative uses on Slack to coding new bundles.

If you're looking to contribute code, whether in form of corrections or separate bundles with features, the open-source nature of eZ Platform lets you do this without any fuss using GitHub. Take a look at [Using GitHub](#using-github) and our [Development guidelines](#development-guidelines) to get started.

If you've noticed any improvement needed in the documentation, see how to [Contribute to Documentation](#contribute-to-documentation).

If you'd just like to let us know of a bug you've encountered, see how to report it in [Report and follow issues](#report-and-follow-issues).

If you'd like to contribute to a translation of eZ Platform interface, see [Contributing translations](#contributing-translations).

If what you're looking for is simply discussing the way you use eZ Platform, drop by to the [community website](http://share.ez.no) or the [eZ Community Slack team](https://ezcommunity.slack.com/).
 
## Report and follow issues

The development of eZ projects is organized using a bugtracker. It can be found here: <https://jira.ez.no>. Its role is to centralize references to all improvements, bug fixes and documentation being added to eZ projects.

The first thing you should do in order to be able to get involved and have feedback on what is happening on eZ projects is to create a JIRA account.

**Note:** The term "issue" is used to refer to a bugtracker item regardless of its type (bug, improvement, story, etc.)

!!! caution "Security issues"

    If you discover a security issue, please do not report it using regular channels, but instead take a look at [Security section](../guide/reporting_issues.md).

### How to find an existing issue

When you have a great idea or if you have found a bug, you may want to create a new issue to let everyone know about it. Before doing that, you should make sure no one has made a similar report before.

In order to do that, you should use the search page available in the top menu (under **Issues/Search for issues**) or the search box in the top right corner. Using filters and keywords you should be able to search and maybe find an issue to update instead of creating a new one.

### How to improve existing issues

Existing issues need to be monitored, sorted and updated in order to be processed in the best way possible.

In case of bugs, trying to reproduce them, in order to confirm that they are (still) valid, is a great help for developers who will later troubleshoot and fix them. By doing that you can also provide extra information, if needed, such as:

- Extra steps to reproduce
- Context/environment-specific information
- Links to duplicate or related issues

In case of improvements, you can add extra use cases and spot behaviors that might be tricky or misleading.

### How to follow an issue

Every issue has a "Start watching this issue" link. It lets you receive notifications each time the issue is updated.

This way you can get and provide feedback during the issue's life. You are also informed about ongoing development regarding the issue and can try out patches before they are integrated into the product.

### How to report an issue

If you cannot find an issue matching what you are about to report using the search page, you can create a new one.
Click **Create** at the top of the bugtracker window and fill in the form:

|||
|------|------|
|**Project**|Select **eZ Publish/Platform** if your issue affects platform as a standalone project, or **eZ Platform Enterprise Edition** if it is needed in order to reproduce the issue.|
|**Issue type**|Choose **Bug** or **Improvement** depending on what you are reporting, do not use other issue types (they are for internal use only).|
|**Summary**|Write a short sentence describing what you are reporting.|
|**Security level**|Select security if you are reporting a security issue. It will make your issue visible only to you and the core dev team until it is fixed and distributed.|
|**Priority**|Select the priority you consider the issue to be. Please try to keep a cool head while selecting it. A 1 pixel alignment bug is not a "blocker".|
|**Component/s**|This is important, as it will make your issue appear on the radar (dashboards, filters) of people dealing with various parts of eZ projects.|
|**Affect version/s**|Add the versions of the application you experienced the issue on.|
|**Fix version/s**|Leave blank.|
|**Assignee**|Leave blank, unless you are willing to work on the issue yourself.|
|**Reporter**|Leave as is (yourself).|
|**Environment**|Enter specific information regarding your environment that could be relevant in the context of the issues.|
|**Description**|This is the most important part of the issue report. In case of a bug, it **must** contain explicit steps to reproduce your issue. Anybody should be able to reproduce it at first try. In case of an improvement, it needs to contain use cases and detailed information regarding the expected behavior.|
|**Labels**|Leave blank.|
|**Epic Link**|Leave blank.|
|**Sprint**|Leave blank.|
 
## Contributing translations

If you'd like to see eZ Platform in your language, you can contribute to the translations. Contributing is made easy by using Crowdin, which allows you to translate elements of the interface in context.

### How to translate the interface using Crowdin

If you wish to contribute to an existing translation of PlatformUI or start a new one, the best way is to start with in-context translation (but you can also [translate directly on the Crowdin website](#translating-outside-in-context)).

### Preparing to use in-context

To start translating, you need an option to turn in-context translation on and off. To do this, set a browser cookie. There are several ways to do this, but we will highlight a couple here.

#### Using bookmarks

You can easily create a bookmark to toggle in-context on/off.

Right-click your browser's bookmark bar, and create a new bookmark as shown in the screenshot below:

![Bookmark for toggling in-context translation](img/toggle_incontext.png "Bookmark for toggling in-context translation")

**Name**: Toggle in-context

**URL**: `javascript:function hasInContextCookie(){ return document.cookie.match(/^(.*;)?\s*ez_in_context_translation\s*=\s*[^;]+(.*)?$/);}(function () { document.cookie = hasInContextCookie() ? document.cookie = &#39;ez_in_context_translation=;expires=Mon, 05 Jul 2000 00:00:00 GMT;path=/;&#39;: document.cookie=&#39;ez_in_context_translation=1;path=/;&#39;; location.reload()})()`

Clicking the bookmark while on PlatformUI will toggle in-context translation on/off.

#### Using the debugging console

Another way is to open the development console and run this line:

``` javascript
function hasInContextCookie(){ return document.cookie.match(/^(.*;)?\s*ez_in_context_translation\s*=\s*[^;]+(.*)?$/);}(function () { document.cookie = hasInContextCookie() ? document.cookie = 'ez_in_context_translation=;expires=Mon, 05 Jul 2000 00:00:00 GMT;path=/;': document.cookie='ez_in_context_translation=1;path=/;'; location.reload()})()
```

### Using in-context translation

The first time you enable in-context, if you're not logged into Crowdin, it will ask you to log in or register an account. Once done, it will ask you which language you want to translate to, from the list of languages configured in Crowdin.

Choose your language and you can start translating right away. Strings in the interface that can be translated will be outlined in red (untranslated), blue (translated) or green (approved). When moving over them, an edit button will show up on the top left corner of the outline. Click on it, and edit the string in the window that shows up.

![In-context translation of Platform UI](img/incontext_translation_ezplatform_crowdin.png "In-context translation of Platform UI")

##### Troubleshooting

Make sure you clear your browser's cache in addition to eZ Platform's. Some of the translation resources use aggressive HTTP cache.

### Translating outside in-context

If you prefer not to use in-context, simply visit [eZ Platform's Crowdin page](https://crowdin.com/project/ezplatform), choose a language and you will see a list of files containing strings. Here you can suggest your translations.

If the language you want to translate to is not available, you can ask for it to be added in the [Crowdin discussion forum for eZ Platform](https://crowdin.com/project/ezplatform/discussions).

### Install new translation package

To make use of the UI translations, you need to install the new translation package in your project.

#### Translation packages per language

To allow users to install only what they need, we have split every language into a dedicated package.

All translation packages are published on [ezplatform-i18n organisation on github](https://github.com/ezplatform-i18n)

#### Install a new language in your project

If you want to install a new language in your project, you just have to install the corresponding package.

For example, if you want to translate your application into French, you just have to run:

`composer require ezplatform-i18n/ezplatform-i18n-fr_fr`

and then clear the cache.

Now you can reload your eZ Platform administration page which will be translated in French (if your browser is configured to fr\_FR.)

### Full translation workflow

You can read a full description of how new translations are prepared and distributed in [the documentation of GitHub](https://github.com/ezsystems/ezplatform/blob/1.8/doc/i18n/translation_workflow.md).

## Development guidelines

These are the development/coding guidelines for eZ Platform kernel, they are the same if you intend to write Bundles, hack on eZ Platform itself or create new functionality for or on top of eZ Platform.

Like most development guidelines these aims to improve security, maintainability, performance and readability of our software. They follow industry standards but sometimes extend them to cater specifically to our needs for eZ Platform ecosystem. The next sections will cover all relevant technologies from a high level point of view.

### HTTP

eZ Platform is a web software that is reached via HTTP in most cases, out of the box in eZ Platform kernel this is specifically: web (usually HTML) or REST.

We aim to follow the [latest](http://trac.tools.ietf.org/wg/httpbis/trac/wiki#HTTP1.1Deliverables) stable HTTP specification, and industry best practice:

- **Expose our data in a RESTful way**
    - GET, HEAD, OPTIONS and TRACE methods are [safe](http://tools.ietf.org/html/draft-ietf-httpbis-p2-semantics-21#section-5.2.1) (otherwise known as [nullipotent](http://en.wiktionary.org/wiki/nullipotent)), as in: should never cause changes to resources (note: things like writing a line in a log file are not considered resource changes)
    - PUT and DELETE methods are [idempotent](http://tools.ietf.org/html/draft-ietf-httpbis-p2-semantics-21#section-5.2.2), as in multiple identical requests should all have the same result as a single request
    - GET and HEAD methods should be [cacheable](http://tools.ietf.org/html/draft-ietf-httpbis-p2-semantics-21#section-5.2.3) both on client side, server-side and proxies between, as further defined in the HTTP [specification](http://tools.ietf.org/html/draft-ietf-httpbis-p6-cache-21)
    - As PUT is for replacing a resource, we should use [PATCH](http://tools.ietf.org/html/rfc5789) in cases where only partial replacement is intended
- **Authenticated traffic**
    - Should use HTTPS
- **Session based traffic**
    - Should follow recommendations for *Authenticated traffic*
    - Should use a per user session [CSRF](http://en.wikipedia.org/wiki/Cross-site_request_forgery) token on all requests using un-safe HTTP methods (POST, PUT, DELETE, PATCH, ...)
    - Should expire session ID, session data and CSRF token on login, logout and session time out, except:
        - On login session data from previous session ID is moved to new session ID, keeping for instance shopping basket on login
    - Should avoid timing attacks by using a random amount of time for login operation
    - Should never use Session ID in URI's. And this feature ("SID") must always be disabled on production servers
- **Sessions**
    - Should not be used to store large amounts of data; store data in database and ID's in session if needed
    - Should not store critical data: if user deletes his cookies or closes his browser session data is lost
    - Should use an ID generated with enough randomness to prevent prediction or brute-force attacks
- **Cookies (especially session cookies)**
    - Should never store sensitive data in cookies (only exception is session ID in session cookie)
    - Should always set *Full domain* to avoid [cross-subdomain cooking](http://en.wikipedia.org/wiki/Session_fixation#Attacks_using_cross-subdomain_cooking) when on shared domain.
    - Should set *HttpOnly* flag to reduce risk of attacks such as [cross-site cooking](http://en.wikipedia.org/wiki/Session_fixation#Attacks_using_cross-site_cooking) and [cross-site scripting](http://en.wikipedia.org/wiki/Cross-site_scripting "Cross-site scripting")
    - Should set *Secure flag* if HTTPS is used (as recommended above)
    - Must never exceed 4kb
- **Headers**
    - Should never include input data from user input or data from database without sanitizing it
- **Redirects**
    - Should never take URL from user input (example: POST parameter), instead allow identifiers instead that are understood by the backend
- **User input**
    - Should always be validated, sanitized, casted and filtered to avoid [XSS](http://en.wikipedia.org/wiki/Cross-site_scripting) and [clickjacking](http://en.wikipedia.org/wiki/Clickjacking) attacks
        - Note: this includes variables in the php supervariable `$_SERVER` as well (e.g. hostname should not be trusted)
- **User file uploads**
    - Should follow recommendations for "User input" to validate file name
    - Should place uploaded files in a non public folder to avoid access to execute uploaded file or in case of assets white list the type
    - Should be appropriately limited in size to avoid DOS attacks on disk space, CPU usage by antivirus tool etc...
- **File downloads**
    - Should not rely on user provided file path for non public files, instead use a synthetic ID
- **Admin operations**
    - May be placed on a different (sub)domain then the front end website to avoid session stealing across front and backend.
- **Fully support being placed behind a reverse proxy like [Varnish](https://www.varnish-cache.org/)**

### REST

For now see the living [REST v2 specification](https://github.com/ezsystems/ezp-next/blob/master/doc/specifications/rest/REST-API-V2.rst) in our git repository for further details.

### UI

eZ Platform is often used as a web content management software, so we always strive to use the HTML/CSS/EcmaScript specifications correctly, and keep new releases up to date on new revisions of those. We furthermore always try to make sure our software gracefully degrades making sure it is useful even on older or less capable web clients (browsers), the industry terms for this approach are:

- [Progressive enhancement](http://en.wikipedia.org/wiki/Progressive_enhancement "Progressive enhancement")
- [Unobtrusive JavaScript](http://en.wikipedia.org/wiki/Unobtrusive_JavaScript)
- [Responsive Design](http://en.wikipedia.org/wiki/Responsive_Web_Design "Responsive Web Design")

All these terms in general recommends aiming for the minimum standard first, and enhance with additional features/styling if the client is capable of doing so. In essence this allows eZ Platform to be "Mobile first" if the design allows for it, which is recommended. But eZ Platform should always also be fully capable of having different sets of web presentations for different devices using one or several sets of SiteAccess matching rules for the domain, port or URI, so any kind of device detection can be used together with eZ Platform, making it fully possible to write for instance [WAP](http://en.wikipedia.org/wiki/Wireless_Application_Protocol) based websites and interfaces on top of eZ Platform.

#### WEB Forms/Ajax

As stated in the HTTP section, all unsafe requests to the web server should have a CSRF token to protect against attacks; this includes web forms and ajax requests that don't use the GET http method. As also stated in the HTTP section and further defined in the PHP section, User input should always be validated to avoid XSS issues.

#### HTML/Templates

All data that comes from backend and in return comes from user input should always be escaped, in case of Twig templates this done by default, but in case of PHP templates, Ajax and other not Twig based output this must be handled manually.

Output escaping must be properly executed according to the desired format, eg. javascript vs. html, but also taking into account the correct character set (see e.g. output escaping fallacy when not specifying charset encoding in [htmlspecialchars](http://www.php.net/htmlspecialchars))

#### Admin

Admin operations that can have a severe impact on the web applications should require providing password and require it again after some time has gone, normally 10-20 minutes, on all session based interfaces.

### PHP

For now see our comprehensive coding standard and guidelines [wiki page](https://github.com/ezsystems/ezpublish-kernel/wiki/codingstandards) on github.

!!! note "eZ Coding Standards Tools"

    See also [eZ Coding Standards Tools](https://github.com/ezsystems/ezcs) repository to get the configuration files for your favorite tools.

#### Public API

The PHP public API provided in eZ Platform is in most cases in charge of checking permissions to data for you, but some API's are not documented to throw `UnauthorizedException`, which means that it is the consumer of the API's who is responsible for checking permissions.

The following example shows how this is done in the case of loading users:

**loadUser()**

``` php
// Get a user
$userId = (int)$params['id'];
$userService = $repository->getUserService();
$user = $userService->loadUser( $userId );

// Now check that current user has access to read this user
if ( !$repository->canUser( 'content', 'read', $user ) )
{
    // Generates message: User does not have access to 'content' 'read' with id '10'
    throw new \eZ\Publish\Core\Base\Exceptions\UnauthorizedException( 'content', 'read', [ 'id' => $userId ] );
}
```

#### Command line

Output must always be escaped when displaying data from the database.

### Data and databases

- Values coming from variables should always be appropriately quoted or binded in SQL statements
- The SQL statements used should never be created by hand with one version per supported database, as this increases both the maintenance load and the chances for security-related problems
- Usage of temporary tables is discouraged, as their behavior is very different on different databases. Subselects should be preferred (esp. since recent mysql versions have much better support for them)
- Full table locking is discouraged

#### Sessions

- Business logic should not depend on database connections being either persistent or not persistent
- The connection to the database should always be opened as late as possible during page execution. Ideally, to improve scalability, a web page executing no queries should not connect to the database at all (note that closing the database connection as soon as possible is a tricky problem, as we expect to support persistent database connections as well for absolute best performances)
- The same principle applies to configurations where a master/slave database setup is in use: the chance for a failure due to a database malfunction should not increase with the number of database servers at play, but actually decrease
- It is recommended to avoid as much as possible statements which alter the current session, as they slow down the application, are brittle and hard to debug.
    Point in case; if a database session locks a table then is abruptly terminated, the table might stay locked for a long time

#### Transactions

- Transactions should always be used to wrap sql statements which affect data in multiple tables: either all data changes go through or none of them
- Transactions are prone to locking issues, so the code executed within a transaction should be limited to the minimum necessary amount (ex. clearing caches should be done after the transaction is committed)
- When using transactions, always consider side effects on external system, such as on-disk storage. E.g. is a transaction relative to creating an image variation is rolled back, the corresponding file should not be left on disk
- Nested transactions are supported in the following way:
    - a transaction within another one will not commit when requested, only the outermost transaction will commit
    - a transaction within another one will roll back all the way to the start of the outermost transaction when requested
    - as a result a transaction shall never be rolled back just as a means of cancelling its work - the side effect might be of cancelling other work which had just been done previously

#### Limitations in the SQL dialect supported

Striving to support Mysql 5, PostgreSQL xx and Oracle 10, the following limitations apply:

- Tables, columns and other database objects should not use names longer than 30 chars
- Varchar columns with a definition of *default "" not null* are discouraged
- For SELECTs, offset and limit have to be handled by the php layer, not hardcoded in the SQL
- Never treat a NULL varchar value as semantically different from an empty string value
- The select list of a query cannot contain the same field multiple times
- For GROUP BY statements, all fields in the group by clause should be in the select list as well
- For SELECTs, usage of the AS token is allowed in the select list, but not in the list of tables
- Do not put quotes around numeric values (use proper casting/escaping to avoid SQL injection)
 
## Contribute to Documentation

While we are doing our best to make sure our documentation fulfills all your needs, there is always place for improvement. If you'd like to contribute to our docs, you can do the following:

### How to contribute to documentation

This documentation is written on GitHub and generated into a static site. It is organized in branches. Each branch is a version of documentation (which in turn corresponds to a version of eZ Platform).

If you are familiar with the git workflow, you will find it easy to contribute.
Please create a Pull Request for any, even the smallest change you want to suggest.

#### Contributing through the GitHub website

To quickly contribute a fix to a page, find the correct `*.md` files in the GitHub repository and select "Edit this file".

Introduce your changes, at the bottom of the page provide a title and a description of what you modified and select "Propose file change".

This will lead to a screen for creating a Pull Request. Enter the name and description and select "Create pull request".

Your pull request will be reviewed by the team and, when accepted, merged with the rest of the repository.
You will be notified of all activity related to the pull request by email.

#### Contributing through git

You can also contribute to the documentation using regular git workflow.
If you are familiar with it, this should be quick work.

1. Assuming you have a GitHub account and a git command line tool installed,
fork the project and clone it into a folder: `git clone XXX .`

1. Add your own fork as a remote: `git remote add fork <address of your fork>`.

1. Checkout the branch you want to contribute to:

```
git checkout <branch name>
git fetch origin
git rebase origin/<branch name>
```

!!! note "Choosing a branch"

    Always contribute to the **earliest** branch that a change applies to.
    For example, if a change concerns versions v1.7 and v.1.13, make your contribution to the `v1.7` branch.
    The changes will be merged forward to be included in later versions as well.

1. Create a new local branch: `git checkout -b <name of your new branch>`.

1. Now introduce whatever changes you wish, either modifying existing files, or creating new ones.

1. Once you are happy with your edits, add your files to the staging area. Use `git add .` to add all changes.

1. Commit your changes, with a short, clear description of your changes: `git commit -m "Description of commit"`.

1. Now push your changes to your fork: `git push fork <name of your branch>`.

1. Finally, you can go to the project's page on GitHub and you should see a "Compare and pull request" button. Activate it, write a description and select "Create pull request". If your contribution solves a JIRA issues, start the pull request's name with the issue number. Now you can wait for your changes to be reviewed and merged.

#### Contributing outside git and GitHub

- **Create a JIRA issue.** You can also report any omissions or inaccuracies you find by creating a JIRA issue. See [Report and follow issues](#report-and-follow-issues) on how to do this. Remember to add the "Documentation" component to your issue to make sure we don't lose track of it
- **Visit Slack.** The `\#documentation-contrib` channel on [eZ Community Slack team](http://ez-community-on-slack.herokuapp.com) is the place to drop your comments, suggestions, or proposals for things you'd like to see covered in documentation. (You can use the link to get an auto-invite to Slack)
- **Contact the Doc Team.** If you'd like to add to any part of the documentation, you can also contact the Doc Team directly at <doc-team@ez.no>

### Writing guidelines

*(see [Style Guide](#style-guide) below for more details)*

- Write in (GitHub-flavored) Markdown
- Try to keep lines no longer than 120 characters. If possible, break lines in logical places, for example at sentence end.
- Use simple language
- Call the user "you" (not "the user", "we", etc.).
Use gender-neutral language: the visitor has *their* account, not *his*, *her*, *his/her*, etc.

**Do not be discouraged** if you are not a native speaker of English and/or are not sure about your style.
Our team will proofread your contribution and make sure any problems are fixed. Any edits we do are not intended to be criticism of your work.
We may simply modify the language of your contributions according to our style guide,
to make sure the terminology is consistent throughout the docs, and so on.

#### Markdown writing tools

You can write and edit Markdown in any text editor, including the most simple notepad-type applications, as well as most common IDEs.
You can also make use of some Markdown-dedicated tools, both online and desktop.
While we do not endorse any of the following tools, you may want to try out:

- online: [dillinger.io](http://dillinger.io), [jbt.github.io/markdown-editor](http://jbt.github.io/markdown-editor) or [stackedit.io](https://stackedit.io)
- desktop (open source): [atom.io](http://atom.io) or [brackets.io](http://brackets.io)

### Markdown primer

*(see [below](#detailed-markdown-conventions) for more detailed markdown conventions we apply)*

[Markdown](http://daringfireball.net/projects/markdown/) is a light and simple text format
that allows you to write quickly using almost any tool, and lets us generate HTML based on it.
Even if you are not familiar with Markdown, writing in it is very similar to writing plain text, with a handful of exceptions.
Here's a list of most important Markdown rules as we use them:

- Each paragraph must be separated by a blank line. A single line break will not create a new paragraph.
- A heading starts with a number of hash marks (#): level 1 heading starts with **#**, level two heading with **##**, and so on.
- In an unordered list each item starts with a dash (**-**) and a space. Items within one list are not separated with blank lines.
- In an ordered list each item starts with a number, period and a space. Here items within one list are also not separated.
- You can put *emphasis* on text by surrounding it with single asterisks (*), and **bold** the text using double asterisks.
- You can mark part of a text as code (`monospace`) by surrounding it with single backticks (**`**).
- If you need a longer, multi-line piece of code, put it in a separate paragraph and add a line with three backticks (**```**)
- To add a link, enter the link title in square brackets immediately followed by the link proper in regular brackets.
- To add an image, start with an exclamation mark (**!**),
then provide the alt text in square brackets immediately followed by the link to the image in regular brackets.

You can find a detailed description of all features of Markdown [in its syntax doc](http://daringfireball.net/projects/markdown/syntax).

This page is written in Markdown. View it on GitHub and select **Raw** in the upper right corner to see an example of a document in Markdown.

### Style Guide

*(see [above](#writing-guidelines-short-version) for a summary or writing guidelines)*

#### Phrasing

- Address the reader with "you", not "the user."
- Do not use "we", unless specifically referring to the company.
- Avoid using other personal pronouns. If necessary, use "they," not "he," "he or she," "he/she."
- Use active, not passive as much as possible.
- Clearly say which parts of instructions are obligatory ("To do X you need to/must do Y") and which are optional ("If you want A, you may do B.")
- Do not use Latin abbreviations, besides "etc." and "e.g."

#### Punctuation

- Use American English spelling.
- Use American-style dates: January 31, 2016 or 01/31/2016.
- Use sentence-style capitalization for titles and headings (only capitalize words that would have capital letters in a normal sentence).
- Do not use periods (full stops) or colons at the end of headings.
- Do not use a space before question mark, colon (:) or semi-colon (;).
- Do not use symbols instead of regular words, for example "&" for "and" or "#" for "number".
- Do not end list items with a comma or period, unless the item contains a whole sentence.
- Place commas and periods inside quotation marks and other punctuation outside quotations.
- Use the [Oxford comma](https://en.wikipedia.org/wiki/Serial_comma) ([especially when it clarifies meaning](https://www.grammarly.com/blog/what-is-the-oxford-comma-and-why-do-people-care-so-much-about-it/))
- pluralize acronyms with a simple "s", without apostrophe: "URLs", "IDs", not ~~URL's~~, ~~ID's~~

#### Formatting

- Mark interface elements with **bold** the first time they appear in a given section (not necessarily every single time).
- Capitalize interface elements the way they are capitalized in the interface.
- Capitalize domain names.
- Capitalize names of third-party products/services, etc., unless they are explicitly spelled otherwise
(e.g. use "GitHub" NOT "github", but "git" not "Git"; "Composer", not "composer"), or unless used in commands (`composer update`).
- When linking, provide a description of the target in the link text (e.g. "See the templating documentation", NOT "Click for more info").
- If possible, link to specific heading, not just to a general page (especially with longer pages).
- Use numbered lists to list steps in a procedure or items that are explicitly counted
(e.g.: "There are three ways to ..." followed by a numbered list). In other cases, use a bullet list.
- If a procedure has long steps that would require multiple paragraphs, consider using numbered low-level headings instead.
- Use code marking (backtick quotes) for commands, parameters, file names, etc.

#### Naming

- use eZ Platform to refer to the product in general, or eZ Platform Enterprise Edition (eZ Enterprise in short) to refer to the commercial edition.
- use Studio (or Studio UI) to refer to the feature set and interface specific to eZ Enterprise.

### Conventions for some problematic words

- **add-on** has a hyphen
- **backup** is a noun ("Make a backup"); **back up** is a verb ("Back up you data")
- **content** is uncountable, if you have more than one piece of content, call it a **Content item**
- **email** has no hyphen
- **login** is a noun ("Enter your login"); **log in** is a verb ("Log in to the application")
- **open source** is used after a verb ("This software is open source");
**open-source** is used when describing a noun ("This is open-source software")
- **reset** is written as one word
- **setup** is a noun ("Setup is required"); **set up** is a verb ("You must set up this or that")
- **back end** is a noun ("This is done on the back end"); **back-end** is an adjective ("On the back-end side")
- **hard-coded** has a hyphen
- ~~**click** something, not "click on" ("Click the button" not ~~"Click on the button"~~)~~
    - if possible, use **select** or **activate** instead of **click**
- **vs.** is followed by a period (full stop)

### Some common grammatical and spelling mistakes

- **its** is a possessive ("This app and its awesome features"); **it's** is short for "it is"
("This app is awesome and it's open source")
- **allow** must be followed by "whom", -ing or a noun
("This allows you to do X", "This allows doing X" or "This allows X", but NOT just ~~"This allows to do X"~~)

### Detailed markdown conventions

- **Headings:** Always put page title in H1, do not use H1 besides page titles.
- **Headings:** Do not create headings via underlines (setext-style headings).
- **Whiteline:** Always divide paragraphs, headings, code blocks, lists and pretty much everything else
with one (and only one) whiteline.
- **Code:** Mark all commands, filenames, paths and folder names, parameters and GitHub repo names as code.
- **Code:** In code blocks, where relevant, put the name of the file they concern
in the first line in a *comment proper for the language*.
- **Code:** In code blocks, if possible, always provide language.
Pygments does not have syntax highlighting for Twig, so use `html` instead.
- **Lists:** Use dashes for unordered lists and "1." for ordered list
(yes, always "1", it will be interpreted as proper numbers in the list).
- **Images:** Always add the `alt` text in square brackets.
Add title in quotations marks after the image link (inside parenthesis) if you want a caption under the image.
- **Note boxes:** Write the following way. Possible types are `note`, `tip`, `caution`.

```
!!! tip "This is note title"

    This is note text, indented. Can span more paragraphs, all indented
```

Which will result in:

!!! tip "This is note title"

    This is note text, indented. Can span more paragraphs, all indented

- **Table of contents**: Insert a table of contents of the heading inside a page using `[TOC]`.
