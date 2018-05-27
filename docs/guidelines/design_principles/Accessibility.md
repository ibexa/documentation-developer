## <div class="mgt-2">Overview and limitations</div>
The overall accessibility of any project built with eZ Platform CMS depends in large part on the author’s markup, additional styling, and scripting they’ve included. However, provided that these have been implemented correctly, it should be perfectly possible to create websites and applications with Bootstrap that fulfill WCAG 2.0 (A/AA/AAA), Section 508 and similar accessibility standards and requirements.

### <div class="mgt-2">Markup</div>
This documentation aims to provide developers with best practice examples to demonstrate the use of eZ Platform itself and illustrate appropriate semantic markup, including ways in which potential accessibility concerns can be addressed.

### <div class="mgt-2">Interactive components</div>
Regarding interactive components—such as modal dialogs, dropdown menus and custom tooltips—are we rely on Bootstrap´s framework that designed them to work for touch, mouse and keyboard users. Through the use of relevant WAI-ARIA roles and attributes, these components should also be understandable and operable using assistive technologies (such as screen readers).

For more information regarding this topic, please check [Bootstrap's Accessibility](https://getbootstrap.com/docs/4.0/getting-started/accessibility/) section.

### <div class="mgt-2">Color contrast</div>
**Visual hierarchy and differentiation.** We prioritize Create and Edit content as main functions in our CMS with orange color. Because most of the application has soft colors, color stands out and catches user's attention. We also define secondary, neutral and negative colors. Despite of this, it is also important to remind to not always rely on color to provide visual differentiation. If too many colors are employed, colors might lose their meaning.

All color combinations have been previously tested to meet at least one or more of the minimum ratios that the [WCAG 2.0](https://www.w3.org/TR/WCAG20/) specifies for text and background color combinations. This compliance will help users who are colorblind or have low vision to better interact with our app, as well as it will benefit usability and readability for all users.

When planning a new color combination, check beforehand compliance with these standards. We suggest [Colour Contrast Analyser](https://www.paciellogroup.com/resources/contrastanalyser/) app.
