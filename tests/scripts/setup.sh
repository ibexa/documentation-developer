#!/bin/bash

TUTORIAL_REPOSITORY=https://github.com/ezsystems/ezplatform-ee-beginner-tutorial
STEP1_BRANCH=v3-step1
STEP4_BRANCH=v3-step4
TUTORIAL_DATA_DIRECTORY_1=tutorial_data_1
TUTORIAL_DATA_DIRECTORY_2=tutorial_data_2
IMAGES_SOURCE=vendor/ezsystems/developer-documentation/docs/tutorials/enterprise_beginner/img/photos.zip
IMAGES_DESTINATION=./images

# clone tutorial data
git clone $TUTORIAL_REPOSITORY --depth=1 -b $STEP1_BRANCH $TUTORIAL_DATA_DIRECTORY_1
git clone $TUTORIAL_REPOSITORY --depth=1 -b $STEP4_BRANCH $TUTORIAL_DATA_DIRECTORY_2

# add suite to Behat
echo '    - vendor/ezsystems/developer-documentation/tests/behat_suites.yml' >> behat.yml.dist

# add Context service definitions to the appplication
cat ./vendor/ezsystems/developer-documentation/tests/config/services.yaml >> config/services.yaml

# copy images
mkdir $IMAGES_DESTINATION
unzip $IMAGES_SOURCE -d $IMAGES_DESTINATION

# copy templates, styles and configuration files
cp $TUTORIAL_DATA_DIRECTORY_1/templates/{pagelayout.html.twig,pagelayout_menu.html.twig} ./templates

mkdir ./templates/full
cp $TUTORIAL_DATA_DIRECTORY_1/templates/full/{article.html.twig,dog_breed.html.twig,folder.html.twig,tip.html.twig} ./templates/full
cp $TUTORIAL_DATA_DIRECTORY_1/config/packages/{views.yaml,image_variations.yaml,webpack_encore.yaml} ./config/packages
cp $TUTORIAL_DATA_DIRECTORY_1/config/services.yaml ./config

cp $TUTORIAL_DATA_DIRECTORY_1/webpack.config.js ./

mkdir -p ./assets/{css,images}
cp $TUTORIAL_DATA_DIRECTORY_1/assets/css/style.css assets/css
cp $TUTORIAL_DATA_DIRECTORY_1/assets/images/header.jpg assets/images

mkdir ./src/QueryType
cp $TUTORIAL_DATA_DIRECTORY_1/src/QueryType/{LocationChildrenQueryType.php,MenuQueryType.php} ./src/QueryType
cp $TUTORIAL_DATA_DIRECTORY_1/src/Controller/MenuController.php ./src/Controller/
