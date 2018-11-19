#!/bin/bash

TUTORIAL_REPOSITORY=https://github.com/ezsystems/ezplatform-ee-beginner-tutorial
STEP1_BRANCH=v2-step1
STEP4_BRANCH=master
TUTORIAL_DATA_DIRECTORY_1=tutorial_data_1
TUTORIAL_DATA_DIRECTORY_2=tutorial_data_2
IMAGES_SOURCE=vendor/ezsystems/developer-documentation/docs/tutorials/enterprise_beginner/img/photos.zip
IMAGES_DESTINATION=./images

# clone tutorial data
git clone $TUTORIAL_REPOSITORY --depth=1 -b $STEP1_BRANCH $TUTORIAL_DATA_DIRECTORY_1
git clone $TUTORIAL_REPOSITORY --depth=1 -b $STEP4_BRANCH $TUTORIAL_DATA_DIRECTORY_2

# add suite to Behat
echo '    - vendor/ezsystems/developer-documentation/tests/behat_suites.yml' >> behat.yml.dist

#copy images
mkdir $IMAGES_DESTINATION
unzip $IMAGES_SOURCE -d $IMAGES_DESTINATION

# copy templates, styles and configuration files
cp $TUTORIAL_DATA_DIRECTORY_1/app/Resources/views/{pagelayout.html.twig,pagelayout_menu.html.twig} ./app/Resources/views

mkdir ./app/Resources/views/full
cp $TUTORIAL_DATA_DIRECTORY_1/app/Resources/views/full/{article.html.twig,dog_breed.html.twig,folder.html.twig,tip.html.twig} ./app/Resources/views/full
cp $TUTORIAL_DATA_DIRECTORY_1/app/config/{views.yml,image_variations.yml} ./app/config

mkdir web/{assets,assets/css,assets/images}
cp $TUTORIAL_DATA_DIRECTORY_1/web/assets/css/style.css ./web/assets/css
cp $TUTORIAL_DATA_DIRECTORY_1/web/assets/images/header.jpg ./web/assets/images

mkdir src/AppBundle/{QueryType,Controller,DependencyInjection,Resources,Resources/config}
cp $TUTORIAL_DATA_DIRECTORY_1/src/AppBundle/QueryType/{LocationChildrenQueryType.php,MenuQueryType.php} ./src/AppBundle/QueryType
cp $TUTORIAL_DATA_DIRECTORY_1/src/AppBundle/DependencyInjection/AppExtension.php ./src/AppBundle/DependencyInjection/
cp $TUTORIAL_DATA_DIRECTORY_1/src/AppBundle/Controller/MenuController.php ./src/AppBundle/Controller/
cp $TUTORIAL_DATA_DIRECTORY_1/src/AppBundle/Resources/config/services.yml ./src/AppBundle/Resources/config
