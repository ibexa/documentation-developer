for container in $(find docs/trainings -type d -a -name download); do
  for folder in $(find $container -type d -a -mindepth 1 -a -maxdepth 1); do
    cd $folder; #pwd;
    archive="$(basename $(dirname $container)).$(basename $folder).zip";
    rm -f ../$archive;
    echo "$archive ← $folder";
    zip -r ../$archive ./* ;
    cd - > /dev/null;
  done;
done;
