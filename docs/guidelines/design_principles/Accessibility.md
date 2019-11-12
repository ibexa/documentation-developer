# Accessibility

### Overview and limitations

The overall accessibility of any project built with eZ Platform depends in large part on the author's markup, additional styling, and scripting they've included. However, provided that these have been implemented correctly, it should be perfectly possible to create websites and applications with Bootstrap that fulfill WCAG 2.0 (A/AA/AAA), Section 508 and similar accessibility standards and requirements.

### Markup

This documentation aims to provide developers with best practice examples to demonstrate the use of eZ Platform itself and illustrate appropriate semantic markup, including ways in which potential accessibility concerns can be addressed.

### Interactive components

Regarding interactive components — such as modal dialogs, dropdown menus and custom tooltips — we rely on Bootstrap's framework that designed them to work for touch, mouse and keyboard users. Through the use of relevant WAI-ARIA roles and attributes, these components should also be understandable and operable using assistive technologies (such as screen readers).

As standard practice for users of assistive technologies, as well as for other users using keyboard for website navigation, we add <code>tab-index="-1"</code> to a HTML element/node wherever needed, when a click handler had been attached to it. It's applicable to all other HTML elements different than <code>button</code> and <code>a</code>.

For more information regarding this topic, please check [Bootstrap's Accessibility](https://getbootstrap.com/docs/4.0/getting-started/accessibility/) section.

### Color contrast

All color combinations have been previously tested to meet at least one or more of the minimum ratios that the [WCAG 2.0](https://www.w3.org/TR/WCAG20/) specifies for text and background color combinations. This compliance will help users who are colorblind or have low vision to better interact with our app, as well as it will benefit usability and readability for all users.

When planning a new color combination, check beforehand compliance with these standards. We suggest [Colour Contrast Analyser](https://www.paciellogroup.com/resources/contrastanalyser/) app.
