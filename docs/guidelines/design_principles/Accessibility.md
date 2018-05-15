! In progress

### Overview and limitations
The overall accessibility of any project built with eZ Platform CMS depends in large part on the author’s markup, additional styling, and scripting they’ve included. However, provided that these have been implemented correctly, it should be perfectly possible to create websites and applications with Bootstrap that fulfill WCAG 2.0 (A/AA/AAA), Section 508 and similar accessibility standards and requirements.

#### Markup
This documentation aims to provide developers with best practice examples to demonstrate the use of eZ Platform itself and illustrate appropriate semantic markup, including ways in which potential accessibility concerns can be addressed.

#### Interactive components
Bootstrap’s interactive components—such as modal dialogs, dropdown menus and custom tooltips—are designed to work for touch, mouse and keyboard users. Through the use of relevant WAI-ARIA roles and attributes, these components should also be understandable and operable using assistive technologies (such as screen readers).

Because Bootstrap’s components are purposely designed to be fairly generic, authors may need to include further ARIA roles and attributes, as well as JavaScript behavior, to more accurately convey the precise nature and functionality of their component. This is usually noted in the documentation.

#### Color contrast
Most colors that currently make up Bootstrap’s default palette—used throughout the framework for things such as button variations, alert variations, form validation indicators—lead to insufficient color contrast (below the recommended WCAG 2.0 color contrast ratio of 4.5:1) when used against a light background. Authors will need to manually modify/extend these default colors to ensure adequate color contrast ratios.

All color combinations have been previously tested to meet at least one or more of the minimum ratios that the [WCAG 2.0](https://www.w3.org/TR/WCAG20/) specifies for text and background color combinations. This compliance will help users who are colorblind or have low vision to better interact with our app, as well as it will benefit usability and readability for all users.

When planning a new color combination, check beforehand compliance with these standards. We suggest [Colour Contrast Analyser](https://www.paciellogroup.com/resources/contrastanalyser/) app.