Feature: Setup eZ Platform Enterprise dogs tutorial

    @step1
    Scenario: Get a starter website
        Given I create a "Dog Breed" Content Type with "dog_breed" identifier:
            | Field Type | Name              | Identifier        | Required | Searchable | Translatable |
            | Text line	 | Name              | name	             | yes      | yes	     | yes          |
            | Text line	 | Short Description | short_description | yes      | yes	     | yes          |
            | Image	     | Photo	         | photo	         | yes      | no	     | no           |
            | RichText	 | Full Description	 | description       | yes      | yes	     | yes          |
        And I create a "Tip" Content Type with "tip" identifier:
            | Field Type | Name	 | Identifier | Required | Searchable | Translatable |
            | Text line	 | Title | title	  | yes	     | yes	      | yes          |
            | Text block | Body	 | body	      | no	     | no	      | yes          |
        And I remove "image" field from Article Content Type
        And I add field to Article Content Type
            | Field Type | Name  | Identifier |	Required | Searchable |	Translatable |
            | Image      | Image | image      | no	     | no         |	yes          |
        And I add imports to "app/config/config.yml"
            | name                 |
            | image_variations.yml |
            | views.yml            |
        And I add necessary configuration
        And I create "folder" Content items in "Home"
            | contentName       |
            | All Articles      |
            | Dog Breed Catalog |
            | All Tips          |
        And I create "article" Content items in "Home/All Articles"
            | contentName                               | imageName    |
            | Dog favorites                             | article1.jpg |
            | Adopt or buy?                             | article2.jpg |
            | Dogs and other pets                       | article3.jpg |
            | Taking care of your dog during a heatwave | article4.jpg |
            | Dog owner's first steps                   | article5.jpg |
            | Traveling with your dog                   | article6.jpg |
        And I create "dog_breed" Content items in "Home/Dog Breed Catalog"
            | contentName          | imageName                |
            | Alsatian             | alsatian.jpg             |
            | King Charles Spaniel | king-charles-spaniel.jpg |
            | St Bernard           | st-bernard.jpg           |
        And I create "tip" Content items in "Home/All Tips"
            | contentName |
            | Tip1        |
            | Tip2        |
            | Tip3        |
        And I delete eZ Platform Folder under Home

    @step2
    Scenario: Prepare the Landing Page
        Given I create a file "app/config/layouts.yml" containing "layoutdefinition.yml"
        And I add imports to "app/config/config.yml"
            | name        |
            | layouts.yml |
        And I add thumbnail image to "web/assets/images/layouts/"
        And I create a file "app/Resources/views/layouts/sidebar.html.twig" containing "sidebartemplate.html.twig"
        And I create a file "app/Resources/views/full/landing_page.html.twig" containing "landingpagetemplate.html.twig"
        And I set the Landing Page template configuration in "app/config/views.yml"

    @step3
    Scenario: Use existing blocks
        Given I create a file "app/Resources/views/blocks/contentlist/default.html.twig" containing "contentlisttemplate.html.twig"
        And I add Content List layout configuration to "app/config/layouts.yml"
        And I set Content List image variations in "app/config/image_variations.yml"
        And I append to "web/assets/css/style.css" file "landingpage.css"
        And I add Content Scheduler layout configuration to "app/config/layouts.yml"
        And I create a file "app/Resources/views/blocks/schedule/featured.html.twig" containing "scheduleblock.html.twig"
        And I set template for Article in "app/config/views.yml"
        And I create a file "app/Resources/views/featured/article.html.twig" containing "article.html.twig"
        And I set Content Scheduler image variations in "app/config/image_variations.yml"
        And I append to "web/assets/css/style.css" file "contentscheduler.css"

    @step4
    Scenario: Create a custom block
        Given I create configuration of Random block to "app/config/layouts.yml"
        And I create a file "app/Resources/views/blocks/random/default.html.twig" containing "random.html.twig"
        And I create a file "src/AppBundle/Event/RandomBlockListener.php" containing "RandomBlockListener.php"
        And I copy the block icon to "web/assets/images/blocks"
        And I add RandomBlockListener service configuration to "app/config/services.yml"
        And I append to "web/assets/css/style.css" file "randomblock.css"
