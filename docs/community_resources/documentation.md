# Contribute to Documentation

While we are doing our best to make sure our documentation fulfills all your needs, there is always place for improvement. If you'd like to contribute to our docs, you can do the following:

## How to contribute to documentation

This documentation is written on GitHub and generated into a static site. It is organized in branches. Each branch is a version of documentation (which in turn corresponds to a version of eZ Platform).

If you are familiar with the git workflow, you will find it easy to contribute.
Please create a Pull Request for any, even the smallest change you want to suggest.

### Contributing through the GitHub website

To quickly contribute a fix to a page, find the correct `*.md` files in the GitHub repository and select "Edit this file".

Introduce your changes, at the bottom of the page provide a title and a description of what you modified and select "Propose file change".

This will lead to a screen for creating a Pull Request. Enter the name and description and select "Create pull request".

Your pull request will be reviewed by the team and, when accepted, merged with the rest of the repository.
You will be notified of all activity related to the pull request by email.

### Contributing through git

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

### Contributing outside git and GitHub

- **Create a JIRA issue.** You can also report any omissions or inaccuracies you find by creating a JIRA issue. See [Report and follow issues](#report-and-follow-issues) on how to do this. Remember to add the "Documentation" component to your issue to make sure we don't lose track of it
- **Visit Slack.** The `\#documentation-contrib` channel on [eZ Community Slack team](http://ez-community-on-slack.herokuapp.com) is the place to drop your comments, suggestions, or proposals for things you'd like to see covered in documentation. (You can use the link to get an auto-invite to Slack)
- **Contact the Doc Team.** If you'd like to add to any part of the documentation, you can also contact the Doc Team directly at <doc-team@ez.no>

## Writing guidelines

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

### Markdown writing tools

You can write and edit Markdown in any text editor, including the most simple notepad-type applications, as well as most common IDEs.
You can also make use of some Markdown-dedicated tools, both online and desktop.
While we do not endorse any of the following tools, you may want to try out:

- online: [dillinger.io](http://dillinger.io), [jbt.github.io/markdown-editor](http://jbt.github.io/markdown-editor) or [stackedit.io](https://stackedit.io)
- desktop (open source): [atom.io](http://atom.io) or [brackets.io](http://brackets.io)

## Markdown primer

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

## Style Guide

*(see [above](#writing-guidelines-short-version) for a summary or writing guidelines)*

### Phrasing

- Address the reader with "you", not "the user."
- Do not use "we", unless specifically referring to the company.
- Avoid using other personal pronouns. If necessary, use "they," not "he," "he or she," "he/she."
- Use active, not passive as much as possible.
- Clearly say which parts of instructions are obligatory ("To do X you need to/must do Y") and which are optional ("If you want A, you may do B.")
- Do not use Latin abbreviations, besides "etc." and "e.g."

### Punctuation

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

### Formatting

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

### Naming

- use eZ Platform to refer to the product in general, or eZ Platform Enterprise Edition (eZ Enterprise in short) to refer to the commercial edition.
- use Studio (or Studio UI) to refer to the feature set and interface specific to eZ Enterprise.

## Conventions for some problematic words

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

## Some common grammatical and spelling mistakes

- **its** is a possessive ("This app and its awesome features"); **it's** is short for "it is"
("This app is awesome and it's open source")
- **allow** must be followed by "whom", -ing or a noun
("This allows you to do X", "This allows doing X" or "This allows X", but NOT just ~~"This allows to do X"~~)

## Detailed markdown conventions

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
