# Contribute to documentation

While we are doing our best to make sure our documentation fulfills all your needs, there is always place for improvement. If you'd like to contribute to our docs, you can do the following:

## How to contribute to documentation

This documentation is written on GitHub and generated into a static site. It is organized in branches. Each branch is a version of documentation (which in turn corresponds to a version of [[= product_name =]]).

If you are familiar with the git workflow, you will find it easy to contribute.
Please create a Pull Request for any, even the smallest change you want to suggest.

### Contributing through the GitHub website

To quickly contribute a fix to a page, find the correct `*.md` file in the GitHub repository and select "Edit this file".

Introduce your changes, at the bottom of the page provide a title and a description of what you modified and select "Propose file change".

This will lead to a screen for creating a Pull Request. Enter a name and description for the pull request and select "Create pull request".

Your pull request will be reviewed by the team and, when accepted, merged with the rest of the repository.
You will be notified of all activity related to the pull request by email.

### Contributing through git

You can also contribute to the documentation by using a regular git workflow.
If you are familiar with it, this should be quick work.

1. Assuming that you have a GitHub account and a git command line tool installed,
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

- **Create a JIRA issue.** You can also report any omissions or inaccuracies you find by creating a JIRA issue. See [Report and follow issues](report_follow_issues.md) on how to do this. Remember to add the "Documentation" component to your issue to make sure we don't lose track of it
- **Visit Slack.** The `\#documentation-contrib` channel on [eZ Community Slack team](http://ez-community-on-slack.herokuapp.com) is the place to drop your comments, suggestions, or proposals for things you'd like to see covered in documentation. (You can use the link to get an auto-invite to Slack)
- **Contact the Doc Team.** If you'd like to add to any part of the documentation, you can also contact the Doc Team directly at <doc-team@ez.no>

## Writing guidelines

- Write in (GitHub-flavored) Markdown
- Try to keep lines no longer than 120 characters. If possible, break lines in logical places, for example at sentence end.
- Use simple language
- Call the user "you" (not "the user", "we", etc.).
Use gender-neutral language: the visitor has *their* account, not *his*, *her*, *his/her*, etc.

**Do not be discouraged** if you are not a native speaker of English and/or are not sure about your style.
Our team will proofread your contribution and make sure any problems are fixed. Any edits we do are not intended to be a criticism of your work.
We may simply modify the language of your contributions according to our style guide,
to make sure the terminology is consistent throughout the docs, and so on.
