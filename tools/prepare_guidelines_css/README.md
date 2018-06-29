prepare:

npm install -g less

run:

sh build.sh

Copy bootstrap-iso.css and ez-guidelines.css to docs/css/ directory

# tmp:
delete @font-face's for 'Maven Pro' from ez-guidelines.css

# tmp2:

bootstrap-iso.css:

Find all instance of: .bootstrap-iso body and .bootstrap-iso html
Replace with: .bootstrap-iso

ez-guidelines.css:

.ez-guidelines body  ->  .ez-guidelines
