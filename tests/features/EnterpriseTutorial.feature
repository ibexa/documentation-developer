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
        And I rebuild Webpack Encore assets

    @step2
    Scenario: Prepare the Landing Page
        Given I create a file "config/packages/ezplatform_page_fieldtype.yaml" containing "layoutdefinition.yaml"
        And I add thumbnail image to "public/assets/images/layouts/"
        And I create a file "templates/layouts/sidebar.html.twig" containing "sidebartemplate.html.twig"
        And I create a file "templates/full/landing_page.html.twig" containing "landingpagetemplate.html.twig"
        And I set the Landing Page template configuration in "config/packages/views.yaml"
        And I rebuild Webpack Encore assets

    @step3
    Scenario: Use existing blocks
        Given I create a file "templates/blocks/contentlist/default.html.twig" containing "contentlisttemplate.html.twig"
        And I add Content List layout configuration to "config/packages/ezplatform_page_fieldtype.yaml"
        And I set Content List image variations in "config/packages/image_variations.yaml"
        And I append to "assets/css/style.css" file "landingpage.css"
        And I add Content Scheduler layout configuration to "config/packages/ezplatform_page_fieldtype.yaml"
        And I create a file "templates/blocks/schedule/featured.html.twig" containing "scheduleblock.html.twig"
        And I set template for Article in "config/packages/views.yaml"
        And I create a file "templates/featured/article.html.twig" containing "article.html.twig"
        And I set Content Scheduler image variations in "config/packages/image_variations.yaml"
        And I append to "assets/css/style.css" file "contentscheduler.css"
        And I rebuild Webpack Encore assets

    @step4
    Scenario: Create a custom block
        Given I create configuration of Random block to "config/packages/ezplatform_page_fieldtype.yaml"
        And I create a file "templates/blocks/random/default.html.twig" containing "random.html.twig"
        And I create a file "src/Event/RandomBlockListener.php" containing "RandomBlockListener.php"
        And I copy the block icon to "public/assets/images/blocks"
        And I append to "assets/css/style.css" file "randomblock.css"
        And I rebuild Webpack Encore assets
