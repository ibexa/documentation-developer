# Reporting security issues in eZ Systems products

The security of our software is a primary concern and we take it seriously. No engineering team is perfect though, and if you do discover a security issue in one of our products we are very grateful for your help in reporting it to us privately, and refraining from public disclosure until we have found the solution and distributed it. Thank you!

## Channels

- If you're a customer or partner, please log in to your Service Portal at <https://support.ez.no/> and, in the "eZ Support Services" section, follow the link to the "Open new ticket", and report the issue as you would report a normal support request. eZ Systems Product Support will respond, take care of the report, and keep you informed of the developments.
- If you're not a customer or partner, please log in to the eZ Systems JIRA issue tracker: <https://jira.ez.no/> Create an account if you don't have one, it's free. Click the "Create" button in the top menu to create your report. For "Project", select either "eZ Publish / Platform" or "eZ Platform Enterprise Edition", depending on which product is affected by the bug. **Important: Use "Security Level": "Security"!** The engineering team will take care of your report.
- It is also possible to report security issues by email to <security@ez.no> - this requires no account.

## Verbosity

Please be verbose when reporting issues. The issue will be solved faster if you include:

- A **title** describing the gist of the issue in one sentence
- A **description** which includes the steps you take to produce the problem, what you expect the result to be, and what actually happens.
- Make it clear **why you consider it a security issue**. If you know, also include what type of security issue it is (example: SQL injection, CSRF, role/policy failure), what the nature of it is (example: slowing/stopping a web site, leaking sensitive information, destroying data, privilege escalation) and how easy it is to exploit (example: Does it require editor login?).

## Dialogue

The engineering team may need your help to clarify certain specifics, so please respond to such inquiries. We will keep you updated about the progress on our end.

## Responsible disclosure

Please give the engineering team time to produce and distribute a solution before you disclose the issue on other channels, if you plan to do so. Please discuss the specifics with the team.

## Attribution

We will, if you want, include your name and/or the name of your organisation, a link, and short description about you in the security notification we send out with the fix. Thank you!